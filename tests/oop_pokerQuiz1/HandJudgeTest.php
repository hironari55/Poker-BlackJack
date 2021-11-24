<?php

namespace PokerQuiz\Tests;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib/oop_pokerQuiz1/HandJudge.php');
require_once(__DIR__ . '/../../lib/oop_pokerQuiz1/PokerCardsNotJoker.php');

use PokerQuiz\HandJudge;
use PokerQuiz\TwoCardsHandJudge;
use PokerQuiz\PokerCardsNotJoker;

class HandJudgeTest extends TestCase
{
    public function testStart()
    {
        $handJudge = new HandJudge(new TwoCardsHandJudge());
        $cards = [new PokerCardsNotJoker('CA'), new PokerCardsNotJoker('CA')];
        $this->assertSame(
            ['hand' => 'pair',
            'handRank' => 2,
            'strongestCard' => 13,
            'secondStrongestCard' => 13,
            'thirdStrongestCard' => 0,],
            $handJudge->judge($cards)
        );
    }

    public function testGetWinner()
    {
        $this->assertSame(1, HandJudge::getWinner(
            [
                'hand' => 'straight',
                'handRank' => 3,
                'strongestCard' => 10,
                'secondStrongestCard' => 9,
                'thirdStrongestCard' => 0,
            ],
            [
                'hand' => 'straight',
                'handRank' => 3,
                'strongestCard' => 9,
                'secondStrongestCard' => 8,
                'thirdStrongestCard' => 0,
            ]
        ));

        $this->assertSame(2, HandJudge::getWinner(
            [
                'hand' => 'straight',
                'handRank' => 3,
                'strongestCard' => 1,
                'secondStrongestCard' => 13,
                'thirdStrongestCard' => 0,
            ],
            [
                'hand' => 'straight',
                'handRank' => 3,
                'strongestCard' => 13,
                'secondStrongestCard' => 12,
                'thirdStrongestCard' => 0,
            ]
        ));
    }
}
