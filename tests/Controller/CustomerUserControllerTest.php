<?php

namespace App\Tests\Controller;

class CustomerUserControllerTest extends ApiWebTestCase
{
    public function testGetCustomerUsersList()
    {
        $client = $this->getAuthenticatedClient();

        $client->request('GET', '/api/customer_users');

        $this->assertEquals('[{"id":1,"email":"client1@gmail.com","password":"motdepasse","firstname":"John","lastname":"Doe","@id":"\/api\/customer_users\/1"},{"id":2,"email":"client2@gmail.com","password":"motdepasse","firstname":"John","lastname":"Doe","@id":"\/api\/customer_users\/2"},{"id":3,"email":"client3@gmail.com","password":"motdepasse","firstname":"John","lastname":"Doe","@id":"\/api\/customer_users\/3"}]', $client->getResponse()->getContent());
        $this->assertResponseIsSuccessful();
    }

    public function testGetCustomerUserItem()
    {
        $client = $this->getAuthenticatedClient();

        $client->request('GET', '/api/customer_users/1');

        $this->assertEquals('{"id":1,"email":"client1@gmail.com","password":"motdepasse","firstname":"John","lastname":"Doe"}', $client->getResponse()->getContent());
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

        //todo: json decode
        $this->assertEquals('{"id":111,"email":"test@test.fr","password":"password","firstname":"john","lastname":"doe"}', $client->getResponse()->getContent());
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