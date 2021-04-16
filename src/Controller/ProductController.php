<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/products")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"})
     */
    public function getCollection(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        return $this->json($products);
    }

    /**
     * @Route("/{id}", methods={"GET"})
     */
    public function getItem(Product $product): Response
    {
        return $this->json($product);
    }
}