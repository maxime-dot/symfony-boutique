<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    private $em;

    public function  __construct(EntityManagerInterface $entitymanager){
        $this->em = $entitymanager ;
    }

    #[Route('/register', name: 'app_register')]
    public function index(Request $request, UserPasswordHasherInterface $encoder): Response
    {

        $user = new User() ;
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();

            $password = $encoder->hashPassword($user ,$user->getPassword());
            $user->setPassword($password) ;

            $this->em->persist($user) ;
            $this->em->flush();

        }


        return $this->render('register/index.html.twig',[
            'form' => $form->createView(),
        ]);
    }
}
