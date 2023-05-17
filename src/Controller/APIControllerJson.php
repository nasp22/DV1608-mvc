<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use App\Card\CardHand;
use App\Repository\BookRepository;
use App\Entity\Book;
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

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck", name: "json_deck_get", methods: ['GET'])]
    public function jsonDeck(
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

    #[Route("/api/game", name: "api_game", methods: ['GET'])]
    public function game(
        SessionInterface $session
    ): Response {
        $player = $session->get("player");
        $computer =  $session->get("computer");

        $data = [
            'Player current score' => $player,
            'Computer current score' => $computer,
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
    #[Route('api/library/books', name: 'api_book_show_all')]
    public function showAllBook(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository
            ->findAll();

        $library = [];

        foreach ($books as $book) {
            $book= [
            'title' => $book->getTitle(),
            'author'=> $book->getAuthor(),
            'isbn' => $book->getIsbn(),
            'img' => $book->getImg(),
            'id' => $book->getId()
            ];

            $library[] = $book;
        };

        $data = [
            'books' => $library
        ];
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
