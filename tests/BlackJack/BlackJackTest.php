<?php

namespace App\BlackJackClass;

use PHPUnit\Framework\TestCase;
use App\BlackJackClass\BlackJack;
use App\BlackJackClass\Player;

/**
 * Test cases for the class BlackJack.
 */

class BlackJackTest extends TestCase {
    public function testCreateBlackJack() {
        $blackjack = new BlackJack();
        $this->assertInstanceOf("\App\BlackJackClass\BlackJack", $blackjack);
    }

    public function testGetPlayerBlackJack() {
        $blackjack = new BlackJack();
        $getPlayer = $blackjack->getPlayer();
        $this->assertInstanceOf("\App\BlackJackClass\Player", $getPlayer);
    }

    public function testGetScorePlayer() {
        $blackjack = new BlackJack();
        $getPlayer = $blackjack->getPlayer();
        $score = $getPlayer->getScore();
        $this->assertIsInt($score);
    }

    public function testGetDealerBlackJack() {
        $blackjack = new BlackJack();
        $getDealer = $blackjack->getDealer();
        $this->assertInstanceOf("\App\BlackJackClass\Player", $getDealer);
    }

    public function testGetDeck() {
        $blackjack = new BlackJack();
        $getDeck = $blackjack->getDeck();
        $this->assertInstanceOf("\App\DeckClass\Deck", $getDeck);
    }

    public function testGetSecondCardDealer() {
        $blackjack = new BlackJack();
        $getSecondCardDealer = $blackjack->getSecondCardDealer();
        $this->assertIsArray($getSecondCardDealer);
    }

    public function testStartGame() {
        $blackjack = new BlackJack();
        $blackjack->startGame();
        $getPlayer = $blackjack->getPlayer();
        $getDealer = $blackjack->getDealer();
        $this->assertIsArray($getPlayer->getHand());
        $this->assertIsArray($getDealer->getHand());
    }

    public function testHitPlayer() {
        $blackjack = new BlackJack();
        $blackjack->startGame();
        $getPlayer = $blackjack->getPlayer();
        $blackjack->dealCard();
        $this->assertIsArray($getPlayer->getHand());
    }

    public function testStandDealer() {
        $blackjack = new BlackJack();
        $blackjack->startGame();
        $getDealer = $blackjack->getDealer();
        $blackjack->stand();
        $this->assertIsArray($getDealer->getHand());
        $this->assertGreaterThanOrEqual(2, count($getDealer->getHand()));
    }

    public function testRevealSecondCardDealer() {
        $blackjack = new BlackJack();
        $blackjack->startGame();
        $getSecondCardDealer = $blackjack->getSecondCardDealer();
        $this->assertIsArray($getSecondCardDealer);
    }

    public function testCompareResults() {
        $blackjack = new BlackJack();
        $blackjack->startGame();
        $getPlayer = $blackjack->getPlayer();
        $getDealer = $blackjack->getDealer();
        $blackjack->stand();
        $result = $blackjack->compareResults();
        $this->assertIsString($result);
    }

    public function testCompareResultsLost() {
        $blackjack = new BlackJack();
        $blackjack->startGame();
        $getPlayer = $blackjack->getPlayer();
        $getDealer = $blackjack->getDealer();
        $getPlayer->setScore(22);
        $getDealer->setScore(21);
        $result = $blackjack->compareResults();
        $this->assertEquals("Du förlorade!", $result);
    }
    
    public function testCompareResultsWin() {
        $blackjack = new BlackJack();
        $blackjack->startGame();
        $getPlayer = $blackjack->getPlayer();
        $getDealer = $blackjack->getDealer();
        $getPlayer->setScore(21);
        $getDealer->setScore(20);
        $result = $blackjack->compareResults();
        $this->assertEquals("Du vann!", $result);
    }

    public function testCompareResultsDraw() {
        $blackjack = new BlackJack();
        $blackjack->startGame();
        $getPlayer = $blackjack->getPlayer();
        $getDealer = $blackjack->getDealer();
        $getPlayer->setScore(20);
        $getDealer->setScore(20);
        $result = $blackjack->compareResults();
        $this->assertEquals("Lika!", $result);}
    
    public function testCompareResultsDealerBust() {
        $blackjack = new BlackJack();
        $blackjack->startGame();
        $getPlayer = $blackjack->getPlayer();
        $getDealer = $blackjack->getDealer();
        $getPlayer->setScore(20);
        $getDealer->setScore(22);
        $result = $blackjack->compareResults();
        $this->assertEquals("Banken blev tjock, du vinner!", $result);
    }

    public function compareResultsPlayerLost() {
        $blackjack = new BlackJack();
        $blackjack->startGame();
        $getPlayer = $blackjack->getPlayer();
        $getDealer = $blackjack->getDealer();
        $getPlayer->setScore(15);
        $getDealer->setScore(20);
        $result = $blackjack->compareResults();
        $this->assertEquals("Du förlorade!", $result);
    }

    public function testCalculateScore() {
        $blackjack = new BlackJack();
        $score = $blackjack->calculateScore(["A", "K"]);
        $this->assertIsInt($score);
    }

    public function testCalculateScoreWithExtraAce() {
        $blackjack = new BlackJack();
        $score = $blackjack->calculateScore(["A", "A", "K"]);
        $this->assertEquals(12, $score);
    }

    public function testCalculateScoreEmptyArray() {
        $blackjack = new BlackJack();
        $score = $blackjack->calculateScore([]);
        $this->assertEquals(0, $score);
    }
}

