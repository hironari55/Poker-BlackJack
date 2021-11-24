<?php

/* 【クイズ】スーパーの支払金額

◯お題
スーパーで買い物したときの支払金額を計算するプログラムを書きましょう。
以下の商品リストがあります。先頭の数字は商品番号です。金額は税抜です。

玉ねぎ 100円
人参 150円
りんご 200円
ぶどう 350円
牛乳 180円
卵 220円
唐揚げ弁当 440円
のり弁 380円
お茶 80円
コーヒー 100円
また、以下の条件を満たすと割引されます。

a. 玉ねぎは3つ買うと50円引き
b. 玉ねぎは5つ買うと100円引き
c. 弁当と飲み物を一緒に買うと20円引き（ただし適用は一組ずつ）
d. お弁当は20〜23時はタイムセールで半額

合計金額（税込み）を求めてください。

◯仕様
金額を計算するcalc関数を定義してください。
calcメソッドは「購入時刻 商品番号 商品番号 商品番号 ...」を引数に取り、合計金額（税込み）を返します。
購入時刻はHH:MM形式（例. 20:00）とし、商品番号は1〜10の整数とします。
同時に買える商品は20個までです。また、購入時刻は9〜23時です。

◯実行例
calc('21:00', [1, 1, 1, 3, 5, 7, 8, 9, 10])  //=> 1298 */

const TAX = 1.1;
const GOODS = [
    1 => 100,
    2 => 150,
    3 => 200,
    4 => 350,
    5 => 180,
    6 => 220,
    7 => 440,
    8 => 380,
    9 => 80,
    10 => 100,
];

function beforeDiscount($number)
{
    $beforeDiscount = 0;
    foreach ($number as $num) {
        //(金額*商品番号)
        $beforeDiscount += GOODS[$num];
    }
    return $beforeDiscount;
}

function discount($time, $number)
{
    //入力された値の個数を変数に格納
    $goodsQuantity = array_count_values($number);

    //割引価格の合計を算出
    $discount = 0;

    //玉ねぎ条件
    $more3onion = ($goodsQuantity[1]) >= 3 && ($goodsQuantity[1]) <= 4;
    $more5onion = ($goodsQuantity[1]) >= 5;
    //玉ねぎ
    if ($more3onion) {
        $discount += 50;
    } elseif ($more5onion) {
        $discount += 100;
    }

    //セット価格条件
    $lunch = $goodsQuantity[7] + $goodsQuantity[8];
    $drink = $goodsQuantity[5] + $goodsQuantity[9] + $goodsQuantity[10];
    //弁当と飲み物セット割引用のセット個数算出
    $discountQuantity = 0;
    if ($lunch < $drink) {
        $discountQuantity = $lunch;
    } elseif ($drink < $lunch) {
        $discountQuantity = $lunch;
    }
    //弁当、飲み物、セット割引
    if (!empty($discountQuantity)) {
        $discount += 20 * $discountQuantity;
    }

    //時間割引
    if ($time >= '20:00' && $time <= '23:00') {
        $discount += $goodsQuantity[7] * GOODS[7] * 0.5 + $goodsQuantity[8] * GOODS[8] * 0.5;
    }
    return $discount;
}


//実行関数ーーーーーーー
function calc($time, $number)
{
    //割引前の合計金額算出
    $beforeDiscount = beforeDiscount($number);

    //割引金額算出
    $discount = discount($time, $number);

    //割引後の合計金額算出
    $totalMoney = ($beforeDiscount - $discount) * TAX;
    echo $totalMoney . PHP_EOL;
}
