<?php

namespace PokerQuiz;

/* 【クイズ】ツーカードポーカーを単一責任の原則で設計しよう

◯お題

ツーカードポーカーを単一責任の原則で設計しましょう。下記の仕様を追加します。

プログラムを実行すると、与えられたカードのランクを返すようにします
テスト駆動で開発しましょう。

◯仕様

カードのランクは、2が1、3が2、...Kが12、Aが13とします。
プログラムの入力値として「プレイヤー1のカードの配列、プレイヤー2のカードの配列」を取ります。プログラムの返り値として [プレイヤー1のカードランクの配列, プレイヤー2のカードランクの配列] を返します。
◯テスト例

PokerGameTest のテスト例のみ記載します。他のクラスは単一責任の原則に基づいて設計してみてください。

 */

require_once('PokerCardsNotJoker.php');
require_once('HandJudge.php');
require_once('TwoCardsHandJudge.php');
require_once('ThreeCardsHandJudge.php');
require_once('FiveCardsHandJudge.php');


class PokerQuiz
{
    public function __construct(
        private array $player1Cards,
        private array $player2Cards,
        private string $ruleType,
        private string $cardRankType,
    ) {
    }

    public function start()
    {
        foreach ([$this->player1Cards, $this->player2Cards] as $cards) {
            //プレイヤーごとのカード  １回目['CA', 'DA'], ２回目['S3', 'H3']   $playerCards = [PokerCards'CA',PokerCards'DA'];
            $playerCards = array_map(fn($card) => $this->judgeRuleOfCardRank($card), $cards);
            //数字をランクに切り替える
            $rule = $this->getHandJudge();
            $handJudge = new HandJudge($rule);
            $playerStatus[] = $handJudge->judge($playerCards);
        }

        $winner = HandJudge::getWinner($playerStatus[0], $playerStatus[1]);

        return [$playerStatus[0]['hand'], $playerStatus[1]['hand'], $winner];
    }

    private function getHandJudge()
    {
        if ($this->ruleType === 'TwoCards') {
            return new TwoCardsHandJudge();
        }

        if ($this->ruleType === 'ThreeCards') {
            return new ThreeCardsHandJudge();
        }

        if ($this->ruleType === 'FiveCards') {
            return new FiveCardsHandJudge();
        }
    }

    private function judgeRuleOfCardRank($card)
    {
        if ($this->cardRankType === 'notJoker') {
            return new PokerCardsNotJoker($card);
        }
        // withJoker...
    }

    /* //二人のプレイヤーごとにカードを渡す
        $PlayerCards = array_map(
            fn($playerCards) => new PokerPlayer($playerCards),
            [$this->player1Cards, $this->player2Cards]
        );

        //数字をランクに切り替える
        $cardsRank = array_map(fn($PlayerCard) => $PlayerCard->getRank() , $PlayerCards);
        return $cardsRank; */
}
