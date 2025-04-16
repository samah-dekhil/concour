<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Concours;
use App\Entity\Grade;
use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ConcoursRepository;
use App\Repository\ReclamationRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\Mailer\MailerInterface;

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter as ParamConverter;
//#[Route('/admin')]
class ReclamationController extends AbstractController
{
    #[Route('/admin/reclamations', name: 'reclamation_index')]
    public function index(Request $request, EntityManagerInterface $entityManager,ReclamationRepository $reclamationRepository): Response
    {   
        
        $list= $reclamationRepository->findAll();
   
        return $this->render('reclamation/index.html.twig', [
            'list'=>$list,
    
        ]);
    }
    /**
     * Add New Entity 
     *  */
    #[Route('/envoyer-reclamation', methods: ['GET', 'POST'], name: 'reclamation_new')]
    // #[ParamConverter('concours', options: ['mapping' => ['idConcours' => 'id']])]
    public function new(Request $request, EntityManagerInterface $entityManager,MailerInterface $mailer,ConcoursRepository $concoursRep): Response
    {
       
        $respone=[];
        $Now=new \DateTime();
        $listConcours =  $concoursRep->findAll();
        foreach($listConcours as $conc){
            if(count($conc->getGrades())>0 &&  $conc->getDateFinInscription()->format('Y-m-d') > $Now->format('Y-m-d')){
                foreach ($conc->getGrades()  as $grade)
                $respone[]= array('id'=>$grade->getId() );
            } 
        }
        if(count($respone)==0)
             return $this->redirectToRoute('app_home');


        $reclamation = new Reclamation();
          
          
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ) {
            //dd($reclamation);
            $entityManager->persist($reclamation);
            $entityManager->flush();
           

       
            $this->addFlash('success', 'لقد قمنا بإرسال طلبك، سيتم الاتصال بك في أقرب وقت ممكن');
            return $this->redirectToRoute('reclamation_new');
        }

        return $this->render('reclamation/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Ajax get list of grades availables 
     */
    #[Route('/ajax-get-grades-availables', methods: ['POST'], name: 'reclamation_grade_availables')]
    public function getSpecialitesGrade(ConcoursRepository $concoursRep): Response
    {    
        $respone=[];
        $Now=new \DateTime();
       
        $listConcours =  $concoursRep->findAll();
        foreach($listConcours as $conc){
            if(count($conc->getGrades())>0 &&  $conc->getDateFinInscription()->format('Y-m-d') >$Now->format('Y-m-d')){
                foreach ($conc->getGrades()  as $grade)
                $respone[]= array('id'=>$grade->getId(),
                'libelle'=>$grade->getLibelle(),
                'datetime'=> $Now->format('Y-m-d'),
                'dfi'=>$conc->getDateFinInscription()->format('Y-m-d'));
            } 
        }

        return new JsonResponse( $respone);
    }

}