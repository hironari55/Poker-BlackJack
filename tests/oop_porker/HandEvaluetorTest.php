<?php

namespace OopPoker\Tests;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib/oop_poker/HandEvaluator.php');
require_once(__DIR__ . '/../../lib/oop_poker/RuleA.php');
require_once(__DIR__ . '/../../lib/oop_poker/Card.php');

use OopPoker\HandEvaluator;
use OopPoker\RuleA;
use OopPoker\Card;

final class HandEvaluatorTest extends TestCase
{
    public function testGetHand()
    {
        $rule = new RuleA();
        $handEvaluator = new HandEvaluator($rule);
        $this->assertSame('pair', $handEvaluator->getHand([new Card('C', 1), new Card('S', 1)]));
    }
}
