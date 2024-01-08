<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountPasswordController extends AbstractController
{


    private $em;

    public function  __construct(EntityManagerInterface $entitymanager){
        $this->em = $entitymanager ;
    }


    #[Route('/account/password', name: 'app_account_password')]
    public function index(Request $request, UserPasswordHasherInterface $encoder): Response
    {
        $user = $this->getUser();
        assert($user instanceof \App\Entity\User);
        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) 
        {
            $old_pass = $form->get('old_password')->getData();
        
            if($encoder->isPasswordValid($user, $old_pass)){
                $new_password = $form->get('new_password')->getData();
                $password = $encoder->hashPassword($user, $new_password);
                 
                $user->setPassword($password);

                $this->em->persist($user) ;
                 $this->em->flush();

            }
        }

        return $this->render('account/password.html.twig',[
            'form' => $form->createView(),
        ]);
    }
}
