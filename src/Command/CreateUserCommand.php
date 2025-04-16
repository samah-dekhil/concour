<?php
// src/Command/CreateUserCommand.php
namespace App\Command;
use App\Entity\User;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Service\UserManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
#[AsCommand(
    name: 'app:create-new-admin',
    description: 'Creates a new admin.',
    hidden: false,
    aliases: ['app:add-user']
)]
// the name of the command is what users type after "php bin/console"
// #[AsCommand(name: 'app:create-user')]
class CreateUserCommand  extends Command
{

    public function __construct(    private UserPasswordHasherInterface $userPasswordHasher,private EntityManagerInterface $entityManager
    ){
       
        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output ): int
    {
        //$this->userManager->registerNewUsser($input->getArgument('username'),$input->getArgument('password'));



        $user = new User();
        if(strlen($input->getArgument('password'))>=8 && filter_var($input->getArgument('email'), FILTER_VALIDATE_EMAIL)){
            $user->setEmail($input->getArgument('email'));
        
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                $input->getArgument('password')
            )
        );

        
        $user->setRoles(['ROLE_ADMIN']);
        $user->setFullName('nouveau utilisateur');
        $user->setIsVerified(true);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        
        $output->writeln('<fg=white;bg=green>User successfully generated!</>');
        }else{
            $output->writeln('<error>User Not created , please check email and password</error>');
        }
        

    
        return Command::SUCCESS;
    }
    protected function configure(): void
    {
        $this
            // the command description shown when running "php bin/console list"
            ->setDescription('Creates a new admin.')
            // the command help shown when running the command with the "--help" option
            ->setHelp('This command allows you to create an  admin...')
            ->addArgument('email', InputArgument::REQUIRED, 'The email of the admin.')
            ->addArgument('password',InputArgument::REQUIRED , 'Admin password')
        ;
    }
}