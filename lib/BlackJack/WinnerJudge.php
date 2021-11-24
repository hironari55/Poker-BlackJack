<?php

namespace BlackJack;

class WinnerJudge
{
    public function __construct(private array $allPlayers)
    {
    }

    public function winnerJudge()
    {
        foreach ($this->allPlayers as $eachPlayer) {
            if ($eachPlayer->totalRank > 21) {
                $moreThan21 []= $eachPlayer->totalRank;
            } elseif ($eachPlayer->totalRank <= 21) {
                $lessThan21 []= $eachPlayer->totalRank;
            }
        }
        $strongCardsRank = max($lessThan21);

        foreach ($this->allPlayers as $eachPlayer) {
            if ($eachPlayer->totalRank === $strongCardsRank) {
                $winners[] = $eachPlayer->getName();
            }
        }

        return $winners;
    }
}

//   それぞれのランクの中から
