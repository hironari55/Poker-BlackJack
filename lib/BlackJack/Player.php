<?php

namespace BlackJack;

class Player
{
    private const NUMBER_WHERE_A_CHANGE_TO_1 = 11;
    private array $PlayerRank;
    public array $PlayerCards = [];
    public int $totalRank = 0;

    public function __construct(private string $name)
    {
    }

    public function getName()
    {
        return $this->name;
    }

    public function addCards(Deck $deck, $num)
    {
        $this->PlayerCards = array_merge($this->PlayerCards,$deck->addCards($num));
        return $this->PlayerCards;
    }

    public function getTotalPlayerRank($player1Cards, $ruleOfRank): int
    {
        $this->PlayerRank[] = $player1Cards[array_key_last($player1Cards)]->getRank($ruleOfRank);
        $this->totalRank = array_sum($this->PlayerRank);
        return $this->totalRank;
    }

    public function getRuleOfPlayerRank($totalPlayerRank)
    {
        if ($totalPlayerRank >= self::NUMBER_WHERE_A_CHANGE_TO_1) {
            return new OneEqualACardRank();
        } else {
            return new ElevenEqualACardRank();
        }
    }
}
