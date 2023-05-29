<?php

namespace App\BlackJack;

use App\BlackJack\BlackJackCard;

/**
 * class for DeckofCards
 */
class BlackJackDeckOfCards
{
    /**
    * array to hold value
    * @var array<int, BlackJackCard> $value
    */
    public array $value;
    /**
     * construct method
     */

    /**
    * Boolean to show if stay or not $stay
    */
    public bool $stay;

    /**
    * Boolean to show if fat or not $fat
    */
    public bool $fat;


    /**
     * construct method
     */
    public function __construct()
    {
        $this->value = [];
        $this->stay = false;
        $this->fat = false;
        $colors = ["_of_spades", "_of_hearts", "_of_diamonds", "_of_clubs"];
        $numbers = ["2", "3", "4", "5", "6", "7", "8", "9", "10", "jack", "queen", "king", "ace"];
        // $colors = ["_of_spades", "_of_hearts", "_of_diamonds", "_of_clubs"];
        // $numbers = ["2","8"];

        foreach ($colors as $color) {
            foreach ($numbers as $number) {
                $card = new BlackJackCard();
                $card ->specificCard([$number, $color]);
                $this->value[] = $card;
            }
        }
    }
    /**
    * method to shuffle the deck, returns array with cards (values)
    * @return array<int, string> $values
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
    * method to get value of deck, returns array with cards (values)
    * @return array<int, array<int, string>> $values
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
    * method to get value of deck in string, returns array with string
    * @return array<int, string> $values
    */
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

        $arrWithCards=[];

        foreach ($thisArr as $card) {
            $cardObject = new BlackJackCard();
            $cardObject->specificCard([$card[0], $card[1]]);
            $arrWithCards[]=$cardObject;
        }

        $this->value = $arrWithCards;
        return $this->value;
    }
}
