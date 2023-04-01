<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class QuoteControllerJson
{
    #[Route("/api/quote", name: "quote")]
    public function jsonNumber(): Response
    {
        $number = random_int(0, 4);

        $citatArr = array(
            "All that glitters is not gold",
            "May the Force be with you",
            "There is no place like home",
            "What does not kill us makes us stronger",
            "Knowledge is power"
        );

        $citat = $citatArr[$number];
        $today = date("Y-m-d");
        $time = date("h:i:sa");


        $data = [
            'citat' => $citat,
            'dagens datum' => $today,
            'tidstampel' => $time
        ];

        // $response = new Response();
        // $response->setContent(json_encode($data));
        // $response->headers->set('Content-Type', 'application/json');
        // return $response;

        // alt. rätt:
        // return new JsonResponse($data);

        // alt. rätt snygg utskrift json:
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
