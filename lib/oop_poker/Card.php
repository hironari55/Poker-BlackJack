<?php

namespace OopPoker;

class Card
{
    public function __construct(private string $suit, private int $num)
    {
    }

    public function getSuit()
    {
        return $this->suit;
    }

    public function getNumber()
    {
        return $this->num;
    }
}
