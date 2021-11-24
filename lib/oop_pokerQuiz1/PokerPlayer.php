<?php

/* namespace PokerQuiz;

class PokerPlayer
{
    public function __construct(private array $playerCards)
    {
    }

    public function getRank()
    {
        return array_map(fn($playerCard) => $playerCard->getRank() ,$this->playerCards);
    }
        /* $PlayerCards = array_map(fn($PlayerCard) => new PokerCardRanks($PlayerCard) ,$this->playerCards);
        return array_map(fn ($PlayerCard) => $PlayerCard->getRank(), $this->PlayerCards); */
