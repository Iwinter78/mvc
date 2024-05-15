<?php

namespace App\DeckClass;

class Deck extends BaseDeck
{
    /**
     * @var array<string>
     */
    public array $deckArray;

    /**
     * @var array<string>
     */
    public array $deck;

    /**
     * @param array<string> $deckArray
     */
    public function __construct(array $deckArray = [])
    {
        parent::__construct();
        if (!empty($deckArray)) {
            $this->createDeck($deckArray);
            return;
        }
        $this->createDeck();
    }

    /**
     * @param string $suit
     * @return string
     */

    private function getSuit(string $suit): string
    {
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
        return $suitClass;
    }

    /**
     * @param string $suitClass
     * @param string $value
     * @param string $suit
     * @param array<string> $redCards
     * @param array<string> $blackCards
     */
    private function assignCard(string $suitClass, string $value, string $suit, array &$redCards, array &$blackCards): void
    {
        $card = '<p class="'. $suitClass . '">' . $value . '</p>' . '<span class="' . $suitClass . '">' . $suit . '</span>';

        if ($suitClass == 'hearts' || $suitClass == 'diamonds') {
            $redCards[] = $card;
            return;
        }
        $blackCards[] = $card;
    }

    /**
     * @param array<string> $deckArray
     * @return array<string>
     */
    public function createDeck(array $deckArray = []): array
    {
        if (!empty($deckArray)) {
            $this->deck = $deckArray;
            return $this->deck;
        }

        $redCards = [];
        $blackCards = [];

        foreach ($this->suits as $suit) {
            foreach ($this->values as $value) {
                $suitClass = $this->getSuit($suit);
                $this->assignCard($suitClass, $value, $suit, $redCards, $blackCards);
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
     * @return array<int, string|null>
     */
    public function drawCards(int $amount): array
    {
        $cards = [];
        for ($i = 0; $i < $amount; $i++) {
            $cards[] = array_shift($this->deck);
        }
        return $cards;
    }

    /**
     * @return array<string>
     */
    public function getDeck(): array
    {
        return $this->deck;
    }

    /**
     * @param array<string> $deckArray
     */
    public function setDeck(array $deckArray): void
    {
        $this->deck = $deckArray;
    }
}
