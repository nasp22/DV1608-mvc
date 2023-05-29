<?php

namespace App\BlackJack;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class BlackJackDeckOfCards.
 */
class BlackJackDeckOfCardsTest extends TestCase
{
    /**
     * test to create a Deck of Cards
     */
    public function testCreateDeckOfCards():void
    {
        $deck= new BlackJackDeckOfCards();
        $this->assertInstanceOf("\App\BlackJack\BlackJackDeckOfCards", $deck);

        $res = Count($deck->value);
        $exp = 52;
        $this->assertEquals($res, $exp);

        foreach ($deck->value as $card) {
            $this->assertInstanceOf("\App\BlackJack\BlackJackCard", $card);
        }
    }
    /**
     * test method shuffle()
     */
    public function testShuffle():void
    {
        $deck= new BlackJackDeckOfCards();
        $this->assertInstanceOf("\App\BlackJack\BlackJackDeckOfCards", $deck);
        $exp = $deck->value;
        $deckShuffled = $deck->shuffle();
        $res = $deckShuffled;

        $this->assertNotEquals($res, $exp);
    }

    /**
     * test method GetValue()
     */
    public function testGetValue():void
    {
        $deck = new BlackJackDeckOfCards();
        $cards = [];
        foreach ($deck->value as $card) {
            $cards[] = $card->getValue();
        }

        $res = $deck->getValue();
        $exp = $cards;
        $this->assertEquals($res, $exp);
    }
    /**
     * test method getAsString
     */
    public function testgetAsString():void
    {
        $deck = new BlackJackDeckOfCards();
        $cards = [];
        foreach ($deck->value as $card) {
            $cards[] = $card->getAsString();
        }

        $res = $deck->getAsString();
        $exp = $cards;
        $this->assertEquals($res, $exp);
    }
    /**
     * test method setValue
     */
    public function testSetValue():void
    {
        $deck = new BlackJackDeckOfCards();
        $deck2 = new BlackJackDeckOfCards();

        $res = $deck->value;
        $exp = $deck2->value;
        $this->assertEquals($res, $exp);

        $card = new BlackJackCard();
        $card->specificCard(["2", "_of_spades"]);
        $cards = [$card];
        $deck->setValue($cards);

        $res = $deck->value;
        $exp = $deck2->value;
        $this->assertNotEquals($res, $exp);

        $res = ["2", "_of_spades"];
        $exp = $card->getValue();
        $this->assertEquals($res, $exp);
    }
    /**
     * test method remove
     */
    public function testRemove():void
    {
        $deck = new BlackJackDeckOfCards();
        $deck2 = new BlackJackDeckOfCards();

        $res = $deck->value;
        $exp = $deck2->value;
        $this->assertEquals($res, $exp);

        $card = new BlackJackCard();
        $card->specificCard(["2", "_of_spades"]);
        $card2 = new BlackJackCard();
        $card2->specificCard(["3", "_of_spades"]);
        $cards = [$card, $card2];
        $deck->setValue($cards);

        $res = $deck->value;
        $exp = $deck2->value;
        $this->assertNotEquals($res, $exp);

        $res = ["2", "_of_spades"];
        $exp = $card->getValue();
        $this->assertEquals($res, $exp);
        $res = $deck->remove($cards);
        $exp = [];
        $this->assertEquals($res, $exp);

        foreach ($res as $card) {
            $this->assertInstanceOf("\App\BlackJack\BlackJackCard", $card);
        }
    }
}
