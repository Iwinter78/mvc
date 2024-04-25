<?php

namespace App\BlackJackClass;

class Player
{
    private array $hand;
    private int $score;

    public function __construct()
    {
        $this->hand = [];
        $this->score = 0;
    }

    public function getHand(): array
    {
        return $this->hand;
    }

    public function setHand($hand): void
    {
        $this->hand = $hand;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore($score): void
    {
        $this->score = $score;
    }
}
