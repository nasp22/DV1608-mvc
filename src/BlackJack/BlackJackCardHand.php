<?php

namespace App\BlackJack;

use App\BlackJack\BlackJackCard;
use App\BlackJack\BlackJackDeckOfCards;
use Symfony\Component\Validator\Constraints\Length;
use App\BlackJack\BlackJackDrawException;

/**
 * class for BlackJackCardHand
 */
class BlackJackCardHand extends BlackJackDeckOfCards
{
    /**
    * method to draw cards, returns array with cards
    */
    public function draw(int $number, array $deck): array
    {
        if ($number > Count($deck)) {
            throw new BlackJackDrawException("Kan inte dra fler kort än vad som är kvar i leken!");
        }

        $handArr=[];
        $amountCards=[];
        $count = $number;
        shuffle($deck);

        if ($number != 1) {
            for ($i = 0; $i < $number; $i++) {
                $amountCards[] = $deck[$count-1];
                $count -= 1;
            }

            foreach ($amountCards as $card) {
                $newCard = new BlackJackCard();
                $newCard->specificCard([$card[0], $card[1]]);
                $handArr[]=$newCard;
            };

            return $handArr;
        }

        for ($i = 0; $i < $number; $i++) {
            $amountCards[] = $deck[0];
        };

        foreach ($amountCards as $card) {
            $newCard = new BlackJackCard();
            $newCard->specificCard([$card[0], $card[1]]);
            $handArr[]=$newCard;
        };

        return $handArr;
    }
    /**
     * method to get points of the hand, returns string
     */
    public function getPoints(): string
    {
        $points=0;
        foreach ($this->value as $card) {
            $points += $card->getPoints();
        }
        return strval($points);
    }

    /**
     * method to add a card, returns handobject
     */
    public function addCard(object $newCard, object $hand): object
    {
        $hand->value[] = $newCard;

        return $hand;
    }
    /**
     * method to check for ace, returns total point of the hand
     */
    public function checkforace(int $points): void
    {   /**
        * if ace of any color in hand, set points
        *
        */
        if (intval($points) > 21 && in_array("ace_of_spades", $this->getAsString())) {
            $index = array_search("ace_of_spades", array_values($this->getAsString()));
            $this->ace((int)$index);
        } if (intval($points) > 21 && in_array("ace_of_hearts", $this->getAsString())) {
            $index = array_search("ace_of_hearts", array_values($this->getAsString()));
            $this->ace((int)$index);
        } if (intval($points)> 21 && in_array("ace_of_diamonds", $this->getAsString())) {
            $index = array_search("ace_of_diamonds", array_values($this->getAsString()));
            $this->ace((int)$index);
        } if (intval($points) > 21 && in_array("ace_of_clubs", $this->getAsString())) {
            $index = array_search("ace_of_clubs", array_values($this->getAsString()));
            $this->ace((int)$index);
        };
    }
    /**
     * adds score if aces in hand
     */
    public function ace(int $index): void
    {
        $ace = $this->value[$index];
        $ace->points = 1;
    }
}
