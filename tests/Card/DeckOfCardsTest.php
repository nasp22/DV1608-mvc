<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DeckOfCards.
 */
class DeckOfCardsTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateDeckOfCards()
    {
        $deck= new DeckOfCards();
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);

        $res = Count($deck->value);
        $exp = 52;
        $this->assertEquals($res, $exp);

        foreach($deck->value as $card) {
            $this->assertInstanceOf("\App\Card\Card", $card);
        }
    }

    public function testShuffle()
    {
        $deck= new DeckOfCards();
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);
        $exp = $deck->value;
        $deckShuffled = $deck->shuffle();
        $res = $deckShuffled;

        $this->assertNotEquals($res, $exp);

    }

    public function testGetValue()
    {
        $deck = new DeckOfCards();
        $cards = [];
        foreach($deck->value as $card) {
            $cards[] = $card->getValue();
        }

        $res = $deck->getValue();
        $exp = $cards;
        $this->assertEquals($res, $exp);
    }

    public function testgetAsString()
    {
        $deck = new DeckOfCards();
        $cards = [];
        foreach($deck->value as $card) {
            $cards[] = $card->getAsString();
        }

        $res = $deck->getAsString();
        $exp = $cards;
        $this->assertEquals($res, $exp);
    }

    public function testSetValue()
    {
        $deck = new DeckOfCards();
        $deck2 = new DeckOfCards();

        $res = $deck->value;
        $exp = $deck2->value;
        $this->assertEquals($res, $exp);

        $card = new Card();
        $card->specificCard(["2", "_of_spades"]);
        $cards = [$card];
        $deck->setValue([$cards]);

        $res = $deck->value;
        $exp = $deck2->value;
        $this->assertNotEquals($res, $exp);

        $res = ["2", "_of_spades"];
        $exp = $card->getValue();
        $this->assertEquals($res, $exp);
    }
    public function testRemove()
    {
        $deck = new DeckOfCards();
        $deck2 = new DeckOfCards();

        $res = $deck->value;
        $exp = $deck2->value;
        $this->assertEquals($res, $exp);

        $card = new Card();
        $card->specificCard(["2", "_of_spades"]);
        $card2 = new Card();
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

    }
}