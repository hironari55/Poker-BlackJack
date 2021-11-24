<?php

namespace BlackJack;

use BlackJack\BlackJackGame;
use BlackJack\Deck;
use BlackJack\Player;

require_once('BlackJackGame.php');

$player = new Player('あなた');
$blackJackGame = new BlackJackGame($player, 2);
$deck = new Deck();

$blackJackGame->start($deck);

// php lib/BlackJack/main.php
