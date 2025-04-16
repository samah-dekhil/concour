<?php 
// src/Service/MessageGenerator.php
namespace App\Service;
use App\Entity\User;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserManager
{
    private $userPasswordHasher;
    private $entityManager;
    
    public function __construct()
    {
        $this->userPasswordHasher = new \UserPasswordHasherInterface();
        $this->entityManager = new \EntityManagerInterface();
     
    }
    
public function getHappyMessage(): string
{
    $messages = [
    'You did it! You updated the system! Amazing!',
    'That was one of the coolest updates I\'ve seen all day!',
    'Great work! Keep going!',
    ];

    $index = array_rand($messages);

    return $messages[$index];
}






    public function registerNewUsser(  $username, $pwd): string
    {
         $user = new User();
      
            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setRoles(['ROLE_ADMIN']);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
          
            return 1;
            

        
       
    }
}