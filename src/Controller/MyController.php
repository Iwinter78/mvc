<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Anax\TextFilter\TextFilter;

class MyController extends AbstractController
{
    #[Route("/", name: "index")]
    public function startPage(): Response
    {
        $filename = dirname(__DIR__) . "/markdown/index.md";
        $text     = file_get_contents($filename);
        $filter   = new TextFilter();
        $parsed   = $filter->parse($text, ["shortcode", "markdown"]);
        $data = [
            "text" => $parsed->text,
        ];
        return $this->render('index.html.twig', $data);
    }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        $filename = dirname(__DIR__) . "/markdown/about.md";
        $text     = file_get_contents($filename);
        $filter   = new TextFilter();
        $parsed   = $filter->parse($text, ["shortcode", "markdown"]);
        $data = [
            "text" => $parsed->text,
        ];
        return $this->render('about.html.twig', $data);
    }

    #[Route("/report", name: "report")]
    public function report(): Response
    {
        $namesOfReports = [
            "kmom01",
            "kmom02",
            "kmom03",
            "kmom04",
            "kmom05",
            "kmom06",
            "kmom10"
        ];

        function parseReports($namesOfReports)
        {
            $data = [];
            for ($c = 0; $c < count($namesOfReports); $c++) {
                $filename = dirname(__DIR__) . "/markdown/" . $namesOfReports[$c] . ".md";
                if (!file_exists($filename)) {
                    continue;
                }
                $text     = file_get_contents($filename);
                $filter   = new TextFilter();
                $parsed   = $filter->parse($text, ["shortcode", "markdown"]);
                $data[$namesOfReports[$c]] = [
                    "text" => $parsed->text,
                ];
            }
            return $data;
        }
        $data = parseReports($namesOfReports);
        return $this->render('report.html.twig', ["data" => $data]);
    }

    #[Route("/lucky", name: "lucky")]
    public function lucky(): Response
    {
        $number = random_int(0, 100);

        return $this->render('lucky.html.twig', ['number' => $number]);
    }

    #[Route("/api", name: "api")]
    public function apiRoutes(): Response
    {
        $avalaibleRoutes = [
            "/api/quote" => ["description" => "Genererar ett random citat"],
            "/api/deck" => ["description" => "Genererar en kortlek"],
            "/api/deck/shuffle" => [
            "description" => "Blandar kortleken samt sparar den i en session [POST]",
            "isPost" => true
            ],
            "/api/deck/draw" => [
            "description" => "Drar ett kort från kortleken [POST]",
            "isPost" => true
            ],
            "api_deck_draw_amount" => [
                "description" => "Drar ett antal kort från kortleken [POST]. Standartvärdet vid tryck av länk är 5 kort.",
                "optionalArgs" => ["amount" => 5],
                "optionalRouteName" => "/api/deck/draw/{amount}",
                "isPost" => true,
            ],
        ];
        return $this->render('api_routes.html.twig', ["routes" => $avalaibleRoutes]);
    }

    #[Route("/session", name: "all_sessions")]
    public function allSessions(Request $request): Response
    {
        $session = $request->getSession();
        return $this->render('session.html.twig', ["session" => $session->all()]);
    }

    #[Route("/session/delete", name: "delete_session")]
    public function deleteSession(Request $request): Response
    {
        $session = $request->getSession();
        $session->clear();
        $this->addFlash("notice", "Borttagning av sessioner lyckades!");
        return $this->redirectToRoute("all_sessions");
    }

    #[Route("/card", name: "card")]
    public function card(): Response
    {
        return $this->render('card.html.twig');
    }
}
