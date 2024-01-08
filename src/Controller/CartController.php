<?php

namespace App\Controller;

use App\Classes\Cart;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{   
    #[Route('/cartpanier', name: 'panier')]
    public function index(SessionInterface $session, ProductRepository $produitrepository)
    {
        $panier = $session->get('panier', []) ;

        //On initialise des variables
        $data = [];
        $total = 0 ;

        foreach($panier as $id => $quantite){
            $product = $produitrepository->find($id);

            $data[] = [
                'product' => $product ,
                'quantity' => $quantite
            ];

            $total += $product->getPrice() * $quantite / 100 ;
        }

        return $this->render('cart/index.html.twig', compact('data', 'total'));
    }


    #[Route('/cartadd/{id}', name: 'addpanier')]
    public function add(Product $produit, SessionInterface $session)
    {
        // On récupère l'id du Produit
        $id = $produit->getId();

        // On récupère le panier existant
        $panier = $session->get('panier', []);

        // on ajoute le produit s'il n'y est pas encore
        // sinon on incrémente sa quantité
        if(empty($panier[$id])){
            $panier[$id] = 1 ;
        }
        else{
            $panier[$id]++;
        }

        $session->set('panier', $panier);

        //on rédirige vers la page du panier
        return $this->redirectToRoute('panier') ;
    }

    #[Route('/cartremove/{id}', name: 'removepanier')]
    public function cartRemove(Product $produit, SessionInterface $session)
    {
        // On récupère l'id du Produit
        $id = $produit->getId();

        // On récupère le panier existant
        $panier = $session->get('panier', []);

        // on ajoute le produit s'il n'y est pas encore
        // sinon on incrémente sa quantité
        if(!empty($panier[$id]))
        {
            if($panier[$id] > 1){
            
                $panier[$id]-- ;
            }
            else{
                unset($panier[$id]);
            }
        }

        $session->set('panier', $panier);

        //on rédirige vers la page du panier
        return $this->redirectToRoute('panier') ;
    }

    #[Route('/supprimer/{id}', name: 'supprimer')]
    public function Supprimer(Product $produit, SessionInterface $session)
    {
        // On récupère l'id du Produit
        $id = $produit->getId();

        // On récupère le panier existant
        $panier = $session->get('panier', []);

        // on ajoute le produit s'il n'y est pas encore
        // sinon on incrémente sa quantité
        if(!empty($panier[$id]))
        {  unset($panier[$id]);  
        }

        $session->set('panier', $panier);

        //on rédirige vers la page du panier
        return $this->redirectToRoute('panier') ;
    }


    #[Route('/vider', name: 'vider')]
    public function Vider( SessionInterface $session)
    {
        $session->remove('panier');
        return $this->redirectToRoute('panier') ;

    }   














   /* #[Route('/cart', name: 'app_cart')]
    public function index(Cart $cart): Response
    {
        return $this->render('cart/index.html.twig',[
            'cart' => $cart->get()
        */
        /*]);
    }

    #[Route('/addpanier/{id}', name: 'app_addpanier')]
    public function addPanier(Cart $cart, $id): Response
    {
        $cart->add($id);
        return $this->redirectToRoute('cart/index.html.twig');
    }

    #[Route('/removepanier/{id}', name: 'app_removepanier')]
    public function removePanier(Cart $cart, $id): Response
    {
        $cart->remove($id);
        return $this->redirectToRoute('product/index.html.twig');
    } 
    */


}
