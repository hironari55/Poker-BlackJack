<?php

namespace BlackJack;

require_once('CardRank.php');

class Card
{
    public const CARD_RANK = [
        '2' => 2,
        '3' => 3,
        '4' => 4,
        '5' => 5,
        '6' => 6,
        '7' => 7,
        '8' => 8,
        '9' => 9,
        '10' => 10,
        'J' => 10,
        'Q' => 10,
        'K' => 10,
        'A' => 1,
    ];

    public function __construct(private string $suit, private string $num)
    {
    }

    public function getSuit(): string
    {
        return $this->suit;
    }

    public function getNum(): string
    {
        return $this->num;
    }

    public function getRank($ruleOfRank): int
    {
        return $ruleOfRank->getRank($this->num);
    }
}
