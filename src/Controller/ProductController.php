<?php

namespace App\Controller;

use App\Classes\Search;
use App\Entity\Product;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    private $em ;

    public function __construct(EntityManagerInterface $entitymanager)
    {
        $this->em = $entitymanager ;
    }


    #[Route('/product', name: 'app_product')]
    public function index(Request $request): Response
    {

        


        $search = new Search() ;
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
        $products = $this->em->getRepository(Product::class)->findWithSearch($search) ;

        }
        else{
            $products = $this->em->getRepository(Product::class)->findAll() ;
        }

        return $this->render('product/index.html.twig', [
            'products' => $products ,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/product/{slug}', name: 'app_product_show')]
    public function showOneProduct($slug): Response
    {

        $product = $this->em->getRepository(Product::class)->findOneBySlug($slug) ;

        if(!$product){
            return $this->redirectToRoute('app_product') ;
        }

        return $this->render('product/showProduct.html.twig', [
            'product' => $product ,
        ]);
    }
}
