<?php

namespace App\BlackJackClass;

use App\DeckClass\Deck;
use App\BlackJackClass\Player;

/**
 * Class controlling the game BlackJack
 */
class BlackJack
{
    /**
     * @var Player $player
     */
    private Player $player;
    /**
     * @var Player $dealer
     */
    private Player $dealer;
    /**
     * @var Deck $deck
     */
    private Deck $deck;
    /**
     * @var array<int, string|null> $secondCardDealer
     */
    private array $secondCardDealer;

    public function __construct()
    {
        $this->player = new Player();
        $this->dealer = new Player();
        $this->deck = new Deck();
        $this->secondCardDealer = [];
    }
    /**
     * Fetches the player from the class
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }

    /**
     * Fetches the dealer from the class
     * @return Player
     */
    public function getDealer(): Player
    {
        return $this->dealer;
    }

    /**
     * Fetches the deck from the class
     * @return Deck
     */
    public function getDeck(): Deck
    {
        return $this->deck;
    }


    /**
     * Gets the second card that the dealer has
     * @return array<int, string|null>
     */
    public function getSecondCardDealer(): array
    {
        return $this->secondCardDealer;
    }

    /**
     * Starts the new round of the game.
     */
    public function startGame(): void
    {
        $this->deck->shuffleDeck();
        $this->player->setHand($this->deck->drawCards(2));
        $this->dealer->setHand($this->deck->drawCards(1));
        $this->secondCardDealer = $this->deck->drawCards(1);
    }

    /**
     * Calculates the score of a single hand
     * @param array<int, string|null> $hand
     */
    public function calculateScore(array $hand): int
    {
        $score = 0;
        $aceCount = 0;
        $rawHand = $this->deck->toRawData(array_filter($hand));

        foreach ($rawHand as $card) {
            $value = substr($card, 0, 2) == '10' ? '10' : substr($card, 0, 1);

            if (is_numeric($value)) {
                $score += (int)$value;
                continue;
            }

            if ($value == 'A') {
                $score += 11;
                $aceCount++;
                continue;
            }

            $score += 10;
        }

        while ($score > 21 && $aceCount > 0) {
            $score -= 10;
            $aceCount--;
        }

        return $score;
    }

    /**
     * Deals another card to the player
     */
    public function dealCard(): void
    {
        if ($this->player->getScore() < 21) {
            $this->player->setHand(array_merge($this->player->getHand(), $this->deck->drawCards(1)));
            $this->player->setScore($this->calculateScore($this->player->getHand()));
        }
    }

    /**
     * Reveals the second card the dealer has. This by mearging the second card array to dealers current array.
     */
    public function revealSecondCardDealer(): void
    {
        $this->dealer->setHand(array_merge($this->dealer->getHand(), $this->secondCardDealer));
        $this->dealer->setScore($this->calculateScore($this->dealer->getHand()));
    }

    public function preCheckPlayerWin(): bool
    {
        if ($this->player->getScore() === 21) {
            $this->revealSecondCardDealer();
            return true;
        }
        return false;
    }

    public function checkIfAnyWon(): bool
    {
        if ($this->player->getScore() > 21 || $this->dealer->getScore() > 21) {
            $this->stand();
            return true;
        }
        return false;
    }

    /**
     * Makes the dealer stand by drawing cards until it get's 17 or more.
     */
    public function stand(): void
    {
        $this->revealSecondCardDealer();
        while ($this->dealer->getScore() < 17) {
            $this->dealer->setHand(array_merge($this->dealer->getHand(), $this->deck->drawCards(1)));
            $this->dealer->setScore($this->calculateScore($this->dealer->getHand()));
        }
    }
    /**
     * Compares the results between the dealer and player. Returns a string with the result.
     * @return string
     */
    public function compareResults(): string
    {
        $playerScore = $this->player->getScore();
        $dealerScore = $this->dealer->getScore();

        if ($playerScore > 21) {
            return 'Du förlorade!';
        }

        if ($dealerScore > 21 || $playerScore > $dealerScore) {
            return 'Du vinner!';
        }

        if ($playerScore < $dealerScore) {
            return 'Du förlorade!';
        }

        return 'Lika!';
    }
}
