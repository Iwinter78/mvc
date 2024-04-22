<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Anax\TextFilter\TextFilter;

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
    public function blackjack(): Response
    {
        return $this->render('blackjack.html.twig');
    }
}