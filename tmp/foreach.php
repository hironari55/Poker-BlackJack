<?php

const GAME = [
    1 => '120',
    2 => '160',
    3 => '80',
    4 => '50',
];

$sales = [
    1 => 12,
    2 => 3,
    3 => 5,
    4 => 16,
];

$sum = 0;
foreach ($sales as $number => $quantity) {
    $sum += GAME[$number] * $quantity;
}
echo ($sum) . PHP_EOL;

// docker-compose exec app php foreach.php
