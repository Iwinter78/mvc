<?php

namespace AdvancedBlackJack;
use App\DeckClass\Deck;


class CardCount extends AdvancedBlackJack 
{
    public function countCards(array $hand): int {
        $deck = new Deck();

        $count = 0;
        $rawHand = $deck->toRawData(array_filter($hand));
        $negative = ['J', 'Q', 'K', 'A', '10'];
        $positive = ['2', '3', '4', '5', '6'];

        foreach ($rawHand as $card) {
            if (in_array($card, $negative)) {
                $count--;
            } elseif (in_array($card, $positive)) {
                $count++;
            }
        }

        return $count;
    }
}