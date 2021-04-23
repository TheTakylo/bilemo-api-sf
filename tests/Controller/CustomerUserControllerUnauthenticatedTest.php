<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CustomerUserControllerUnauthenticatedTest extends WebTestCase
{
    public function testGetCustomerUsersListUnauthenticated()
    {
        $client = static::createClient();

        $client->request('GET', '/api/customer_users');

        $this->assertEquals('{"code":401,"message":"JWT Token not found"}', $client->getResponse()->getContent());
        $this->assertResponseStatusCodeSame(401);
    }

    public function testGetCustomerUserItemUnauthenticated()
    {
        $client = static::createClient();

        $client->request('GET', '/api/customer_users/1');

        $this->assertEquals('{"code":401,"message":"JWT Token not found"}', $client->getResponse()->getContent());
        $this->assertResponseStatusCodeSame(401);
    }
}