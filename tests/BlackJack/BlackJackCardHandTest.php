<?php

namespace App\BlackJack;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class BlackJackBlackJackCardHand.
 */
class BlackJackCardHandTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testDraw():void
    {
        $deck = new BlackJackDeckOfCards();
        $hand= new BlackJackCardHand();
        $handOne= new BlackJackCardHand();


        $hand->value = $hand->draw(5, $hand->getValue());
        $handOne->value = $handOne->draw(1, $deck->getValue());

        foreach ($hand->value as $card) {
            $this->assertInstanceOf("\App\BlackJack\BlackJackCard", $card);
        }

        $res = Count($hand->value);
        $exp = 5;
        $this->assertEquals($res, $exp);

        $this->expectException(BlackJackDrawException::class);
        $hand->value = $hand->draw(6, $hand->getValue());

        $res = Count($handOne->value);
        $exp = 1;
        $this->assertEquals($res, $exp);
    }

    public function testGetPoints():void
    {
        $hand = new BlackJackCardHand();
        $card = new BlackJackCard();
        $card->specificCard(["2", "_of_spades"]);
        $cards = [$card];
        $hand->setValue($cards);

        $res = $hand->getPoints();
        $exp = 2;
        $this->assertEquals($res, $exp);
    }

    public function testAddBlackJackCard():void
    {
        $hand = new BlackJackCardHand();

        $card = new BlackJackCard();
        $card->specificCard(["2", "_of_spades"]);

        $card2 = new BlackJackCard();
        $card2->specificCard(["5", "_of_spades"]);
        $hand->setValue([$card]);
        $hand->addCard($card2, $hand);

        $res = $hand->getPoints();
        $exp = 7;
        $this->assertEquals($res, $exp);
    }

    public function testCheckForAce():void
    {
        $hand = new BlackJackCardHand();

        $cardSpades = new BlackJackCard();
        $cardSpades->specificCard(["ace", "_of_spades"]);
        $cardClubs = new BlackJackCard();
        $cardClubs->specificCard(["ace", "_of_clubs"]);
        $cardDiamonds = new BlackJackCard();
        $cardDiamonds->specificCard(["ace", "_of_diamonds"]);
        $cardHearts = new BlackJackCard();
        $cardHearts->specificCard(["ace", "_of_hearts"]);

        $hand->setValue([$cardSpades]);

        $hand->checkforace(22);
        $res = $hand->getPoints();
        $exp = 1;
        $this->assertEquals($res, $exp);

        $hand->setValue([$cardDiamonds]);

        $hand->checkforace(22);
        $res = $hand->getPoints();
        $exp = 1;
        $this->assertEquals($res, $exp);

        $hand->setValue([$cardHearts]);

        $hand->checkforace(22);
        $res = $hand->getPoints();
        $exp = 1;
        $this->assertEquals($res, $exp);

        $hand->setValue([$cardClubs]);

        $hand->checkforace(22);
        $res = $hand->getPoints();
        $exp = 1;
        $this->assertEquals($res, $exp);
    }
}
