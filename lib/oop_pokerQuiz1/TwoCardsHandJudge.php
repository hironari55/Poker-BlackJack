<?php

namespace PokerQuiz;

require_once('PokerRule.php');

class TwoCardsHandJudge implements PokerRule
{
    private const CARD_HAND_RANK = [
        'high card' => 1,
        'pair' => 2,
        'straight' => 3,
    ];
    private const HIGH_CARD = 'high card';
    private const PAIR = 'pair';
    private const STRAIGHT = 'straight';

    public function judge(array $playerCards)
    {
        $rank = array_map(fn($playerCard) => $playerCard->getRank(), $playerCards);

        $hand = self::HIGH_CARD;
        $strongestCard = max($rank);
        $secondStrongestCard = min($rank);
        if ($this->isPair($rank)) {
            $hand = self::PAIR;
        }
        if ($this->isStraight($rank)) {
            $hand = self::STRAIGHT;
            if ($this->isMinMax($rank)) {
                $strongestCard = min($rank);
                $secondStrongestCard = max($rank);
            }
        }

        return [
            'hand' => $hand,
            'handRank' => self::CARD_HAND_RANK[$hand],
            'strongestCard' => $strongestCard,
            'secondStrongestCard' => $secondStrongestCard,
            'thirdStrongestCard' => 0,
        ];
    }

    private function isPair($rank): bool
    {
        if ($rank[0] === $rank[1]) {
            return true;
        } else {
            return false;
        }
    }

    private function isStraight($rank): bool
    {
        if (abs($rank[0] - $rank[1]) === 1 || $this->isMinMax($rank)) {
            return true;
        } else {
            return false;
        }
    }

    private function isMinMax($rank): bool
    {
        if (abs($rank[0] - $rank[1]) === max(PokerCardsNotJoker::CARD_RANK) - min(PokerCardsNotJoker::CARD_RANK)) {
            return true;
        } else {
            return false;
        }
    }
}
