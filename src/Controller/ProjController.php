<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Anax\TextFilter\TextFilter;

class ProjController extends AbstractController
{
    #[Route('/proj', name: 'proj')]
    public function index(): Response 
    {
        return $this->render('proj/index.html.twig');
    }

    #[Route('proj/advancedblackjack/{players}/{deck}', name: 'advancedblackjack')]
    public function start(int $players, int $deck, Request $request, SessionInterface $session): Response
    {   

        $advancedBlackJack = new AdvancedBlackJack($players, $deck);
        $advancedBlackJack->startGame();
        $session->set('advancedBlackJack', $advancedBlackJack);

        $data = [
            "players" => $advancedBlackJack->getPlayers(),
            "dealer" => $advancedBlackJack->getDealer(),
            "deck" => $advancedBlackJack->getDeck(),
            "secondCardDealer" => $advancedBlackJack->getSecondCardDealer()
        ];

        return $this->render('proj/advancedblackjack.html.twig', $data);
    }
}