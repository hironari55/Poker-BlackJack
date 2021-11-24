<?php

namespace OopPoker\Tests;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib/oop_poker/RuleA.php');

use OopPoker\RuleA;
use OopPoker\Card;

final class RuleATest extends TestCase
{
    public function testGetHand()
    {
        $rule = new RuleA();
        $cards = [new Card('C', 1), new Card('S', 1)];
        $this->assertSame('pair', $rule->getHand($cards));
    }
}
