<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use PHPUnit\Framework\TestCase;

class LibraryControllerTest extends WebTestCase
{
    public function testLibraryIndex(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/library');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('section');
        $this->assertSelectorExists('a');
    }
}