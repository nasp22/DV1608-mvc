<?php

namespace App\Card;

use App\Card\Card;
/**
 * class for DeckofCards
 */
class DeckOfCards
{
    /**
    * @var array<int, Card> $value
    */
    /**
     * array to hold value
     */
    public array $value;
    /**
     * construct method
     */
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
    /**
    * @return array<int, string> $values
    */
    /**
     * method to shuffle the deck, returns array with cards (values)
     */
    public function shuffle(): array
    {
        $values = [];
        foreach ($this->value as $card) {
            $values[] = $card->getAsString();
        }
        shuffle($values);
        return $values;
    }

    /**
    * @return array<int, array<int, string>> $values
    */
    /**
     * method to get value of deck, returns array with cards (values)
     */
    public function getValue(): array
    {
        $values=[];
        foreach ($this->value as $card) {
            $values[] = $card->getValue();
        }
        return $values;
    }
    /**
    * @return array<int, string> $values
    */
    /**
     * method to get value of deck in string, returns array with string
     */
    public function getAsString(): array
    {
        $values = [];
        foreach ($this->value as $card) {
            $values[] = $card->getAsString();
        }
        return $values;
    }
    /**
    * @param array<int, Card> $cards
    */
    /**
     * method to set specific value of deck
     */
    public function setValue(array $cards): void
    {
        $values = [];
        foreach ($cards as $card) {
            $values[] = $card;
        }
        $this->value = $values;
    }
    /**
    * @param array<int, Card> $cards
    * @return array<int, Card> $values
    */
    /**
     * method to remove specific card/cards from deck
     */
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

        $arrWithCards=[];

        foreach ($thisArr as $card) {
            $cardObject = new Card();
            $cardObject->specificCard([$card[0], $card[1]]);
            $arrWithCards[]=$cardObject;
        }

        $this->value = $arrWithCards;
        return $this->value;
    }
}
