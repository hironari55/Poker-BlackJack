<?php

namespace OopPoker;

require_once('Game.php');

//gameクラスを呼び出してgameクラスのstartメソッドを呼び出してる
$game = new Game('田中', '中村', 2, 'A');
$game->start();
