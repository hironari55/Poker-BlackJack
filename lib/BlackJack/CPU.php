<?php

namespace BlackJack;

interface CPU
{
    public function getName();

    public function addCards(Deck $deck, $num);

    public function getTotalRank($ruleOfRank);
}
