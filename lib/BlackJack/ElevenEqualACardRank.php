<?php

namespace BlackJack;

require_once('CardRank.php');

class ElevenEqualACardRank implements CardRank
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
        'A' => 11,
    ];

    public function getRank($num)
    {
        return self::CARD_RANK[$num];
    }
}
