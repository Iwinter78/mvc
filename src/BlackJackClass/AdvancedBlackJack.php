<?php

namespace App\BlackJackClass;

use App\DeckClass\Deck;
use App\BlackJackClass\Player;
use App\BlackJackClass\BlackJack;

/**
 * Class AdvancedBlackJack manages the advanced verison of the BlackJack game.
 */
class AdvancedBlackJack
{
    /**
     * @var array<int, Player>
     */
    private $players;

    /**
     * @var Player
     */
    private $dealer;

    /**
     * @var array<int, Deck>
     */
    private $decks;

    /**
     * @var array<int, string>
     */
    private $secondCardDealer;

    public function __construct(int $players, int $decks)
    {
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
        }

    }
    /**
     * Gets the players.
     * @return array<int, Player>
     */
    public function getPlayers(): array
    {
        return $this->players;
    }
    /**
     * Gets the dealer.
     * @return Player
     */
    public function getDealer(): Player
    {
        return $this->dealer;
    }

    /**
     * Gets the decks.
     * @return array<int, Deck>
     */
    public function getDecks(): array
    {
        return $this->decks;
    }

    /**
     * Gets the second card for the dealer
     * @return array<int, string>
     */
    public function getSecondCardDealer(): array
    {
        return $this->secondCardDealer;
    }
    /**
     * Sets the second card for the dealer
     * @param array<int, string|null> $cards
     */
    public function setSecondCardDealer(array $cards): void
    {
        $this->secondCardDealer = array_merge($this->secondCardDealer, $cards);
    }
    /**
     * Sets the hand for a player
     * @param Player $player
     * @param array<int, string|null> $cards
     */
    public function setHand(Player $player, array $cards): void
    {
        $player->setHand(array_merge($player->getHand(), $cards));
    }

    /**
     * Sets the stand flag for the player
     * @param Player $player
     * @return void
     */
    public function stand(Player $player): void
    {
        $player->setStand(true);
    }

    /**
     * Draws cards for the player with a specified amount
     * @param Player|array<int, Player> $player
     * @param int $amount
     */
    private function drawCard($player, int $amount): void
    {
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

    /**
     * Calculates the score for a hand
     * @param array<int, string|null> $hand
     * @return int
     */
    private function calculateScore(array $hand): int
    {
        $blackjack = new BlackJack();
        $deck = new Deck();
        $rawHand = $deck->toRawData(array_filter($hand));
        $score = $blackjack->calculateScore($rawHand);
        return $score;
    }

    /**
     * Manages the count for the cards using the HI-LO system
     * @param array<int, string|null> $hand
     * @return int
     */
    private function countCards(array $hand): int
    {
        $deck = new Deck();

        $count = 0;
        $rawHand = $deck->toRawData(array_filter($hand));

        $negative = ['J', 'Q', 'K', 'A', '10']; // -1
        $positive = ['2', '3', '4', '5', '6']; // +1

        foreach ($rawHand as $card) {
            $card = substr($card, 0, 1);
            if (in_array($card, $negative)) {
                $count--;
            } elseif (in_array($card, $positive)) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Calculates the total count for the players and the dealer and returns the value
     * @param Player|array<int, Player> $players
     * @param Player|array<int, Player> $dealer
     * @return int
     */
    public function calculateTotalCount($players, $dealer): int
    {
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

    /**
     * Starts the game by shuffling the decks, drawing cards for the dealer and the players
     * @return void
     */
    public function startGame(): void
    {

        foreach ($this->decks as $deck) {
            $deck->shuffleDeck();
        }

        $this->drawCard($this->dealer, 1);
        $this->setSecondCardDealer($this->decks[0]->drawCards(1));

        foreach ($this->players as $player) {
            $this->drawCard($player, 2);
            $playerScore = $this->calculateScore($player->getHand());
            $player->setScore($playerScore);

            if ($playerScore === 21) {
                $player->setStand(true);
            }
        }

        $dealerScore = $this->calculateScore($this->dealer->getHand());
        $this->dealer->setScore($dealerScore);

    }

    /**
     * Does the hit action for the player
     * @param Player $player
     */
    public function hit(Player $player): void
    {
        $this->drawCard($player, 1);
        $newCalculation = $this->calculateScore($player->getHand());
        $player->setScore($newCalculation);

        if ($newCalculation >= 21) {
            $player->setStand(true);
        }
    }
    /**
     * Checks if all the players stand flag has changed to true
     * @return bool
     */
    private function hasAllPlayersStood(): bool
    {
        foreach ($this->players as $player) {
            if (!$player->getStand()) {
                return false;
            }
        }
        return true;
    }

    /**
     * Manges the draw functionallity for the dealer
     * @return void
     */
    public function dealerDraw(): void
    {
        array_merge($this->dealer->getHand(), $this->getSecondCardDealer());
        $dealerScore = $this->dealer->getScore();

        while ($dealerScore < 17 && $this->hasAllPlayersStood()) {
            $this->drawCard($this->dealer, 1);
            $dealerScore = $this->calculateScore($this->dealer->getHand());
            $this->dealer->setScore($dealerScore);
        }
    }

    /**
     * Compares the winners and returns the result
     * @return array<int, string>
     */
    public function compareWinners(): array
    {
        if ($this->hasAllPlayersStood()) {
            $dealerScore = $this->dealer->getScore();
            $winners = [];
            foreach ($this->players as $player) {
                $playerScore = $player->getScore();
                if ($playerScore > 21) {
                    $winners[] = "Du förlorade!";
                } elseif ($dealerScore > 21) {
                    $winners[] = "Du vann!";
                } elseif ($playerScore > $dealerScore) {
                    $winners[] = "Du vann!";
                } elseif ($playerScore < $dealerScore) {
                    $winners[] = "Du förlorade!";
                }
                if ($playerScore == $dealerScore) {
                    $winners[] = "Lika!";
                }
            }
            return $winners;
        }
        return [];
    }
    /**
     * Resets the players and the dealer for a new round
     * @return void
     */
    public function resetRound(): void
    {
        $numPlayers = count($this->players);
        $this->dealer = new Player();
        $this->players = [];
        $this->secondCardDealer = [];

        for ($i = 0; $i < $numPlayers; $i++) {
            $this->players[] = new Player();
        }
    }
}
