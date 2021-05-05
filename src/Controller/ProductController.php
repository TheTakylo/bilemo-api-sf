<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Psr\Cache\CacheItemPoolInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * @Security(name="Bearer")
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
     *  @OA\Parameter(
     *     name="page",
     *     in="query",
     *     @OA\Schema(type="integer")
     * ),
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
    public function getCollection(Request $request, ProductRepository $productRepository, NormalizerInterface $normalizer, CacheItemPoolInterface $pool): Response
    {
        $page = $request->query->getInt('page', 1);

        $products = $pool->get('collection_products_' . $page, function (ItemInterface $item) use ($normalizer, $productRepository, $page) {
            $item->expiresAfter(3600);

            return $normalizer->normalize($productRepository->paginate($page, 10));
        });

        foreach ($products['items'] as $k => $v) {
            $products['items'][$k]['@id'] = $this->generateUrl('product_getitem', ['id' => $v['id']]);
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
    public function getItem(int $id, ProductRepository $productRepository, CacheItemPoolInterface $pool): Response
    {
        $product = $pool->get('collection_product_' . $id, function (ItemInterface $item) use ($productRepository, $id) {
            $item->expiresAfter(3600);

            return $productRepository->findOneBy(['id' => $id]);
        });

        if (!$product) {
            throw $this->createNotFoundException();
        }

        return $this->json($product);
    }
}
