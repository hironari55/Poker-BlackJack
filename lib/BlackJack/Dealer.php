<?php

namespace BlackJack;

require_once('CPU.php');

class Dealer implements CPU
{
    private const NUMBER_WHERE_A_CHANGE_TO_1 = 11;
    private array $CPURanks;
    public array $CPUCards = [];
    public int $totalRank = 0;

    public function __construct(private string $name)
    {
    }

    public function getName()
    {
        return $this->name;
    }

    public function addCards(Deck $deck, $num): array
    {
        $this->CPUCards = array_merge($this->CPUCards, $deck->addCards($num));
        return $this->CPUCards;
    }

    public function getTotalRank($ruleOfRank): int
    {
        $this->CPURanks[] = $this->CPUCards[array_key_last($this->CPUCards)]->getRank($ruleOfRank);
        $this->totalRank = array_sum($this->CPURanks);
        return $this->totalRank;
    }

    public function getRuleOfCPURank($totalCPURank)
    {
        if ($totalCPURank >= self::NUMBER_WHERE_A_CHANGE_TO_1) {
            return new OneEqualACardRank();
        } else {
            return new ElevenEqualACardRank();
        }
    }
}
