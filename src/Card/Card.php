<?php

namespace App\Card;

class Card
{
    public $value;
    public $points;

    public function __construct()
    {
        $this->value = null;
        $this->points = null;
    }
    public function specificCard($cardArray)
    {
        $this->value = $cardArray;

        if ($cardArray[0][0] == "a") {
            $this->points = 14;
        }
        if ($cardArray[0][0] == "2") {
            $this->points = 2;
        }
        if ($cardArray[0][0] == "3") {
            $this->points = 3;
        }
        if ($cardArray[0][0] == "4") {
            $this->points = 4;
        }
        if ($cardArray[0][0] == "5") {
            $this->points = 5;
        }
        if ($cardArray[0][0] == "6") {
            $this->points = 6;
        }
        if ($cardArray[0][0] == "7") {
            $this->points = 7;
        }
        if ($cardArray[0][0] == "8") {
            $this->points = 8;
        }
        if ($cardArray[0][0] == "9") {
            $this->points = 9;
        }
        if ($cardArray[0][0] == "1" && $this->value[0][1] == "0") {
            $this->points = 10;
        }
        if ($cardArray[0][0] == "j") {
            $this->points = 11;
        }
        if ($cardArray[0][0] == "q") {
            $this->points = 12;
        }
        if ($cardArray[0][0] == "k") {
            $this->points = 13;
        }
    }
    public function getValue(): array
    {
        return $this->value;
    }
    public function getPoints(): int
    {
        return $this->points;
    }

    public function setPoints($points)
    {
        $this->points = $points;
    }

    public function getAsString(): string
    {
        return implode("", $this->value);
    }
}
