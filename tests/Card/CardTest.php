<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class CardTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateCard()
    {
        $card = new Card();
        $this->assertInstanceOf("\App\Card\Card", $card);
    }

    public function testSetPoints()
    {
        $card = new Card();
        $card->setPoints(22);
        $res = $card->getPoints();
        $exp = 22;
        $this->assertEquals($res, $exp);
    }
}