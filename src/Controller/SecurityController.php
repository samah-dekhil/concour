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

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Controller used to manage the application security.
 * See https://symfony.com/doc/current/security/form_login_setup.html.
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class SecurityController extends AbstractController
{
    use TargetPathTrait;

    private $params;
    
    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    #[Route('/connexiondaf', name: 'security_login')]
    public function login( AuthenticationUtils  $authenticationUtils): Response
    {
        // if user is already logged in, don't display the login page again
   
        if ($this->getUser()) {
    
            return $this->redirectToRoute('reclamation_index');
        }
        
           // get the login error if there is one
            $error = $authenticationUtils->getLastAuthenticationError();
   
            // last username entered by the user
            $lastUsername = $authenticationUtils->getLastUsername();
   
            return $this->render('security/login.html.twig', [
            
                'last_username' => $lastUsername,
                'error'         => $error,
            ]);

  
    }

    #[Route('/logout', name: 'security_logout')]
    public function logout(): void
    {
    
        throw new \Exception('This should never be reached!');
    }
}