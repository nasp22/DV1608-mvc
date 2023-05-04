<?php

namespace App\Controller;

use App\Card\CardHand;
use App\Card\DeckOfCards;
use App\Card\Result;
use App\Card\Card;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class TwentyOneController extends AbstractController
{
    #[Route("/game/init", name: "21_init")]
    public function twentyoneinit(
        SessionInterface $session
    ): Response {
        $deck = new DeckOfCards();
        $session->set("twentyOneDeck", $deck);
        $deck = $deck->shuffle();
        $session->set("player", 0);
        $session->set("computer", 0);
        return $this->redirectToRoute('21_start');
    }

    #[Route("/game/doc", name: "doc")]
    public function doc(): Response
    {
        return $this->render('game/doc.html.twig');
    }

    #[Route("/game/newGame", name: "21_new")]
    public function twentyonenew(
        SessionInterface $session
    ): Response {
        $deck = new DeckOfCards();
        $session->set("twentyOneDeck", $deck);
        $deck = $deck->shuffle();
        $session->set("player", 0);
        $session->set("computer", 0);
        return $this->redirectToRoute('21_board');
    }

    #[Route("/game", name: "21_start")]
    public function twentyonehome(
        SessionInterface $session
    ): Response {
        $deck = $session->get("twentyOneDeck");
        if ($deck == null) {
            return $this->redirectToRoute('21_init');
        }

        $data = [
            "deck" => $deck->getAsString()
        ];
        $deck = $session->set("twentyOneDeck", $deck);

        return $this->render('game/home.html.twig', $data);
    }

    #[Route("/game/board", name: "21_board")]
    public function board(
        SessionInterface $session
    ): Response {
        $deck = $session->get("twentyOneDeck");
        $deckString = $deck->getValue();

        $hand = new CardHand();
        $handArr = $hand->draw(1, $deckString);
        $hand->setValue($handArr);
        $session->set("hand", $hand);

        $handPoints = $hand->getPoints();

        $newDeck = $deck->remove($handArr);
        $deck->setValue($newDeck);

        $data = [
            "hand"=>$hand->getAsString(),
            "deck"=>$deck->getAsString(),
            "points" => $handPoints
        ];

        $session->set("twentyOneDeck", $deck);
        $session->set("player", $handPoints);

        return $this->render('game/board.html.twig', $data);
    }

    #[Route("/game/draw", name: "21_draw")]
    public function drawone(
        SessionInterface $session
    ): Response {
        $deck = $session->get("twentyOneDeck");
        $hand = $session->get("hand");
        $playersPoints = $session->get("player");
        $computerPoints = $session->get("computer");
        $deckString = $deck->getValue();
        $newCard = $hand->draw(1, $deckString)[0];
        $hand = $hand->addCard($newCard, $hand);
        $cardPoints = $newCard->getPoints();
        $playersPoints = $playersPoints + $cardPoints;

        $newCardArr = [];

        $session->set("hand", $hand);
        $newCardArr[] = $newCard;

        $hand->checkforace($playersPoints);
        $playersPoints = $hand->getPoints();

        $newDeck = $deck->remove($newCardArr);
        $deck->setValue($newDeck);

        // computer wins, player is FAT:
        // $playersPoints = 22;

        $data = [
            "hand"=>$hand->getAsString(),
            "deck"=>$deck->getAsString(),
            "playersPoints" => $playersPoints,
            "computerPoints" => $computerPoints
        ];
        $session->set("hand", $hand);
        $session->set("player", $playersPoints);
        $session->set("twentyOneDeck", $deck);

        if ($playersPoints > 21) {
            return $this->redirectToRoute('21_fat');
        }

        return $this->render('game/player.html.twig', $data);
    }
    #[Route("/game/stay", name: "21_stay", methods: ['POST'])]
    public function twentyonestay(
        Request $request,
        SessionInterface $session
    ): Response {

        $playersPoints = $request->request->get('stay');

        $session->set("player", $playersPoints);
        return $this->redirectToRoute('21_computer');
    }

    #[Route("/game/computer", name: "21_computer")]
    public function computer(
        SessionInterface $session
    ): Response {
        $deck = $session->get("twentyOneDeck");
        $hand = $session->get("hand");
        $playersPoints = $session->get("player");
        $computerPoints = $session->get("computer");
        $deckString = $deck->getValue();

        $computerHand = new CardHand();
        $computerHandArr = $computerHand->draw(2, $deckString);
        $computerHand->setValue($computerHandArr);

        $computerPoints = $computerHand->getPoints();
        $session->set("computer", $computerPoints);

        while ($computerPoints <=17) {
            $newCard = $computerHand->draw(1, $deckString)[0];
            $computerHand = $computerHand->addCard($newCard, $computerHand);
            $computerPoints = $computerHand->getPoints();
        }

        $computerHand->checkforace($computerPoints);
        $computerPoints = $computerHand->getPoints();

        $hand = $hand->getAsString();
        $computerHand = $computerHand->getAsString();

        $newDeck = $deck->remove($computerHandArr);
        $deck->setValue($newDeck);

        $session->set("twentyOneDeck", $deck);
        $session->set("player", $playersPoints);
        $session->set("computer", $computerPoints);
        $session->set("computerHand", $computerHand);
        return $this->redirectToRoute('21_result');
    }

    #[Route("/game/result", name: "21_result")]
    public function computerresult(
        SessionInterface $session
    ): Response {
        $deck = $session->get("twentyOneDeck");
        $hand = $session->get("hand");
        $playersPoints = $session->get("player");
        $computerPoints = $session->get("computer");
        $hand = $hand->getAsString();
        $computerHand = $session->get("computerHand");

        // TEST RESULTS:
        // If player is fat -> route "21_fat"

        // you lost:
        // $playersPoints = 21;
        // $computerPoints= 21;

        // you won:
        // $playersPoints = 21;
        // $computerPoints= 22;

        // you won:
        // $playersPoints = 10;
        // $computerPoints= 22;

        // you lost:
        // $playersPoints = 18;
        // $computerPoints= 18;

        $result = new Result();
        $result = $result->checkresult($computerPoints, $playersPoints);

        $this->addFlash(
            $result[0],
            $result[1]
        );

        $data = [
            "playersPoints" => $playersPoints,
            "computerPoints" => $computerPoints,
            "hand"=>$hand,
            "computerHand"=>$computerHand,
            "deck"=>$deck->getAsString()
        ];

        $session->set("twentyOneDeck", $deck);

        return $this->render('game/result.html.twig', $data);
    }

    #[Route("/game/fat", name: "21_fat")]
    public function computerfat(
        SessionInterface $session
    ): Response {
        $deck = $session->get("twentyOneDeck");
        $hand = $session->get("hand");
        $playersPoints = $session->get("player");
        $hand = $hand->getAsString();

        $data = [
            "playersPoints" => $playersPoints,
            "computerPoints" => 0,
            "hand"=>$hand,
            "computerHand"=>[""],
            "deck"=>$deck->getAsString()
        ];

        $session->set("twentyOneDeck", $deck);

        $result = new Result();
        $result = $result->checkresult(0, 500);

        $this->addFlash(
            $result[0],
            $result[1]
        );

        return $this->render('game/fat.html.twig', $data);
    }
}
