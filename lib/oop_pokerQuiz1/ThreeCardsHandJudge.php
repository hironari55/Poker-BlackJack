<?php

namespace PokerQuiz;

require_once('PokerRule.php');

class ThreeCardsHandJudge implements PokerRule
{
    private const CARD_HAND_RANK = [
        'high card' => 1,
        'pair' => 2,
        'straight' => 3,
        'three card' => 4,
    ];

    private const HIGH_CARD = 'high card';
    private const PAIR = 'pair';
    private const STRAIGHT = 'straight';
    private const THREE_CARD = 'three card';

    public function judge(array $playerCards)
    {
        $rank = array_map(fn ($playerCard) => $playerCard->getRank(), $playerCards);
        sort($rank);

        $hand = self::HIGH_CARD;
        $strongestCard = $rank[2];
        $secondStrongCard = $rank[1];
        $thirdStrongestCard = $rank[0];

        if ($this->isPair($rank)) {
            $hand = self::PAIR;
        }
        if ($this->isStraight($rank)) {
            $hand = self::STRAIGHT;
            if (abs($rank[0] - $rank[1]) === 1 && $this->isMinMax($rank)) {   //2,3,A-> 1,2,13
                $strongestCard = $rank[1];
                $secondStrongCard = $rank[0];
                $thirdStrongestCard = $rank[2];
            }
        }
        if ($this->isThreeCard($rank)) {
            $hand = self::THREE_CARD;
        }

        return[
            'hand' => $hand,
            'handRank' => self::CARD_HAND_RANK[$hand],
            'strongestCard' => $strongestCard,
            'secondStrongestCard' => $secondStrongCard,
            'thirdStrongestCard' => $thirdStrongestCard,
        ];
    }

    private function isThreeCard($rank): bool
    {
        return $rank[0] === $rank[1] && $rank[1] === $rank[2];
    }

    private function isPair($rank): bool
    {
        if ($this->isThreeCard($rank)) {
            return false;
        } elseif ($rank[0] === $rank[1] || $rank[1] === $rank[2] || $rank[0] === $rank[2]) {
            return true;
        } else {
            return false;
        }
    }

    private function isStraight($rank): bool
    {
        return (abs($rank[0] - $rank[1]) === 1 && abs($rank[1] - $rank[2]) === 1)
        || (abs($rank[0] - $rank[1]) === 1 && $this->isMinMax($rank));
    }

    private function isMinMax($rank): bool
    {
        return abs($rank[0] - $rank[2]) === 12;
    }
}
