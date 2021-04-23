<?php

namespace App\Tests\Controller;

use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiWebTestCase extends WebTestCase
{
    private function getToken()
    {
        $customerRepository = static::$container->get(CustomerRepository::class);
        $testCustomer = $customerRepository->findOneBy(['email' => 'admin@marketplace1.fr']);
        $jwtManager = self::$container->get('lexik_jwt_authentication.jwt_manager');

        return $jwtManager->create($testCustomer);
    }

    public function getAuthenticatedClient(): \Symfony\Bundle\FrameworkBundle\KernelBrowser
    {
        $client = static::createClient();

        $client->setServerParameter('HTTP_AUTHORIZATION', 'Bearer ' . $this->getToken());

        return $client;
    }
}