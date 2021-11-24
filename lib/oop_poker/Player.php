<?php

namespace OopPoker;

class Player
{
    public function __construct(private string $name)
    {
    }

    public function drawCards(Deck $deck, int $num)
    {
        return $deck->drawCards($num);
    }
}
