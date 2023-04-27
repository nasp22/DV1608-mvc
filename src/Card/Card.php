<?php

namespace App\Card;

/**
* @property int $points
* @property array<int, string> $value
 */
/**
 * class for Card
 */
class Card
{
    /**
    * @var array<int, string> $value
    */
    /**
     * array to hold value
     */
    public array $value;
    /**
     * int to hold points
     */
    public int $points;

    /**
    * @param array<int, string> $value
    */
    /**
     * construct method to set value and points
     */
    public function __construct(array $value = [], int $points = 0)
    {
        $this->value = $value;
        $this->points = $points;
    }
    /**
    * @param array<int, string> $cardArray
    */
    /**
     * method to set points and value as incoming argument
     */
    public function specificCard(array $cardArray):void
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
    /**
    * @return array<int, string> $this-value
    */
    /**
     * method to get value of the card
     */
    public function getValue(): array
    {
        return $this->value;
    }
    /**
    * @return int $this->points;
    */
    /**
     * method to get points of the card
     */
    public function getPoints(): int
    {
        return $this->points;
    }
    /**
     * method to set points of the card
     */
    public function setPoints(int $points):void
    {
        $this->points = $points;
    }
    /**
     * method to get value as a string
     */
    public function getAsString(): string
    {
        return implode("", $this->value);
    }
}
