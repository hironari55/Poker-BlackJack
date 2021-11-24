<?php

namespace OopPoker;

require_once('Rule.php');

class RuleB implements Rule
{
    public function getHand(array $card): string
    {
        return 'high card';
    }
}
