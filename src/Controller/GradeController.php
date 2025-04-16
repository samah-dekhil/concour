<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\GradeType;
use App\Repository\GradeRepository;
use App\Entity\Grade;
use App\Repository\ConcoursRepository;
use App\Entity\Concours;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter as ParamConverter;
#[Route('/admin')]
class GradeController extends AbstractController
{
    #[Route('/concours/{token}/grade', name: 'grade_index')]
    public function index(Request $request, EntityManagerInterface $entityManager,Concours $concours): Response
    {   
        
        $list= $concours->getGrades();
   
        return $this->render('grade/index.html.twig', [
            'controller_name' => 'GradeController',
            'list'=>$list,
            'concours'=>$concours
        ]);
    }
    /**
     * Add New Entity 
     *  */
    #[Route('/concours/{token}/grade/new', methods: ['GET', 'POST'], name: 'grade_new')]
    public function new(Request $request, EntityManagerInterface $entityManager,Concours $concours): Response
    {
        $grade = new Grade(); 
        $grade->setConcours($concours);
        $form = $this->createForm(GradeType::class, $grade);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ) {
            $entityManager->persist($grade);
            $entityManager->flush();
            $this->addFlash('success', 'grade créé avec succès');
            return $this->redirectToRoute('grade_index', ['token' => $concours->getToken()]);
        }

        return $this->render('grade/new.html.twig', [
            'form' => $form->createView(),
            'concours'=>$concours
        ]);
    }

    /**
     *  Edit Entity
     */
    #[Route('/concours/{tokenConcours}/grade/{token}/edit', methods: ['GET', 'POST'], name: 'grade_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager,#[MapEntity(mapping: ['tokenConcours' => 'token'])] Concours $concours,  #[MapEntity(mapping: ['token' => 'token'])]Grade $grade): Response
    {
        
        $form = $this->createForm(GradeType::class, $grade);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ) {
            $entityManager->persist($grade);
            $entityManager->flush();
            $this->addFlash('success', 'grade modifié avec succès');
            return $this->redirectToRoute('grade_show', ['tokenConcours' => $concours->getToken(),'token'=>$grade->getToken()]);
        }

        return $this->render('grade/edit.html.twig', [
            'form' => $form->createView(),
            'concours'=>$concours
        ]);
    }



    /**
     * Finds and displays a Grade entity.
     */
    #[Route('/concours/{tokenConcours}/grade/{token}/', methods: ['GET'], name: 'grade_show')]
    public function show(Request $request, EntityManagerInterface $entityManager, #[MapEntity(mapping: ['tokenConcours' => 'token'])] Concours $concours,  #[MapEntity(mapping: ['token' => 'token'])]Grade $grade ): Response
    {  
        return $this->render('grade/show.html.twig', [
            'concours' => $concours,
            'grade'=>$grade,

        ]);
    }
}