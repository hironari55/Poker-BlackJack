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



///作り方・・・・・・・・・・
/* ------------------------------------------------------
[1 10 2 3 5 1 7 5 10 1]
2つずつに分ける
$twoEach
[1 10][2 3][5 1][7 5][10 1]


アウトプットについて
ーーーー売上合計金額----

値段がキー、個数が値の配列への入れ替え作業

$perMoney = [
    値段 => 個数
]

$perMoney = []
foreach ($twoEach as $val)    金額は50,80,100,120,150,180,250,300
{
    if ($val[0] === 9) {
        $perMoney[50] =$val[1]
    } elseif (($val[0] === 1 || 11) {
        $perMoney[100] = $val[1]
    }
}



合計金額の計算作業
$total[];
foreach $key as $value
$total = array_merge($total, $key * $value)
array_sum$total

ーーーーもっとも売れた、もっとも売れなかったものーーーー
$sales = [
    商品番号 => 個数
]

個数が最大、最小のものをmax,minを使って探す
配列からキーを返す関数array_keysを使って商品番号を返す
------------------------------------------------------ */
function twoEach($argv): array
{
    //最初の要素を切り話した後、配列を２つずつに分割　　　下、マジックナンバー
    $twoEach = array_chunk(array_slice($argv, 1), 2);
    return $twoEach;
}

function perMoneyAndQuantity(array $twoEach): array
{
    $perMoney = [];
    foreach ($twoEach as $oneEach) {
        //商品番号
        $number = $oneEach[0];
        //個数
        $quantity = $oneEach[1];

        //金額がキー、個数が値の配列に格納
        if ($number === '9') {
            $perMoney['50'][] = $quantity;
        } elseif ($number === '5') {
            $perMoney['80'][] = $quantity;
        } elseif ($number === '1' || $number === '7') {
            $perMoney['100'][] = $quantity;
        } elseif ($number === '2' || $number === '6') {
            $perMoney['120'][] = $quantity;
        } elseif ($number === '3') {
            $perMoney['150'][] = $quantity;
        } elseif ($number === '8') {
            $perMoney['180'][] = $quantity;
        } elseif ($number === '4') {
            $perMoney['250'][] = $quantity;
        } elseif ($number === '10') {
            $perMoney['300'][] = $quantity;
        }
    }
    return $perMoney;
}

//税率を定義
const TAX = 1.1;
function totalMoney(array $perMoney): float
{
    //それぞれの合計金額を算出
    $perTotalMoney = 0;
    foreach ($perMoney as $number => $quantity) {
        $perTotalMoney += $number * array_sum($quantity);
    }

    $totalMoney = round(($perTotalMoney) * TAX, 0);
    return $totalMoney;
}

function itemNoAndQuantity(array $twoEach): array
{
    $itemNo = [];
    foreach ($twoEach as $oneEach) {
        //商品番号
        $number = $oneEach[0];
        //個数
        $quantity = $oneEach[1];

        $itemNo[$number] = $quantity;
    }
        return $itemNo;
}

function displaySalesTotal(float $totalMoney, array $itemNo)
{
//合計金額
    echo $totalMoney . PHP_EOL;

    //もっとも売れた、もっとも売れなかった商品の商品番号
    $bestSelling = array_keys($itemNo, max($itemNo));
    $fewSelling = array_keys($itemNo, min($itemNo));

    foreach ($bestSelling as $bestSell) {
            echo $bestSell . ' ';
    }
    echo PHP_EOL;

    foreach ($fewSelling as $fewSell) {
            echo $fewSell . ' ';
    }
    echo PHP_EOL;
}

//２個ずつに受け取った配列を入れ直す
$twoEach = twoEach($argv);

//金額毎に商品の個数を配列に格納する
$perMoney = perMoneyAndQuantity($twoEach);

//合計金額を計算
$totalMoney = totalMoney($perMoney);

//商品番号毎に商品の個数を配列に格納する
$itemNo = itemNoAndQuantity($twoEach);

//合計金額、もっとも売れた商品、売れなかった商品、以上３つのアウトプット
displaySalesTotal($totalMoney, $itemNo);

/* ◯実行コマンド例
docker-compose exec app php quiz2.php 1 10 2 3 5 1 7 5 10 1 */
