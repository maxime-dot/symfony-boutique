<?php

namespace App\Classes ;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

Class Cart
{
    private $session ;

    public function __construct(SessionInterface $sess)
    {
        $this->session = $sess ;
    }

    public function add($id)
    {
        $cart = $this->session->get('cart',[]);

        if(!empty($cart[$id])){
            $cart[$id]++;
        } 
        else{

            $cart[$id] = 1 ;
        }              
        $this->session->set('cart', $cart);
    }

    public function get()
    {
        return $this->session->get('cart');
    }

    public function remove()
    {
        return $this->session->remove('cart');
    }
}