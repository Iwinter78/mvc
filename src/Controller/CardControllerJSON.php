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
    #[Route("/api/deck", methods: ['GET'])]
    public function api_deck(): JsonResponse 
    {
        $deck = new Deck();
        $deck->create_deck();

        return new JsonResponse($deck->deck);
    }

    #[Route("/api/deck/shuffle", methods: ['POST'])]
    public function api_shuffle(Request $request): JsonResponse
    {
        $session = $request->getSession();
        $deck = new Deck();
        $deck->create_deck();
        $deck->shuffle_deck();
        $session->set('deck', $deck->deck);

        return new JsonResponse($deck->deck);
    }

    #[Route("/api/deck/draw", methods: ['POST'])]
    public function api_draw(Request $request): JsonResponse
    {
        $session = $request->getSession();
        $deck = new Deck($session->get('deck'));
        $count = count($deck->deck);
        $session->set('count', $count);
        $cards = null;

        if ($count > 0) {
            $cards = $deck->draw_cards(1);
            $session->set('deck', $deck->deck);
        }

        return new JsonResponse($cards);
    }

    #[Route("/api/deck/draw/{amount}", methods: ['POST'])]
    public function api_draw_amount(Request $request, $amount): JsonResponse
    {
        $session = $request->getSession();
        $deck = new Deck($session->get('deck'));
        $count = count($deck->deck);
        $session->set('count', $count);
        $cards = null;

        if ($count > 0) {
            $cards = $deck->draw_cards($amount);
            $session->set('deck', $deck->deck);
        }

        return new JsonResponse($cards);
    }
}
