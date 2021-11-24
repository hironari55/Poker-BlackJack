<?php

namespace BlackJack;

require_once('Dealer.php');
require_once('Player.php');
require_once('Deck.php');
require_once('Card.php');
require_once('WinnerJudge.php');
require_once('OneEqualACardRank.php');
require_once('ElevenEqualACardRank.php');
require_once('Dealer.php');
require_once('CPUPlayer1.php');
require_once('CPUPlayer2.php');

class BlackJackGame
{
    private const DRAW_ONE_CARD = 1;
    private const HAVE_TWO_CARDS = 2;
    private const CPU_ENOUGH_NUM = 17;
    private const THE_STRONGEST_NUM_OF_THE_RULE = 21;

    public function __construct(private Player $player, private $cpuPlayerNum)
    {
    }

    public function start(Deck $deck)
    {
        echo 'ブラックジャックを開始します。' . PHP_EOL;
        $totalCPURank = 0;
        while (count($this->player->PlayerCards) < self::HAVE_TWO_CARDS) {
            //カードが２枚与えられる  (プレイヤーの処理--------)
            //1枚目にAを引いていた場合ルールが変更となるため、１枚ずつ引いてルールを確認する
            $myselfCards = $this->player->addCards($deck, self::DRAW_ONE_CARD);
            $ruleOfRank = $this->player->getRuleOfPlayerRank($totalCPURank);
            $totalPlayerRank = $this->player->getTotalPlayerRank($myselfCards, $ruleOfRank);
        }

        echo "{$this->player->getName()}の引いた１枚目のカードは{$myselfCards[0]->getSuit()}の{$myselfCards[0]->getNum()}です" . PHP_EOL;
        echo "{$this->player->getName()}の引いた２枚目のカードは{$myselfCards[1]->getSuit()}の{$myselfCards[1]->getNum()}です" . PHP_EOL;

        //CPUのオブジェクト生成ーーー
        $CPUObjects = $this->getCPUNumRule($this->cpuPlayerNum);
        if (count($CPUObjects) > 0) {
            foreach ($CPUObjects as $CPUObject) {
                while (count($CPUObject->CPUCards) < self::HAVE_TWO_CARDS) {
                    //カードを二枚引く
                    $CPUObject->addCards($deck, self::DRAW_ONE_CARD);
                    $ruleOfRank = new ElevenEqualACardRank();
                    $CPUObject->getTotalRank($ruleOfRank);
                }
                echo "{$CPUObject->getName()}の引いた１枚目のカードは{$CPUObject->CPUCards[0]->getSuit()}の{$CPUObject->CPUCards[0]->getNum()}です" . PHP_EOL;
                echo "{$CPUObject->getName()}の引いた２枚目のカードはわかりません" . PHP_EOL;
            }
        } else {
            //CPUプレイヤー人数が設定範囲外のものは強制終了
            echo 'Error: CPUプレイヤー人数は0~2の中から選んでください' . PHP_EOL;
            exit;
        }


        echo "{$this->player->getName()}の現在の得点は{$totalPlayerRank}です。";

        //プレイヤーの処理ーーーー
        while (true) {
            echo 'カードを引きますか？（Y/N）' . PHP_EOL;
            $stdin = trim(fgets(STDIN));
            if ($stdin === 'Y') {
                $myselfCards = $this->player->addCards($deck, self::DRAW_ONE_CARD);
                $ruleOfRank = $this->player->getRuleOfPlayerRank($totalPlayerRank);
                $totalPlayerRank = $this->player->getTotalPlayerRank($myselfCards, $ruleOfRank);
                echo "{$this->player->getName()}の引いたカードは{$myselfCards[array_key_last($myselfCards)]->getSuit()}の{$myselfCards[array_key_last($myselfCards)]->getNum()}です" . PHP_EOL;
                echo "{$this->player->getName()}の現在の得点は{$totalPlayerRank}です。" . PHP_EOL;
                if ($totalPlayerRank > self::THE_STRONGEST_NUM_OF_THE_RULE) {
                    break;
                }
            } elseif ($stdin === 'N') {
                break;
            } elseif ($stdin !== 'N' || 'Y') {
                echo 'YまたはNで入力してください' . PHP_EOL;
            }
        }

        //CPUの処理--------------
        foreach ($CPUObjects as $CPUObject) {
            echo "{$CPUObject->getName()}の引いた２枚目のカードは{$CPUObject->CPUCards[1]->getSuit()}の{$CPUObject->CPUCards[1]->getNum()}でした" . PHP_EOL;
            echo "{$CPUObject->getName()}の現在の得点は{$CPUObject->totalRank}です" . PHP_EOL;
        }

        //CPU繰り返し引く処理
        foreach ($CPUObjects as $CPUObject) {
            while ($CPUObject->totalRank < self::CPU_ENOUGH_NUM) {
                $CPUObject->addCards($deck, self::DRAW_ONE_CARD);
                $ruleOfRank = $CPUObject->getRuleOfCPURank($CPUObject->totalRank);
                $CPUObject->getTotalRank($ruleOfRank);

                echo "{$CPUObject->getName()}の引いたカードは{$CPUObject->CPUCards[array_key_last($CPUObject->CPUCards)]->getSuit()}の{$CPUObject->CPUCards[array_key_last($CPUObject->CPUCards)]->getNum()}です。";
                echo "{$CPUObject->getName()}の得点は{$CPUObject->totalRank}です" . PHP_EOL;
                if ($CPUObject->totalRank > self::THE_STRONGEST_NUM_OF_THE_RULE) {
                    break;
                }
            }
        }

        $allPlayers = array_merge($CPUObjects, [$this->player]);
        $winnerJudge = new WinnerJudge($allPlayers);
        $winners = $winnerJudge->winnerJudge();

        foreach ($winners as $winner) {
            if(count($winners) === 1 ) {
                echo "{$winner}";
            } elseif (count($winners) >= 2) {
                echo "{$winner}" . ',';
            }
        }
        echo 'の勝ちです' . PHP_EOL;
        echo 'ブラックジャックを終了します' . PHP_EOL;
    }

    private function getCPUNumRule($cpuPlayerNum): array
    {
        if($cpuPlayerNum === 0) {
            $dealer = new Dealer('ディーラー');
            return [$dealer];
        } elseif ($cpuPlayerNum === 1) {
            $dealer = new Dealer('ディーラー');
            $player1 = new CPUPlayer1('プレイヤー１');
            return [$dealer, $player1];
        } elseif ($cpuPlayerNum === 2) {
            $dealer = new Dealer('ディーラー');
            $player1 = new CPUPlayer1('プレイヤー１');
            $player2 = new CPUPlayer2('プレイヤー2');
            return [$dealer, $player1, $player2];
        } else {
            return[];
        }
    }
}
