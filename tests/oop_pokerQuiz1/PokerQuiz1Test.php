<?php

namespace PokerQuiz\Tests;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib/oop_pokerQuiz1/PokerQuiz.php');

use PokerQuiz\PokerQuiz;

class PokerQuizTest extends TestCase
{
    public function testStart()
    {
        // カードが2枚の場合
        $game1 = new PokerQuiz(['CA', 'DA'], ['C9', 'H10'], 'TwoCards', 'notJoker');
        $this->assertSame(['pair', 'straight', 2], $game1->start());

        // カードが3枚の場合
        $game2 = new PokerQuiz(['C2', 'D2', 'S2'], ['CA', 'H2', 'D3'], 'ThreeCards', 'notJoker');
        $this->assertSame(['three card', 'straight' ,1], $game2->start());

        /* $game3 = new PokerQuiz(['CA', 'D2', 'S3', 'D4', 'S5'], ['C10', 'H10', 'S10', 'D10','SA'], 'FiveCards');
        $this->assertSame(['straight', 'four card'], $game3->start()); */
    }
}
