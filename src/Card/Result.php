<?php

namespace App\Card;

/**
 * class for Result
 */
class Result
{
    /**
     * array to hold message
    * @var array<int, string> $message
    */
    public array $message = [];
    /**
     * construct method to set this->message
     */
    public function __construct()
    {
        $this->message = [];
    }

    /**
    * method to check result, returns message
    * @param int $computerPoints
    * @param int $playersPoints
    * @return array<int, string> $this->message
    */
    public function checkresult(int $computerPoints, int $playersPoints): array
    {
        if ($computerPoints > 21) {
            $this->message = ['success', 'You Won!'];
        } elseif ($computerPoints == 21) {
            $this->message = ['warning', 'You lost!'];
        } elseif ($playersPoints == 21) {
            $this->message = ['success', 'You Won!'];
        } elseif ($computerPoints > $playersPoints) {
            $this->message = ['warning', 'You lost!'];
        } elseif ($playersPoints > 21) {
            $this->message = ['warning', 'You lost!'];
        } if ($playersPoints < 21 && $computerPoints < 21 && $playersPoints < $computerPoints) {
            $this->message = ['warning', 'You lost!'];
        } if ($playersPoints < 21 && $computerPoints < 21 && $computerPoints < $playersPoints) {
            $this->message = ['success', 'You Won!'];
        } elseif ($playersPoints == $computerPoints) {
            $this->message = ['warning', 'You lost!'];
        } elseif ($playersPoints == 500) {
            $this->message = ['warning', 'You got over 21 and you lost the game!'];
        }

        return $this->message;
    }
}
