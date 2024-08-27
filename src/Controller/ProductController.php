<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'app_product')]
    public function index(): Response
    {
        // todo list of all products with pagination
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/{id}', name: 'app_product_show')]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', compact('product'));
    }
}
