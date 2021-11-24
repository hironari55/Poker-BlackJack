<?php

/*
【クイズ】ツーカードポーカー

◯お題

2枚の手札でポーカーを行います。ルールは次の通りです。

・プレイヤーは2人です
・各プレイヤーはトランプ2枚を与えられます
・ジョーカーはありません
・与えられたカードから、役を判定します。役は番号が大きくなるほど強くなります

ハイカード：以下の役が一つも成立していない
ペア：2枚のカードが同じ数字
ストレート：2枚のカードが連続している。A は 2 と K の両方と連続しているとみなし、A を含むストレート は、A-2 と K-A の2つです
・2つの手札について、強さは以下に従います
2つの手札の役が異なる場合、より上位の役を持つ手札が強いものとする
2つの手札の役が同じ場合、各カードの数値によって強さを比較する
　 ・（弱）2, 3, 4, 5, 6, 7, 8, 9, 10, J, Q, K, A (強)
　 ・ハイカード：一番強い数字同士を比較する。左記が同じ数字の場合、もう一枚のカード同士を比較する
　 ・ペア：ペアの数字を比較する
　 ・ストレート：一番強い数字を比較する (ただし、A-2 の組み合わせの場合、2 を一番強い数字とする。K-A が最強、A-2 が最弱)
　 ・数値が同じ場合：引き分け
　
それぞれの役と勝敗を判定するプログラムを作成ください。
◯仕様

それぞれの役と勝敗を判定するshowDownメソッドを定義してください。
showDownメソッドは引数として、プレイヤー1のカード、プレイヤー1のカード、プレイヤー2のカード、プレイヤー2のカードを取ります。
カードはH1〜H13（ハート）、S1〜S13（スペード）、D1〜D13（ダイヤ）、C1〜C13（クラブ）、となります。ただし、Jは11、Qは12、Kは13、Aは1とします。
showDownメソッドは返り値として、プレイヤー1の役、プレイヤー2の役、勝利したプレイヤーの番号、を返します。引き分けの場合、プレイヤーの番号は0とします。
 */


const CARD = ["2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K", "A"];
define('CARD_RANK', (function () {
    $cardRanks = [];
    foreach (CARD as $key => $value) {
        $cardRanks[$value] = $key;
    }
    return $cardRanks;
})());

const HAND_RANK = [
    'high card' => 0,
    'pair' => 1,
    'straight' => 2,
];

function showDown(string $player11, $player12, $player21, $player22)
{
    //カードの絵柄を切り取る
    $cardsRanks = array_map(
        fn($card)=> CARD_RANK[substr($card, 1, strlen($card) - 1)],
        [$player11, $player12, $player21, $player22]
    );

    //役を判定する
    $hands = array_map(
        fn ($playerCard)=> judgment($playerCard),
        [[$cardsRanks[0], $cardsRanks[1]], [$cardsRanks[2], $cardsRanks[3]]]
    );

    //勝者の判定
    $winner = decideWinner($hands);

    return [$hands[0]['hand'], $hands[1]['hand'], $winner];
}

function judgment(array $playerCard): array
{
    $hand = 'high card';
    $strongestHand = max($playerCard);
    $secondHand = min($playerCard);

    if (pair($playerCard)) {
        $hand = 'pair';
    } elseif (straight($playerCard)) {
        $hand = 'straight';
        if (isMinMax($playerCard)) {
            $strongestHand = min($playerCard);
            $secondHand = max($playerCard);
        }
    }

    return [
        'hand' => $hand,
        'handRank' => HAND_RANK[$hand],
        'strongestHand' => $strongestHand,
        'secondHand' => $secondHand,
    ];
}

function pair(array $playerCard): bool
{
    if ($playerCard[0] === $playerCard[1]) {
        return true;
    } else {
        return false;
    }
}

function straight(array $playerCard): bool
{
    if ($playerCard[0] !== $playerCard[1] && abs($playerCard[0] - $playerCard[1]) === 1 || isMinMax($playerCard)) {
        return true;
    } else {
        return false;
    }
}

function isMinMax(array $playerCard): bool
{
    if (abs($playerCard[0] - $playerCard[1]) === 12) {
        return true;
    } else {
        return false;
    }
}

function highCard(array $playerCard): bool
{
    if (!straight($playerCard) && $playerCard[0] !== $playerCard[1]) {
        return true;
    } else {
        return false;
    }
}

function decideWinner(array $hands): int
{
    foreach (['handRank', 'strongestHand', 'secondHand'] as $k) {
        if ($hands[0][$k] > $hands[1][$k]) {
            return 1;
        } elseif ($hands[0][$k] < $hands[1][$k]) {
            return 2;
        }
    }
    return 0;
}
