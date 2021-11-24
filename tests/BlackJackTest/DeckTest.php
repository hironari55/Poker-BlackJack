<?php

namespace BlackJack\Tests;

use PHPUnit\Framework\TestCase;
use BlackJack\Deck;

require_once(__DIR__ . '/../../lib/BlackJack/Deck.php');

class DeckTest extends TestCase
{
    public function testAddCards()
    {
        $deck = new Deck();
        $this->assertSame(2, count($deck->addCards(2)));
    }
}
