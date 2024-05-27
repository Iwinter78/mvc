<?php

namespace App\BlackJackClass;

use App\DeckClass\Deck;
use App\BlackJackClass\Player;
use App\BlackJackClass\BlackJack;

class AdvancedBlackJack 
{
    function __construct(int $players, int $decks) {
        $this->players = $players;
        $this->dealer = new Player();
        $this->decks = [];
        $this->players = [];
        $this->secondCardDealer = [];

        for ($i = 0; $i < $players; $i++) {
            $this->players[] = new Player();
        }

        for ($i = 0; $i < $decks; $i++) {
            $deck = new Deck();
            $this->decks[] = $deck;
            $this->deck = array_merge($this->decks, $deck->getDeck());
        }

    }

    public function getPlayers(): array {
        return $this->players;
    }

    public function getDealer(): Player {
        return $this->dealer;
    }

    public function getDecks(): array {
        return $this->decks;
    }

    public function getSecondCardDealer(): array {
        return $this->secondCardDealer;
    }

    public function setHand(Player $player, array $cards): void {
        $player->setHand(array_merge($player->getHand(), $cards));
    }

    private function drawCard($player, int $amount): void {
        if (!is_array($player)) {
            $player = [$player];
        }
    
        $deckIndex = 0;
        for ($i = 0; $i < $amount; $i++) {
            foreach ($player as $p) {
                if ($deckIndex >= count($this->decks)) {
                    return;
                }
    
                $isEmpty = count($this->decks[$deckIndex]->getDeck()) === 0;
                while ($this->decks[$deckIndex] === $isEmpty) {
                    $deckIndex++;

                    if ($deckIndex >= count($this->decks)) {
                        return;
                    }
                }
    
                $cards = $this->decks[$deckIndex]->drawCards(1);
                $this->setHand($p, $cards);
            }
        }
    }

    private function calculateScore(array $hand): int {
        $blackjack = new BlackJack();
        $deck = new Deck();
        $rawHand = $deck->toRawData(array_filter($hand));
        $score = $blackjack->calculateScore($rawHand);
        return $score;
    }

    private function countCards(array $hand): int {
        $deck = new Deck();

        $count = 0;
        $rawHand = $deck->toRawData(array_filter($hand));

        $negative = ['J', 'Q', 'K', 'A', '10']; // -1
        $positive = ['2', '3', '4', '5', '6']; // +1

        foreach ($rawHand as $card) {
            if (in_array($card, $negative)) {
                $count--;
            } elseif (in_array($card, $positive)) {
                $count++;
            }
        }

        return $count;
    }

    public function calculateTotalCount($players, $dealer): int {
        $players = is_array($players) ? $players : [$players];
        $dealer = is_array($dealer) ? $dealer : [$dealer];
    
        $count = 0;
        foreach ($players as $player) {
            $count += $this->countCards($player->getHand());
        }

        foreach ($dealer as $d) {
            $count += $this->countCards($d->getHand());
        }

        return $count;
    }

    public function startGame(): void {

        foreach ($this->decks as $deck) {
            $deck->shuffleDeck();
        }

        $this->drawCard($this->dealer, 1);
        $this->drawCard($this->secondCardDealer, 1);

        foreach ($this->players as $player) {
            $this->drawCard($player, 2);
            $playerScore = $this->calculateScore($player->getHand());
            $player->setScore($playerScore);
        }

        $dealerScore = $this->calculateScore($this->dealer->getHand());
        $this->dealer->setScore($dealerScore);
    }

    public function hit(array $player): void {
        $this->drawCard($player, 1);
        $this->calculateScore($player->getHand());
    }

    public function stand(Player $player): void {
        $player->stand();
    }

    public function hasAllPlayersStood(): bool {
        foreach ($this->players as $player) {
            if (!$player->checkIfStand()) {
                return false;
            }
        }
        return true;
    }

    public function dealerDraw(): void {
        if ($this->hasAllPlayersStood()) {
            while ($this->dealer->getScore() < 17) {
                $this->drawCard($this->dealer, 1);
                $this->calculateScore($this->dealer->getHand());
            }
        }
    }

    public function compareWinners(): string {
        $dealerScore = $this->dealer->getScore();
        $winners = [];
        foreach ($this->players as $player) {
            $playerScore = $player->getScore();
            if ($playerScore > 21) {
                $winners[] = "Du vann!";
            } else if ($dealerScore > 21) {
                $winners[] = "Du vann!";
            } else if ($playerScore > $dealerScore) {
                $winners[] = "Du vann!";
            } else if ($playerScore < $dealerScore) {
                $winners[] = "Du förlorade";
            } else {
                $winners[] = "Lika!";
            }
        }
        return $winners;
    }

}
