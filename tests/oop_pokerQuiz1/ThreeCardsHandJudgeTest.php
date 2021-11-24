<?php

namespace PokerQuiz\Tests;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib/oop_pokerQuiz1/ThreeCardsHandJudge.php');
require_once(__DIR__ . '/../../lib/oop_pokerQuiz1/PokerCardsNotJoker.php');

use PokerQuiz\ThreeCardsHandJudge;
use PokerQuiz\PokerCardsNotJoker;

class ThreeCardsHandJudgeTest extends TestCase
{
    public function testStart()
    {
        $ruleB = new ThreeCardsHandJudge();
        $playCards = [new PokerCardsNotJoker('CA'), new PokerCardsNotJoker('SA'), new PokerCardsNotJoker('HA')];
        $this->assertSame(
            ['hand' => 'three card',
            'handRank' => 4,
            'strongestCard' => 13,
            'secondStrongestCard' => 13,
            'thirdStrongestCard' => 13,
            ],
            $ruleB->judge($playCards)
        );

        $playCards = [new PokerCardsNotJoker('CA'), new PokerCardsNotJoker('S2'), new PokerCardsNotJoker('H3')];
        $this->assertSame(
            ['hand' => 'straight',
            'handRank' => 3,
            'strongestCard' => 2,
            'secondStrongestCard' => 1,
            'thirdStrongestCard' => 13,
            ],
            $ruleB->judge($playCards)
        );
    }
}
