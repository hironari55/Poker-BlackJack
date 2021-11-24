<?php

namespace PokerQuiz\Tests;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib/oop_pokerQuiz1/FiveCardsHandJudge.php');
require_once(__DIR__ . '/../../lib/oop_pokerQuiz1/PokerCardsNotJoker.php');

use PokerQuiz\FiveCardsHandJudge;
use PokerQuiz\PokerCardsNotJoker;

class FiveCardsHandJudgeTest extends TestCase
{
    public function testStart()
    {
        $fiveCardsHandJudge = new FiveCardsHandJudge();
        $this->assertSame(
            'four card',
            $fiveCardsHandJudge->judge([
            new PokerCardsNotJoker('CA'),
            new PokerCardsNotJoker('DA'),
            new PokerCardsNotJoker('HA'),
            new PokerCardsNotJoker('SA'),
            new PokerCardsNotJoker('C2')])
        );

        $this->assertSame(
            'hull house',
            $fiveCardsHandJudge->judge([
            new PokerCardsNotJoker('CA'),
            new PokerCardsNotJoker('DA'),
            new PokerCardsNotJoker('HA'),
            new PokerCardsNotJoker('S2'),
            new PokerCardsNotJoker('C2')])
        );

        $this->assertSame(
            'straight',
            $fiveCardsHandJudge->judge([
            new PokerCardsNotJoker('CA'),
            new PokerCardsNotJoker('D2'),
            new PokerCardsNotJoker('H3'),
            new PokerCardsNotJoker('S4'),
            new PokerCardsNotJoker('C5')])
        );

        $this->assertSame(
            'straight',
            $fiveCardsHandJudge->judge([
            new PokerCardsNotJoker('C10'),
            new PokerCardsNotJoker('DJ'),
            new PokerCardsNotJoker('HQ'),
            new PokerCardsNotJoker('SK'),
            new PokerCardsNotJoker('CA')])
        );

        $this->assertSame(
            'three card',
            $fiveCardsHandJudge->judge([
            new PokerCardsNotJoker('CA'),
            new PokerCardsNotJoker('DA'),
            new PokerCardsNotJoker('HA'),
            new PokerCardsNotJoker('S3'),
            new PokerCardsNotJoker('C2')])
        );

        $this->assertSame(
            'two pair',
            $fiveCardsHandJudge->judge([
            new PokerCardsNotJoker('CA'),
            new PokerCardsNotJoker('DA'),
            new PokerCardsNotJoker('H3'),
            new PokerCardsNotJoker('S2'),
            new PokerCardsNotJoker('C2')])
        );

        $this->assertSame(
            'one pair',
            $fiveCardsHandJudge->judge([
            new PokerCardsNotJoker('CA'),
            new PokerCardsNotJoker('DA'),
            new PokerCardsNotJoker('H4'),
            new PokerCardsNotJoker('S3'),
            new PokerCardsNotJoker('C2')])
        );

        $this->assertSame(
            'high card',
            $fiveCardsHandJudge->judge([
            new PokerCardsNotJoker('C8'),
            new PokerCardsNotJoker('D6'),
            new PokerCardsNotJoker('H5'),
            new PokerCardsNotJoker('S3'),
            new PokerCardsNotJoker('C2')])
        );
    }
}
