<?php

namespace OopPoker;

require_once('Card.php');

class Deck
{
    private array $cards;
    public function __construct()
    {
        foreach (['C','H','S','D'] as $suit) {
            foreach (range(1, 13) as $num) {
                $this->cards[] = new Card($suit, $num);
            }
        }
    }

    public function drawCards(int $num)
    {
        return array_slice($this->cards, 0, $num);
    }
}
