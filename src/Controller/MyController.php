<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class MyController extends AbstractController
{
    #[Route("/", name: "index")]
    public function start_page(): Response
    {
        $filename = dirname(__DIR__) . "/markdown/index.md";
        $text     = file_get_contents($filename);
        $filter   = new \Anax\TextFilter\TextFilter();
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
        $filter   = new \Anax\TextFilter\TextFilter();
        $parsed   = $filter->parse($text, ["shortcode", "markdown"]);
        $data = [
            "text" => $parsed->text,
        ];
        return $this->render('about.html.twig', $data);
    }

    #[Route("/report", name: "report")]
    public function report(): Response
    {
        $names_of_reports = [
            "kmom01",
            "kmom02",
            "kmom03",
            "kmom04",
            "kmom05",
            "kmom06",
            "kmom10"
        ];

        function parseReports($names_of_reports)
        {
            $data = [];
            for ($c = 0; $c < count($names_of_reports); $c++) {
                $filename = dirname(__DIR__) . "/markdown/" . $names_of_reports[$c] . ".md";
                if (!file_exists($filename)) {
                    continue;
                }
                $text     = file_get_contents($filename);
                $filter   = new \Anax\TextFilter\TextFilter();
                $parsed   = $filter->parse($text, ["shortcode", "markdown"]);
                $data[$names_of_reports[$c]] = [
                    "text" => $parsed->text,
                ];
            }
            return $data;
        }
        $data = parseReports($names_of_reports);
        return $this->render('report.html.twig', ["data" => $data]);
    }

    #[Route("/lucky", name: "lucky")]
    public function lucky(): Response
    {
        $number = random_int(0, 100);

        return $this->render('lucky.html.twig', ['number' => $number]);
    }

    #[Route("/api", name: "api")]
    public function api_routes(): Response
    {
        $avalaible_routes = [
            "/api/quote" => "Genererar ett random citat"
        ];
        return $this->render('api_routes.html.twig', ["routes" => $avalaible_routes]);
    }

    #[Route("/session", name: "all_sessions")]
    public function all_sessions(Request $request): Response
    {
        $session = $request->getSession();
        return $this->render('session.html.twig', ["session" => $session->all()]);
    }

    #[Route("/session/delete", name: "delete_session")]
    public function delete_session(Request $request): Response
    {
        $session = $request->getSession();
        $session->clear();
        $this->addFlash("notice", "Borttagning av sessioner lyckades!");
        return $this->redirectToRoute("all_sessions");
    }
}
