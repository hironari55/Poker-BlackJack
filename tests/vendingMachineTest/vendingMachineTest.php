<?php

use PHPUnit\Framework\TestCase;
use VendingMachine\VendingMachine;
use VendingMachine\Snack;
use VendingMachine\NormalDrink;
use VendingMachine\Cup;

require_once(__DIR__ . '/../../lib/oop_vendingMachine/vendingMachine.php');
require_once(__DIR__ . '/../../lib/oop_vendingMachine/normalDrink.php');
require_once(__DIR__ . '/../../lib/oop_vendingMachine/Cup.php');

class VendingMachineTest extends TestCase
{
    public function testDepositCoin()
    {
        $vendingMachine = new VendingMachine();
        $this->assertSame(0, $vendingMachine->depositCoin(200));
        $this->assertSame(0, $vendingMachine->depositCoin(150));
        $this->assertSame(100, $vendingMachine->depositCoin(100));
        $this->assertSame(200, $vendingMachine->depositCoin(100));
    }

    public function testPressButton()
    {
        $cider = new NormalDrink('cider');
        $coke = new NormalDrink('coke');
        $hotCupCoffee = new Cup('hot cup coffee');
        $potatoChips = new Snack('potato chips');
        $vendingMachine = new VendingMachine();

        //お金を入れてない場合
        $this->assertSame('', $vendingMachine->pressButton($cider));
        $this->assertSame('', $vendingMachine->pressButton($coke));

        //１００円入れた場合
        $vendingMachine->depositCoin(100);
        $this->assertSame('', $vendingMachine->pressButton($cider));
        $vendingMachine->depositItem($cider, 1);
        $this->assertSame('cider', $vendingMachine->pressButton($cider));

        //200円入れた場合
        $vendingMachine->depositCoin(100);
        $vendingMachine->depositCoin(100);
        $this->assertSame('', $vendingMachine->pressButton($coke));
        $vendingMachine->depositItem($coke, 1);
        $this->assertSame('coke', $vendingMachine->pressButton($coke));

        //100円入れてカップを入れてない場合、
        $vendingMachine->depositCoin(100);
        $this->assertSame('', $vendingMachine->pressButton($hotCupCoffee));

        // カップを入れた場合は購入できる
        $vendingMachine->addCup(1);
        $this->assertSame('', $vendingMachine->pressButton($hotCupCoffee));
        $vendingMachine->depositItem($hotCupCoffee, 1);
        $this->assertSame('hot cup coffee', $vendingMachine->pressButton($hotCupCoffee));

        //スナックを購入する場合　　残高５０円
        $this->assertSame('', $vendingMachine->pressButton($potatoChips));

        //残高150円
        $vendingMachine->depositCoin(100);
        $this->assertSame('', $vendingMachine->pressButton($potatoChips));
        $vendingMachine->depositItem($potatoChips, 1);
        $this->assertSame('potato chips', $vendingMachine->pressButton($potatoChips));
    }

    public function testAddCup()
    {
        $vendingMachine = new VendingMachine();
        $this->assertSame(99, $vendingMachine->addCup(99));
        $this->assertSame(100, $vendingMachine->addCup(1));
        $this->assertSame(100, $vendingMachine->addCup(1));
    }

    public function testDepositItem()
    {
        $vendingMachine = new VendingMachine();
        $cider = new NormalDrink('cider');
        # サイダーの在庫の上限が50個の場合
        $this->assertSame(50, $vendingMachine->depositItem($cider, 50));
        $this->assertSame(50, $vendingMachine->depositItem($cider, 1));
    }

    public function testGiveBackDepositCoin()
    {
        $vendingMachine = new VendingMachine();
        $this->assertSame(0, $vendingMachine->giveBackDepositCoin());
        $vendingMachine->depositCoin(100);
        $this->assertSame(100, $vendingMachine->giveBackDepositCoin());
    }
}
