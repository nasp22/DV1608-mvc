<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardHand.
 */
class CardHandTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testDraw():void
    {
        $deck = new DeckOfCards();
        $hand= new CardHand();
        $handOne= new CardHand();


        $hand->value = $hand->draw(5, $hand->getValue());
        $handOne->value = $handOne->draw(1, $deck->getValue());

        foreach ($hand->value as $card) {
            $this->assertInstanceOf("\App\Card\Card", $card);
        }

        $res = Count($hand->value);
        $exp = 5;
        $this->assertEquals($res, $exp);

        $this->expectException(DrawException::class);
        $hand->value = $hand->draw(6, $hand->getValue());

        $res = Count($handOne->value);
        $exp = 1;
        $this->assertEquals($res, $exp);
    }

    public function testGetPoints():void
    {
        $hand = new CardHand();
        $card = new Card();
        $card->specificCard(["2", "_of_spades"]);
        $cards = [$card];
        $hand->setValue($cards);

        $res = $hand->getPoints();
        $exp = 2;
        $this->assertEquals($res, $exp);
    }

    public function testAddCard():void
    {
        $hand = new CardHand();

        $card = new Card();
        $card->specificCard(["2", "_of_spades"]);

        $card2 = new Card();
        $card2->specificCard(["5", "_of_spades"]);
        $hand->setValue([$card]);
        $hand->addCard($card2, $hand);

        $res = $hand->getPoints();
        $exp = 7;
        $this->assertEquals($res, $exp);
    }

    public function testCheckForAce():void
    {
        $hand = new CardHand();

        $cardSpades = new Card();
        $cardSpades->specificCard(["ace", "_of_spades"]);
        $cardClubs = new Card();
        $cardClubs->specificCard(["ace", "_of_clubs"]);
        $cardDiamonds = new Card();
        $cardDiamonds->specificCard(["ace", "_of_diamonds"]);
        $cardHearts = new Card();
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
