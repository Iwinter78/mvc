<?php

namespace App\BlackJackClass;

use PHPUnit\Framework\TestCase;
use App\BlackJackClass\BlackJack;
use App\BlackJackClass\Player;

/**
 * Test cases for the class BlackJack.
 */

class BlackJackTest extends TestCase {
    public function testCreateBlackJack(): void {
        $blackjack = new BlackJack();
        $this->assertInstanceOf("\App\BlackJackClass\BlackJack", $blackjack);
    }

    public function testGetPlayerBlackJack(): void {
        $blackjack = new BlackJack();
        $getPlayer = $blackjack->getPlayer();
        $this->assertInstanceOf("\App\BlackJackClass\Player", $getPlayer);
    }

    public function testGetScorePlayer(): void {
        $blackjack = new BlackJack();
        $getPlayer = $blackjack->getPlayer();
        $score = $getPlayer->getScore();
        $this->assertIsInt($score);
    }

    public function testGetDealerBlackJack(): void {
        $blackjack = new BlackJack();
        $getDealer = $blackjack->getDealer();
        $this->assertInstanceOf("\App\BlackJackClass\Player", $getDealer);
    }

    public function testGetDeck(): void {
        $blackjack = new BlackJack();
        $getDeck = $blackjack->getDeck();
        $this->assertInstanceOf("\App\DeckClass\Deck", $getDeck);
    }

    public function testGetSecondCardDealer(): void {
        $blackjack = new BlackJack();
        $getSecondCardDealer = $blackjack->getSecondCardDealer();
        $this->assertIsArray($getSecondCardDealer);
    }

    public function testStartGame(): void {
        $blackjack = new BlackJack();
        $blackjack->startGame();
        $getPlayer = $blackjack->getPlayer();
        $getDealer = $blackjack->getDealer();
        $this->assertIsArray($getPlayer->getHand());
        $this->assertIsArray($getDealer->getHand());
    }

    public function testHitPlayer(): void {
        $blackjack = new BlackJack();
        $blackjack->startGame();
        $getPlayer = $blackjack->getPlayer();
        $blackjack->dealCard();
        $this->assertIsArray($getPlayer->getHand());
    }

    public function testStandDealer():void {
        $blackjack = new BlackJack();
        $blackjack->startGame();
        $getDealer = $blackjack->getDealer();
        $blackjack->stand();
        $this->assertIsArray($getDealer->getHand());
        $this->assertGreaterThanOrEqual(2, count($getDealer->getHand()));
    }

    public function testRevealSecondCardDealer(): void {
        $blackjack = new BlackJack();
        $blackjack->startGame();
        $getSecondCardDealer = $blackjack->getSecondCardDealer();
        $this->assertIsArray($getSecondCardDealer);
    }

    public function testCompareResults(): void {
        $blackjack = new BlackJack();
        $blackjack->startGame();
        $getPlayer = $blackjack->getPlayer();
        $getDealer = $blackjack->getDealer();
        $blackjack->stand();
        $result = $blackjack->compareResults();
        $this->assertIsString($result);
    }

    public function testCompareResultsLost(): void {
        $blackjack = new BlackJack();
        $blackjack->startGame();
        $getPlayer = $blackjack->getPlayer();
        $getDealer = $blackjack->getDealer();
        $getPlayer->setScore(22);
        $getDealer->setScore(21);
        $result = $blackjack->compareResults();
        $this->assertEquals("Du förlorade!", $result);
    }
    
    public function testCompareResultsWin(): void {
        $blackjack = new BlackJack();
        $blackjack->startGame();
        $getPlayer = $blackjack->getPlayer();
        $getDealer = $blackjack->getDealer();
        $getPlayer->setScore(21);
        $getDealer->setScore(20);
        $result = $blackjack->compareResults();
        $this->assertEquals("Du vinner!", $result);
    }

    public function testCompareResultsDraw(): void {
        $blackjack = new BlackJack();
        $blackjack->startGame();
        $getPlayer = $blackjack->getPlayer();
        $getDealer = $blackjack->getDealer();
        $getPlayer->setScore(20);
        $getDealer->setScore(20);
        $result = $blackjack->compareResults();
        $this->assertEquals("Lika!", $result);}
    
    public function testCompareResultsDealerBust(): void {
        $blackjack = new BlackJack();
        $blackjack->startGame();
        $getPlayer = $blackjack->getPlayer();
        $getDealer = $blackjack->getDealer();
        $getPlayer->setScore(20);
        $getDealer->setScore(22);
        $result = $blackjack->compareResults();
        $this->assertEquals("Du vinner!", $result);
    }

    public function testCompareResultsPlayerLost(): void {
        $blackjack = new BlackJack();
        $blackjack->startGame();
        $getPlayer = $blackjack->getPlayer();
        $getDealer = $blackjack->getDealer();
        $getPlayer->setScore(15);
        $getDealer->setScore(20);
        $result = $blackjack->compareResults();
        $this->assertEquals("Du förlorade!", $result);
    }

    public function testPlayerLoseWithLowerScore(): void {
        $blackjack = new BlackJack();
        $blackjack->startGame();
        $getPlayer = $blackjack->getPlayer();
        $getDealer = $blackjack->getDealer();
        $getPlayer->setScore(15);
        $getDealer->setScore(20);
        $result = $blackjack->compareResults();
        $this->assertEquals("Du förlorade!", $result);
    }

    public function testCalculateScore(): void {
        $blackjack = new BlackJack();
        $score = $blackjack->calculateScore(["A", "K"]);
        $this->assertIsInt($score);
    }

    public function testCalculateScoreWithExtraAce(): void {
        $blackjack = new BlackJack();
        $score = $blackjack->calculateScore(["A", "A", "K"]);
        $this->assertEquals(12, $score);
    }

    public function testCalculateScoreEmptyArray(): void {
        $blackjack = new BlackJack();
        $score = $blackjack->calculateScore([]);
        $this->assertEquals(0, $score);
    }

    public function testPreCheckPlayerWin(): void {
        $blackjack = new BlackJack();
        $blackjack->startGame();
        $getPlayer = $blackjack->getPlayer();
        $getPlayer->setScore(21);
        $result = $blackjack->preCheckPlayerWin();
        $this->assertTrue($result);
    }

    public function testPreCheckPlayerWinFalse(): void {
        $blackjack = new BlackJack();
        $blackjack->startGame();
        $getPlayer = $blackjack->getPlayer();
        $getPlayer->setScore(20);
        $result = $blackjack->preCheckPlayerWin();
        $this->assertFalse($result);
    }
    
    public function testCheckIfAnyWon(): void {
        $blackjack = new BlackJack();
        $blackjack->startGame();
        $getPlayer = $blackjack->getPlayer();
        $getPlayer->setScore(22);
        $result = $blackjack->checkIfAnyWon();
        $this->assertTrue($result);
    }

    public function testCheckIfAnyWonFalse(): void {
        $blackjack = new BlackJack();
        $blackjack->startGame();
        $getPlayer = $blackjack->getPlayer();
        $getPlayer->setScore(20);
        $result = $blackjack->checkIfAnyWon();
        $this->assertFalse($result);
    }
}

