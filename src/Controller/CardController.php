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
        $deck = new Deck($session->get('deck'));
        if (count($deck->deck) != 52) {
            $deck->create_deck();
        }
        $deck->shuffle_deck();
        $session->set('deck', $deck->deck);
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
        $cards = null;
        return $this->render('deck/draw.html.twig', ['count' => $count, 'cards' => $cards]);
    }

    #[Route("/card/deck/draw/", name: "draw_request", methods: ['POST'])]
    public function draw_request(Request $request): Response
    {
        $session = $request->getSession();
        if ($session->has('deck')) {
            $deck = new Deck($session->get('deck'));
            $cards = $deck->draw_cards(1);
            $session->set('deck', $deck->deck);
            $count = count($deck->deck);
        }
        return $this->render('deck/draw.html.twig', ['cards' => $cards, 'count' => $count]);
    }

    #[Route("/card/deck/draw/{amount}", name: "draw_amount")]
    public function draw_multible(Request $request, int $amount): Response
    {
        $session = $request->getSession();
        if ($session->has('deck')) {
            $deck = new Deck($session->get('deck'));
            $cards = $deck->draw_cards($amount);
            $session->set('deck', $deck->deck);
            $count = count($deck->deck);
        }
        return $this->render('deck/draw.html.twig', ['cards' => $cards, 'count' => $count]);
    }
}
