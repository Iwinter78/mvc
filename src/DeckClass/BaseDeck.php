<?php

namespace App\DeckClass;

class BaseDeck
{
    /**
     * @var array<string>
     */
    protected array $suits = ['♠', '♣', '♥', '♦'];
    /**
     * @var array<string>
     */
    protected array $values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
    /**
     * @var array<Card>
     */
    protected array $cards = [];

    public function __construct()
    {
        foreach ($this->suits as $suit) {
            foreach ($this->values as $value) {
                $this->cards[] = new Card($suit, $value);
            }
        }
    }
}
