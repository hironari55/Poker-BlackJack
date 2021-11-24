<?php

/* ◯お題

2枚の手札でポーカーを行います。ルールは次の通りです。

・プレイヤーは2人です
・各プレイヤーはトランプ2枚を与えられます
・ジョーカーはありません
・与えられたカードから、役を判定します。役は番号が大きくなるほど強くなります

1.ハイカード：以下の役が一つも成立していない
2.ペア：2枚のカードが同じ数字
3.ストレート：2枚のカードが連続している。A は 2 と K の両方と連続しているとみなし、A を含むストレート は、A-2 と K-A の2つです
・2つの手札について、強さは以下に従います
4.2つの手札の役が異なる場合、より上位の役を持つ手札が強いものとする
5.2つの手札の役が同じ場合、各カードの数値によって強さを比較する
　 ・（弱）2, 3, 4, 5, 6, 7, 8, 9, 10, J, Q, K, A (強)
　 ・ハイカード：一番強い数字同士を比較する。左記が同じ数字の場合、もう一枚のカード同士を比較する
　 ・ペア：ペアの数字を比較する
　 ・ストレート：一番強い数字を比較する (ただし、A-2 の組み合わせの場合、2 を一番強い数字とする。K-A が最強、A-2 が最弱)
　 ・数値が同じ場合：引き分け
　
それぞれの役と勝敗を判定するプログラムを作成ください。
◯仕様

それぞれの役と勝敗を判定するshowDownメソッドを定義してください。
showDownメソッドは引数として、
プレイヤー1のカード、プレイヤー1のカード、プレイヤー2のカード、プレイヤー2のカードを取ります。
カードはH1〜H13（ハート）、S1〜S13（スペード）、D1〜D13（ダイヤ）、C1〜C13（クラブ）、となります。
ただし、Jは11、Qは12、Kは13、Aは1とします。
showDownメソッドは返り値として、プレイヤー1の役、プレイヤー2の役、勝利したプレイヤーの番号、を返します。引き分けの場合、プレイヤーの番号は0とします。


showDown('CK', 'DJ', 'C10', 'H10')  //=> ['high card', 'pair', 2]
showDown('CK', 'DJ', 'C3', 'H4')    //=> ['high card', 'straight', 2]
showDown('C3', 'H4', 'DK', 'SK')    //=> ['straight', 'pair', 1]
showDown('HJ', 'SK', 'DQ', 'D10')   //=> ['high card', 'high card', 1]
showDown('H9', 'SK', 'DK', 'D10')   //=> ['high card', 'high card', 2]
showDown('H3', 'S5', 'D5', 'D3')    //=> ['high card', 'high card', 0]
showDown('CA', 'DA', 'C2', 'D2')    //=> ['pair', 'pair', 1]
showDown('CK', 'DK', 'CA', 'DA')    //=> ['pair', 'pair', 2]
showDown('C4', 'D4', 'H4', 'S4')    //=> ['pair', 'pair', 0]
showDown('SA', 'DK', 'C2', 'CA')    //=> ['straight', 'straight', 1]
showDown('C2', 'CA', 'S2', 'D3')    //=> ['straight', 'straight', 2]
showDown('S2', 'D3', 'C2', 'H3')    //=> ['straight', 'straight', 0] */
const HIGH_CARD = 'high card';
const PAIR = 'pair';
const STRAIGHT = 'straight';

const CARD_LEVEL = [
    HIGH_CARD => 0,
    PAIR => 1,
    STRAIGHT => 2,
];

const CARDS = ['2','3','4','5','6','7','8','9','10','J','Q','K','A'];
define('CARD_RANK', (function () {
    $cardRanks = [];
    foreach (CARDS as $key => $value) {
        $cardRanks[$value] = $key;
    }
    return $cardRanks;
})());

function showdown(string $player11, string $player12, string $player21, string $player22)
{
//カードをランクに変更する
    $cards = [$player11, $player12, $player21, $player22];
    $cardRanks = array_map(fn ($card) => CARD_RANK[substr($card, 1, strlen($card) - 1)], $cards);

    //それぞれの手札ごとの配列に格納する
    $eachPlayerCardRanks = array_chunk($cardRanks, 2);

    //役を判定  ハイカード、ペア、ストレート、　　役の強さを定義　　　　役が違う場合は、役を比べて強さを判定  array_mapを使うことで配列ごとに関数を適応可能
    //役が同じ場合は　　強い方のカードを比べる　　強い方が同じ場合は弱い方のカードを比べる　　
    //⏫　　　役の強さ、強い方のカード、弱い方のカード、定義
    $hands = array_map(fn($eachPlayerCardRank) => judgment($eachPlayerCardRank), $eachPlayerCardRanks);

    //勝者を決める
    $winner = winner($hands);

    return ([$hands[0]['name'], $hands[1]['name'], $winner]) ;
}

function judgment(array $eachPlayerCardRank): array
{
    $primary = max($eachPlayerCardRank[0], $eachPlayerCardRank[1]);
    $secondary = min($eachPlayerCardRank[0], $eachPlayerCardRank[1]);
    $name = HIGH_CARD;

    if (pair($eachPlayerCardRank)) {
        $name = PAIR;
    } elseif (straight($eachPlayerCardRank)) {
        $name = STRAIGHT;
        if (isMinMax($eachPlayerCardRank)) {
            $primary = min($eachPlayerCardRank[0], $eachPlayerCardRank[1]);
            $secondary = max($eachPlayerCardRank[0], $eachPlayerCardRank[1]);
        }
    }

    return [
        'name' => $name,
        'nameLevel' => CARD_LEVEL[$name],
        'primary' => $primary,
        'secondary' => $secondary,
    ];
}

function pair(array $eachPlayerCardRank): bool
{
    if ($eachPlayerCardRank[0] === $eachPlayerCardRank[1]) {
        return true;
    } else {
        return false;
    }
}

function straight(array $eachPlayerCardRank): bool
{
    if (abs($eachPlayerCardRank[0] - $eachPlayerCardRank[1]) === 1 || isMinMax($eachPlayerCardRank)) {
        return true;
    } else {
        return false;
    }
}

function isMinMax(array $eachPlayerCardRank): bool
{
    if (abs($eachPlayerCardRank[0] - $eachPlayerCardRank[1]) === 12) {
        return true;
    } else {
        return false;
    }
}


function winner(array $hands): int
{
    foreach (['nameLevel', 'primary',] as $k) {
        if ($hands[0][$k] > $hands[1][$k]) {
            return 1;
        }
        if ($hands[0][$k] < $hands[1][$k]) {
            return 2;
        }
    }
    return 0;
}
