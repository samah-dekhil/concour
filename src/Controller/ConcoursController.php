<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ConcoursType;
use App\Repository\ConcoursRepository;
use App\Entity\Concours;
#[Route('/admin')]
class ConcoursController extends AbstractController
{
    #[Route('/daf_concours', name: 'concours_index')]
    public function index(ConcoursRepository $ConcoursRepository): Response
    {  $list= $ConcoursRepository ->findAll();
   
        return $this->render('concours/index.html.twig', [
            'controller_name' => 'ConcoursController','list'=>$list
        ]);
    }


    /**
     * add new Entity
     */
    #[Route('/concours/new', methods: ['GET', 'POST'], name: 'concours_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $concours = new Concours(); 
        $form = $this->createForm(ConcoursType::class, $concours);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ) {
          
            $entityManager->persist($concours);
            $entityManager->flush();
            $this->addFlash('success', 'concours créé avec succès');
            return $this->redirectToRoute('concours_index');
        }

        return $this->render('concours/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }




    /**
     * Edit  Entity
     */
    #[Route('/concours/edit/{token}', methods: ['GET', 'POST'], name: 'concours_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager, Concours $concours): Response
    {
       // $concours = new Concours(); 
        $form = $this->createForm(ConcoursType::class, $concours);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ) {
          
            $entityManager->persist($concours);
            $entityManager->flush();
            $this->addFlash('success', 'concours modifié avec succès');
            return $this->redirectToRoute('concours_index');
        }

        return $this->render('concours/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }


     /**
     * Finds and displays a Mission entity.
     */

    #[Route('/daf_concours/{token}', methods: ['GET'], name: 'concours_show')]
    public function show(Request $request, EntityManagerInterface $entityManager,Concours $concours): Response
    { 
        return $this->render('concours/show.html.twig', [
            'concours' => $concours,
        ]);
    }
}