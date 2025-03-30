<?php

namespace App\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProfilesListApiTest extends WebTestCase
{
    public function testCalculationsEndpointReturnsValidJson()
    {
        $client = static::createClient();

        $client->request('GET', '/api/v1/profiles');
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), 'Статус ответа должен быть 200.');
        $content = $response->getContent();
        $this->assertJson($content, 'Ответ должен быть валидным JSON.');

        $data = json_decode($content, true);
        if ($data) {
            $firstElement = $data[0];
            $this->assertArrayHasKey('id', $firstElement, 'В ответе должен присутствовать ключ "id".');
            $this->assertArrayHasKey('name', $firstElement, 'В ответе должен присутствовать ключ "name".');
        }
    }
}
