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

    public function testAddBook(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/library/addbook');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form');
    }

    public function testShowBooks(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/library/showbooks');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('section');
        $this->assertSelectorExists('div');
        $this->assertSelectorExists('a');
        $this->assertSelectorExists('h2');
    }

    public function testShowSingleBook(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/library/showsbook/Hungerspelen');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('section');
        $this->assertSelectorExists('div');
        $this->assertSelectorExists('a');
        $this->assertSelectorExists('h2');
    }

    public function testEditBook(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/library/editbook/9789179751221');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form');
        $this->assertSelectorExists('input');
    }
}