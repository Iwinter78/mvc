<?php

namespace App\BlackJackClass;

class Player
{
    /**
     * @var array<int, string|null> $hand
     */
    private array $hand;
    /**
     * @var int $score
     */
    private int $score;

    private $stand = false;

    public function __construct()
    {
        $this->hand = [];
        $this->score = 0;
    }

    /**
     * @return array<int, string|null>
     */
    public function getHand(): array
    {
        return $this->hand;
    }
    /**
     * @param array<int, string|null> $hand
     */
    public function setHand(array $hand): void
    {
        $this->hand = $hand;
    }
    /**
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }
    /**
     * @param int $score
     */
    public function setScore(int $score): void
    {
        $this->score = $score;
    }

    public function getStand(): bool
    {
        return $this->stand;
    }

    public function setStand(bool $stand): void
    {
        $this->stand = $stand;
    }
}
