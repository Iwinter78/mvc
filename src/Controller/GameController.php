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

class GameController extends AbstractController {
    #[Route("/game", name: "game")]
    public function game(): Response
    {
        return $this->render('game.html.twig');
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
        return $this->render('gamedocs.html.twig', $data);
    }

    #[Route("/blackjack", name: "blackjack")]
    public function blackjack(Request $request, SessionInterface $session): Response
    {
        $blackjack = $session->get('blackjack');
        if ($blackjack === null) {
            $blackjack = new BlackJack();
            $blackjack->startGame();
            $session->set('blackjack', $blackjack);
        }
        
        $session->set('blackjack', $blackjack);
        $session->set('player', $blackjack->getPlayer());
        $session->set('dealer', $blackjack->getDealer());
        $session->set('stand', false);
        $session->set('hit', false);
    
        $data = [
            "player" => $session->get('player'),
            "playerScore" => $blackjack->calculateScore($blackjack->getPlayer()->getHand()),
            "dealer" => $session->get('dealer'),
            "dealerScore" => $blackjack->calculateScore($blackjack->getDealer()->getHand()),
        ];
        return $this->render('blackjack.html.twig', $data);
    }

    #[Route(name: "blackjack_hit")]
    public function blackjackHit(Request $request, SessionInterface $session): Response
    {
        $session->set('hit', true);
        $data = [];
        if (gettype($session->get('hit') == 'boolean')) {
            $blackjack = new BlackJack();
            $player = $session->get('player');
            $dealer = $session->get('dealer');
            $blackjack->playersTurn();
            $data = [
                "player" => $player,
                "dealer" => $dealer,
            ];
        }
        return $this->redirectToRoute('blackjack', $data);
    }

    #[Route(name: "blackjack_stand")]
    public function blackjackStand(Request $request, SessionInterface $session): Response
    {
        $session->set('stand', true);
        $data = [];
        if (gettype($session->get('stand') == 'boolean')) {
            $blackjack = new BlackJack();
            $player = $session->get('player');
            $dealer = $session->get('dealer');;
            $blackjack->dealersTurn();
            $data = [
                "player" => $player,
                "dealer" => $dealer,
            ];
        }
        return $this->redirectToRoute('blackjack', $data);
    }
}
