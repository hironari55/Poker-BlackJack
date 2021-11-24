<?php

namespace VendingMachine;

require_once('Item.php');

class Cup extends Item
{
    private const NORMAL_DRINK_PRICE = [
        'ice cup coffee' => 100,
        'hot cup coffee' => 100,
    ];

    public function __construct(protected string $name)
    {
        parent::__construct($name);
    }

    public function getPrice()
    {
        return self::NORMAL_DRINK_PRICE[$this->name];
    }

    public function getUseCup()
    {
        return 1;
    }
}
