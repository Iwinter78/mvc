<?php

namespace App\Models;

class Deck extends Card
{
    public function __construct($deckArray = [])
    {
        parent::__construct();
        $this->deck = [];
        if (!empty($deckArray)) {
            $this->create_deck($deckArray);
        } else {
            $this->create_deck();
        }
    }

    public function create_deck($deckArray = [])
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

    public function shuffle_deck()
    {
        return shuffle($this->deck);
    }

    public function to_raw_data($data)
    {
        $raw_data = [];
        foreach ($data as $card) {
            $raw_data[] = strip_tags($card);
        }
        return $raw_data;
    }

    public function draw_cards(int $amount)
    {
        $cards = [];
        for ($i = 0; $i < $amount; $i++) {
            $cards[] = array_shift($this->deck);
        }
        return $cards;
    }
}
