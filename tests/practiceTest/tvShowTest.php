<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib/practice/viewingTv.php');

final class TvShowTest extends TestCase
{
    public function test()
    {
        $output = <<<EOD
        1.7
        1 45 2
        5 25 1
        2 30 1

        EOD;

        $this->expectOutputString($output);

        //見たチャンネルと視聴分数毎に配列に格納し直す
        $watches = ArraySetOfTwo(["lib/tvShow.php", "1", "30", "5", "25", "2", "30", "1", "15"]);

        //チャンネルがキー、それに対する値が視聴分数の配列を定義
        $myChannel = myChannel($watches);

        //表示する処理を書く
        displayTime($myChannel);
    }
}
