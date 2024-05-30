<?php

namespace App\BlackJackClass;

use PHPUnit\Framework\TestCase;
use App\BlackJackClass\AdvancedBlackJack;
use App\BlackJackClass\Player;

/**
 * Test cases for the class AdvancedBlackJack.
 */

class AdvancedBlackJackTest extends TestCase
{
    public function testCreateAdvancedBlackJackInstance(): void
    {
        $advancedBlackJack = new AdvancedBlackJack(1, 1);
        $this->assertInstanceOf("\App\BlackJackClass\AdvancedBlackJack", $advancedBlackJack);
    }

    public function testGetPlayers(): void
    {
        $advancedBlackJack = new AdvancedBlackJack(2, 1);
        $players = $advancedBlackJack->getPlayers();
        $this->assertIsArray($players);
        $this->assertInstanceOf("\App\BlackJackClass\Player", $players[0]);
    }

    public function testGetDealer(): void
    {
        $advancedBlackJack = new AdvancedBlackJack(2, 1);
        $dealer = $advancedBlackJack->getDealer();
        $this->assertInstanceOf("\App\BlackJackClass\Player", $dealer);
    }

    public function testGetDecks(): void
    {
        $advancedBlackJack = new AdvancedBlackJack(1, 1);
        $decks = $advancedBlackJack->getDecks();
        $this->assertIsArray($decks);
        $this->assertInstanceOf("\App\DeckClass\Deck", $decks[0]);
    }

    public function testGetSecondCardDealer(): void
    {
        $advancedBlackJack = new AdvancedBlackJack(1, 1);
        $secondCardDealer = $advancedBlackJack->getSecondCardDealer();
        $this->assertIsArray($secondCardDealer);
    }

    public function testSetSecondCardDealer(): void
    {
        $advancedBlackJack = new AdvancedBlackJack(1, 1);
        $advancedBlackJack->setSecondCardDealer(["A"]);
        $secondCardDealer = $advancedBlackJack->getSecondCardDealer();
        $this->assertIsArray($secondCardDealer);
        $this->assertEquals(["A"], $secondCardDealer);
    }

    public function testSetHand(): void
    {
        $advancedBlackJack = new AdvancedBlackJack(1, 1);
        $player = new Player();
        $advancedBlackJack->setHand($player, ["A"]);
        $hand = $player->getHand();
        $this->assertIsArray($hand);
        $this->assertEquals(["A"], $hand);
    }

    public function testStartGame(): void
    {
        $advancedBlackJack = new AdvancedBlackJack(1, 1);
        $advancedBlackJack->startGame();
        $players = $advancedBlackJack->getPlayers();
        $dealer = $advancedBlackJack->getDealer();
        $getDealerSecondCard = $advancedBlackJack->getSecondCardDealer();

        $this->assertIsArray($players[0]->getHand());
        $this->assertIsArray($dealer->getHand());
        $this->assertGreaterThanOrEqual(2, count($players[0]->getHand()));
        $this->assertEquals(1, count($dealer->getHand()));
        $this->assertIsArray($getDealerSecondCard);
        $this->assertEquals(1, count($getDealerSecondCard));
    }

    public function testHit(): void
    {
        $advancedBlackJack = new AdvancedBlackJack(1, 1);
        $advancedBlackJack->startGame();
        $players = $advancedBlackJack->getPlayers();
        $advancedBlackJack->hit($players[0]);
        $hand = $players[0]->getHand();
        $this->assertIsArray($hand);
        $this->assertGreaterThanOrEqual(2, count($hand));
    }

    public function testStand(): void
    {
        $advancedBlackJack = new AdvancedBlackJack(2, 1);
        $advancedBlackJack->startGame();
        $player = $advancedBlackJack->getPlayers();
        $player[0]->setStand(true);
        $this->assertTrue($player[0]->getStand());
    }

    public function testDealerDraw(): void
    {
        mt_srand(100);

        $advancedBlackJack = new AdvancedBlackJack(1, 1);
        $advancedBlackJack->startGame();
        $players = $advancedBlackJack->getPlayers();

        foreach ($players as $player) {
            $player->setStand(true);
        }

        $advancedBlackJack->dealerDraw();
        $dealer = $advancedBlackJack->getDealer();

        $hand = $dealer->getHand();

        $this->assertIsArray($hand);
        $this->assertGreaterThanOrEqual(2, count($hand));
    }

    public function testCalculateTotalCount(): void
    {
        mt_srand(100);
        $advancedBlackJack = new AdvancedBlackJack(1, 1);
        $advancedBlackJack->startGame();
        $players = $advancedBlackJack->getPlayers();
        $dealer = $advancedBlackJack->getDealer();
        $currentCount = $advancedBlackJack->calculateTotalCount($players, $dealer);
        $this->assertIsInt($currentCount);
        $this->assertEquals(1, $currentCount);
    }

    public function testHasAllPlayersStoodFalse(): void
    {
        $advancedBlackJack = new AdvancedBlackJack(2, 1);
        $advancedBlackJack->startGame();
        $firstPlayer = $advancedBlackJack->getPlayers()[0];
        $firstPlayer->setStand(true);
        $advancedBlackJack->dealerDraw();
        $result = $advancedBlackJack->compareWinners();
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function testHasAllPlayersStoodTrue(): void
    {
        $advancedBlackJack = new AdvancedBlackJack(2, 1);
        $advancedBlackJack->startGame();
        $players = $advancedBlackJack->getPlayers();
        foreach ($players as $player) {
            $player->setStand(true);
        }
        $result = $advancedBlackJack->compareWinners();
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
    }

    public function testCompareWinnersPlayerBust(): void
    {
        $advancedBlackJack = new AdvancedBlackJack(1, 1);
        $advancedBlackJack->startGame();
        $player = $advancedBlackJack->getPlayers()[0];
        $dealer = $advancedBlackJack->getDealer();
        $player->setScore(22);
        $player->setStand(true);
        $dealer->setScore(20);
        $result = $advancedBlackJack->compareWinners();
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertEquals("Du förlorade!", $result[0]);
    }

    public function testCompareWinnersDealerBust(): void
    {
        $advancedBlackJack = new AdvancedBlackJack(1, 1);
        $advancedBlackJack->startGame();
        $player = $advancedBlackJack->getPlayers()[0];
        $dealer = $advancedBlackJack->getDealer();
        $player->setScore(20);
        $player->setStand(true);
        $dealer->setScore(22);
        $result = $advancedBlackJack->compareWinners();
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertEquals("Du vann!", $result[0]);
    }

    public function testcompareWinnersPlayerLowerThanDealer(): void
    {
        $advancedBlackJack = new AdvancedBlackJack(1, 1);
        $advancedBlackJack->startGame();
        $player = $advancedBlackJack->getPlayers()[0];
        $dealer = $advancedBlackJack->getDealer();
        $player->setScore(20);
        $player->setStand(true);
        $dealer->setScore(21);
        $result = $advancedBlackJack->compareWinners();
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertEquals("Du förlorade!", $result[0]);
    }

    public function testCompareWinnersDraw(): void
    {
        $advancedBlackJack = new AdvancedBlackJack(1, 1);
        $advancedBlackJack->startGame();
        $player = $advancedBlackJack->getPlayers()[0];
        $dealer = $advancedBlackJack->getDealer();
        $player->setScore(20);
        $player->setStand(true);
        $dealer->setScore(20);
        $result = $advancedBlackJack->compareWinners();
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertEquals("Lika!", $result[0]);
    }

    public function testResetRound(): void
    {
        $advancedBlackJack = new AdvancedBlackJack(1, 1);
        $advancedBlackJack->startGame();
        $players = $advancedBlackJack->getPlayers();
        $dealer = $advancedBlackJack->getDealer();
        $players[0]->setStand(true);
        $advancedBlackJack->dealerDraw();
        $advancedBlackJack->compareWinners();
        $advancedBlackJack->resetRound();

        $players = $advancedBlackJack->getPlayers();
        $dealer = $advancedBlackJack->getDealer();

        $this->assertIsArray($players);
        $this->assertEmpty($players[0]->getHand());
        $this->assertEquals(0, $players[0]->getScore());
        $this->assertFalse($players[0]->getStand());

        $this->assertEmpty($dealer->getHand());
        $this->assertEquals(0, $dealer->getScore());
    }

    public function testHitAndGet21(): void
    {
        $advancedBlackJack = new AdvancedBlackJack(1, 1);
        $advancedBlackJack->startGame();
        $player = $advancedBlackJack->getPlayers()[0];
        $player->setHand(["A", "K"]);
        $player->setScore(21);
        $advancedBlackJack->hit($player);
        $this->assertTrue($player->getStand());
    }
}
