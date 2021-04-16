<?php

namespace App\Controller;

use App\Repository\CustomerUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 * @Route("/api/customer_users")
 */
class CustomerUserController extends AbstractController
{
    /**
     * @Route("/", methods="GET")
     */
    public function getCollection(CustomerUserRepository $customerUserRepository): Response
    {
        $customers = $customerUserRepository->findBy(['customer' => $this->getUser()]);

        return $this->json($customers, 200, [], ['groups' => 'read']);
    }

    /**
     * @Route("/{id}", methods="GET")
     */
    public function getItem(int $id, CustomerUserRepository $customerUserRepository): Response
    {
        $customer = $customerUserRepository->findOneBy(['id' => $id, 'customer' => $this->getUser()]);

        if(!$customer) {
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

        if(!$customer) {
            throw $this->createNotFoundException();
        }

        $em->remove($customer);
        $em->flush();

        return new Response();
    }
}