<?php

namespace App\BlackJack;

/**
*  class for BlackJackPlayer
* @property array<int, int> $points
* @property array<int, string> $value
*/
class BlackJackPlayer
{
    /**
    * @var array<int, string> $hands
    * array to hold hands
    */
    public array $hands;

    /**
    * @var array<int, int> $points
    * array to hold points
    */
    public array $points;

    /**
    * this->name, to hold name
    */
    public string $alias;

    /**
    * this->coins, to hold coins
    */
    public int $coins;

    /**
    * construct method to set name and points
    *@param array<int, int> $points
    *@param array<int, string> $hands
    */
    public function __construct(string $alias = "player", array $points = [], int $coins = 500, array $hands=[])
    {
        $this->points = $points;
        $this->coins = $coins;
        $this->hands = $hands;
        $this->alias = $alias;
    }
    /**
     * method to get points as a string
    */
    public function getAsString(): string
    {
        return implode("", $this->points);
    }
}
