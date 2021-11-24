<?php

namespace PokerQuiz;

require_once('PokerRule.php');

class HandJudge
{
    public function __construct(private PokerRule $rule)
    {
    }

    public function judge($playerCards)
    {
        return $this->rule->judge($playerCards);
    }

    public static function getWinner(array $player1Status, array $player2Status): int
    {
        foreach (['handRank', 'strongestCard', 'secondStrongestCard', 'thirdStrongestCard'] as $key) {
            if ($player1Status[$key] > $player2Status[$key]) {
                return 1;
            } elseif ($player1Status[$key] < $player2Status[$key]) {
                return 2;
            }
        }
        return 0;
    }
}
