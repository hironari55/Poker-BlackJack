<?php

namespace OopPoker;

interface Rule
{
    public function getHand(array $card);
}
