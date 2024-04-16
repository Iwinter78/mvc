<?php

namespace App\DeckClass;

class Card
{
    public string $suit;
    public string $value;

    public function __construct(string $suit, string $value)
    {
        $this->suit = $suit;
        $this->value = $value;
    }
}
