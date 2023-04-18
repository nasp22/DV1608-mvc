<?php

namespace App\Controller;

use App\Card\CardHand;
use App\Card\DeckOfCards;
use App\Card\Player;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class TwentyOneController extends AbstractController
{
    #[Route("/game/init", name: "21_init")]
    public function TwentyOneInit(
        Request $request,
        SessionInterface $session
    ): Response {
        $deck = new DeckOfCards();
        $session->set("twentyOneDeck", $deck);
        $deck = $deck->shuffle();
        $session->set("player", 0);
        $session->set("computer", 0);
        return $this->redirectToRoute('21_start');
    }

    #[Route("/game/newGame", name: "21_new")]
    public function TwentyOneNew(
        Request $request,
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
    public function twentyOneHome(
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
    public function Board(
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
        $session->set("player", $handPoints );

        return $this->render('game/board.html.twig', $data);
    }

    #[Route("/game/draw", name: "21_draw")]
    public function drawOne(
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

        $session->set("hand", $hand);
        $newCardArr[] = $newCard;

        if ($playersPoints > 21 && in_array("ace_of_spades", $hand->getAsString())) {
            $index = array_search("ace_of_spades", array_values($hand->getAsString()));
            $aceS = $hand->value[$index];
            $aceS->points = 1;
            $playersPoints = $hand->getPoints();
        } if ($playersPoints > 21 && in_array("ace_of_hearts", $hand->getAsString())) {
            $index = array_search("ace_of_hearts", array_values($hand->getAsString()));
            $aceH = $hand->value[$index];
            $aceH->points = 1;
            $playersPoints = $hand->getPoints();
        } if ( $playersPoints > 21 && in_array("ace_of_diamonds", $hand->getAsString())) {
            $index = array_search("ace_of_diamonds", array_values($hand->getAsString()));
            $aceD = $hand->value[$index];
            $aceD->points = 1;
            $playersPoints = $hand->getPoints();
        } if ($playersPoints > 21 && in_array("ace_of_clubs", $hand->getAsString())) {
            $index = array_search("ace_of_clubs", array_values($hand->getAsString()));
            $aceC = $hand->value[$index];
            $aceC->points = 1;
            $playersPoints = $hand->getPoints();
        };

        $playersPoints = $hand->getPoints();

        $newDeck = $deck->remove($newCardArr);
        $deck->setValue($newDeck);


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
    public function twentyOneStay(
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
        $session->set("computer", $computerPoints );

        while ($computerPoints <=17) {
            $newCard = $computerHand->draw(1, $deckString)[0];
            $computerHand = $computerHand->addCard($newCard, $computerHand);
            $computerPoints = $computerHand->getPoints();
        }

        if ($computerPoints > 21 && in_array("ace_of_spades", $computerHand->getAsString())) {
            $index = array_search("ace_of_spades", array_values($computerHand->getAsString()));
            $aceS = $computerHand->value[$index];
            $aceS->points = 1;
            $computerPoints = $computerHand->getPoints();
        } if ($computerPoints > 21 && in_array("ace_of_hearts", $computerHand->getAsString())) {
            $index = array_search("ace_of_hearts", array_values($computerHand->getAsString()));
            $aceH = $computerHand->value[$index];
            $aceH->points = 1;
            $computerPoints = $computerHand->getPoints();
        } if ( $computerPoints > 21 && in_array("ace_of_diamonds", $computerHand->getAsString())) {
            $index = array_search("ace_of_diamonds", array_values($computerHand->getAsString()));
            $aceD = $computerHand->value[$index];
            $aceD->points = 1;
            $computerPoints = $computerHand->getPoints();
        } if ($computerPoints > 21 && in_array("ace_of_clubs", $computerHand->getAsString())) {
            $index = array_search("ace_of_clubs", array_values($computerHand->getAsString()));
            $aceC = $computerHand->value[$index];
            $aceC->points = 1;
            $computerPoints = $computerHand->getPoints();
        };

        $computerPoints = $computerHand->getPoints();

        $hand = $hand->getAsString();
        $computerHand = $computerHand->getAsString();

        $newDeck = $deck->remove($computerHandArr);
        $deck->setValue($newDeck);

        $session->set("twentyOneDeck", $deck);
        $session->set("player", $playersPoints );
        $session->set("computer", $computerPoints );
        $session->set("computerHand", $computerHand );
        return $this->redirectToRoute('21_result');
    }

    #[Route("/game/result", name: "21_result")]
    public function computerResult(
        SessionInterface $session
    ): Response {
        $deck = $session->get("twentyOneDeck");
        $hand = $session->get("hand");
        $playersPoints = $session->get("player");
        $computerPoints = $session->get("computer");
        $hand = $hand->getAsString();
        $computerHand = $session->get("computerHand");

        if ($computerPoints > 21) {
            $this->addFlash(
                'success',
                'You Won!'
            );
        } else if ($playersPoints == 21) {
            $this->addFlash(
                'warning',
                'You lost!'
            );
        } else if ($playersPoints == 21) {
            $this->addFlash(
                'success',
                'You Won!'
            );
        } else if ($computerPoints > $playersPoints) {
        $this->addFlash(
            'warning',
            'You lost!'
        );
        } else if ($playersPoints > 21) {
            $this->addFlash(
                'warning',
                'You lost!'
            );
        } else if ($playersPoints < 21 && $computerPoints < 21 && $playersPoints < $computerPoints) {
            $this->addFlash(
                'warning',
                'You lost!'
            );
        } else if ($playersPoints < 21 && $computerPoints < 21 && $computerPoints < $playersPoints) {
            $this->addFlash(
                'success',
                'You Won!'
            );
        }

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
    public function computerFat(
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

        if ($playersPoints> 21) {
            $this->addFlash(
                'warning',
                'You got over 21 and you lost the game!'
            );
        }

        return $this->render('game/fat.html.twig', $data);
    }

}




// if ($computerPoints > 21 && in_array("ace_of_spades", [$newCard->getAsString()])) {
//     $newCard->setPoints(1);
// } else if ($computerPoints > 21 && in_array("ace_of_hearts", [$newCard->getAsString()])) {
//     $newCard->setPoints(1);
// } else if ($computerPoints > 21 && in_array("ace_of_diamonds", [$newCard->getAsString()])) {
//     $newCard->setPoints(1);
// } else if ($computerPoints > 21 && in_array("ace_of_clubs", [$newCard->getAsString()])) {
//     $newCard->setPoints(1);
// };

// $cardPoints = $newCard->getPoints();
// $computerPoints = $session->get("computer");
// $computerPoints = $computerPoints + $cardPoints;