<?php

namespace App\Controller;

use App\Entity\CustomerUser;
use App\Exception\FormValidationErrorException;
use App\Repository\CustomerUserRepository;
use Doctrine\ORM\EntityManagerInterface;
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
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * @Security(name="Bearer")
 * @IsGranted("ROLE_USER")
 * @Route("/api/customer_users")
 * @OA\Tag(name="CustomerUser")
 */
class CustomerUserController extends AbstractController
{
    /**
     * @OA\Get(
     *   operationId="get-collection-customeruser",
     *   summary="Get list of customer users",
     *  @OA\Parameter(
     *     name="page",
     *     in="query",
     *     @OA\Schema(type="integer")
     * ),
     *   @OA\Response(
     *     response="200",
     *     description="All customer users",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=CustomerUser::class, groups={"read"}))
     *     )
     *   )
     * )
     * @Route("", methods="GET")
     */
    public function getCollection(Request $request, CustomerUserRepository $customerUserRepository, NormalizerInterface $normalizer, CacheItemPoolInterface $pool): Response
    {
        $page = $request->query->getInt('page', 1);

        $customers = $pool->get('collection_customer_users_' . $page, function (ItemInterface $item) use ($customerUserRepository, $normalizer, $page) {
            $item->expiresAfter(3600);

            return $normalizer->normalize($customerUserRepository->findByPaginated($this->getUser(), $page, 10), null, ['groups' => 'read']);
        });

        foreach ($customers['items'] as $k => $v) {
            $customers['items'][$k]['@id'] = $this->generateUrl('customer_users_getitem', ['id' => $v['id']]);
        }

        return $this->json($customers, 200);
    }

    /**
     * @OA\RequestBody(@Model(type=CustomerUser::class, groups={"write"}))
     * @OA\Post(
     *   operationId="post-customeruser",
     *   summary="Add a customer user",
     * @OA\Response(
     *     response="201",
     *     description="A customer user",
     *     @OA\JsonContent(
     *        type="object",
     *        @OA\Items(ref=@Model(type=CustomerUser::class, groups={"read"}))
     *     )
     *   )
     * )
     * @Route("", methods="POST")
     */
    public function postCollection(Request $request, EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator): Response
    {
        /** @var CustomerUser $customerUser */
        $customerUser = $serializer->deserialize($request->getContent(), CustomerUser::class, 'json');
        $customerUser->setCustomer($this->getUser());

        $errors = $validator->validate($customerUser);

        if (count($errors) > 0) {
            throw new FormValidationErrorException($errors);
        }

        $em->persist($customerUser);
        $em->flush();

        return $this->json($customerUser, 201, [], ['groups' => 'read']);
    }

    /**
     * @OA\Get(
     *   operationId="get-customeruser",
     *   summary="Get a customer user",
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     *     response="200",
     *     description="A customer user",
     *     @OA\JsonContent(
     *        type="object",
     *        @OA\Items(ref=@Model(type=CustomerUser::class, groups={"read"}))
     *     )
     *   )
     * )
     * @Route("/{id<\d+>}", methods="GET", name="customer_users_getitem")
     */
    public function getItem(int $id, CustomerUserRepository $customerUserRepository, CacheItemPoolInterface $pool): Response
    {
        $customer = $pool->get('collection_customer_user_' . $id, function (ItemInterface $item) use ($customerUserRepository, $id) {
            $item->expiresAfter(3600);

            return $customerUserRepository->findOneBy(['id' => $id, 'customer' => $this->getUser()]);
        });

        if (!$customer) {
            throw $this->createNotFoundException();
        }

        return $this->json($customer, 200, [], ['groups' => 'read']);
    }

    /**
     * @OA\Delete(
     *     operationId="delete-customeruser",
     *     summary="Delete a customer user",
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     *     response="204",
     *     description="Delete a customer user",
     *   )
     * )
     * @Route("/{id<\d+>}", methods="DELETE")
     */
    public function deleteItem(int $id, CustomerUserRepository $customerUserRepository, EntityManagerInterface $em, CacheItemPoolInterface $pool): Response
    {
        $customer = $customerUserRepository->findOneBy(['id' => $id, 'customer' => $this->getUser()]);

        if (!$customer) {
            throw $this->createNotFoundException();
        }

        $em->remove($customer);
        $em->flush();

        $pool->deleteItem('collection_customer_user_' . $id);

        return new Response('', 204);
    }
}
