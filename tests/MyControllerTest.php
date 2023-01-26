<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MyControllerTest extends WebTestCase
{
    const SERVER_OPTIONS = [
        'HTTP_HOST' => 'localhost:8000',
    ];
    public function testBrowseAll(): void
    {
        $client = static::createClient([], self::SERVER_OPTIONS);
        $client->request('GET', '/browse');
        $response = $client->getResponse();

        $this->assertTrue($response->getContent() === "Tous les genres");
    }

    public function testBrowseSpecific(): void
    {
        $client = static::createClient([], self::SERVER_OPTIONS);
        $randomGenre = 'HIP-H'.rand(1, 10).'P';
        $client->request('GET', "/browse/{$randomGenre}");
        $response = $client->getResponse();
        $this->assertTrue($response->getContent() === $randomGenre);
    }

    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $content = $client->getResponse()->getContent();

        $this->assertResponseIsSuccessful();
        // $this->assertSelectorTextContains('h1', 'Hello World');
        $this->assertTrue($content == 'PHP EIYUU');
    }
}
