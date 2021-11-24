<?php

use PHPUnit\Framework\TestCase;

final class MathTest extends TestCase
{
    public function testDouble()
    {
        require_once(__DIR__ . '/../../lib/practice/Math.php');
        $this->assertSame([4, 8, 12], double(2, 4, 6));
    }
}
