<?php

namespace App\BlackJack;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class BlackJackResultTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateBlackJackResultTest():void
    {
        $player = new BlackJackResult();
        $this->assertInstanceOf("\App\BlackJack\BlackJackResult", $player);
    }
    /**
     * test return of the message
     */
    public function testRestultTest():void
    {
        $result = new BlackJackResult();

        // if ($computerPoints == $playersPoints) {
        //     $this->equal();
        //     return $this->message;
        // }
        $dealer = 19;
        $player = 19;
        $res = $result->checkresult($dealer, $player);
        $exp = "Oavgjort!";
        $this->assertEquals($res, $exp);

        // if ($computerPoints == 21 &&  $playersPoints !=21) {
        //     $this->lost();
        //     return $this->message;
        // }

        $dealer = 22;
        $player = 21;
        $res = $result->checkresult($dealer, $player);
        $exp = "Vinst!";
        $this->assertEquals($res, $exp);

        // elseif ($playersPoints == 21 &&  $computerPoints !=21) {
        //     $this->win();
        //     return $this->message;
        // }

        $dealer = 21;
        $player = 19;
        $res = $result->checkresult($dealer, $player);
        $exp = "Förlust";
        $this->assertEquals($res, $exp);


        // if ($playersPoints < 21 && $computerPoints < 21 && $playersPoints < $computerPoints) {
        //     $this->lost();
        //     return $this->message;
        // }

        $dealer = 20;
        $player = 19;
        $res = $result->checkresult($dealer, $player);
        $exp = "Förlust";
        $this->assertEquals($res, $exp);

        // elseif ($playersPoints < 21 && $computerPoints < 21 && $playersPoints > $computerPoints) {
        //     $this->win();
        //     return $this->message;
        // }

        $dealer = 19;
        $player = 20;
        $res = $result->checkresult($dealer, $player);
        $exp = "Vinst!";
        $this->assertEquals($res, $exp);

        // elseif ($playersPoints < 21 && $computerPoints > 21) {
        //     $this->win();
        //     return $this->message;
        // }

        $dealer = 24;
        $player = 20;
        $res = $result->checkresult($dealer, $player);
        $exp = "Vinst!";
        $this->assertEquals($res, $exp);


        // if ($playersPoints > 21) {
        //       $this->lost();
        // }}

        $dealer = 0;
        $player = 22;
        $res = $result->checkresult($dealer, $player);
        $exp = "Förlust";
        $this->assertEquals($res, $exp);

    }
}
