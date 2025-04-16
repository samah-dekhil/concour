<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Specialite;
use App\Entity\Grade;
use App\Entity\Concours;
use App\Form\SpecialiteType;
use App\Repository\GradeRepository;
use App\Repository\SpecialiteRepository;
use App\Repository\ConcoursRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter as ParamConverter;
#[Route('/admin')]
class SpecialiteController extends AbstractController
{
    #[Route('/concours/{tokenConcours}/grade/{token}/specialites', name: 'specialite_index')]
    public function index(Request $request, EntityManagerInterface $entityManager, #[MapEntity(mapping: ['tokenConcours' => 'token'])] Concours $concours,#[MapEntity(mapping: ['token' => 'token'])]Grade $grade,ConcoursRepository $ConcoursRepository): Response
    {   
        
        $list= $grade->getSpecialites();
   
        return $this->render('grade/index.html.twig', [
            'controller_name' => 'GradeController',
            'list'=>$list,
            'grade'=>$grade,
            'concours'=>$concours
        ]);
    }
  /**
   * Add entity specialité
   */
    #[Route('/concours/{tokenConcours}/grade/{token}/specialite/new', methods: ['GET', 'POST'], name: 'specialite_new')]
    public function new(Request $request, EntityManagerInterface $entityManager, #[MapEntity(mapping: ['tokenConcours' => 'token'])] Concours $concours,#[MapEntity(mapping: ['token' => 'token'])]Grade $grade): Response
    {
        $specialite = new Specialite(); 
        $specialite->setGrade($grade);
       // dd($specialite);
        $form = $this->createForm(SpecialiteType::class, $specialite);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ) {
            $entityManager->persist($specialite);
            $entityManager->flush();
            $this->addFlash('success', 'specialité créée avec succès');
            return $this->redirectToRoute('grade_index', ['tokenConcours' => $concours->getToken(), 'token'=>$grade->getToken()]);
        }

        return $this->render('specialite/new.html.twig', [
            'form' => $form->createView(),
            'grade'=>$grade,
        ]);
    }

/**
   * Edit entity specialité
   */
  #[Route('/concours/{tokenConcours}/grade/{tokenGrade}/specialite/{id}/edit', methods: ['GET', 'POST'], name: 'specialite_edit')]
  public function edit(Request $request, EntityManagerInterface $entityManager, #[MapEntity(mapping: ['tokenConcours' => 'token'])] Concours $concours,#[MapEntity(mapping: ['tokenGrade' => 'token'])]Grade $grade,#[MapEntity(mapping: ['id' => 'id'])] Specialite $specialite): Response
  {
      $specialite->setGrade($grade);
   
      $form = $this->createForm(SpecialiteType::class, $specialite);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid() ) {
          $entityManager->persist($specialite);
          $entityManager->flush();
          $this->addFlash('success', 'specialité modifiée avec succès');
          return $this->redirectToRoute('grade_show', ['tokenConcours' => $concours->getToken(),'token'=>$grade->getToken()]);
      }

      return $this->render('specialite/edit.html.twig', [
          'form' => $form->createView(),
          'grade'=>$grade,
      ]);
  }

}