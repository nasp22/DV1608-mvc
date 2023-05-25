<?php

namespace App\BlackJack;

/**
 * class for Result
 */
class BlackJackResult
{
    /**
     * stringto hold message
    * @var string $message
    */
    public string $message;
    /**
     * construct method to set this->message
     */
    public function __construct()
    {
        $this->message = "";
    }

    /**
    * method to check result, returns message
    * @param int $computerPoints
    * @param int $playersPoints
    * @return array<int, string> $this->message
    */
    public function checkresult(int $computerPoints, int $playersPoints): string
    {   /**
        * if fat, winning or loosing, set message and return
        */
        if ($computerPoints > 21) {
            $this->win();
        } elseif ($computerPoints == 21) {
            $this->lost();
        } elseif ($playersPoints == 21) {
            $this->message = 'Vinst!';
        } elseif ($computerPoints > $playersPoints) {
            $this->lost();
        } elseif ($playersPoints > 21) {
            $this->lost();
        } if ($playersPoints < 21 && $computerPoints < 21 && $playersPoints < $computerPoints) {
            $this->lost();
        } if ($playersPoints < 21 && $computerPoints < 21 && $computerPoints < $playersPoints) {
            $this->win();
        } elseif ($playersPoints == $computerPoints) {
            $this->lost();
        } elseif ($playersPoints == 500) {
            $this->fat();
        }

        return $this->message;
    }

    /**
    * method set message winning
    */
    public function win(): void
    {
        $this->message = 'Vinst!';
    }
    /**
    * method set message loosing
    */
    public function lost(): void
    {
        $this->message = 'Förlust!';
    }
    /**
    * method set message fat
    */
    public function fat(): void
    {
        $this->message = 'You got over 21 and you lost the game!';
    }
}
