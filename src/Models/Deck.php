<?php

namespace App\Models;

class Deck extends Card
{   
    /**
     * @var string[]
     */
    public array $deck;

    /**
     * @var string[]
     */
    public array $deckArray;
    
    /**
     * @param array<string> $deckArray
     */
    public function __construct(array $deckArray = [])
    {
        parent::__construct();
        $this->deck = [];
        if (!empty($deckArray)) {
            $this->createDeck($deckArray);
            return;
        }
        $this->createDeck();
    }

    /**
     * @param array<string> $deckArray
     * @return array<string>
     */
    public function createDeck(array $deckArray = []) : array
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
                    continue;
                }
                $blackCards[] = $card;
            }
        }
    
        $this->deck = array_merge($redCards, $blackCards);
        return $this->deck;
    }

    /**
     * @return bool
     */
    public function shuffleDeck(): bool
    {
        return shuffle($this->deck);
    }
    /**
     * @param array<string> $data
     * @return array<string>
     */
    public function toRawData(array $data): array
    {
        $rawData = [];
        foreach ($data as $card) {
            $rawData[] = strip_tags($card);
        }
        return $rawData;
    }

    /**
     * @param int $amount
     * @return array<int<0, max>, string|null>
     */
    public function drawCards(int $amount) : array
    {
        $cards = [];
        for ($i = 0; $i < $amount; $i++) {
            $cards[] = array_shift($this->deck);
        }
        return $cards;
    }
}
