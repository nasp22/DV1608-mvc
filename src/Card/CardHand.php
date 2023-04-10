<?php

namespace App\Card;

use App\Card\Card;
use App\Card\DeckOfCards;

class CardHand extends DeckOfCards
{
    public function draw($number, $deck)
    {
        if ($number > Count($deck)) {
            throw new \Exception("Kan inte dra fler kort än vad som är kvar i leken!");
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

}
