<?php

namespace PokerQuiz\Tests;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib/oop_pokerQuiz1/TwoCardsHandJudge.php');
require_once(__DIR__ . '/../../lib/oop_pokerQuiz1/PokerCardsNotJoker.php');

use PokerQuiz\TwoCardsHandJudge;
use PokerQuiz\PokerCardsNotJoker;

class TwoCardsHandJudgeTest extends TestCase
{
    public function testStart()
    {
        $ruleA = new TwoCardsHandJudge();
        $this->assertSame(
            ['hand' => 'pair',
            'handRank' => 2,
            'strongestCard' => 13,
            'secondStrongestCard' => 13,
            'thirdStrongestCard' => 0,],
            $ruleA->judge([new PokerCardsNotJoker('CA'), new PokerCardsNotJoker('SA')])
        );

        $this->assertSame(
            ['hand' => 'high card',
            'handRank' => 1,
            'strongestCard' => 3,
            'secondStrongestCard' => 1,
            'thirdStrongestCard' => 0,],
            $ruleA->judge([new PokerCardsNotJoker('C2'), new PokerCardsNotJoker('S4')])
        );

        $this->assertSame(
            ['hand' => 'straight',
            'handRank' => 3,
            'strongestCard' => 1,
            'secondStrongestCard' => 13,
            'thirdStrongestCard' => 0,],
            $ruleA->judge([new PokerCardsNotJoker('CA'), new PokerCardsNotJoker('S2')])
        );
    }
}
