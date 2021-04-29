<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @IsGranted("ROLE_USER")
 * @Route("/api/products")
 * @OA\Tag(name="Product")
 */
class ProductController extends AbstractController
{
    /**
     * @OA\Get(
     *   operationId="get-collection-product",
     *   summary="Get list of products",
     * @OA\Response(
     *     response="200",
     *     description="All products",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Product::class))
     *     )
     *   )
     * )
     * @Route("", methods={"GET"})
     */
    public function getCollection(ProductRepository $productRepository, NormalizerInterface $normalizer): Response
    {
        $products = $normalizer->normalize($productRepository->findAll());

        foreach ($products as $k => $v) {
            $products[$k]['@id'] = $this->generateUrl('product_getitem', ['id' => $v['id']]);
        }

        return $this->json($products);
    }

    /**
     * @OA\Get(
     *   operationId="get-product",
     *   summary="Get a product",
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     @OA\Schema(type="integer")
     * ),
     *  @OA\Response(
     *     response="200",
     *     description="A product",
     *     @OA\JsonContent(
     *        type="object",
     *        @OA\Items(ref=@Model(type=Product::class, groups={"read"}))
     *     )
     *   )
     * )
     * @Route("/{id<\d+>}", methods={"GET"}, name="product_getitem")
     */
    public function getItem(int $id, ProductRepository $productRepository): Response
    {
        $product = $productRepository->findOneBy(['id' => $id]);

        if (!$product) {
            throw $this->createNotFoundException();
        }

        return $this->json($product);
    }
}