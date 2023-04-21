<?php

namespace App\Card;

class Result
{
    /**
    * @var array<int, string> $message
    */
    public array $message = [];

    public function __construct()
    {
        $this->message = [];
    }

    /**
    * @param int $computerPoints
    * @param int $playersPoints
    * @return array<int, string> $this->message
    */
    public function checkresult(int $computerPoints, int $playersPoints): array
    {
        if ($computerPoints > 21) {
            $this->message = ['success', 'You Won!'];
        } else if ($computerPoints == 21) {
            $this->message = ['warning', 'You lost!'];
        } else if ($playersPoints == 21) {
            $this->message = ['success', 'You Won!'];
        } else if ($computerPoints > $playersPoints) {
            $this->message = ['warning', 'You lost!'];
        } else if ($playersPoints > 21) {
            $this->message = ['warning', 'You lost!'];
        } if ($playersPoints < 21 && $computerPoints < 21 && $playersPoints < $computerPoints) {
            $this->message = ['warning', 'You lost!'];
        } if ($playersPoints < 21 && $computerPoints < 21 && $computerPoints < $playersPoints) {
            $this->message = ['success', 'You Won!'];
        } else if ($playersPoints == $computerPoints) {
            $this->message = ['warning', 'You lost!'];
        } else if ($playersPoints == 500) {
            $this->message = ['warning', 'You got over 21 and you lost the game!'];
        }

        return $this->message;
    }
}