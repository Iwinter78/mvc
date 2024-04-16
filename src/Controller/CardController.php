<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\DeckClass\Deck;

class CardController extends AbstractController
{
    #[Route("/card", name: "holder")]
    public function holderPage(): Response
    {
        return $this->render('card.html.twig');
    }

    #[Route("/card/deck", name: "deck")]
    public function renderDeck(Request $request): Response
    {
        $deck = new Deck();
        $session = $request->getSession();
        $session->set('deck', $deck->createDeck());
        return $this->render('deck/deck.html.twig', ['deck' => $session->get('deck')]);
    }

    #[Route("/card/deck/shuffle", name: "shuffle")]
    public function shuffleCards(Request $request): Response
    {
        $session = $request->getSession();
        $deckArray = $session->get('deck');
        if (!is_array($deckArray)) {
            $deckArray = [];
        }
        $deck = new Deck();
        $deck->createDeck($deckArray);
        $deck->shuffleDeck();
        $session->set('deck', $deck->getDeck());
        return $this->render('deck/shuffle.html.twig', ['deck' => $session->get('deck')]);
    }

    #[Route("/card/deck/draw", name: "draw")]
    public function draw(Request $request): Response
    {
        $session = $request->getSession();
        $deck = $session->get('deck', []);

        if (!$deck) {
            $deckObj = new Deck();
            $deck = $deckObj->getDeck();
            $session->set('deck', $deck);
        }
        $count = is_array($deck) ? count($deck) : 0;
        $session->set('count', $count);
        $cards = null;
        return $this->render('deck/draw.html.twig', ['count' => $count, 'cards' => $cards]);
    }

    #[Route("/card/deck/draw/", name: "draw_request", methods: ['POST'])]
    public function drawRequest(Request $request): Response
    {
        $session = $request->getSession();
        $cards = [];
        $count = 0;

        if ($session->has('deck')) {
            $deckArray = $session->get('deck');
            if (!is_array($deckArray)) {
                $deckArray = [];
            }
            $deck = new Deck();
            $deck->createDeck($deckArray);
            $cards = $deck->drawCards(1);
            $session->set('deck', $deck->getDeck());
            $count = count($deck->getDeck());
        }

        return $this->render('deck/draw.html.twig', ['cards' => $cards, 'count' => $count]);
    }

    #[Route("/card/deck/draw/{amount}", name: "draw_amount")]
    public function drawMultible(Request $request, int $amount): Response
    {
        $session = $request->getSession();
        $cards = [];
        $count = 0;

        if ($session->has('deck')) {
            $deckArray = $session->get('deck');
            if (!is_array($deckArray)) {
                $deckArray = [];
            }
            $deck = new Deck();
            $deck->createDeck($deckArray);
            $cards = $deck->drawCards($amount);
            $session->set('deck', $deck->getDeck());
            $count = count($deck->getDeck());
        }

        return $this->render('deck/draw.html.twig', ['cards' => $cards, 'count' => $count]);
    }
}
