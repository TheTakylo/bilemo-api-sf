<?php

namespace App\Tests\Controller;

class ProductControllerTest extends ApiWebTestCase
{
    public function testGetProductsList()
    {
        $client = $this->getAuthenticatedClient();

        $client->request('GET', '/api/products');

       // $this->assertEquals('[{"id":1,"name":"Samsung S21 5G","brand":"Samsung","price":859,"description":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\u0027s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.","releaseAt":"2021-04-16T00:00:00+02:00","@id":"\/api\/products\/1"},{"id":2,"name":"Samsung S21+ 5G","brand":"Samsung","price":1059,"description":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\u0027s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.","releaseAt":"2021-04-16T00:00:00+02:00","@id":"\/api\/products\/2"},{"id":3,"name":"Samsung S21 Ultra 5G","brand":"Samsung","price":1259,"description":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\u0027s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.","releaseAt":"2021-04-16T00:00:00+02:00","@id":"\/api\/products\/3"},{"id":4,"name":"HUAWEI Mate40 Pro","brand":"HUAWEI","price":1199,"description":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\u0027s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.","releaseAt":"2021-04-16T00:00:00+02:00","@id":"\/api\/products\/4"},{"id":5,"name":"HUAWEI P40 Pro+","brand":"HUAWEI","price":1399,"description":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\u0027s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.","releaseAt":"2021-04-16T00:00:00+02:00","@id":"\/api\/products\/5"},{"id":6,"name":"HUAWEI P40 Pro","brand":"HUAWEI","price":1099,"description":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\u0027s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.","releaseAt":"2021-04-16T00:00:00+02:00","@id":"\/api\/products\/6"},{"id":7,"name":"HUAWEI P40","brand":"HUAWEI","price":799,"description":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\u0027s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.","releaseAt":"2021-04-16T00:00:00+02:00","@id":"\/api\/products\/7"},{"id":8,"name":"iPhone 12 Pro Max","brand":"Apple","price":1259,"description":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\u0027s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.","releaseAt":"2021-04-16T00:00:00+02:00","@id":"\/api\/products\/8"},{"id":9,"name":"iPhone 12 Pro","brand":"Apple","price":1159,"description":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\u0027s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.","releaseAt":"2021-04-16T00:00:00+02:00","@id":"\/api\/products\/9"},{"id":10,"name":"iPhone 12","brand":"Apple","price":809,"description":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\u0027s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.","releaseAt":"2021-04-16T00:00:00+02:00","@id":"\/api\/products\/10"},{"id":11,"name":"OPPO Finx X3 Pro","brand":"OPPO","price":1149,"description":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\u0027s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.","releaseAt":"2021-04-16T00:00:00+02:00","@id":"\/api\/products\/11"},{"id":12,"name":"OPPO Finx X3 Neo","brand":"OPPO","price":799,"description":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\u0027s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.","releaseAt":"2021-04-16T00:00:00+02:00","@id":"\/api\/products\/12"},{"id":13,"name":"OPPO Finx X3 Lite","brand":"OPPO","price":449,"description":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\u0027s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.","releaseAt":"2021-04-16T00:00:00+02:00","@id":"\/api\/products\/13"}]', $client->getResponse()->getContent());
        $this->assertResponseIsSuccessful();
    }

    public function testGetProductItem()
    {
        $client = $this->getAuthenticatedClient();

        $client->request('GET', '/api/products/1');

     //   $this->assertEquals('{"id":1,"name":"Samsung S21 5G","brand":"Samsung","price":859,"description":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\u0027s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.","releaseAt":"2021-04-16T00:00:00+02:00"}', $client->getResponse()->getContent());
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