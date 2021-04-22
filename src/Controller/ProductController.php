<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 * @Route("/api/products")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("", methods={"GET"})
     */
    public function getCollection(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        return $this->json($products);
    }

    /**
     * @Route("/{id<\d+>}", methods={"GET"})
     */
    public function getItem(int $id, ProductRepository $productRepository): Response
    {
        $product = $productRepository->findOneBy(['id' => $id]);

        if(!$product) {
            throw $this->createNotFoundException();
        }

        return $this->json($product);
    }
}