<?php

namespace App\BlackJack;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class BlackJackPlayerTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateBlackJackPlayer():void
    {
        $player = new BlackJackPlayer();
        $this->assertInstanceOf("\App\BlackJack\BlackJackPlayer", $player);
    }
    /**
     * Test Get as string
     */
   /**
     * test method getAsString
     */
    public function testgetAsString():void
    {

        $player = new BlackJackPlayer();

        $res = $player->getAsString();
        $exp = "";
        $this->assertEquals($res, $exp);
    }
}
