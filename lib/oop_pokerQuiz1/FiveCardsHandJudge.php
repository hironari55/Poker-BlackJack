<?php

namespace PokerQuiz;

require_once('PokerRule.php');

class FiveCardsHandJudge implements PokerRule
{
    private const HIGH_CARD = 'high card';
    private const ONE_PAIR = 'one pair';
    private const TWO_PAIR = 'two pair';
    private const THREE_CARD = 'three card';
    private const STRAIGHT = 'straight';
    private const FULL_HOUSE = 'hull house';
    private const FOUR_CARD = 'four card';

    public function judge(array $playerCards)
    {
        $rank = array_map(fn($playerCard) => $playerCard->getRank(), $playerCards);
        sort($rank);

        $hand = self::HIGH_CARD;
        if ($this->isFourCard($rank)) {
            $hand = self::FOUR_CARD;
        } elseif ($this->isHullHouse($rank)) {
            $hand = self::FULL_HOUSE;
        } elseif ($this->isStraight($rank)) {
            $hand = self::STRAIGHT;
        } elseif ($this->isThreeCard($rank)) {
            $hand = self::THREE_CARD;
        } elseif ($this->isTwoPair($rank)) {
            $hand = self::TWO_PAIR;
        } elseif ($this->isOnePair($rank)) {
            $hand = self::ONE_PAIR;
        }
        return $hand;
    }

    private function isFourCard(array $rank): bool
    {
        return count(array_unique(array_slice($rank, 0, 4))) === 1
        || count(array_unique(array_slice($rank, 1, 4))) === 1;
    }

    private function isHullHouse(array $rank): bool
    {
        return (count(array_unique(array_slice($rank, 0, 2))) === 1
            && count(array_unique(array_slice($rank, 2, 3))) === 1)
        || (count(array_unique(array_slice($rank, 0, 3))) === 1
            && count(array_unique(array_slice($rank, 3, 2))) === 1);
    }

    private function isStraight(array $rank): bool
    {
        //$rank = [1,2,3,4,5]の場合、
        return range($rank[0], $rank[0] + count($rank) - 1) === $rank
        || $this->isFirstStraight($rank);
    }
    private function isFirstStraight(array $rank): bool
    {
        //5-4-3-2-A  //[1,2,3,4,13]
        return [min($rank),min($rank) + 1, min($rank) + 2, min($rank) + 3, max($rank)] === $rank;
    }

    private function isThreeCard(array $rank): bool
    {
        return count(array_unique(array_slice($rank, 0, 3))) === 1
            || count(array_unique(array_slice($rank, 1, 3))) === 1
            || count(array_unique(array_slice($rank, 2, 3))) === 1;
    }

    private function isTwoPair(array $rank): bool
    {
        return (count(array_unique(array_slice($rank, 0, 2))) === 1
                && count(array_unique(array_slice($rank, 2, 2))) === 1)
            || (count(array_unique(array_slice($rank, 0, 2))) === 1
                && count(array_unique(array_slice($rank, 3, 2))) === 1)
            || (count(array_unique(array_slice($rank, 1, 2))) === 1
                && count(array_unique(array_slice($rank, 3, 2))) === 1);
    }

    private function isOnePair(array $rank): bool
    {
        return count(array_unique($rank)) === 4;
    }

    //それぞれarray_uniqueを適応させた時の要素数は,
    //highCard 5
    //onePair 4
    //twoPair 3
    //ThreeCard 3
    //Straight 5
    //HullHouse 2
    //FourCard 2
}
