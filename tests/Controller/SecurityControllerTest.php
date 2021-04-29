<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testGetCustomerUsersListUnauthenticated()
    {
        $client = static::createClient();

        $client->request('POST', '/api/login_check',
            [],
            [],
            array('CONTENT_TYPE' => 'application/json'),
            '{"username":"admin@marketplace1.fr","password":"motdepasse"}');

        $datas = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(true, isset($datas['token']));
        $this->assertResponseStatusCodeSame(200);
    }
}