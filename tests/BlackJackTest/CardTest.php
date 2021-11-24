<?php

namespace BlackJack\Tests;

use PHPUnit\Framework\TestCase;
use BlackJack\Card;
use BlackJack\ElevenEqualACardRank;
use BlackJack\OneEqualACardRank;

require_once(__DIR__ . '/../../lib/BlackJack/Card.php');
require_once(__DIR__ . '/../../lib/BlackJack/ElevenEqualACardRank.php');
require_once(__DIR__ . '/../../lib/BlackJack/OneEqualACardRank.php');

class CardTest extends TestCase
{
    public function testGetSuit()
    {
        $card = new Card('クラブ', 5);
        $this->assertSame('クラブ', $card->getSuit());
    }

    public function testGetNum()
    {
        $card = new Card('C', 5);
        $this->assertSame('5', $card->getNum());
    }

    public function testGetRank()
    {
        $ruleOfRank = new ElevenEqualACardRank();
        $card = new Card('スペード', 'A');
        $this->assertSame(11, $card->getRank($ruleOfRank));

        $ruleOfRank = new OneEqualACardRank();
        $card = new Card('クローバー', 'A');
        $this->assertSame(1, $card->getRank($ruleOfRank));
    }
}
