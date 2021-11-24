<?php

namespace BlackJack\Tests;

use PHPUnit\Framework\TestCase;
use BlackJack\BlackJackGame;
use BlackJack\Deck;
use BlackJack\Player;
use BlackJack\Dealer;

require_once(__DIR__ . '/../../lib/BlackJack/BlackJackGame.php');

class BlackJackGameTest extends TestCase
{
    public function testStart()
    {
        $player = new Player('player1');
        $dealer = new Dealer('dealer');
        $blackJackGame = new BlackJackGame($player, $dealer);
        $deck = new Deck();

        //$this->assertSame(1, count($blackJackGame->start($deck)));
    }
}
