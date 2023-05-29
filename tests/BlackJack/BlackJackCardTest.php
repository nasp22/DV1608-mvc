<?php

namespace App\BlackJack;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class BlackJackCardTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateBlackJackCard():void
    {
        $card = new BlackJackCard();
        $this->assertInstanceOf("\App\BlackJack\BlackJackCard", $card);
    }

    public function testSetPoints():void
    {
        $card = new BlackJackCard();
        $card->setPoints(22);
        $res = $card->getPoints();
        $exp = 22;
        $this->assertEquals($res, $exp);
    }
}
