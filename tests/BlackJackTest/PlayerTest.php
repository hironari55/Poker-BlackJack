<?php

namespace BlackJack\Tests;

use PHPUnit\Framework\TestCase;
use BlackJack\Player;
use BlackJack\Deck;
use BlackJack\Card;
use BlackJack\ElevenEqualACardRank;
use BlackJack\OneEqualACardRank;

require_once(__DIR__ . '/../../lib/BlackJack/Player.php');
require_once(__DIR__ . '/../../lib/BlackJack/Deck.php');
require_once(__DIR__ . '/../../lib/BlackJack/Card.php');
require_once(__DIR__ . '/../../lib/BlackJack/ElevenEqualACardRank.php');
require_once(__DIR__ . '/../../lib/BlackJack/OneEqualACardRank.php');

class PlayerTest extends TestCase
{
    public function testGetPlayerName()
    {
        $player = new Player('中山');
        $this->assertSame('中山', $player->getPlayerName());
    }

    public function testAddCards()
    {
        $player1 = new Player('player1');
        $deck = new Deck();
        $this->assertSame(2, count($player1->addCards($deck, 2)));
    }

    public function testGetTotalPlayerRank()
    {
        $player1 = new Player('player1');
        $player1Cards = [new Card('クローバー', 'A'), new Card('スペード', '6')];
        $ruleOfRank = new ElevenEqualACardRank();
        $this->assertSame(17, $player1->getTotalPlayerRank($player1Cards, $ruleOfRank));

        $player1Cards = [new Card('クローバー', 'A'), new Card('スペード', '6'), new Card('クローバー', 'A')];
        $ruleOfRank = new OneEqualACardRank();
        $this->assertSame(18, $player1->getTotalPlayerRank($player1Cards, $ruleOfRank));
    }

    public function testPlayerDrawCard()
    {
        $player1 = new Player('player1');
        $deck = new Deck();
        $player1Cards = [new Card('クローバー', '5'), new Card('スペード', '6')];
        $this->assertSame(3, count($player1->playerDrawCard($player1Cards, $deck)));
    }
}
