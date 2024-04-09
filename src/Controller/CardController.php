<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Models\Deck;

class CardController extends AbstractController
{
    #[Route("/card", name: "holder")]
    public function holder_page(): Response
    {
        return $this->render('card.html.twig');
    }

    #[Route("/card/deck", name: "deck")]
    public function render_deck(Request $request): Response
    {
        $deck = new Deck();
        $session = $request->getSession();
        $session->set('deck', $deck->create_deck());
        return $this->render('deck/deck.html.twig', ['deck' => $deck->deck]);
    }

    #[Route("/card/deck/shuffle", name: "shuffle")]
    public function shuffle_cards(Request $request): Response
    {
        $session = $request->getSession();
        if ($session->has('deck')) {
            $deck = new Deck();
            $deck->deck = $session->get('deck');
            $deck->shuffle_deck();
            $session->set('deck', $deck->deck);
        } else {
            $deck = new Deck();
            $deck->shuffle_deck();
            $session->set('deck', $deck->deck);
        }
        return $this->render('deck/shuffle.html.twig', ['deck' => $deck->deck]);
    }

    #[Route("/card/deck/draw", name: "draw")]
    public function draw(Request $request): Response
    {   
        $session = $request->getSession();
        if (!$session->has('deck')) {
            $deck = new Deck();
            $createDeck = $deck->create_deck();
            $shuffleDeck = $deck->shuffle_deck();
            $session->set('deck', $deck->deck);
        }
        $count = count($session->get('deck'));
        $session->set('count', $count);
        $card = null;
        return $this->render('deck/draw.html.twig', ['count' => $count, 'card' => $card]);
    }

    #[Route("/card/deck/draw/", name: "draw_request", methods: ['POST'])]
    public function draw_request(Request $request): Response
    {
        $session = $request->getSession();
        if ($session->has('deck')) {
            $deck = new Deck($session->get('deck'));
            $card = array_pop($deck->deck);
            $session->set('deck', $deck->deck);
            $count = count($deck->deck);
        }
        return $this->render('deck/draw.html.twig', ['card' => $card, 'count' => $count]);
    }

    #[Route("/card/deck/draw/:number", name: "draw_multible")]
    public function draw_multible(): Response
    {
        return $this->render('deck/draw_multible.html.twig');
    }
}
