<?php

/* 【クイズ】テレビの視聴時間

◯お題
あなたはテレビが好きすぎて、プログラミングの学習が捗らないことに悩んでいました。
テレビをやめれば学習時間が増えることは分かっているのですけど、テレビをすぐに辞めることができないでいます。
そこで、一日のテレビの視聴分数を記録することから始めようと思い、プログラムを書くことにしました。
テレビを見るたびにチャンネルごとの視聴分数をメモしておき、一日の終わりに記録します。テレビの合計視聴時間と、チャンネルごとの視聴分数と視聴回数を出力してください。

◯インプット
入力は以下の形式で与えられます。

テレビのチャンネル 視聴分数 テレビのチャンネル 視聴分数 ...

ただし、同じチャンネルを複数回見た時は、それぞれ分けて記録すること。

チャンネル：数値を指定すること。1〜12の範囲とする（1ch〜12ch）
視聴分数：分数を指定すること。1〜1440の範囲とする

◯アウトプット
テレビの合計視聴時間
テレビのチャンネル 視聴分数 視聴回数
テレビのチャンネル 視聴分数 視聴回数
...

ただし、閲覧したチャンネルだけ出力するものとする。

視聴時間：時間数を出力すること。小数点一桁までで、端数は四捨五入すること

◯インプット例

1 30 5 25 2 30 1 15

◯アウトプット例

1.7
1 45 2
2 30 1
5 25 1

◯実行コマンド例
php quiz.php 1 30 5 25 2 30 1 15 */

function ArraySetOfTwo(array $argv): array
{
    $watches = array_chunk(array_slice($argv, 1), 2);
    return $watches;
}

function myChannel(array $watches): array
{
    $myChannel = [];
    foreach ($watches as $watch) {
        $chan = $watch[0];
        $min = [$watch[1]];

        if (array_key_exists($chan, $myChannel)) {
            $min = array_merge($myChannel[$chan], $min);
        }
        $myChannel[$chan] = $min;
    }
    return $myChannel;
}

function totalHours(array $myChannel)
{
    $totalMins = [];
    foreach ($myChannel as $channel) {
        $totalMins = array_merge($totalMins, $channel);
    }

    $totalHours = round(array_sum($totalMins) / 60, 1);
    return $totalHours;
}

function displayTime($myChannel)
{
    //合計時間計算の関数の呼び出し
    $totalHours = totalHours($myChannel);
    echo $totalHours . PHP_EOL;

    //キーと値をそれぞれ表示
    foreach ($myChannel as $key => $value) {
        echo $key . ' ' . array_sum($value) . ' ' . count($value) . PHP_EOL;
    }
}

//見たチャンネルと視聴分数毎に配列に格納し直す
$watches = ArraySetOfTwo($_SERVER['argv']);

//チャンネルがキー、それに対する値が視聴分数の配列を定義
$myChannel = myChannel($watches);

//表示する処理を書く
displayTime($myChannel);

//ファイルを開く  docker-compose exec app php lib/tvShow.php 1 30 5 25 2 30 1 15
