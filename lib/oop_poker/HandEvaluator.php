<?php

namespace OopPoker;

class HandEvaluator
{
    public function __construct(private $rule)
    {
    }

    public function getHand(array $card): string
    {
        return $this->rule->getHand($card);
    }

    public static function getWinner(string $hand1, string $hand2): int
    {
        return 2;
    }
}
