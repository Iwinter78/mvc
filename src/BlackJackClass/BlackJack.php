<?php

namespace App\BlackJackClass;

use App\DeckClass\Deck;
use App\BlackJackClass\Player;

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

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function getDealer(): Player
    {
        return $this->dealer;
    }

    public function getDeck(): Deck
    {
        return $this->deck;
    }
    /**
     * @return array<int, string|null>
     */
    public function getSecondCardDealer(): array
    {
        return $this->secondCardDealer;
    }

    public function startGame(): void
    {
        $this->deck->shuffleDeck();
        $this->player->setHand($this->deck->drawCards(2));
        $this->dealer->setHand($this->deck->drawCards(1));
        $this->secondCardDealer = $this->deck->drawCards(1);
    }

    /**
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

    public function dealCard(): void
    {
        if ($this->player->getScore() < 21) {
            $this->player->setHand(array_merge($this->player->getHand(), $this->deck->drawCards(1)));
            $this->player->setScore($this->calculateScore($this->player->getHand()));
        }
    }

    public function revealSecondCardDealer(): void
    {
        $this->dealer->setHand(array_merge($this->dealer->getHand(), $this->secondCardDealer));
        $this->dealer->setScore($this->calculateScore($this->dealer->getHand()));
    }

    public function stand(): void
    {
        $this->revealSecondCardDealer();
        while ($this->dealer->getScore() < 17) {
            $this->dealer->setHand(array_merge($this->dealer->getHand(), $this->deck->drawCards(1)));
            $this->dealer->setScore($this->calculateScore($this->dealer->getHand()));
        }
    }

    public function compareResults(): string
    {
        $playerScore = $this->player->getScore();
        $dealerScore = $this->dealer->getScore();
        if ($playerScore > 21) {
            return 'Du förlorade!';
        } elseif ($dealerScore > 21) {
            return 'Banken blev tjock, du vinner!';
        } elseif ($playerScore > $dealerScore) {
            return 'Du vann!';
        } elseif ($playerScore < $dealerScore) {
            return 'Du förlorade!';
        } elseif ($playerScore == $dealerScore) {
            return 'Lika!';
        }
        return 'Någonting gick fel!';
    }
}
