<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use PHPUnit\Framework\TestCase;
use App\DeckClass\Deck;


class CardControllerTest extends WebTestCase
{
    public function testHolderPage(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/card');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('p', 'Kortleken');
        $this->assertSelectorExists('img');
        $this->assertSelectorExists('a');
    }

    public function testRenderDeck(): void
    {
        $client = static::createClient();
    
        $crawler = $client->request('GET', '/card/deck');
    
        $this->assertResponseIsSuccessful();
        $this->assertCount(52, $crawler->filter('span'));
    }

    public function testShuffleCards(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/card/deck/shuffle');

        $this->assertResponseIsSuccessful();
        $this->assertCount(52, $crawler->filter('span'));
    }

    public function testDraw(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/card/deck/draw');

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Draw a card', $crawler->filter('h1')->text());
    }
    //För att kunna skriver fler tester så behövs session.
}