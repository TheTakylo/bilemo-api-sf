<?php

namespace App\Controller;

use App\Entity\CustomerUser;
use App\Repository\CustomerUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @IsGranted("ROLE_USER")
 * @Route("/api/customer_users")
 */
class CustomerUserController extends AbstractController
{
    /**
     * @Route("", methods="GET")
     */
    public function getCollection(CustomerUserRepository $customerUserRepository): Response
    {
        $customers = $customerUserRepository->findBy(['customer' => $this->getUser()]);

        return $this->json($customers, 200, [], ['groups' => 'read']);
    }

    /**
     * @Route("", methods="POST")
     */
    public function postCollection(Request $request, EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator): Response
    {
        /** @var CustomerUser $customerUser */
        $customerUser = $serializer->deserialize($request->getContent(), CustomerUser::class, 'json');
        $customerUser->setCustomer($this->getUser());

        $errors = $validator->validate($customerUser);

        if (count($errors) > 0) {
            return $this->json($errors);
        }

        $em->persist($customerUser);
        $em->flush();

        return $this->json($customerUser, 200, [], ['groups' => 'read']);
    }



    /**
     * @Route("/{id}", methods="GET")
     */
    public function getItem(int $id, CustomerUserRepository $customerUserRepository): Response
    {
        $customer = $customerUserRepository->findOneBy(['id' => $id, 'customer' => $this->getUser()]);

        if (!$customer) {
            throw $this->createNotFoundException();
        }

        return $this->json($customer, 200, [], ['groups' => 'read']);
    }

    /**
     * @Route("/{id}", methods="DELETE")
     */
    public function deleteItem(int $id, CustomerUserRepository $customerUserRepository, EntityManagerInterface $em): Response
    {
        $customer = $customerUserRepository->findOneBy(['id' => $id, 'customer' => $this->getUser()]);

        if (!$customer) {
            throw $this->createNotFoundException();
        }

        $em->remove($customer);
        $em->flush();

        return new Response();
    }
}