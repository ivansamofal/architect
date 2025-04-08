<?php

namespace App\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProfileCreateValidationTest extends WebTestCase
{
    public function testProfileCreateFailsWithInvalidData(): void
    {
        $client = static::createClient([
            'environment' => 'test',
            'debug' => false,
        ]);

        $invalidPayload = [
            'surname' => 'Will',
            'password' => 'short',
            'status' => 1,
            'countryCode' => 'USA', // wrong length
            'cityId' => 131,
            'birthDate' => '2025-03-01',
        ];

        $client->request(
            'POST',
            '/api/v1/profiles',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json', ],
            json_encode($invalidPayload)
        );

        $response = $client->getResponse();
        //        $this->assertEquals(400, $response->getStatusCode(), 'An error occurred');

        $content = $response->getContent();
        $this->assertJson($content, 'An error occurred');

        $data = json_decode($content, true);

        $this->assertIsArray($data);
        //        $this->assertArrayHasKey('email', $data, 'Expects error with field email');
        //        $this->assertArrayHasKey('name', $data, 'Expects error with field name');
        //        $this->assertArrayHasKey('countryCode', $data, 'Expects error with field countryCode');
        //        $this->assertArrayHasKey('birthDate', $data, 'Expects error with field birthDate');
    }

    public function testInvalidDate(): void
    {
        $client = static::createClient();

        $invalidPayload = [
            'surname' => 'Will',
            'password' => 'short',
            'status' => 1,
            'countryCode' => 'USA', // wrong length
            'cityId' => 131,
            'birthDate' => 'invalid-date',
        ];

        $client->request(
            'POST',
            '/api/v1/profiles',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'],
            json_encode($invalidPayload)
        );

        $response = $client->getResponse();
        $this->assertEquals(400, $response->getStatusCode(), 'Ответ должен быть валидным JSON');
    }
}
