<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class LuckyControllerJson
{
    #[Route("/api/lucky/number")]
        public function jsonNumber(): Response
        {
            $number = random_int(0, 100);

            $data = [
                'lucky-number' => $number,
                'lucky-message' => 'Hi there!',
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