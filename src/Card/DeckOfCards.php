<?php

namespace App\Card;

use App\Card\Card;

class DeckOfCards
{
    public array $value;

    public function __construct()
    {
        $this->value = [];
        $colors = ["_of_spades", "_of_hearts", "_of_diamonds", "_of_clubs"];
        $numbers = ["2", "3", "4", "5", "6", "7", "8", "9", "10", "jack", "queen", "king", "ace"];

        foreach($colors as $color) {
            foreach($numbers as $number) {
                $card = new Card();
                $card ->specificCard([$number, $color]);
                $this->value[] = $card;
            }
        }
    }

    public function shuffle(): array
    {
        $values = [];
        foreach ($this->value as $card) {
            $values[] = $card->getAsString();
        }
        shuffle($values);
        return $values;
    }

    public function getValue(): array
    {
        $values=[];
        foreach ($this->value as $card) {
            $values[] = $card->getValue();
        }
        return $values;
    }

    public function getAsString(): array
    {
        $values = [];
        foreach ($this->value as $card) {
            $values[] = $card->getAsString();
        }
        return $values;
    }

    public function setValue(array $cards): void
    {
        $values = [];
        foreach ($cards as $card) {
            $values[] = $card;
        }
        $this->value = $values;
    }

    public function remove(array $cards): array
    {
        $handArr=[];
        $thisArr=[];

        foreach ($cards as $card) {
            $card = $card->getValue();
            $handArr[]=$card;
        };

        foreach ($this->value as $card) {
            $card = $card->getValue();
            $thisArr[]=$card;
        };

        foreach ($handArr as $remove) {
            $key = array_search($remove, $thisArr);
            unset($thisArr[$key]);
        };

        $arr_with_cards=[];

        foreach ($thisArr as $card) {
            $cardObject = new Card();
            $cardObject->specificCard([$card[0], $card[1]]);
            $arr_with_cards[]=$cardObject;
        }

        $this->value = $arr_with_cards;
        return $this->value;
    }
}
