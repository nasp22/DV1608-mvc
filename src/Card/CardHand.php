<?php

namespace App\Card;

use App\Card\Card;
use App\Card\DeckOfCards;
use Symfony\Component\Validator\Constraints\Length;

class CardHand extends DeckOfCards
{
    public function draw($number, $deck)
    {
        if ($number > Count($deck)) {
            throw new \Exception("Kan inte dra fler kort än vad som är kvar i leken!");
        }
        // var_dump($deck);
        $handArr=[];
        $amountCards=[];
        $count = $number;
        shuffle($deck);

        if ($number != 1) {
            for ($i = 0; $i < $number; $i++) {
                $amountCards[] = $deck[$count-1];
                $count -= 1;
            }
        } else {
            for ($i = 0; $i < $number; $i++) {
                $amountCards[] = $deck[0];
            };
        }

        foreach ($amountCards as $card) {
            $Newcard = new Card();
            $Newcard->specificCard([$card[0], $card[1]]);
            $handArr[]=$Newcard;
        };

        return $handArr;
    }
    public function getPoints(): string
    {
        $points=0;
        foreach ($this->value as $card) {
            $points += $card->getPoints();
        }
        return strval($points);
    }
    public function addCard($newCard, $hand)
    {
        $hand->value[] = $newCard;

        return $hand;

    }
}
