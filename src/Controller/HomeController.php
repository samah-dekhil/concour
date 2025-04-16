<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Concours;
use App\Entity\Grade;
use App\Repository\ConcoursRepository;
class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ConcoursRepository $ConcoursRepository): Response
    {
        $listConc=array();
      
        $listConcours =  $ConcoursRepository->findAll();
      
        foreach($listConcours as $conc){
            if(count($conc->getGrades())>0) $listConc[]=$conc;
           }

      return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'listConcours'=>$listConc
        ]);
    }

    #[Route('/test-edition-convocation-daf-prolongation-huissiers-disabled', name: 'page-test-edition-convocation')]
    public function indexTestConvocation(ConcoursRepository $ConcoursRepository): Response
    {
        $listConc=array();
        $listConcours =  $ConcoursRepository->findAll();
      
        foreach($listConcours as $conc){
            if(count($conc->getGrades())>0) 
              $listConc[]= $conc;
           }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'listConcours'=>$listConc
        ]);
    }
}