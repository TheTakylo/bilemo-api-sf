<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerUnauthenticatedTest extends WebTestCase
{
    public function testGetProductsListUnauthenticated()
    {
        $client = static::createClient();

        $client->request('GET', '/api/products');

        $this->assertEquals('{"code":401,"message":"JWT Token not found"}', $client->getResponse()->getContent());
        $this->assertResponseStatusCodeSame(401);
    }

    public function testGetProductItemUnauthenticated()
    {
        $client = static::createClient();

        $client->request('GET', '/api/products/1');

        $this->assertEquals('{"code":401,"message":"JWT Token not found"}', $client->getResponse()->getContent());
        $this->assertResponseStatusCodeSame(401);
    }
}