<?php

/* function judge(int $answer, int $guess): array
{
    $hit = 0;
    $blow = 0;
    //回答者の考えた答えが$guess, ＄guessを配列に変更 [5678]
    $arrayGuess = str_split((string) $guess);
    //foreachで$guessの配列を一つずつ、キーが$index,値が$guessElemとして出力
    foreach ($arrayGuess as $index => $guessElem) {
        //if文の条件の中でisHit関数の呼び出し　　　　0=>5 1=>6 2=>7 3=>8
        if (isHit($guessElem, $answer, $index)) {
            $hit++;
        }

        if (isBlow($guessElem, $answer, $index)) {
            $blow++;
        }
    }

    return [$hit, $blow];
}
//arrayGuessは回答者の答えを配列にしたもの
//arrayGuessのforeachの値$guessElemを$letterとして受け取る、  $answerは問題の答え、   $indexはarrayGuessのforeachのキー
function isHit(string $letter, int $answer, int $index): bool
{
    //答えを配列に変更した後、答えの、回答と同じキーに対する値が同じかを比較
    return str_split((string) $answer)[$index] === $letter;
}

function isBlow(string $letter, int $answer, int $index): bool
{
    //もしヒットに該当してtrueを返していればfalseを返してblowにカウントしない
    if (isHit($letter, $answer, $index)) {
        return false;
    }

    //回答の値が、答えの配列の中にもあるかを調べる
    return in_array($letter, str_split((string) $answer), true);
}
 */

function judge(int $answer, int $guess)
{
    //ヒットとブロウの数を算出するにはまず定義
    $hit = 0;
    $blow = 0;
    // 入力された文字列を配列に格納する
    $arrayGuess = str_split((string) $guess);

    // foreachで答えをバラバラにする
    foreach ($arrayGuess as $order => $number) {
            //回答と答えが順番まであっているのか、バラバラのキーと値を答えのものと比べる合っていれば →→ $hit++
        if (isHit($answer, $order, $number)) {
            $hit++;
        }

        if (isBlow($answer, $order, $number)) {
            $blow++;
        }
    }

    /* $blow = $blow - $hit; */

    return [$hit, $blow];
    //回答の中に値のみ一致しているものがあるか、バラバラの値を使って求める --> $blow
}

function isHit(int $answer, int $order, string $number): bool
{
    return str_split((string) $answer)[$order] === $number;
}

function isBlow(int $answer, int $order, string $number): bool
{
    if (isHit($answer, $order, $number)) {
        return false;
    };
    return in_array($number, str_split((string) $answer));
}
