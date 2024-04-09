<?php

namespace App\Models;

class Deck extends Card
{
    function __construct($deckArray = [])
    {
        parent::__construct();
        $this->deck = [];
        if (!empty($deckArray)) {
            $this->create_deck($deckArray);
        } else {
            $this->create_deck();
        }
    }

    function create_deck($deckArray = [])
    {
        if (!empty($deckArray)) {
            $this->deck = $deckArray;
            return $this->deck;
        }

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

    function shuffle_deck()
    {
        return shuffle($this->deck);
    }

    function draw_cards(int $amount)
    {
        $cards = [];
        for ($i = 0; $i < $amount; $i++) {
            $cards[] = array_pop($this->deck);
        }
        return $cards;
    }
}
