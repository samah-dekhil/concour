<?php

namespace App\Controller;

use App\Entity\InscriptionConvocation;
use App\Entity\Inscription;
use App\Entity\Phase;
use App\Form\InscriptionConvocationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use App\Entity\Grade;
use App\Entity\Concours;
use App\Entity\Historique;
use App\Entity\InscriptionConvocationProlongation;
use App\Repository\InscriptionConvocationProlongationRepository;
use App\Repository\InscriptionConvocationRepository;
use App\Repository\InscriptionRepository;
use App\Repository\PhaseRepository;
use App\Repository\ScoreRegionRepository;


class InscriptionConvocationController extends AbstractController
{

    


    /**
     *  Edition convocation inscription    
     */
    #[Route('/concours/{tokenConcours}/grade/{token}/inscription/convocation', methods: ['GET', 'POST'], name: 'inscription_convocation')]
    public function editionInscription(Request $request, #[MapEntity(mapping: ['tokenConcours' => 'token'])] Concours $concours,
    #[MapEntity(mapping: ['token' => 'token'])] Grade $grade, InscriptionConvocationRepository $InscriptionConvocationRepository, 
    ScoreRegionRepository $scoreRegionRepository,InscriptionRepository $InscriptionRepository ,
     EntityManagerInterface $entityManager): Response
    {

        //***********************************************STARt // check if Convocation  is avaiable****************************************************
        
        $phases = $concours->getPhases();
        $bool=false;
        foreach ($phases as  $phase) {
            if ($phase->isIsEnabled() == 1 && in_array($grade->getId(),$phase->getGrades())) {
                $dateDebutPhase = $phase->getDateDebut()->format('Y-m-d');
                $dateFinPhase = $phase->getDateFin()->format('Y-m-d');
                $ph=$phase;
                $bool=true;
            }
        }
       
        $Now = new \DateTime();

        if($bool){
            if($dateFinPhase < $Now->format('Y-m-d')){
                if($ph->isIsEnabled()){
                    $ph->setIsEnabled(false);
                    $entityManager->persist($ph);
                    $entityManager->flush();
                }
           
            }
            if($ph ===null || $dateFinPhase < $Now->format('Y-m-d') || $dateDebutPhase > $Now->format('Y-m-d'))
                return $this->redirectToRoute('app_home');
              
               
        }else
        return $this->redirectToRoute('app_home');
        //***********************************************END // check if Convocation  is avaiable****************************************************
        $success = 0;
        $Inscription = new InscriptionConvocation();

        $form = $this->createForm(InscriptionConvocationType::class, $Inscription);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $searchInscriptionConvocation = $InscriptionConvocationRepository->findOneBy([
                                            'cin' => $request->request->all()['inscription_convocation']['cin'],
                                            'idDossier' => $request->request->all()['inscription_convocation']['idDossier'],
                                            'idGrade'=>$grade->getId(),

                                        ]);

            if ($searchInscriptionConvocation) {

                $historique =new Historique();
                $historique->setGrade($grade->getId());
                $historique->setPhase($ph->getId());
                $historique->setCin($searchInscriptionConvocation->getCin());
                $historique->setIdDossier($searchInscriptionConvocation->getIdDossier());
                $entityManager->persist($historique);
               
               
               if($grade->getId()==1){
                $entityManager->flush();
                return $this->render('inscription/imprimer_convocation_grade_1.html.twig', [
                    'inscription' => $searchInscriptionConvocation,
                    'grade' => $grade,
                    'concours' => $concours
                ]);
               }
               /*if($grade->getId()==2){
                 
                        $entityManager->flush();
                         return $this->render('inscription/imprimer_convocation_grade_2.html.twig', [
                            'inscription' => $searchInscriptionConvocation,
                            'grade' => $grade,
                            'concours' => $concours
                        ]);
               

                    
               }*/
            } else {
                $existInscription = $InscriptionRepository->findOneBy(['cin'=>$request->request->all()['inscription_convocation']['cin'],
                                                                        'id' => $request->request->all()['inscription_convocation']['idDossier'],
                                                                        'grade'=>$grade->getId()]);
                                                                      
                if( $existInscription){
                    /************** */
                    $gouv =$existInscription->getcodeGouv();
                    $findScore = $scoreRegionRepository->findOneBy([
                                                                'idGrade'=>$grade->getId(),
                                                                'idSpecialite'=> $existInscription->getSpecialite()->getId()]);
                   
                    $dernierScore =$findScore->getDernierScoreTotal();
                    $dateNaissanceDernierCandidatAdmis =$findScore->getDateNaissanceDernierCandidatAdmis();
                    /********************** */
                    if(count($grade->getSpecialites())>1){
                        $title=$grade->getLibelle();
                        $subtitle= "( إختصاص ". $existInscription->getSpecialite()->getLibelle(). " )";
                    }else{
                        $title="عدول خزينة بسلك عدول الخزينة";
                        $subtitle= "";
                    }


                            $this->addFlash('error', 'نأسف لإعلامك بعدم قبولك في نتائج الترتيب الآلي للترشحات للمناظرة الخارجية لإنتداب
                             
                            '.$title.'
                            '. $subtitle.'
                            التابع لوزارة الفلاحة والموارد المائية والصيد البحري نظرا وأن مجموع النقاط الذي تحصلت عليه لم يمكنك من أن تكون ضمن المترشحين المقبولين والمدعوين للإدلاء بملفاتهم باعتبار أن مجموع
                            النقاط الأدنى المقبول لآخر مترشح هو '.$dernierScore.' و مولود بتاريخ '.$dateNaissanceDernierCandidatAdmis.' .');

                        $this->addFlash('error', '
                        (وفي صورة تساوي مجموع النقاط يتم اختيار المترشح الأكبر سنا.)');
                        return $this->redirectToRoute('inscription_convocation', ['tokenConcours' => $concours->getToken(), 'token' => $grade->getToken()]);
                }
                
                $this->addFlash('error', 'لم تقم بالتّسجيل بهذه المناظرة ');
                return $this->redirectToRoute('inscription_convocation', ['tokenConcours' => $concours->getToken(), 'token' => $grade->getToken()]);

            }
        }
        return $this->render('inscription/convocation.html.twig', [
            'form' => $form->createView(),
            'grade' => $grade,
            'success' => $success
        ]);
    }
}