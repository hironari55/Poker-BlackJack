<?php

/* ◯お題
あなたは小さなパン屋を営んでいました。一日の終りに売上の集計作業を行います。
商品は10種類あり、それぞれ金額は以下の通りです（税抜）。

①100
②120
③150
④250
⑤80
⑥120
⑦100
⑧180
⑨50
⑩300

一日の売上の合計（税込み）と、販売個数の最も多い商品番号と販売個数の最も少ない商品番号を求めてください。

◯インプット
入力は以下の形式で与えられます。

販売した商品番号 販売個数 販売した商品番号 販売個数 ...

※ただし、販売した商品番号は1〜10の整数とする。

◯アウトプット

売上の合計
販売個数の最も多い商品番号
販売個数の最も少ない商品番号

※ただし、税率は10%とする。
※また、販売個数の最も多い商品と販売個数の最も少ない商品について、販売個数が同数の商品が存在する場合、それら全ての商品番号を記載すること。

◯インプット例

1 10 2 3 5 1 7 5 10 1

◯アウトプット例
2464
1
5 10
 */

//@param array<int, int> $argv

const SPLIT_LENGTH = 2;
const TAX = 1.1;
const BREAD = [
    1 => 100,
    2 => 120,
    3 => 150,
    4 => 250,
    5 => 80,
    6 => 120,
    7 => 100,
    8 => 180,
    9 => 50,
    10 => 300,
];

function getInput(array $argv): array
{
    //最初の値を一つ切り取って、値が2つずつの配列に分割
    $twoEach = array_chunk(array_slice($argv, 1), SPLIT_LENGTH);

    //商品番号がキー、個数が値の配列を作成
    $itemNoAndQuantity = [];
    foreach ($twoEach as $each) {
        $itemNoAndQuantity[$each[0]] = (int)$each[1];
    }
    //値が配列になっていない、array_key_existでarray_margeなど複雑な処理がないため、上の処理を一行で終わらせて良い
    return $itemNoAndQuantity;
}

function totalMoney(array $itemNoAndQuantity): int
{
    $totalMoney = 0;
    foreach ($itemNoAndQuantity as $number => $quantity) {
        (int)$totalMoney += (BREAD[$number] * (int)$quantity) * TAX;
    }
    return $totalMoney;
}

function QuantityMax($itemNoAndQuantity)
{
    $maxes = array_keys($itemNoAndQuantity, max($itemNoAndQuantity));
    return $maxes;
}

function QuantityMin($itemNoAndQuantity)
{
    $mins = array_keys($itemNoAndQuantity, min($itemNoAndQuantity));
    return $mins;
}

function displaySales($itemNoAndQuantity)
{
    $totalMoney = totalMoney($itemNoAndQuantity);
    $maxes = QuantityMax($itemNoAndQuantity);
    $mins = QuantityMin($itemNoAndQuantity);

    echo $totalMoney . PHP_EOL;

    foreach ($maxes as $max) {
        echo $max . ' ';
    }
    echo PHP_EOL;
    foreach ($mins as $min) {
        echo $min . ' ';
    }
    echo PHP_EOL;
}

//入力された値を入手、変換
$itemNoAndQuantity = getInput($argv);

//合計金額の計算
totalMoney($itemNoAndQuantity);

//個数の最大値を対する商品番号を算出
QuantityMax($itemNoAndQuantity);

//個数の最小値に対する商品番号を算出
QuantityMin($itemNoAndQuantity);

//アウトプット用の関数
displaySales($itemNoAndQuantity);

//docker-compose exec app php bread.php 1 10 2 3 5 1 7 5 10 1
