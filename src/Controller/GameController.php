<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Anax\TextFilter\TextFilter;
use App\BlackJackClass\BlackJack;
use App\BlackJackClass\Player;

class GameController extends AbstractController
{
    #[Route("/game", name: "game")]
    public function game(): Response
    {
        return $this->render('blackjack/game.html.twig');
    }

    #[Route("/game/doc", name: "gamedocs")]
    public function gameDocs(): Response
    {
        $filename = dirname(__DIR__) . "/markdown/gamedocs.md";
        $text     = file_get_contents($filename);
        $filter   = new TextFilter();
        $parsed   = $filter->parse($text, ["shortcode", "markdown"]);
        $data = [
            "text" => $parsed->text,
        ];
        return $this->render('blackjack/gamedocs.html.twig', $data);
    }

    #[Route("/blackjack", name: "blackjack")]
    public function blackjack(SessionInterface $session): Response
    {
        $blackjack = $session->get('blackjack');
        if ($blackjack === null) {
            $blackjack = new BlackJack();
            $blackjack->startGame();
            $session->set('blackjack', $blackjack);
        }

        $session->set('blackjack', $blackjack);
        $session->set('stand', false);
        $session->set('hit', false);

        $player = $blackjack->getPlayer();
        $dealer = $blackjack->getDealer();

        $playerScore = $blackjack->calculateScore($player->getHand());
        $dealerScore = $blackjack->calculateScore($dealer->getHand());

        $player->setScore($playerScore);
        $dealer->setScore($dealerScore);

        $data = [
            "player" => $player,
            "playerScore" => $playerScore,
            "dealer" => $dealer,
            "dealerScore" => $dealerScore,
        ];
        return $this->render('blackjack/blackjack.html.twig', $data);
    }

    #[Route("/game/blackjack/hit", name: "blackjack_hit", methods: ['POST'])]
    public function blackjackHit(SessionInterface $session): Response
    {
        $session->set('hit', true);
        $data = [];
        if (gettype($session->get('hit') == 'boolean')) {
            $blackjack = $session->get('blackjack');
            $blackjack->dealCard();

            $player = $blackjack->getPlayer();
            $dealer = $blackjack->getDealer();

            $playerScore = $blackjack->calculateScore($player->getHand());
            $dealerScore = $blackjack->calculateScore($dealer->getHand());


            if ($playerScore === 21 || $playerScore > 21) {
                $blackjack->revealSecondCardDealer();
                $session->set('result', $blackjack->compareResults());
            }

            $player->setScore($playerScore);
            $dealer->setScore($dealerScore);

            $data = [
                "player" => $player,
                "dealer" => $dealer,
                "playerScore" => $playerScore,
                "dealerScore" => $dealerScore,
            ];
        }
        return $this->render('blackjack/blackjack.html.twig', $data);
    }

    #[Route("/game/blackjack/stand", name: "blackjack_stand", methods: ['POST'])]
    public function blackjackStand(SessionInterface $session): Response
    {
        $session->set('stand', true);
        $data = [];
        if (gettype($session->get('stand') == 'boolean')) {
            $blackjack = $session->get('blackjack');
            $blackjack->stand();

            $player = $blackjack->getPlayer();
            $dealer = $blackjack->getDealer();

            $playerScore = $blackjack->calculateScore($player->getHand());
            $dealerScore = $blackjack->calculateScore($dealer->getHand());

            $player->setScore($playerScore);
            $dealer->setScore($dealerScore);

            $result = $blackjack->compareResults();
            $session->set('result', $result);

            $data = [
                "player" => $player,
                "dealer" => $dealer,
                "playerScore" => $playerScore,
                "dealerScore" => $dealerScore,
            ];
        }
        return $this->render('blackjack/blackjack.html.twig', $data);
    }

    #[Route("/game/blackjack/reset", name: "blackjack_reset", methods: ['POST'])]
    public function blackjackReset(SessionInterface $session): Response
    {
        $sessionsToUnset = [
            'blackjack',
            'player',
            'dealer',
            'stand',
            'hit',
            'result'
        ];

        foreach ($sessionsToUnset as $sessionToUnset) {
            $session->remove($sessionToUnset);
        }

        return $this->redirectToRoute('blackjack');
    }
}
