<?php

namespace OopPoker\Tests;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib/oop_poker/Deck.php');

use OopPoker\Deck;

class DeckTest extends TestCase
{
    public function testDrawCards()
    {
        $deck = new Deck();
        $cards = $deck->drawCards(2);  //２枚のカードを引いたこととする
        $this->assertSame(2, count($cards)); //配列が２個であることを確認
    }
}

// php tests/oop_poker/deckTest.php
