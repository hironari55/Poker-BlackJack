<?php

namespace OopPoker\Tests;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib/oop_poker/Game.php');

use OopPoker\Game;

class GameTest extends TestCase
{
    public function testStart()
    {
        $game = new Game('田中', '中村', 2, 'A');
        $result = $game->start();
        $this->assertSame(2, $result);
    }
}
