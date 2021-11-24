<?php

namespace PokerQuiz;

interface PokerRule
{
    public function judge(array $playerCards);
}
