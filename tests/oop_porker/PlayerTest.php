<?php

namespace OopPoker\Tests;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib/oop_poker/Player.php');

use OopPoker\Deck;
use OopPoker\Player;

final class PlayerTest extends TestCase
{
    public function testDrawCard()
    {
        $deck = new Deck();
        $player = new Player('田中');
        $cards = $player->drawCards($deck, 2);
        $this->assertSame(2, count($cards));
    }
}
