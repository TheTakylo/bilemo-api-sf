<?php

namespace App\Tests\Controller;

class ProductControllerTest extends ApiWebTestCase
{
    public function testGetProductsList()
    {
        $client = $this->getAuthenticatedClient();

        $client->request('GET', '/api/products');

        $this->assertResponseIsSuccessful();
    }

    public function testGetProductItem()
    {
        $client = $this->getAuthenticatedClient();

        $client->request('GET', '/api/products/1');

        $this->assertResponseIsSuccessful();
    }

    public function testBadProductId()
    {
        $client = $this->getAuthenticatedClient();

        $client->request('GET', '/api/products/19585632');

        $this->assertEquals('{"message":404}', $client->getResponse()->getContent());
        $this->assertResponseStatusCodeSame(404);
    }

    public function testBadProductUrl()
    {
        $client = $this->getAuthenticatedClient();

        $client->request('GET', '/api/products/badurl');

        $this->assertEquals('{"message":404}', $client->getResponse()->getContent());
        $this->assertResponseStatusCodeSame(404);
    }

    public function testDeleteProductMustFail()
    {
        $client = $this->getAuthenticatedClient();

        $client->request('DELETE', '/api/products/1');

        $this->assertEquals('{"message":405}', $client->getResponse()->getContent());
        $this->assertResponseStatusCodeSame(405);
    }

    public function testAddProductMustFail()
    {
        $client = $this->getAuthenticatedClient();

        $client->request('POST', '/api/products');

        $this->assertEquals('{"message":405}', $client->getResponse()->getContent());
        $this->assertResponseStatusCodeSame(405);
    }
}