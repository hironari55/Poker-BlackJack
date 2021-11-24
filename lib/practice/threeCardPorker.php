<?php

/* ◯お題

「ツーカードポーカー」に「カードの枚数を3枚に変更して」と仕様変更が発生しました。

・ツーカードポーカーのファイルをコピーして新規ファイルを作成しましょう
・カード枚数を3枚に変更しましょう
・役の仕様は下記に変更します。役は番号が大きくなるほど強くなります

ハイカード：以下の役が一つも成立していない
ペア：2枚のカードが同じ数字
ストレート：3枚のカードが連続している。A は 2 と K の両方と連続しているとみなし、A を含むストレート は、A-2-3 と Q-K-A の2つ。ただし、K-A-2 のランクの組み合わせはストレートとはみなさない
スリーカード：3枚のカードが同じ数字
・2つの手札について、強さは以下に従います
2つの手札の役が異なる場合、より上位の役を持つ手札が強いものとする
2つの手札の役が同じ場合、各カードの数値によって強さを比較する
　 ・（弱）2, 3, 4, 5, 6, 7, 8, 9, 10, J, Q, K, A (強)
　 ・ハイカード：一番強い数字同士を比較する。左記が同じ数字の場合、二番目に強いカード同士を比較する。左記が同じ数字の場合、三番目に強いランクを持つカード同士を比較する。左記が同じランクの場合は引き分け
　 ・ペア：ペアの数字を比較する。左記が同じランクの場合、ペアではない3枚目同士のランクを比較する。左記が同じランクの場合は引き分け
　 ・ストレート：一番強い数字を比較する (ただし、A-2-3 の組み合わせの場合、3 を一番強い数字とする。Q-K-A が最強、A-2-3 が最弱)。一番強いランクが同じ場合は引き分け
　 ・スリーカード：スリーカードの数字を比較する。スリーカードのランクが同じ場合は引き分け
それぞれの役と勝敗を判定するプログラムを作成ください。

◯仕様

それぞれの役と勝敗を判定するshowメソッドを定義してください。
showメソッドは引数として、プレイヤー1のカード、プレイヤー1のカード、プレイヤー1のカード、プレイヤー2のカード、プレイヤー2のカード、プレイヤー2のカードを取ります。
カードはH1〜H13（ハート）、S1〜S13（スペード）、D1〜D13（ダイヤ）、C1〜C13（クラブ）、となります。ただし、Jは11、Qは12、Kは13、Aは1とします。
showメソッドは返り値として、プレイヤー1の役、プレイヤー2の役、勝利したプレイヤーの番号、を返します。引き分けの場合、プレイヤーの番号は0とします。 */

const HIGH_CARD = 'high card';
const PAIR = 'pair';
const STRAIGHT = 'straight';
const THREE_CARD = 'three card';

const CARD_LEVEL = [
    HIGH_CARD => 0,
    PAIR => 1,
    STRAIGHT => 2,
    THREE_CARD => 3,
];

const CARDS = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
define('CARD_RANK', (function () {
    $cardRanks = [];
    foreach (CARDS as $key => $value) {
        $cardRanks[$value] = $key;
    }
    return $cardRanks;
})());

function show(
    string $player11,
    string $player12,
    string $player13,
    string $player21,
    string $player22,
    string $player23,
) {
    //カードをランクに変更する
    $cards = [$player11, $player12, $player13, $player21, $player22, $player23];
    $cardRanks = array_map(fn ($card) => CARD_RANK[substr($card, 1, strlen($card) - 1)], $cards);

    //それぞれの手札ごとの配列に格納する
    $eachPlayerCardRanks = array_chunk($cardRanks, 3);
    //役を判定  ハイカード、ペア、ストレート、　　役の強さを定義　　　　役が違う場合は、役を比べて強さを判定  array_mapを使うことで配列ごとに関数を適応可能
    //役が同じ場合は　　強い方のカードを比べる　　強い方が同じ場合は弱い方のカードを比べる　　
    //⏫　　　役の強さ、強い方のカード、弱い方のカード、定義
    $hands = array_map(fn ($eachPlayerCardRank) => judgment($eachPlayerCardRank), $eachPlayerCardRanks);

    //勝者を決める
    $winner = winner($hands);

    return [$hands[0]['name'], $hands[1]['name'], $winner];
}

function judgment(array $eachPlayerCardRank): array
{
    rsort($eachPlayerCardRank);
    $primary = $eachPlayerCardRank[0];
    $secondary = $eachPlayerCardRank[1];
    $tertiary = $eachPlayerCardRank[2];

    $name = HIGH_CARD;
     /* ・ハイカード：一番強い数字同士を比較する。左記が同じ数字の場合、二番目に強いカード同士を比較する。左記が同じ数字の場合、三番目に強いランクを持つカード同士を比較する。左記が同じランクの場合は引き分け */

    if (pair($eachPlayerCardRank)) {
        $name = PAIR;
    } elseif (straight($eachPlayerCardRank)) {
        $name = STRAIGHT;
        if (isMinMax($eachPlayerCardRank) && absoluteValueSecondAndThird($eachPlayerCardRank) === 1) {
            //Q,K,Aが最強、A,2,3 (12,0,1)が最弱、　　K,A,2(12,11,0)はハイカードとして判定
            $primary = $eachPlayerCardRank[1];
            $secondary = $eachPlayerCardRank[2];
            $tertiary = $eachPlayerCardRank[0];
        }
    } elseif (threeCard($eachPlayerCardRank)) {
        $name = THREE_CARD;
    }

    return [
        'name' => $name,
        'nameLevel' => CARD_LEVEL[$name],
        'primary' => $primary,
        'secondary' => $secondary,
        'tertiary' => $tertiary,
    ];
}

function threeCard($eachPlayerCardRank): bool
{
    if (sameFirstAndSecond($eachPlayerCardRank) && sameSecondAndThird($eachPlayerCardRank)) {
        return true;
    } else {
        return false;
    }
}

function pair(array $eachPlayerCardRank): bool
{
    if (threeCard($eachPlayerCardRank)) {
        return false;
    }
    if (
        sameFirstAndSecond($eachPlayerCardRank)
        || sameSecondAndThird($eachPlayerCardRank)
        || sameFirstAndThird($eachPlayerCardRank)
    ) {
        return true;
    } else {
        return false;
    }
}

function straight(array $eachPlayerCardRank): bool
{
    if (
        (absoluteValueFirstAndSecond($eachPlayerCardRank) === 1
            && absoluteValueSecondAndThird($eachPlayerCardRank) === 1)
        || (isMinMax($eachPlayerCardRank)
            && absoluteValueSecondAndThird($eachPlayerCardRank) === 1)
    ) {
    //12.0.1)
        return true;
    } else {
        return false;
    }
}

function isMinMax(array $eachPlayerCardRank): bool
{
    if (abs($eachPlayerCardRank[0] - $eachPlayerCardRank[2]) === 12) {
        return true;
    } else {
        return false;
    }
}


function winner(array $hands): int
{
    foreach (['nameLevel', 'primary', 'secondary', 'tertiary'] as $k) {
        if ($hands[0][$k] > $hands[1][$k]) {
            return 1;
        }
        if ($hands[0][$k] < $hands[1][$k]) {
            return 2;
        }
    }
    return 0;
}

function sameFirstAndSecond($eachPlayerCardRank): bool
{
    if ($eachPlayerCardRank[0] === $eachPlayerCardRank[1]) {
        return true;
    } else {
        return false;
    }
}

function sameSecondAndThird($eachPlayerCardRank): bool
{
    if ($eachPlayerCardRank[1] === $eachPlayerCardRank[2]) {
        return true;
    } else {
        return false;
    }
}

function sameFirstAndThird($eachPlayerCardRank): bool
{
    if ($eachPlayerCardRank[0] === $eachPlayerCardRank[2]) {
        return true;
    } else {
        return false;
    }
}

function absoluteValueFirstAndSecond($eachPlayerCardRank)
{
    return abs($eachPlayerCardRank[0] - $eachPlayerCardRank[1]);
}

function absoluteValueSecondAndThird($eachPlayerCardRank)
{
    return abs($eachPlayerCardRank[1] - $eachPlayerCardRank[2]);
}
