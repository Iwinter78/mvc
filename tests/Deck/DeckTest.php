<?php

namespace App\DeckClass;

use PHPUnit\Framework\TestCase;
use App\DeckClass\Deck;

/**
 * Test cases for the class Deck.
 */

class DeckTest extends TestCase {
    public function testCreateDeck(): void {
        $deck = new Deck();
        $this->assertInstanceOf("App\DeckClass\Deck", $deck);
    }

    public function testCreateDeckWithArray(): void {
        $deckArray = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];
        $deck = new Deck($deckArray);
        $this->assertInstanceOf("App\DeckClass\Deck", $deck);
    }

    public function testGetDeck(): void {
        $deck = new Deck();
        $retrievedDeck = $deck->getDeck();
        $this->assertIsArray($retrievedDeck);
    }   

    public function testSetDeck(): void {
        $deck = new Deck();
        $myDeck = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];
        $deck->setDeck($myDeck);
        $this->assertEquals($myDeck, $deck->getDeck());
    }
}
