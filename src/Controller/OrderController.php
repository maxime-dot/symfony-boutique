<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[Route('/order', name: 'app_order_add')]
    public function add(SessionInterface $session): Response
    {

            $this->denyAccessUnlessGranted('ROLE_USER') ;

        $panier = $session->get('panier', []) ;
        if($panier == []){
            $this->addFlash('message', 'Votre panier est vide') ;
            return $this->redirectToRoute('app_product');
        }


        // le panier n'est pas vide
        $order = new Order() ;
        // On remplit la commande
        // $order->setUsers($this->getUser()) ;
        // $order->setReference(uniqid()) ;

        // On parcourt le panier pour créer le détails de la commande
        foreach($panier as $item => $quantity ){

            $orderDetails =  new OrdersDetails() ;

            //on va chercher le produit
            $product = $productrepository->find($item);
            $price = $product->getPrice();


            // On crée le détails de la commande
            $orderDetails->setProducts($products);
            $orderDetails->setPrice($price);
            $orderDetails->setQuantity($quantity);

            $order->addOrderDetail($orderDetails);

        }

        // On persiste et on flush
        $em->persist($order);
        $em->flush();

        
        return $this->render('order/index.html.twig',);
    }
}
