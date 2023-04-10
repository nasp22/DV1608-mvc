<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use App\Card\CardHand;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class APIControllerJson
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

    #[Route("/api/deck", name: "json_deck_get", methods: ['GET'])]
        public function jsonDeck(
            Request $request,
            SessionInterface $session
        ): Response {
            $deck = $session->get("left");
            $data = $deck->getAsString();

            $response = new JsonResponse($data);
            $response->setEncodingOptions(
                $response->getEncodingOptions() | JSON_PRETTY_PRINT
            );
            return $response;
        }

        #[Route("/api/deck/shuffle", name: "json_shuffle_get", methods: ['GET'])]
        public function jsonShuffle(
            Request $request,
            SessionInterface $session
        ): Response {
            $deck = $session->get("left");
            $data = $deck->shuffle();

            $response = new JsonResponse($data);
            $response->setEncodingOptions(
                $response->getEncodingOptions() | JSON_PRETTY_PRINT
            );
            return $response;
        }
        #[Route("/api/deck/draw", name: "json_draw_get", methods: ['GET'])]
        public function jsonDraw(
            Request $request,
            SessionInterface $session
        ): Response {
            $deck = $session->get("left");
            $deckString = $deck->getValue();
            $num = $session->get("num");
            $hand = new CardHand();
            $handArr = $hand->draw($num, $deckString);
            $hand->setValue($handArr);

            $newDeck = $deck->remove($handArr);
            $deck->setValue($newDeck);

            $data = [
                "hand" => $hand->getAsString(),
                "resterande kort" => $deck->getAsString()
            ];

            $session->set("left", $deck);

            $response = new JsonResponse($data);
            $response->setEncodingOptions(
                $response->getEncodingOptions() | JSON_PRETTY_PRINT
            );
            return $response;
        }
}
