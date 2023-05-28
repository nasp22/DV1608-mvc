<?php

namespace App\Controller;
use App\BlackJack\BlackJackResult;
use App\BlackJack\BlackJackDeckOfCards;
use App\BlackJack\BlackJackCardHand;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class BlackJackAPIControllerJson

{
    #[Route("/proj/api/player", name: 'proj_api_player', methods: ['POST'])]
    public function jsonPlayer(
        SessionInterface $session,
        Request $request,
    ): Response {
        $player = $session->get("player");
        $alias = $request->request->get('alias');
        $player->alias = $alias;

        $response = new JsonResponse($player);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/proj/api/hands", name: 'proj_api_hands', methods: ['POST'])]
    public function jsonHands(
        SessionInterface $session,
        Request $request,
    ): Response {
        $player = $session->get("player");
        $handsquantity = $request->request->get('hands');
        $deck = $session->get("BlackJackDeck");
        $deckString = $deck->getValue();

        for ($x = 0; $x <= $handsquantity-1; $x++) {
            $hand = new BlackJackCardHand();
            $handArr = $hand->draw(2, $deckString);
            $hand->setValue($handArr);
            $handPoints = $hand->getPoints();
            $player->hands[] = $hand;
            $player->points[] = $handPoints;
          }

        $response = new JsonResponse($player->hands);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/proj/api/dealer", name: "proj_api_dealer", methods: ['GET'])]
    public function jsonDealer(
        SessionInterface $session
    ): Response {
        $deck = $session->get("BlackJackDeck");
        $deckString = $deck->getValue();

        $turn = $session->get("turn");
        $handsleft = $session->get("handsleft");
        $handsquantity = $session->get("handsquantity");
        $player = $session->get("player");
        $bets = $session->get("bets");
        $betsmade = $session->get("betsmade");

        $computerHand = new BlackJackCardHand();
        $computerHandArr = $computerHand->draw(2, $deckString);
        $computerHand->setValue($computerHandArr);

        $computerPoints = $computerHand->getPoints();
        $session->set("computer", $computerPoints);

        while ($computerPoints < 17) {
            $newCard = $computerHand->draw(1, $deckString)[0];
            $computerHand = $computerHand->addCard($newCard, $computerHand);
            $computerPoints = $computerHand->getPoints();
        }

        $computerHand->checkforace($computerPoints);
        $computerPoints = $computerHand->getPoints();

        $computerHand = $computerHand->getAsString();

        $newDeck = $deck->remove($computerHandArr);
        $deck->setValue($newDeck);

        $data = [
            "hand" => $computerHand,
            "Points" => $computerPoints
        ];
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/proj/api/result", name: 'proj_api_result', methods: ['POST'])]
    public function jsonResult(
        SessionInterface $session,
        Request $request,
    ): Response {
        $player = $request->request->get("player");
        $dealer = $request->request->get('dealer');
        $result = new BlackJackresult();
        $message = $result->checkresult($dealer, $player);

        $data = [
            "resultat" => $message,
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
    #[Route("/proj/api/deck", name: "proj_api_deck", methods: ['POST'])]
    public function jsonDraw(
        SessionInterface $session,
        Request $request
    ): Response {
        $deck = new BlackJackDeckOfCards();
        $deck->shuffle();
        $deckString = $deck->getValue();
        $num = $request->request->get('cards');
        $hand = new BlackJackCardHand();
        $handArr = $hand->draw($num, $deckString);
        $hand->setValue($handArr);

        $newDeck = $deck->remove($handArr);
        $deck->setValue($newDeck);

        $data = [
            "dragna kort" => $hand->getAsString(),
            "resterande kort" => $deck->getAsString()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    // #[Route("/api/game", name: "api_game", methods: ['GET'])]
    // public function game(
    //     SessionInterface $session
    // ): Response {
    //     $player = $session->get("player");
    //     $computer =  $session->get("computer");

    //     $data = [
    //         'Player current score' => $player,
    //         'Computer current score' => $computer,
    //     ];

    //     $response = new JsonResponse($data);
    //     $response->setEncodingOptions(
    //         $response->getEncodingOptions() | JSON_PRETTY_PRINT
    //     );
    //     return $response;
    // }
    // #[Route('api/library/books', name: 'api_book_show_all')]
    // public function showAllBook(
    //     BookRepository $bookRepository
    // ): Response {
    //     $books = $bookRepository
    //         ->findAll();

    //     $library = [];

    //     foreach ($books as $book) {
    //         $book= [
    //         'title' => $book->getTitle(),
    //         'author'=> $book->getAuthor(),
    //         'isbn' => $book->getIsbn(),
    //         'img' => $book->getImg(),
    //         'id' => $book->getId()
    //         ];

    //         $library[] = $book;
    //     };

    //     $data = [
    //         'books' => $library
    //     ];
    //     $response = new JsonResponse($data);
    //     $response->setEncodingOptions(
    //         $response->getEncodingOptions() | JSON_PRETTY_PRINT
    //     );
    //     return $response;
    // }
}
