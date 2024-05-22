<?php

namespace AdvancedBlackJack;
use App\DeckClass\Deck;
use App\BlackJackClass\Player;

class AdvancedBlackJack 
{
    function __construct(int $players, int $decks) {
        $this->players = $players;
        $this->dealer = new Player();
        $this->deck = [];
        $this->players = [];
        $this->secondCardDealer = [];

        for ($i = 0; $i < $players; $i++) {
            $this->players[] = new Player();
        }

        for ($i = 0; $i < $decks; $i++) {
            $this->deck = array_merge($this->deck, (new Deck())->getDeck());
        }

    }

    public function getPlayers(): array {
        return $this->players;
    }

    public function getDealer(): array {
        return $this->dealer;
    }

    public function getDeck(): array {
        return $this->deck;
    }

    public function getSecondCardDealer(): array {
        return $this->secondCardDealer;
    }

    public function setHand(Player $player, array $cards): void {
        array_merge($player->getHand(), $cards);
    }

    private function drawCard(Player $player, int $amount): void {
        for ($i = 0; $i < $amount; $i++) {
            $cards = $this->deck->drawCards(1);
            $player->setHand($player, $cards);
        }
    }

    private function calculateScore(array $hand): void {
        $blackjack = new BlackJack();
        foreach ($hand as $card) {
            $blackjack->calculateScore($card);
        }

    }

    public function startGame(): void {
        $this->deck->shuffleCards();
        $this->drawCard($this->dealer, 1);
        $this->drawCard($this->secondCardDealer, 1);

        foreach ($this->players as $player) {
            $this->drawCard($player, 2);
            $this->calculateScore($player->getHand());
        }

        $this->calculateScore($this->dealer->getHand());
    }

    public function hit(Player $player): void {
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
