<?php

function double(int ...$number)
{
    return array_map(fn ($num) => dob($num), $number);
}

function dob($num)
{
    return $num * 2;
}
