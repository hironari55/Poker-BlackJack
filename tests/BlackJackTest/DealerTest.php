<?php

namespace BlackJack\Tests;

use PHPUnit\Framework\TestCase;
use BlackJack\Dealer;
use BlackJack\Deck;
use BlackJack\Card;
use BlackJack\ElevenEqualACardRank;
use BlackJack\OneEqualACardRank;

require_once(__DIR__ . '/../../lib/BlackJack/Dealer.php');
require_once(__DIR__ . '/../../lib/BlackJack/Deck.php');
require_once(__DIR__ . '/../../lib/BlackJack/Card.php');
require_once(__DIR__ . '/../../lib/BlackJack/ElevenEqualACardRank.php');
require_once(__DIR__ . '/../../lib/BlackJack/OneEqualACardRank.php');

class DealerTest extends TestCase
{
    public function testAddCards()
    {
        $dealer = new Dealer('dealer');
        $deck = new Deck();
        $this->assertSame(2, count($dealer->addCards($deck, 2)));
    }

    public function testGetTotalDealerRank()
    {
        $dealer = new Dealer('dealer');
        $dealerCards = [new Card('クローバー', 'A'),new Card('スペード', '6')];
        $ruleOfRank = new ElevenEqualACardRank();
        $this->assertSame(17, $dealer->getTotalDealerRank($dealerCards, $ruleOfRank));

        $dealerCards = [new Card('クローバー', 'A'), new Card('スペード', '6'), new Card('クローバー', 'A')];
        $ruleOfRank = new OneEqualACardRank();
        $this->assertSame(18, $dealer->getTotalDealerRank($dealerCards, $ruleOfRank));
    }

    public function testDealerDrawCard()
    {
        $dealer = new Dealer('dealer');
        $deck = new Deck();
        $dealerCards = [new Card('クローバー', '5'), new Card('スペード', '6')];
        $this->assertSame(3, count($dealer->dealerDrawCard($dealerCards, $deck)));
    }
}
