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

        // TODO: comment verifier le token qui change ?
        // $this->assertEquals('{"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MTkxNjY4OTUsImV4cCI6MTYxOTE3MDQ5NSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoiYWRtaW5AbWFya2V0cGxhY2UxLmZyIn0.aP6kARewnQOM2jcfKr-ak-Fg5pE9uLLefXFXKiJxTL7lpahnD_Ttvr2ft9iGYBwwTzq82XPcklH-qOFpA0UChb0yaI_nhtzTum0uh4RWGx9bEXQOR-8BU7Ca9h-qSvLAAYtFFfWyBE0qgAjVU0SoRY47QEKO9sz5bu8pgIhCtfXUQB7kUCnacb_7Nk_q4NvwyrrmbRexH6NfznrnjmA1aBTiCHrahqZ66zJ_FWxxmnjcjENzqC0ewP13npjq9oJKWDTRR4Dj7vinYFuI0MsqTzwWVhA-fPUJ5qnLffdO8Tl1CKG82PeFbV1WYotdlFB4ERF6BtwZ4tflhwVMi27Z1g"}', $client->getResponse()->getContent());
        $this->assertResponseStatusCodeSame(200);
    }
}