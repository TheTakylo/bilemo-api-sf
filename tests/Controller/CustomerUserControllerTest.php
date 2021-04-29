<?php

namespace App\Tests\Controller;

class CustomerUserControllerTest extends ApiWebTestCase
{
    public function testGetCustomerUsersList()
    {
        $client = $this->getAuthenticatedClient();

        $client->request('GET', '/api/customer_users');

        $this->assertResponseIsSuccessful();
    }

    public function testGetCustomerUserItem()
    {
        $client = $this->getAuthenticatedClient();

        $client->request('GET', '/api/customer_users/1');

        $datas = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals("client1@gmail.com", $datas['email']);
        $this->assertEquals("motdepasse", $datas['password']);
        $this->assertEquals("John", $datas['firstname']);
        $this->assertEquals("Doe", $datas['lastname']);
        $this->assertResponseIsSuccessful();
    }

    public function testBadCustomerUserId()
    {
        $client = $this->getAuthenticatedClient();

        $client->request('GET', '/api/customer_users/19585632');

        $this->assertEquals('{"message":404}', $client->getResponse()->getContent());
        $this->assertResponseStatusCodeSame(404);
    }

    public function testBadCustomerUserUrl()
    {
        $client = $this->getAuthenticatedClient();

        $client->request('GET', '/api/customer_users/badurl');

        $this->assertEquals('{"message":404}', $client->getResponse()->getContent());
        $this->assertResponseStatusCodeSame(404);
    }

    public function testDeleteProduct()
    {
        $client = $this->getAuthenticatedClient();

        $client->request('DELETE', '/api/customer_users/1');

        $this->assertEquals('', $client->getResponse()->getContent());
        $this->assertResponseIsSuccessful();
    }

    public function testAddProductWithBadDatas()
    {
        $client = $this->getAuthenticatedClient();

        $client->request('POST', '/api/customer_users',
            [],
            [],
            array('CONTENT_TYPE' => 'application/json'),
            '{"email":"test@test.fr"}');

        $this->assertEquals('{"title":"Validation Failed","errors":{"password":["This value should not be blank."],"firstname":["This value should not be blank."],"lastname":["This value should not be blank."]}}', $client->getResponse()->getContent());
        $this->assertResponseStatusCodeSame(500);
    }

    public function testAddCustomerUser()
    {
        $client = $this->getAuthenticatedClient();

        $client->request('POST', '/api/customer_users',
            [],
            [],
            array('CONTENT_TYPE' => 'application/json'),
            '{"email":"test@test.fr","password":"password","firstname":"john","lastname":"doe"}');

        $datas = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals("test@test.fr", $datas['email']);
        $this->assertEquals("password", $datas['password']);
        $this->assertEquals("john", $datas['firstname']);
        $this->assertEquals("doe", $datas['lastname']);

        $this->assertResponseStatusCodeSame(200);
    }

    public function testGetCustomerUserRelatedToAnotherCustomerMustFail()
    {
        $client = $this->getAuthenticatedClient();

        $client->request('GET', '/api/customer_users/4');

        $this->assertEquals('{"message":404}', $client->getResponse()->getContent());
        $this->assertResponseStatusCodeSame(404);
    }

    public function testDeleteProductLinkedToAnotherCustomerMustFail()
    {
        $client = $this->getAuthenticatedClient();

        $client->request('DELETE', '/api/customer_users/4');

        $this->assertEquals('{"message":404}', $client->getResponse()->getContent());
        $this->assertResponseStatusCodeSame(404);
    }
}