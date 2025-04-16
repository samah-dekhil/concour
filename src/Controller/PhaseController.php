<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\PhaseType;
use App\Repository\PhaseRepository;
use App\Repository\ConcoursRepository;
use App\Entity\Phase;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Concours;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
#[Route('/admin')]
class PhaseController extends AbstractController
{


    #[Route('/concours/{tokenConcours}/phases', name: 'phase_index')]
    public function index(PhaseRepository $PhaseRepository, #[MapEntity(mapping: ['tokenConcours' => 'token'])] Concours $concours): Response
    {  $list= $PhaseRepository ->getList($concours);
   
        return $this->render('phase/index.html.twig', [
           'list'=>$list, 'concours'=>$concours
        ]);
    }
     /**
     * add new Entity
     */
    #[Route('/concours/{tokenConcours}/phases/new', methods: ['GET', 'POST'], name: 'phase_new')]
    public function new(Request $request, EntityManagerInterface $entityManager, #[MapEntity(mapping: ['tokenConcours' => 'token'])] Concours $concours): Response
    {
        $phase = new Phase(); 
        $phase->setConcours($concours);
        $form = $this->createForm(PhaseType::class, $phase);
        $form->handleRequest($request);
      
        $gradesConcours =$concours->getGrades();
        $parameters = $request->request->all();
        if ($form->isSubmitted() && $form->isValid() ) {
        
            $entityManager->persist($phase);
           $entityManager->flush();
            $this->addFlash('success', 'phase créé avec succès');
            return $this->redirectToRoute('phase_index', ['tokenConcours' => $concours->getToken()]);
        }

        return $this->render('phase/new.html.twig', [
            'form' => $form->createView(),
            'gradesConcours'=>$gradesConcours,
            'concours'=>$concours
        ]);
    }
     /**
     * Edit  Entity
     */
    #[Route('/concours/{tokenConcours}/phases/edit/{id}', methods: ['GET', 'POST'], name: 'phase_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager,  #[MapEntity(mapping: ['id' => 'id'])]  Phase $phase, #[MapEntity(mapping: ['tokenConcours' => 'token'])] Concours $concours): Response
    {
       // $phase = new Phase(); 
        $form = $this->createForm(PhaseType::class, $phase);
        $gradesConcours =[];
        foreach($concours->getGrades() as $grade){
            $gradesConcours[$grade->getId()]=$grade->getLibelle();
        };
        $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid() ) {
          
                    $parameters = $request->request->all();
                    $entityManager->persist($phase);
                    $entityManager->flush();
                    $this->addFlash('success', 'phase modifiée avec succès');
                    return $this->redirectToRoute('phase_index', ['tokenConcours' => $concours->getToken()]);
                }
          

        return $this->render('phase/edit.html.twig', [
            'form' => $form->createView(),  
            'gradesConcours'=>$gradesConcours,    
             'concours'=>$concours
        ]);
    }
     /**
     * Edit  Entity
     */
    #[Route('/delete/{id}', methods: ['GET', 'POST'], name: 'phase_delete')]
    public function delete(Request $request, EntityManagerInterface $entityManager, Phase $phase, PhaseRepository $phaseRep ): Response
    {
        $Searchphase = $phaseRep->findOneBy(['id'=> $phase->getId()]);
        if($Searchphase !=null){
            $entityManager->remove($phase);
            $entityManager->flush();
            $this->addFlash('success', 'phase supprimée avec succès');
            return $this->redirectToRoute('phase_index');
        }
       
    }

     /**
     * Ajax get specialities of grade     
     */
    #[Route('/ajax-get-grade-concours', methods: ['POST'], name: 'phase_grade_concours')]
    public function getGradeConcours(Request $request,ConcoursRepository $concoursRepo): Response
    {    
        $respone=[];
        $concours = $concoursRepo->findOneBy(['id'=>$request->request->get('concours')]);
        $grades =$concours->getGrades();
        foreach ($grades as $note) {
        $respone[]= array('id'=>$note->getId(),'libelle'=>$note->getLibelle());
        }
        return new JsonResponse(   $respone);
    
    }

}