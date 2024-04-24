<?php

namespace App\BlackJackClass;

Class Player {
    private $hand;
    private $score;

    public function __construct() {
        $this->hand = [];
        $this->score = 0;
    }

    public function getHand(): array {
        return $this->hand;
    }

    public function setHand($hand): void {
        $this->hand = $hand;
    }

    public function getScore(): int {
        return $this->score;
    }

    public function setScore($score): void {
        $this->score = $score;
    }
}
