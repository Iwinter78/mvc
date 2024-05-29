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

    #[Route('/proj/about', name: 'proj_about')]
    public function about(): Response 
    {   
        $filename = dirname(__DIR__) . "/markdown/" . "aboutproj.md";
        $text     = file_get_contents($filename);
        $filter   = new TextFilter();
        $parsed   = $filter->parse($text, ["shortcode", "markdown"]);
        $data = [
            "text" => $parsed->text,
        ];
        return $this->render('proj/about.html.twig', $data);
    }

    #[Route('proj/advancedblackjack/{players}/{deck}', name: 'advancedblackjack')]
    public function start(string $players, string $deck, Request $request, SessionInterface $session): Response
    {   
        $players = (int)$players;
        $deck = (int)$deck;
    
        if(!$session->has('advancedBlackJack')) {
            $session->set('advancedBlackJack', new AdvancedBlackJack($players, $deck));
            $session->set('count', 0);
            $session->set('gameStarted', false);
        }
    
        $advancedBlackJack = $session->get('advancedBlackJack');
        
        if(!$session->get('gameStarted')) {
            $advancedBlackJack->startGame();
            $session->set('gameStarted', true);
        }
    
        $session->set('advancedBlackJack', $advancedBlackJack);
    
        $players = $advancedBlackJack->getPlayers();
        $dealer = $advancedBlackJack->getDealer();
    
        $count = $session->get("count");
        $count += $advancedBlackJack->calculateTotalCount($players, $dealer);
    
        $data = [
            "players" => $advancedBlackJack->getPlayers(),
            "dealer" => $advancedBlackJack->getDealer(),
            "currentCount" => $count,
            "results" => []
        ];
    
        return $this->render('proj/advancedblackjack.html.twig', $data);
    }

    #[Route('proj/advancedblackjack/hit', name: 'hit')]
    public function hit(Request $request, SessionInterface $session): Response
    {
        $advancedBlackJack = $session->get('advancedBlackJack');
        $players = $advancedBlackJack->getPlayers();
        $dealer = $advancedBlackJack->getDealer();

        $getIndex = $request->request->get('player');

        $advancedBlackJack->hit($players[$getIndex]);
        $session->set('advancedBlackJack', $advancedBlackJack);

        $count = $session->get("count");
        $count += $advancedBlackJack->calculateTotalCount($players, $dealer);

        $data = [
            "players" => $advancedBlackJack->getPlayers(),
            "dealer" => $advancedBlackJack->getDealer(),
            "currentCount" => $count,
            "results" => []
        ];

        return $this->render('proj/advancedblackjack.html.twig', $data);
    }

    #[Route('proj/advancedblackjack/stand', name: 'stand')]
    public function stand(Request $request, SessionInterface $session): Response
    {
        $advancedBlackJack = $session->get('advancedBlackJack');
        $players = $advancedBlackJack->getPlayers();
        $dealer = $advancedBlackJack->getDealer();
        $getIndex = $request->request->get('player');

        $advancedBlackJack->stand($players[$getIndex]);
        $advancedBlackJack->dealerDraw();
        $session->set('advancedBlackJack', $advancedBlackJack);

        $count = $session->get("count");
        $count += $advancedBlackJack->calculateTotalCount($players, $dealer);

        $data = [
            "players" => $advancedBlackJack->getPlayers(),
            "dealer" => $advancedBlackJack->getDealer(),
            "currentCount" => $count,
            "results" => $advancedBlackJack->compareWinners()
        ];

        return $this->render('proj/advancedblackjack.html.twig', $data);
    }

    #[Route('proj/advancedblackjack/reset', name: 'reset')]
    public function reset(Request $request, SessionInterface $session): Response
    {
        $advancedBlackJack = $session->get('advancedBlackJack');
        $advancedBlackJack->resetRound();
        return $this->redirectToRoute('advancedblackjack', ['players' => 3, 'deck' => 5]);
    }
}