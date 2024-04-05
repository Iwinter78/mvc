<?php

namespace App\Models;

class Deck
{
    function __construct()
    {
        $this->deck = [];
        $this->suits = ['♠', '♣', '♥', '♦'];
        $this->values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
        $this->create_deck();
    }

    function create_deck()
    {
        $redCards = [];
        $blackCards = [];
    
        foreach ($this->suits as $suit) {
            foreach ($this->values as $value) {
                $suitClass = '';
                switch ($suit) {
                    case '♠':
                        $suitClass = 'spades';
                        break;
                    case '♣':
                        $suitClass = 'clubs';
                        break;
                    case '♥':
                        $suitClass = 'hearts';
                        break;
                    case '♦':
                        $suitClass = 'diamonds';
                        break;
                }
                $card = '<p class="'. $suitClass . '">' . $value . '</p>' . '<span class="' . $suitClass . '">' . $suit . '</span>';
    
                if ($suitClass == 'hearts' || $suitClass == 'diamonds') {
                    $redCards[] = $card;
                } else {
                    $blackCards[] = $card;
                }
            }
        }
    
        $this->deck = array_merge($redCards, $blackCards);
        return $this->deck;
    }
}
