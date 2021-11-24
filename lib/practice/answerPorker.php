<?php

//役の名前を定数で定義
const HIGH_CARD = 'high card';
const PAIR = 'pair';
const STRAIGHT = 'straight';

//カードの数字を定義
const CARDS = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];

//無名関数の即席関数を使ってカードランクを定義、　　カードランクはカードの数字の強さを定義している
define('CARD_RANK', (function () {
    $cardRanks = [];
    foreach (CARDS as $index => $card) {
        $cardRanks[$card] = $index;
    }
    return $cardRanks;
})());

//役同士の強さを定義
const HAND_RANK = [
HIGH_CARD => 1,
PAIR => 2,
STRAIGHT => 3,
];

function showDown(string $card11, string $card12, string $card21, string $card22)
{
        //------カードをランクに変更する--------//
    //受け取った値を関数を呼び出してカードランクに変換　 配列として引数を渡すことで受け取り側は一つの変数で受け取ることができる
    $cardRanks = convertToCardRanks([$card11, $card12, $card21, $card22]);
    //⬆️cardRanksにはランクに変更後の４つの値が入った一つの配列が渡される
    var_dump($cardRanks);
    //cardranksに入っている４つの値を２つずつの値の配列に分ける
    $playerCardRanks = array_chunk($cardRanks, 2);

    //--------各役を判定する------//
    // array_mapを使って２人のプレーヤーごとのカードランクの配列を受け取る、　array_mapは要素ごとに関数を適応可能。
    $hands = array_map(fn ($playerCardRank) => checkHand($playerCardRank[0], $playerCardRank[1]), $playerCardRanks);

    //--------勝者を判定するーーーー//
    $winner = decideWinner($hands[0], $hands[1]);
    return [$hands[0]['name'], $hands[1]['name'], $winner];
}

function convertToCardRanks(array $cards): array
{
    //受け取った値をカードランクに変換して返す関数　　　
    // array_mapで第二引数で２人の手札の配列、cardsを受け取り、 第一引数でアロー関数利用。 関数内ではsubstrで絵札部分を聞いとり、数字のみにした後、ランクに変換している
    return array_map(fn ($card) => CARD_RANK[substr($card, 1, strlen($card) - 1)], $cards);
}

function checkHand(int $cardRank1, int $cardRank2): array
{
    //２枚のカードの強い方を定義
    $primary = max($cardRank1, $cardRank2);
    //２枚のカードの弱い方を定義
    $secondary = min($cardRank1, $cardRank2);
    //役がハイカードであることを定義
    $name = HIGH_CARD;

    //ストレートの判定がtrueの場合は役がストレートであることw定義
    if (isStraight($cardRank1, $cardRank2)) {
        $name = STRAIGHT;
    //
        if (isMinMax($cardRank1, $cardRank2)) {
        //ストレートかつ、絶対値が12の場合は最大値が２
            $primary = min(CARD_RANK);
        //ストレートかつ、絶対値が12の場合は最小値がA  同じストレート同士の場合は強い方のカードを比べることとなり、KーAが最強のため。
            $secondary = max(CARD_RANK);
        }
    } elseif (isPair($cardRank1, $cardRank2)) {
        $name = PAIR;
    }

    return [
    //nameは役の名前、ペア、はいカード、ストレート
    'name' => $name,
    //役同士での強さを返す　　　ここで役を比べられる
    'rank' => HAND_RANK[$name],
    //強い方のカードの数値
    'primary' => $primary,
    //弱い方のカードの数値
    'secondary' => $secondary,
    ];
}

function isStraight(int $cardRank1, int $cardRank2): bool
{
    //ストレート判定の条件は絶対値が１または１２の場合の時、 12の場合はisminmaxで定義
    return abs($cardRank1 - $cardRank2) === 1 || isMinMax($cardRank1, $cardRank2);
}

function isMinMax(int $cardRank1, int $cardRank2): bool
{
    ///ストレートの条件、絶対値が１２の場合の条件
    return abs($cardRank1 - $cardRank2) === (max(CARD_RANK) - min(CARD_RANK));
}

function isPair(int $cardRank1, int $cardRank2): bool
{
    //ペアだった時の条件
    return $cardRank1 === $cardRank2;
}

function decideWinner(array $hand1, array $hand2): int
{
    //勝者を判定する関数、　foreachの配列のキーは$handsのキーを回している、比べる優先順位の高いものから並べること
    foreach (['rank', 'primary', 'secondary'] as $k) {
        if ($hand1[$k] > $hand2[$k]) {
            return 1;
        }

        if ($hand1[$k] < $hand2[$k]) {
            return 2;
        }
    }

    return 0;
}
