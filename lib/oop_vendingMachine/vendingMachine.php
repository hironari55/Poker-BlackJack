<?php

namespace VendingMachine;

/* 【クイズ】自動販売機を単一責任の原則で設計しよう

◯お題

自動販売機プログラムを単一責任の原則に基づいて設計しましょう。下記の仕様を追加します。

押したボタンに応じて、サイダーかコーラが出るようにしましょう。サイダーは100円、コーラは150円とします。100円以外のコインは入れられない仕様はそのままです
他の飲み物も追加しましょう
テスト駆動で開発しましょう。
今回は設計にトライしてもらいたいので、テスト例は省略します。 */

require_once('Item.php');
require_once('Cup.php');
require_once('normalDrink.php');
require_once('Snack.php');

class VendingMachine
{
    private $totalDepositCoin = 0;
    private $cupAmount = 0;
    private $totalDepositItem = [
        'cider' => 0,
        'coke' => 0,
        'hot cup coffee' => 0,
        'ice cup coffee' => 0,
        'potato chips' => 0,
    ];

    private const USE_STOCK = 1;
    private const STOCK_MAX = 50;

    public function depositCoin($money)
    {
        if ($money === 100) {
            $this->totalDepositCoin += 100;
        } else {
            $this->totalDepositCoin += 0;
        }
        return $this->totalDepositCoin;
    }

    public function depositItem(Item $item, $addNumber)
    {
        $afterAddDepositItem = ($this->totalDepositItem[$item->getName()] += $addNumber);
        if ((int)$afterAddDepositItem >= self::STOCK_MAX) {
            return self::STOCK_MAX;
        }
        return $afterAddDepositItem;
    }

    public function giveBackDepositCoin()
    {
        $giveBackCoin = $this->totalDepositCoin;
        $this->totalDepositCoin -= $giveBackCoin;
        return $giveBackCoin;
    }

    public function pressButton($item)
    {
        $price = $item->getPrice();

        if (
            $this->totalDepositCoin >= $price
            && $this->cupAmount >= $item->getUseCup()
            && $this->totalDepositItem[$item->getName()] >= self::USE_STOCK
        ) {
            $this->totalDepositCoin -= $price;
            $this->cupAmount -= $item->getUseCup();
            $this->totalDepositItem[$item->getName()] -= self::USE_STOCK;
            return $item->getName();
        } else {
            return '';
        }
    }

    public function addCup($number)
    {
        $afterAddCups = $this->cupAmount += $number;
        if ((int)$afterAddCups >= 100) {
            $afterAddCups = 100;
        }

        return $afterAddCups;
    }


    //カップの残り状況を書く必要があり、残りがない場合は買えない処理を書き足す必要がある
    //クラスの継承はジュース名はJuice.phpができるので、  PressButtonの処理に書き足したい
}
