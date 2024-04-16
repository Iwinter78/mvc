<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\DeckClass\Deck;

class CardControllerJSON extends AbstractController
{
    #[Route("/api/deck", name: "/api/deck", methods: ['GET'])]
    public function apiDeck(): JsonResponse
    {
        $deck = new Deck();
        $deck->createDeck();
        $strippedData = $deck->toRawData($deck->getDeck());

        return new JsonResponse($strippedData);
    }

    #[Route("/api/deck/shuffle", name: "/api/deck/shuffle", methods: ['POST'])]
    public function apiShuffle(Request $request): JsonResponse
    {
        $session = $request->getSession();
        $deck = new Deck();
        $deck->createDeck();
        $deck->shuffleDeck();
        $strippedData = $deck->toRawData($deck->getDeck());
        $session->set('deck', $strippedData);

        return new JsonResponse($strippedData);
    }

    #[Route("/api/deck/draw", name:"/api/deck/draw", methods: ['POST'])]
    public function apiDraw(Request $request): JsonResponse
    {
        $session = $request->getSession();
        $sessionDeck = $session->get('deck');

        if (!is_array($sessionDeck)) {
            throw new \Exception('Datan i sessionen är inte en array.');
        }

        $deck = new Deck();
        $deck->createDeck($sessionDeck);

        $count = count($deck->getDeck());
        $session->set('count', $count);

        if ($count > 0) {
            $deck->drawCards(1);
            $session->set('deck', $deck->getDeck());
            $session->set('count', $count - 1);
        }

        return new JsonResponse(['card' => $deck->getDeck()[0], 'count' => $count]);
    }

    #[Route("/api/deck/draw/{amount}", name: "api_deck_draw_amount", methods: ['POST'])]
    public function apiDrawAmount(Request $request, int $amount): JsonResponse
    {
        $session = $request->getSession();
        $sessionDeck = $session->get('deck');

        if (!is_array($sessionDeck)) {
            throw new \Exception('Datan i sessionen är inte en array.');
        }

        $deck = new Deck();
        $deck->createDeck($sessionDeck);
        $count = count($deck->getDeck());
        $session->set('count', $count);
        $cards = null;
        $currentCount = $session->get('count', 0);

        if ($count > 0) {
            $cards = $deck->drawCards($amount);
            $session->set('deck', $deck->getDeck());
            $countAfterDraw = count($deck->getDeck());
            $session->set('count', $countAfterDraw);
            $currentCount = $session->get('count');
        }

        return new JsonResponse(['cards' => $cards, 'count' => $currentCount]);
    }
}
