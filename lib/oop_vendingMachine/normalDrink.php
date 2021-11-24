<?php

namespace VendingMachine;

require_once('Item.php');

class NormalDrink extends Item
{
    private const NORMAL_DRINK_PRICE = [
        'cider' => 100,
        'coke' => 150,
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
        return 0;
    }
}
