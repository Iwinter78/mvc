<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Models\Deck;

class CardControllerJSON extends AbstractController
{
    #[Route("/api/deck", name: "/api/deck", methods: ['GET'])]
    public function api_deck(): JsonResponse
    {
        $deck = new Deck();
        $deck->create_deck();
        $strippedData = $deck->to_raw_data($deck->deck);

        return new JsonResponse($strippedData);
    }

    #[Route("/api/deck/shuffle", name: "/api/deck/shuffle", methods: ['POST'])]
    public function api_shuffle(Request $request): JsonResponse
    {
        $session = $request->getSession();
        $deck = new Deck();
        $deck->create_deck();
        $deck->shuffle_deck();
        $strippedData = $deck->to_raw_data($deck->deck);
        $session->set('deck', $strippedData);

        return new JsonResponse($strippedData);
    }

    #[Route("/api/deck/draw", name:"/api/deck/draw", methods: ['POST'])]
    public function api_draw(Request $request): JsonResponse
    {
        $session = $request->getSession();
        $deck = new Deck($session->get('deck'));
        $count = count($deck->deck);
        $session->set('count', $count);
        $cards = null;

        if ($count > 0) {
            $cards = $deck->draw_cards(1);
            $session->set('deck', $deck->to_raw_data($deck->deck));
            $session->set('count', $count - 1);
        }

        return new JsonResponse(['card' => $deck->deck[0], 'count' => $count]);
    }

    #[Route("/api/deck/draw/{amount}", name: "api_deck_draw_amount", methods: ['POST'])]
    public function api_draw_amount(Request $request, int $amount): JsonResponse
    {
        $session = $request->getSession();
        $deck = new Deck($session->get('deck'));
        $count = count($deck->deck);
        $session->set('count', $count);
        $cards = null;

        if ($count > 0) {
            $cards = $deck->draw_cards($amount);
            $session->set('deck', $deck->to_raw_data($deck->deck));
            $countAfterDraw = count($deck->deck);
            $session->set('count', $countAfterDraw);
            $currentCount = $session->get('count');
        }

        return new JsonResponse(['cards' => $cards, 'count' => $currentCount]);
    }
}
