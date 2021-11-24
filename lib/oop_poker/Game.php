<?php

namespace OopPoker;

require_once('Deck.php');
require_once('Player.php');
require_once('HandEvaluator.php');
require_once('RuleA.php');
require_once('RuleB.php');

class Game
{
    public function __construct(
        private string $name1,
        private string $name2,
        private int $num,
        private string $ruleType
    ) {
    }

    public function start()
    {
        $hand = [];
        $deck = new Deck();
        $rule = $this->getRule();
        //ruleはインスタンスを渡したい
        $handEvaluator = new HandEvaluator($rule);

        foreach ([$this->name1, $this->name2] as $eachPlayer) {
            //プレイヤーを決める
            $player = new Player($eachPlayer);
            //プレイヤーがカードを引く
            $card = $player->drawCards($deck, $this->num);
            //ルール別に役判定
            $hand[] = $handEvaluator->getHand($card);
        }
        return HandEvaluator::getWinner($hand[0], $hand[1]);
    }

    private function getRule()
    {
        if ($this->ruleType === 'A') {
            return new RuleA();
        } elseif ($this->ruleType === 'A') {
            return new RuleB();
        }
    }
}
