<?php

/* calcの関数
Calc($time, $number)
{
}


$time = $_server[argv[0]]
$number =$_server[argv[1]]

$time = 21:00
$number =[1,1,1,3,5,7,8,9,10]

$goods = [
1 > 玉ねぎ 100円
2 > 人参 150円
3 > りんご 200円
4 > ぶどう 350円
5 > 牛乳 180円
6 > 卵 220円
7 > 唐揚げ弁当 440円
8 > のり弁 380円
9 > お茶 80円
10 >コーヒー 100円
]

合計金額 foreach($number as $num) {
(金額*商品番号)
$beforeDiscount = 0;
$beforeDiscount +=$good[$num] * $num * TAX
}

商品番号*値段の足し算で合計金額、
↑から割引の場合は合計金額から引き算
割引金額

割引
a. 玉ねぎは3つ買うと50円引き 商品番号１*3
b. 玉ねぎは5つ買うと100円引き　商品番号１*5
c. 弁当と飲み物を一緒に買うと20円引き（ただし適用は一組ずつ）　商品番号 7||8 && 5||9||10
d. お弁当は20〜23時はタイムセールで半額 時間　20:00 - 22:59

//玉ねぎ

$more3onion = count($number === 1) >= 3 && count($number === 1) <= 4 ;
$more5onion=  count($number===1)>= 5
//セット価格
$lunch = count($number === 7) + count($number === 8);
$drink = count($number === 5) + count($number === 9) + count($number === 10);
$discountQuantity = 0;
//セットの個数算出
if ($lunch < $drink) {
    $discountQuantity=$lunch;
} elseif($drink < $lunch){
    $discountQuantity=$lunch;
}
//割引価格の合計を算出
$discount=0;
if ($more3onion) {
    $discount +=50;
}elseif($more5onion) {
    $discount +=100;
}

if(!empty($discountQuantity)){
    $discount +=20 * $discountQuantity;
}

if($time>= '20:00' && $time <= '23:00' ){
    $discount += $lunch * 0.5;
}

$totalMoney=0; $totalMoney=$beforeDiscount - $discount;
 */

require_once(__DIR__ . '/lib/superMarket.php');

calc('21:00', [1, 1, 1, 3, 5, 7, 8, 9, 10]);

// php shopping.php
