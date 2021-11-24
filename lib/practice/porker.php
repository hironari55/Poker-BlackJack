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

//J,Q,K,を数字に置き換えること　Aに関しては14と設定
/* const NUMBER = [
    2 => 2,
    3 => 3,
    4 => 4,
    5 => 5,
    6 => 6,
    7 => 7,
    8 => 8,
    9 => 9,
    10 => 10,
    'J' => 11,
    'Q' => 12,
    'K' => 13,
    'A' => 14,
];
function showDown(
        string $firstCardOfThePlayer1,
        string $secondCardOfThePlayer1,
        string $firstCardOfThePlayer2,
        string $secondCardOfThePlayer2
    ) {
    //思いついた処理の案全部メモ
    //substr関数を使って先頭文字の絵札部分を切り取って数字のみにする
    $NumberOfThePlayer1 = [];
    $NumberOfThePlayer2 = [];
    $NumberOfThePlayer1[] = substr($firstCardOfThePlayer1, 1);
    $NumberOfThePlayer1[] = substr($secondCardOfThePlayer1, 1);
    $NumberOfThePlayer2[] = substr($firstCardOfThePlayer2, 1);
    $NumberOfThePlayer2[] = substr($secondCardOfThePlayer2, 1);

    //ーーー比較ーーー
    //お互いペアの場合
    //第一引数をプレーヤー同士で比べる
    if (isBothPair($NumberOfThePlayer1, $NumberOfThePlayer2)) {
        $typePlayer1 = 'pair';
        $typePlayer2 = 'pair';

        if (NUMBER[$NumberOfThePlayer1[0]] > NUMBER[$NumberOfThePlayer2[0]]) {
            $winner = 1;
        } elseif (NUMBER[$NumberOfThePlayer1[0]] < NUMBER[$NumberOfThePlayer2[0]]) {
            $winner = 2;
        } elseif (NUMBER[$NumberOfThePlayer1[0]] === NUMBER[$NumberOfThePlayer2[0]]) {
            $winner = 0;
        }
    }

    $player1AbsoluteValue1 = abs(NUMBER[$NumberOfThePlayer1[0]] - NUMBER[$NumberOfThePlayer1[1]]) === 1;
    $player2AbsoluteValue1 = abs(NUMBER[$NumberOfThePlayer2[0]] - NUMBER[$NumberOfThePlayer2[1]]) === 1;
    $player1AbsoluteValue12 = abs(NUMBER[$NumberOfThePlayer1[0]] - NUMBER[$NumberOfThePlayer1[1]]) === 12;
    $player2AbsoluteValue12 = abs(NUMBER[$NumberOfThePlayer2[0]] - NUMBER[$NumberOfThePlayer2[1]]) === 12;
    //お互いストレート、連続した数字の場合
    //二つの引数の差分の絶対値が１の時、ストレートと判定、2と,A(14)が出た場合の絶対値１２の場合もストレートと判定 abc関数
    if (isBothStraight($NumberOfThePlayer1, $NumberOfThePlayer2)) {
        $typePlayer1 = 'straight';
        $typePlayer2 = 'straight';
    }
        //ストレートかつ二つの数値の差の絶対値が１の場合
    if (
            (isBothStraight($NumberOfThePlayer1, $NumberOfThePlayer2))
            && ($player1AbsoluteValue1 && $player2AbsoluteValue1)
        ) {
        if (array_sum($NumberOfThePlayer1) > array_sum($NumberOfThePlayer2)) {
            $winner = 1;
        } elseif(array_sum($NumberOfThePlayer1) < array_sum($NumberOfThePlayer2)) {
            $winner = 2;
        } elseif (array_sum($NumberOfThePlayer1) === array_sum($NumberOfThePlayer2)) {
            $winner = 0;
        }
    } elseif (
            (isBothStraight($NumberOfThePlayer1, $NumberOfThePlayer2))
            && ($player1AbsoluteValue12 && $player2AbsoluteValue1)
        ) {
        //ストレートかつプレーヤー１の絶対値が１２、プレーヤー２の絶対値が１の場合
        $winner = 2;
    } elseif ((isBothStraight($NumberOfThePlayer1, $NumberOfThePlayer2))
        && ($player1AbsoluteValue1 && $player2AbsoluteValue12)) {
        //ストレートかつプレーヤー１の絶対値が1、プレーヤー２の絶対値が１2の場合
        $winner = 1;
    } elseif ((isBothStraight($NumberOfThePlayer1, $NumberOfThePlayer2))
        && ($player1AbsoluteValue12 && $player2AbsoluteValue12)) {
        //ストレートかつプレーヤー１の絶対値が１２且つ、プレーヤー２の絶対値が１2の場合
        $winner = 0;
    }

    //お互いハイカードの場合
    //引数同士を比べて強い方の数字をプレーヤー同士で比べる
    if (isBothHighCard($NumberOfThePlayer1, $NumberOfThePlayer2)) {
        $typePlayer1 = 'high card';
        $typePlayer2 = 'high card';

        if(
            max(NUMBER[$NumberOfThePlayer1[0]], NUMBER[$NumberOfThePlayer1[1]])
            > max(NUMBER[$NumberOfThePlayer2[0]], NUMBER[$NumberOfThePlayer2[1]])
        ) {
            $winner = 1;
        }elseif (
            max(NUMBER[$NumberOfThePlayer1[0]], NUMBER[$NumberOfThePlayer1[1]])
            < max(NUMBER[$NumberOfThePlayer2[0]], NUMBER[$NumberOfThePlayer2[1]])
            ) {
            $winner = 2;
        }
    }
    if (
        (isBothHighCard($NumberOfThePlayer1, $NumberOfThePlayer2))
        && (max(NUMBER[$NumberOfThePlayer1[0]], NUMBER[$NumberOfThePlayer1[1]])
        === max(NUMBER[$NumberOfThePlayer2[0]], NUMBER[$NumberOfThePlayer2[1]]))
    ) {
        if (
            min(NUMBER[$NumberOfThePlayer1[0]], NUMBER[$NumberOfThePlayer1[1]])
            > min(NUMBER[$NumberOfThePlayer2[0]], NUMBER[$NumberOfThePlayer2[1]])
        ) {
            $winner = 1;
        } elseif (
            min(NUMBER[$NumberOfThePlayer1[0]], NUMBER[$NumberOfThePlayer1[1]])
            < min(NUMBER[$NumberOfThePlayer2[0]], NUMBER[$NumberOfThePlayer2[1]])
        ) {
            $winner = 2;
        } elseif (
            min(NUMBER[$NumberOfThePlayer1[0]], NUMBER[$NumberOfThePlayer1[1]])
            === min(NUMBER[$NumberOfThePlayer2[0]], NUMBER[$NumberOfThePlayer2[1]])
        ) {
            $winner = 0;
        }
    }

    // 一方がペア、もう一方がハイカード　逆も
    if (pairOneAndHighCardTwo(
            $NumberOfThePlayer1,
            $NumberOfThePlayer2,
            $player2AbsoluteValue1,
            $player2AbsoluteValue12
            )) {
        $typePlayer1 = 'pair';
        $typePlayer2 = 'high card';
        $winner = 1;
    }
    if (pairTwoAndHighCardOne(
        $NumberOfThePlayer1,
        $NumberOfThePlayer2,
        $player1AbsoluteValue1,
        $player1AbsoluteValue12
        )) {
        $typePlayer1 = 'high card';
        $typePlayer2 = 'pair';
        $winner = 2;
    }


    //一方がハイカード、もう一方がストレート 逆も
    if (highcardOneAndStraightTwo(
        $NumberOfThePlayer1,
        $NumberOfThePlayer2,
        $player1AbsoluteValue1,
        $player1AbsoluteValue12,
        $player2AbsoluteValue1,
        $player2AbsoluteValue12
        )) {
        $typePlayer1 = 'high card';
        $typePlayer2 = 'straight';
        $winner = 2;
    }

    if (highcardTwoAndStraightOne(
        $NumberOfThePlayer1,
        $NumberOfThePlayer2,
        $player1AbsoluteValue1,
        $player1AbsoluteValue12,
        $player2AbsoluteValue1,
        $player2AbsoluteValue12
        )) {
        $typePlayer1 = 'straight';
        $typePlayer2 = 'high card';
        $winner = 1;
    }

//一方がペア。もう一方がストレート  逆も
if (pairOneAndStraightTwo(
    $NumberOfThePlayer1,
    $NumberOfThePlayer2,
    $player2AbsoluteValue1,
    $player2AbsoluteValue12
    )) {
        $typePlayer1 = 'pair';
        $typePlayer2 = 'straight';
        $winner = 2;
}
if (pairTwoAndStraightOne(
    $NumberOfThePlayer1,
    $NumberOfThePlayer2,
    $player1AbsoluteValue1,
    $player1AbsoluteValue12
    )) {
        $typePlayer1 = 'straight';
        $typePlayer2 = 'pair';
        $winner = 1;
}

    //結果を返す
    return [$typePlayer1, $typePlayer2, $winner];
}


//ペアの条件
function isBothPair($NumberOfThePlayer1, $NumberOfThePlayer2): bool
{
    if (
        NUMBER[$NumberOfThePlayer1[0]] === NUMBER[$NumberOfThePlayer1[1]]
        && NUMBER[$NumberOfThePlayer2[0]] === NUMBER[$NumberOfThePlayer2[1]]
        ) {
        return true;
    }else {
        return false;
    }
}

//ストレートの条件
function isBothStraight ($NumberOfThePlayer1, $NumberOfThePlayer2): bool
{
    $player1AbsoluteValue1 = abs(NUMBER[$NumberOfThePlayer1[0]] - NUMBER[$NumberOfThePlayer1[1]]) === 1;
    $player2AbsoluteValue1 = abs(NUMBER[$NumberOfThePlayer2[0]] - NUMBER[$NumberOfThePlayer2[1]]) === 1;
    $player1AbsoluteValue12 = abs(NUMBER[$NumberOfThePlayer1[0]] - NUMBER[$NumberOfThePlayer1[1]]) === 12;
    $player2AbsoluteValue12 = abs(NUMBER[$NumberOfThePlayer2[0]] - NUMBER[$NumberOfThePlayer2[1]]) === 12;

    if (($player1AbsoluteValue1 || $player1AbsoluteValue12) && ($player2AbsoluteValue1 || $player2AbsoluteValue12)) {
        return true;
    }else {
        return false;
    }
}

//ハイカードの条件
function isBothHighCard($NumberOfThePlayer1, $NumberOfThePlayer2): bool
{
    //もし持っている２つのカードが異なる数字の場合でもストレートの場合はfalseを返す
    if(isBothStraight($NumberOfThePlayer1, $NumberOfThePlayer2)) {
        return false;
    }

    //持っている２つのカードが異なる数字の場合
    if(
        NUMBER[$NumberOfThePlayer1[0]] !== NUMBER[$NumberOfThePlayer1[1]]
        && NUMBER[$NumberOfThePlayer2[0]] !== NUMBER[$NumberOfThePlayer2[1]]
    ) {
        return true;
    } else {
        return false;
    }
}


function pairOneAndHighCardTwo (
    $NumberOfThePlayer1,
    $NumberOfThePlayer2,
    $player2AbsoluteValue1,
    $player2AbsoluteValue12
    ) {
    if (
        (NUMBER[$NumberOfThePlayer1[0]] === NUMBER[$NumberOfThePlayer1[1]])
        && (NUMBER[$NumberOfThePlayer2[0]] !== NUMBER[$NumberOfThePlayer2[1]]
        && !($player2AbsoluteValue1 || $player2AbsoluteValue12))
    ) {
        return true;
    } else {
        return false;
    }
}

function pairTwoAndHighCardOne(
    $NumberOfThePlayer1,
    $NumberOfThePlayer2,
    $player1AbsoluteValue1,
    $player1AbsoluteValue12
    ) {
    if (NUMBER[$NumberOfThePlayer2[0]] === NUMBER[$NumberOfThePlayer2[1]]
        && (NUMBER[$NumberOfThePlayer1[0]] !== NUMBER[$NumberOfThePlayer1[1]]
        && !($player1AbsoluteValue1 || $player1AbsoluteValue12))
    ) {
        return true;
    } else {
        return false;
    }
}

function highcardOneAndStraightTwo(
    $NumberOfThePlayer1,
    $NumberOfThePlayer2,
    $player1AbsoluteValue1,
    $player1AbsoluteValue12,
    $player2AbsoluteValue1,
    $player2AbsoluteValue12
    ) {
    if ((NUMBER[$NumberOfThePlayer1[0]] !== NUMBER[$NumberOfThePlayer1[1]]
        && !($player1AbsoluteValue1 || $player1AbsoluteValue12))
        && (NUMBER[$NumberOfThePlayer2[0]] !== NUMBER[$NumberOfThePlayer2[1]]
        && ($player2AbsoluteValue1 || $player2AbsoluteValue12))
    ){
        return true;
    } else {
        return false;
    }
}

function highcardTwoAndStraightOne(
    $NumberOfThePlayer1,
    $NumberOfThePlayer2,
    $player1AbsoluteValue1,
    $player1AbsoluteValue12,
    $player2AbsoluteValue1,
    $player2AbsoluteValue12
    ) {
    if ((NUMBER[$NumberOfThePlayer1[0]] !== NUMBER[$NumberOfThePlayer1[1]]
        && ($player1AbsoluteValue1 || $player1AbsoluteValue12))
        && (NUMBER[$NumberOfThePlayer2[0]] !== NUMBER[$NumberOfThePlayer2[1]]
        && !($player2AbsoluteValue1 || $player2AbsoluteValue12))
    ) {
        return true;
    } else {
        return false;
    }
}

function pairOneAndStraightTwo(
    $NumberOfThePlayer1,
    $NumberOfThePlayer2,
    $player2AbsoluteValue1,
    $player2AbsoluteValue12
    ) {
    if((NUMBER[$NumberOfThePlayer1[0]] === NUMBER[$NumberOfThePlayer1[1]])
        && (NUMBER[$NumberOfThePlayer2[0]] !== NUMBER[$NumberOfThePlayer2[1]]
        && ($player2AbsoluteValue1 || $player2AbsoluteValue12))
    ) {
        return true;
    } else {
        return false;
    }
}

function pairTwoAndStraightOne(
    $NumberOfThePlayer1,
    $NumberOfThePlayer2,
    $player1AbsoluteValue1,
    $player1AbsoluteValue12
    ) {
    if (NUMBER[$NumberOfThePlayer2[0]] === NUMBER[$NumberOfThePlayer2[1]]
        && (NUMBER[$NumberOfThePlayer1[0]] !== NUMBER[$NumberOfThePlayer1[1]]
        && ($player1AbsoluteValue1 || $player1AbsoluteValue12))
    ) {
        return true;
    }else {
        return false;
    }
}
 */
