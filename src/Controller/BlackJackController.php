<?php

namespace App\Controller;

use App\BlackJack\BlackJackCardHand;
use App\BlackJack\BlackJackDeckOfCards;
use App\BlackJack\BlackJackResult;
use App\BlackJack\BlackJackCard;
use App\BlackJack\BlackJackPlayer;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class BlackJackController extends AbstractController
{
    #[Route("/proj/init", name: "proj_init")]
    public function twentyoneinit(
        SessionInterface $session
    ): Response {
        $deck = new BlackJackDeckOfCards();
        $session->set("BlackJackDeck", $deck);
        $deck->shuffle();
        $session->set("player", new BlackJackPlayer);
        $session->set('handsquantity', 1);
        $session->set("computer", 0);
        $session->set("turn", 0);
        $session->set("bets", []);
        $session->set("betsmade", 0);
        return $this->redirectToRoute('proj_start');
    }

    #[Route("/proj", name: "proj_start")]
    public function twentyonehome(
        SessionInterface $session
    ): Response {
        $deck = $session->get("BlackJackDeck");
        if ($deck == null) {
            return $this->redirectToRoute('proj_init');
        }

        $data = [
            "deck" => $deck->getAsString()
        ];
        $session->set("BlackJackDeck", $deck);

        return $this->render('proj/home.html.twig', $data);
    }

    #[Route("/proj/newGame", name: "proj_new")]
    public function twentyonenew(
        SessionInterface $session
    ): Response {
        return $this->render('proj/setalias.html.twig');
    }


    #[Route("/proj/rematch", name: "proj_rematch")]
    public function twentyonerematch(
        SessionInterface $session
    ): Response {
        $player =$session->get("player");
        $alias = $player->alias;
        $coins = $player->coins;
        $playerNew = new BlackJackPlayer;
        $playerNew->alias = $alias;
        $playerNew->coins = $coins;

        $session->set("player", $playerNew);

        $deck = new BlackJackDeckOfCards();
        $session->set("BlackJackDeck", $deck);
        $deck->shuffle();

        $session->set('handsquantity', 1);
        $session->set("computer", 0);
        $session->set("turn", 0);
        $session->set("bets", []);
        $session->set("betsmade", 0);

        $data = [
            "playername" => $player->alias,
        ];
        return $this->render('proj/sethandsquantity.html.twig', $data);
    }

    #[Route("/proj/setalias", name: "proj_setalias")]
    public function twentyonealias(
        SessionInterface $session,
        Request $request,
    ): Response {
        $alias= $request->request->get('alias');
        $player = $session->get("player");
        $player->alias = $alias;

        $session->set("player", $player);

        $data = [
            "playername" => $player->alias,
        ];

        return $this->render('proj/sethandsquantity.html.twig', $data);
    }


    #[Route("/proj/sethands", name: "proj_sethandsquantity")]
    public function twentyonehandsquantity(
        SessionInterface $session,
        Request $request,
    ): Response {
        $deck = $session->get("BlackJackDeck");
        $deckString = $deck->getValue();
        $player = $session->get("player");
        $handsquantity= $request->request->get('handsquantity');
        $session->set('handsquantity', $handsquantity);

        for ($x = 0; $x <= $handsquantity-1; $x++) {
            $hand = new BlackJackCardHand();
            $handArr = $hand->draw(2, $deckString);
            $hand->setValue($handArr);
            $handPoints = $hand->getPoints();
            $player->hands[] = $hand;
            $player->points[] = $handPoints;
          }

        $session->set("handsleft", $player->hands);
        $session->set("player", $player);

        return $this->redirectToRoute('proj_bet');
    }

    #[Route("/proj/bet", name: "proj_bet")]
    public function twentyonebet(
        SessionInterface $session
    ): Response {
        $handsquantity = $session->get("handsquantity");
        $player = $session->get("player");

        $data = [
            "handsquantity" => $handsquantity,
            "coins" => $player->coins
        ];
        return $this->render('proj/bet.html.twig', $data);
    }

    #[Route("/proj/board", name: "proj_board")]
    public function board(
        SessionInterface $session,
        Request $request,

    ): Response {

        $turn = $session->get("turn");
        $handsquantity = $session->get("handsquantity");
        $bets = $session->get("bets");
        $betsmade = $session->get("betsmade");
        $player = $session->get("player");
        $handsleft = $session->get("handsleft");

        $name = $player->alias;
        $hands = $player->hands;
        $points = $player->points;
        $handsToData = [];
        $pointsToData = [];
        $stayToData = [];
        $fetToData = [];

        foreach ($hands as $hand) {
            $handsToData[] = $hand->getAsString();
        }

        foreach ($points as $point) {
            $pointsToData[] = $point;
        }

        foreach ($handsleft as $hand) {
            if ($hand->stay == true) {
                $stayToData[] = "true";
            } else {
                $stayToData[] = "false";
            }
        }

        foreach ($handsleft as $hand) {
            if ($hand->fat == true) {
                $fetToData[] = "true";
            } else {
                $fetToData[] = "false";
            }
        }

        $data = [
            "alias" => $name,
            "hands" => $handsToData,
            "points" => $pointsToData,
            "handsquantity" => $handsquantity,
            "coins" => $player->coins,
            "bets" => $bets,
            "turn" => $turn,
            "betsmade" => $betsmade,
            "stay" => $stayToData,
            "fat" =>$fetToData
        ];

        return $this->render('proj/board.html.twig', $data);
    }

    #[Route("/proj/draw", name: "proj_draw")]
    public function drawone(
        SessionInterface $session
    ): Response {
        $deck = $session->get("BlackJackDeck");

        $turn = $session->get("turn");
        $handsquantity = $session->get("handsquantity");
        $bets = $session->get("bets");
        $betsmade = $session->get("betsmade");
        $player = $session->get("player");
        $handsleft = $session->get("handsleft");

        $hand = $handsleft[$turn];
        $deckString = $deck->getValue();
        $newCard = $hand->draw(1, $deckString)[0];
        $hand->addCard($newCard, $hand);

        $cardPoints = $newCard->getPoints();
        $player->hands[$turn] = $hand;
        $player->points[$turn] += $cardPoints;

        $hand = $player->hands[$turn];

        $hand->checkforace($player->points[$turn]);
        $latestPoints = $hand->getPoints();
        $player->points[$turn] = $latestPoints;

        if ($player->points[$turn]> 21) {
            $player->hands[$turn]->fat = true;
            $session->set("player", $player);
            return $this->redirectToRoute('proj_turn');
        }

        if ($player->points[$turn] == 21) {
            $player->hands[$turn]->BlackJack = true;
            $session->set("player", $player);
            return $this->redirectToRoute('proj_turn');
        }

        return $this->redirectToRoute('proj_player');
    }

    #[Route("/proj/stay", name: "proj_stay", methods: ['POST'])]
    public function twentyonestay(
        Request $request,
        SessionInterface $session
    ): Response {

        $turn = $request->request->get('stay');
        $handsleft = $session->get("handsleft");
        $handsleft[$turn]->stay = true;
        $session->set("handsleft", $handsleft);

        return $this->redirectToRoute('proj_turn');
    }

    #[Route("/proj/betsmade", name: "proj_betsmade", methods: ['POST'])]
    public function twentyonebetsmade(
        Request $request,
        SessionInterface $session
    ): Response {
    $bets = $session->get("bets");
    $betsmade = $session->get("betsmade");
    $handsquantity = $session->get("handsquantity");

    for ($x = 0; $x <= $handsquantity-1; $x++) {
        $bet = $request->request->get($x+1);
        $hand = $x+1;
        $bets[$hand] = $bet;
        $betsmade += $bet;
    }

    $session->set("bets", $bets);
    $player = $session->get("player");

    $playersCoins = $player->coins;
    $playersCoins = $playersCoins - $betsmade;
    $player->coins = $playersCoins;
    $session->set("betsmade", $betsmade);

    return $this->redirectToRoute('proj_board');
    }

    #[Route("/proj/turn", name: "proj_turn")]
    public function turn(
        SessionInterface $session,
        Request $request,
    ): Response {
        $turn = $session->get("turn");
        $handsquantity = $session->get("handsquantity");
        $player = $session->get("player");
        $handsleft = $session->get("handsleft");

        $turn += 1;
        $session->set("turn", $turn);

        if ($turn <= $handsquantity-1) {
            return $this->redirectToRoute('proj_player');
        } else {
            return $this->redirectToRoute('proj_computer');
        }
     }

    #[Route("/proj/player", name: "proj_player")]
    public function player(
        SessionInterface $session,
        Request $request,
    ): Response {
        $turn = $session->get("turn");
        $handsleft = $session->get("handsleft");
        $handsquantity = $session->get("handsquantity");
        $player = $session->get("player");
        $bets = $session->get("bets");
        $betsmade = $session->get("betsmade");

        $name = $player->alias;
        $hands = $player->hands;
        $points = $player->points;

        $handsToData = [];
        $pointsToData = [];
        $stayToData = [];
        foreach ($hands as $hand) {
            $handsToData[] = $hand->getAsString();
        }

        foreach ($points as $point) {
            $pointsToData[] = $point;
        }

        foreach ($handsleft as $hand) {
            if ($hand->stay === true) {
                $stayToData[] = "true";
            } else {
                $stayToData[] = "false";
            }
        }

        foreach ($handsleft as $hand) {
            if ($hand->fat === true) {
                $fetToData[] = "true";
            } else {
                $fetToData[] = "false";
            }
        }

        $data = [
            "alias" => $name,
            "hands" => $handsToData,
            "points" => $pointsToData,
            "handsquantity" => $handsquantity,
            "coins" => $player->coins,
            "bets" => $bets,
            "turn" => $turn,
            "betsmade" => $betsmade,
            "stay" => $stayToData,
            "fat" => $fetToData
        ];

        return $this->render('proj/board.html.twig', $data);
    }

    #[Route("/proj/computer", name: "proj_computer")]
    public function computer(
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

        $session->set("BlackJackDeck", $deck);
        $session->set("computer", $computerPoints);
        $session->set("computerHand", $computerHand);

        return $this->redirectToRoute('proj_dealer');
        }

        #[Route("/proj/dealer", name: "proj_dealer")]
        public function dealer(
            SessionInterface $session
        ): Response {

        $computerPoints = $session->get("computer");
        $computerHand = $session->get("computerHand");
        $turn = $session->get("turn");
        $handsleft = $session->get("handsleft");
        $handsquantity = $session->get("handsquantity");
        $player = $session->get("player");
        $bets = $session->get("bets");
        $betsmade = $session->get("betsmade");

        $hands = $player->hands;
        $points = $player->points;
        $alias = $player->alias;

        $handsToData = [];
        $pointsToData = [];
        $stayToData = [];

        foreach ($hands as $hand) {
            $handsToData[] = $hand->getAsString();
        }

        foreach ($points as $point) {
            $pointsToData[] = $point;
        }

        foreach ($handsleft as $hand) {
            if ($hand->stay === true) {
                $stayToData[] = "true";
            } else {
                $stayToData[] = "false";
            }
        }

        foreach ($handsleft as $hand) {
            if ($hand->fat === true) {
                $fetToData[] = "true";
            } else {
                $fetToData[] = "false";
            }
        }
        $result = new BlackJackResult();

        $resultPot = 0;

        for ($x = 1; $x <= sizeof($pointsToData); $x++) {
            $message = $result->checkresult($computerPoints, $pointsToData[$x-1]);
            $resultArr[$x] = $message;
        };


        for ($x = 1; $x <= sizeof($resultArr); $x++) {
            if ($resultArr[$x] == "Vinst!") {
                $resultPot += $bets[$x];
            }
        }

        $wallet = $player->coins;
        $player->coins = $wallet + ($resultPot*2);

        $session->set("player", $player);

        $data = [
            "alias" => $alias,
            "hands" => $handsToData,
            "points" => $pointsToData,
            "handsquantity" => $handsquantity,
            "coins" => $player->coins,
            "bets" => $bets,
            "turn" => $turn,
            "betsmade" => $betsmade,
            "stay" => $stayToData,
            "fat" => $fetToData,
            "computerHand" => $computerHand,
            "computerPoints" => $computerPoints,
            "result" => $resultArr,
            "resultPot" => ($resultPot*2)
        ];
        return $this->render('proj/dealer.html.twig', $data);
    }
}
