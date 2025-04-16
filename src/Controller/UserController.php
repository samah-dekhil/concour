<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Form\Type\ChangePasswordType;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Controller used to manage current user.
 *
 * @author Romain Monteil <monteil.romain@gmail.com>
 */
#[Route('/admin/utilisateurs')]
#[IsGranted('ROLE_ADMIN')]
class UserController extends AbstractController
{
    #[Route('/liste', methods: ['GET', 'POST'], name: 'user_index')]
    public function index(Request $request, EntityManagerInterface $entityManager,UserRepository $userRep): Response
    {
        $users = $userRep->findAll();
        return $this->render('user/index.html.twig', [
            'users' => $users
            
        ]);
    }

    #[Route('/profile/edit/{id}', methods: ['GET', 'POST'], name: 'user_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager, User $user): Response
    {
       
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'le compte utilisateur est mis à jour');

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

  
 #[Route('/profile/change-password/{id}', methods: ['GET', 'POST'], name: 'user_change_password')]
    public function changePassword(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager,User $user): Response
    {
    
        $form = $this->createForm(ChangePasswordType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($passwordHasher->hashPassword($user, $form->get('newPassword')->getData()));
            $entityManager->flush();
            if( $this->getUser() === $user){
                $tokenProvider = $this->container->get('security.csrf.token_manager');
                $token = $tokenProvider->getToken('logout')->getValue();
                return $this->redirectToRoute('security_logout', ['logout' => $token]);
            }
            $this->addFlash('success', 'Le Mot de passe est mis à jour');
            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/change_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

     
  


}