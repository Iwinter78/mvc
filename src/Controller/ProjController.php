<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Anax\TextFilter\TextFilter;
use App\BlackJackClass\AdvancedBlackJack;

class ProjController extends AbstractController
{
    #[Route('/proj', name: 'proj')]
    public function index(): Response 
    {
        return $this->render('proj/index.html.twig');
    }

    #[Route('proj/advancedblackjack/{players}/{deck}', name: 'advancedblackjack')]
    public function start(string $players, string $deck, Request $request, SessionInterface $session): Response
    {   
        $players = (int)$players;
        $deck = (int)$deck;

        $advancedBlackJack = new AdvancedBlackJack($players, $deck);
        $advancedBlackJack->startGame();
        $session->set('advancedBlackJack', $advancedBlackJack);

        $players = $advancedBlackJack->getPlayers();
        $dealer = $advancedBlackJack->getDealer();

        $data = [
            "players" => $advancedBlackJack->getPlayers(),
            "dealer" => $advancedBlackJack->getDealer(),
            "currentCount" => $advancedBlackJack->calculateTotalCount($players, $dealer)
        ];

        return $this->render('proj/advancedblackjack.html.twig', $data);
    }

    #[Route('proj/advancedblackjack/hit', name: 'hit')]
    public function hit(Request $request, SessionInterface $session): Response
    {
        $advancedBlackJack = $session->get('advancedBlackJack');
        $players = $advancedBlackJack->getPlayers();
        $dealer = $advancedBlackJack->getDealer();
        $getIndex = $request->query->get('playerIndex');

        $advancedBlackJack->hit($players[$getIndex]);
        $session->set('advancedBlackJack', $advancedBlackJack);

        $data = [
            "players" => $advancedBlackJack->getPlayers(),
            "dealer" => $advancedBlackJack->getDealer(),
            "currentCount" => $advancedBlackJack->calculateTotalCount($players, $dealer)
        ];

        return $this->render('proj/advancedblackjack.html.twig', $data);
    }
}