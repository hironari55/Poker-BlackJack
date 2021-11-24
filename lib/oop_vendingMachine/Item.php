<?php

namespace VendingMachine;

abstract class Item
{
    public function __construct(protected string $name)
    {
    }

    public function getName()
    {
        return $this->name;
    }

    abstract public function getPrice();
    abstract public function getUseCup();
}
