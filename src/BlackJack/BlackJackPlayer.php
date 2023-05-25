<?php

namespace App\BlackJack;

/**
*  class for BlackJackPlayer
* @property int $points
* @property array<int, string> $value
*/
class BlackJackPlayer
{
    /**
    * @var array<int, array<int, string>> $hands
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
    * this->stay, to know if stayed
    */
    public bool $stay;
    /**
    * construct method to set name and points
    */
    public function __construct(string $alias = "player", array $points = [], int $coins = 500,  bool $stay=false, array $hands=[])
    {
        $this->points = $points;
        $this->coins = $coins;
        $this->stay = $stay;
        $this->hands = $hands;
        $this->alias = $alias;
    }
    /**
    * method to get name
    * @return string $this-name
    */
    public function getName(): array
    {
        return $this->name;
    }
    /**
     * method to get points
     * @return int $this->points;
     */
    public function getPoints(): int
    {
        return $this->points;
    }
    /**
     * method to set points
     */
    public function setPoints(int $points): void
    {
        $this->points = $points;
    }
    /**
     * method to get points as a string
     */
    public function getAsString(): string
    {
        return implode("", $this->points);
    }
}
