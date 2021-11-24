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

function createArray($argv): array
{
    array_shift($argv);
    $watches = (array_chunk($argv, 2));

    return $watches;
}

function changeArray(array $watches): array
{
    //foreachで取り出してきた値を別の箱に格納してチャンネルがキー、視聴分数が値の配列を作成したい
    $tvShow = [];

    //$watchesの配列からチャンネルと動画視聴時間をそれぞれ分けて取り出す
    foreach ($watches as $watch) {
        $chan = $watch[0];
         //$minは配列にして複数格納可能にする、データをまとめられるようにする
        $min = [$watch[1]];

        //もし同じチャンネルがすでにある場合は同じキーに対しての値を格納したい
        if (array_key_exists($chan, $tvShow)) {
            $min = array_merge($tvShow[$chan], $min);
        }

        //🔽の定義は🔼のarraymergeの定義の後に行わないと値が先に上書きされてから　arraymergeをしようとするので合併ができない
        $tvShow[$chan] = $min;
    }
    return $tvShow;
}

//合計視聴時間
function totalHours(array $tvShow): float
{
    //合計視聴時間を分数から時間単位に変換して出力
    $totalViewTime = [];
    foreach ($tvShow as $value) {
        $totalViewTime = array_merge($totalViewTime, $value);
    }
    $totalHours = round(array_sum($totalViewTime) / 60, 1);

    return $totalHours;
}


//tvShowの配列の中身をそれぞれ横並びに出力
function seeShowTvTime(array $tvShow)
{
    //tvShowの配列をキー($chan)と値($min)の視聴分数の合計、それぞれ取り出す
    foreach ($tvShow as $key => $value) {
        echo $key . ' ' . array_sum($value) . ' ' . count($value) . PHP_EOL;
    }
}

//入力された値を２個ずつ配列に格納する
$watches = createArray($argv);

//チャンネルがキー毎の分数の値を配列に格納し直す
$tvShow = changeArray($watches);

//合計時間を算出
$totalHours = totalHours($tvShow);
echo $totalHours . PHP_EOL;

//アウトプット用の関数を使いたい 合計視聴時間、出力時のチャンネルと分数の横並び
seeShowTvTime($tvShow);

// docker-compose exec app php quiz.php 1 30 5 25 2 30 1 15
