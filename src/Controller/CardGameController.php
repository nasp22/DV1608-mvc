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

class CardGameController extends AbstractController
{
    #[Route("/card/init", name: "card_init")]
    public function initcallback(
        SessionInterface $session
    ): Response {
        $deck = new DeckOfCards();
        $session->set("left", $deck);
        return $this->redirectToRoute('card_start');
    }

    #[Route("/api/init", name: "api_init")]
    public function initapicallback(
        SessionInterface $session
    ): Response {
        $deck = new DeckOfCards();
        $session->set("left", $deck);
        return $this->redirectToRoute('api');
    }

    #[Route("/card", name: "card_start")]
    public function home(
        SessionInterface $session
    ): Response {
        $deck = $session->get("left");
        if ($deck == null) {
            return $this->redirectToRoute('card_init');
        }
        $data = [
            "deck" => $deck->getAsString()
        ];
        $deck = $session->set("left", $deck);

        return $this->render('card/home.html.twig', $data);
    }

    #[Route("/api", name: "api")]
    public function jsonstart(
        SessionInterface $session
    ): Response {
        $deck = $session->get("left");
        if ($deck == null) {
            return $this->redirectToRoute('api_init');
        }
        $data = [
            "deck" => $deck->getAsString()
        ];
        $deck = $session->set("left", $deck);

        return $this->render('api/home.html.twig', $data);
    }

    #[Route("/card/deck", name: "deck-sorted")]
    public function deck(
        SessionInterface $session
    ): Response {
        $deck = $session->get("left");

        $data = [
            "deck" =>$deck->getAsString()
        ];

        $deck = $session->set("left", $deck);

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "deck-shuffle")]
    public function deckshuffle(
        SessionInterface $session
    ): Response {
        $shuffledDeck = $session->get("left");
        $data = [
            "deck" =>$shuffledDeck->shuffle()
        ];

        return $this->render('card/deck-shuffle.html.twig', $data);
    }

    #[Route("/card/deck/draw-one", name: "deck-draw")]
    public function deckdraw(
        SessionInterface $session
    ): Response {

        $deck = $session->get("left");
        $deckString = $deck->getValue();

        $hand = new CardHand();
        $handArr = $hand->draw(1, $deckString);
        $hand->setValue($handArr);


        $newDeck = $deck->remove($handArr);
        $deck->setValue($newDeck);

        $data = [
            "hand"=>$hand->getAsString(),
            "deck"=>$deck->getAsString(),
            "number"=>1
        ];

        $session->set("left", $deck);


        return $this->render('card/deck-draw.html.twig', $data);
    }

    #[Route("/card/deck/draw/{num<\d+>}", name: "deck-draw-number")]
    public function deckdrawnumber(
        int $num,
        SessionInterface $session
    ): Response {

        $deck = $session->get("left");
        $deckString = $deck->getValue();

        $hand = new CardHand();
        $handArr = $hand->draw($num, $deckString);
        $hand->setValue($handArr);


        $newDeck = $deck->remove($handArr);
        $deck->setValue($newDeck);

        $data = [
            "hand"=>$hand->getAsString(),
            "deck"=>$deck->getAsString(),
            "number"=>$num
        ];

        $session->set("left", $deck);


        return $this->render('card/deck-draw.html.twig', $data);
    }

    #[Route("/api/deck/shuffle", name: "json_shuffle", methods: ['POST'])]
    public function apishufflepost(
        SessionInterface $session
    ): Response {
        $deck = $session->get("left");
        $session->set("left", $deck);

        return $this->redirectToRoute('json_shuffle_get');
    }

    #[Route("/api/deck", name: "json_deck", methods: ['POST'])]
    public function apideckpost(
        SessionInterface $session
    ): Response {
        $deck = $session->get("left");
        $session->set("left", $deck);

        return $this->redirectToRoute('json_deck_get');
    }

    #[Route("/api/draw", name: "json_draw", methods: ['POST'])]
    public function apidrawpost(
        Request $request,
        SessionInterface $session
    ): Response {
        $numCards = $request->request->get('num_cards');

        $deck = $session->get("left");
        $session->set("left", $deck);
        $session->set("num", $numCards);

        return $this->redirectToRoute('json_draw_get');
    }
}
