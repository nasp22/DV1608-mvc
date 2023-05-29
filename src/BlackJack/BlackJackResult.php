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
    * @return string $this->message
    */
    public function checkresult(int $computerPoints, int $playersPoints): string
    {   /**
        * if fat, winning or loosing, set message and return
        */

        if ($computerPoints == $playersPoints) {
            $this->equal();
            return $this->message;
        }

        if ($computerPoints == 21 &&  $playersPoints !=21) {
            $this->lost();
            return $this->message;
        } elseif ($playersPoints == 21 &&  $computerPoints !=21) {
            $this->win();
            return $this->message;
        }

        if ($playersPoints < 21 && $computerPoints < 21 && $playersPoints < $computerPoints) {
            $this->lost();
            return $this->message;
        } elseif ($playersPoints < 21 && $computerPoints < 21 && $playersPoints > $computerPoints) {
            $this->win();
            return $this->message;
        } elseif ($playersPoints < 21 && $computerPoints > 21) {
            $this->win();
            return $this->message;
        }

        if ($playersPoints > 21) {
            $this->lost();
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
        $this->message = 'Förlust';
    }
    /**
    * method set message fat
    */
    public function equal(): void
    {
        $this->message = 'Oavgjort!';
    }
}
