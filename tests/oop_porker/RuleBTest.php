<?php

namespace OopPoker\Tests;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib/oop_poker/RuleB.php');

use OopPoker\RuleB;
use OopPoker\Card;

final class RuleBTest extends TestCase
{
    public function testGetHand()
    {
        $rule = new RuleB();
        $cards = [new Card('C', 1), new Card('S', 1)];
        $this->assertSame('high card', $rule->getHand($cards));
    }
}
