<?php

namespace App\Tests\Controller;

use App\Repository\CustomerRepository;
use App\Tests\AbstractApiTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    protected function getToken()
    {
        $customerRepository = static::$container->get(CustomerRepository::class);
        $testCustomer = $customerRepository->findOneBy(['email' => 'admin@marketplace1.fr']);
        $jwtManager = self::$container->get('lexik_jwt_authentication.jwt_manager');

        return $jwtManager->create($testCustomer);
    }

    public function testGetProductsList()
    {
        $client = static::createClient();

        $client->request('GET', '/api/products/', [], [], ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->getToken()]);

        $this->assertResponseIsSuccessful();
    }
}