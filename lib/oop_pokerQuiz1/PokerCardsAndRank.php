<?php

namespace PokerQuiz;

abstract class PokerCardsAndRank
{
    public function __construct(protected string $suitNumber)
    {
    }

    abstract public function getRank();
}
