<?php

namespace App\Card;

class Card
{
    protected $value;

    public function __construct()
    {
        $this->value = null;
    }
    public function specificCard($cardArray)
    {
        $this->value = $cardArray;
    }
    public function getValue(): array
    {
        return $this->value;
    }

    public function getAsString(): string
    {
        return implode("", $this->value);
    }
}
