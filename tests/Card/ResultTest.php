<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Result.
 */
class ResultTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateResult():void
    {
        $result= new Result();
        $this->assertInstanceOf("\App\Card\Result", $result);
    }

    public function testCheckResult():void
    {
        $result= new Result();
        $this->assertInstanceOf("\App\Card\Result", $result);

        $res = $result->checkresult(22, 21);
        $exp = ['success', 'You Won!'];
        $this->assertEquals($res, $exp);

        $res = $result->checkresult(12, 18);
        $exp = ['success', 'You Won!'];
        $this->assertEquals($res, $exp);

        $res = $result->checkresult(21, 19);
        $exp = ['warning', 'You lost!'];
        $this->assertEquals($res, $exp);

        $res = $result->checkresult(21, 21);
        $exp = ['warning', 'You lost!'];
        $this->assertEquals($res, $exp);

        $res = $result->checkresult(12, 21);
        $exp = ['success', 'You Won!'];
        $this->assertEquals($res, $exp);

        $res = $result->checkresult(0, 500);
        $exp = ['warning', 'You got over 21 and you lost the game!'];
        $this->assertEquals($res, $exp);

        $res = $result->checkresult(18, 12);
        $exp = ['warning', 'You lost!'];
        $this->assertEquals($res, $exp);
    }
}