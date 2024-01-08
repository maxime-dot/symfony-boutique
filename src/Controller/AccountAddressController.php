<?php

namespace App\Controller;

use App\Entity\Address;

use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountAddressController extends AbstractController
{
    private $em ;

    public function __construct(EntityManagerInterface $entity)
    {
        $this->em = $entity ;
    }



    #[Route('/account/address', name: 'app_account_address')]
    public function index(): Response
    {   

        return $this->render('account/address.html.twig');
    }


    #[Route('/account/ajouter-une-adresse', name: 'app_account_address_ajouter')]
    public function add(Request $request): Response
    {
        $adresse = new Address() ;
        $form = $this->createForm(AddressType::class,$adresse) ;

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) 
        {
            $adresse->setUser($this->getUser());
            $this->em->persist($adresse) ;
            $this->em->flush();
            return $this->redirectToRoute('app_account_address');
        }

        return $this->render('account/ajouter_address.html.twig', [
            'form' => $form
        ]);
    }


    #[Route('/account/modifier-une-adresse/{id}', name: 'app_account_address_modifier')]
    public function Modifer(Request $request, Address $adiresy): Response
    {
         
        if(!$adiresy || $adiresy->getUser() != $this->getUser()){
                return $this->redirectToRoute('app_account_address');
        }

        $form = $this->createForm(AddressType::class,$adiresy) ;

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) 
        {
          //   $this->em->persist($adiresy) ;
            $this->em->flush();
            return $this->redirectToRoute('app_account_address');
        }

        return $this->render('account/ajouter_address.html.twig', [
            'form' => $form
        ]);
    }


    #[Route('/account/remove-une-adresse/{id}', name: 'app_account_address_supprimer')]
    public function Supprimer(Address $adiresy): Response
    {
         
        if($adiresy && $adiresy->getUser() == $this->getUser()){
            $this->em->remove($adiresy);
            $this->em->flush();
        }

        return $this->redirectToRoute('app_account_address');

       
    }
}
