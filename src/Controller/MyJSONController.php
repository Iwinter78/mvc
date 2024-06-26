<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MyJSONController extends AbstractController
{
    #[Route("/api/quote", name: "/api/quote")]
    public function apiQuote(): JsonResponse
    {
        $quotes = [
            "There's nobody getting rich writing software that I know of.",
            "It's over Anakin, I have the high ground",
            "I'll be back"
        ];

        $randomQuote = $quotes[array_rand($quotes)];
        $response = new JsonResponse(
            [
                "quote" => $randomQuote,
                "date" => date("Y-m-d H:i:s")
            ]
        );
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
