<?php

namespace BlackJack;

require_once('Card.php');

class Deck
{
    private $cards = [];
    private const CARDS_NUMBER = ['2','3','4','5','6','7','8','9','10','J','Q','K','A'];
    public function __construct()
    {
        foreach (['ダイヤ', 'スペード', 'ハート', 'クローバー'] as $suit) {
            foreach (self::CARDS_NUMBER as $num) {
                $this->cards[] = new Card($suit, $num);
            }
        }
    }


    public function addCards($num): array
    {
        //デッキをシャッフルする
        shuffle($this->cards);
        return array_splice($this->cards, 0, $num);
    }
}
