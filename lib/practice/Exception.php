<?php

class CurrencyCal
{
    private const CURRENCIES = ['dollar', 'pound'];
    public static function calculateToYen($amount, $currency)
    {
        try {
            self::convert($amount, $currency);
        } catch (EXception $e) {
            echo '例外: ' . $e->getMessage() . PHP_EOL;
        }
    }

    private static function convert($amount, $currency)
    {
        if (!in_array($currency, self::CURRENCIES)) {
            throw new Exception('対応していない通過です');
        }
        echo $amount . '円を' . $currency . 'に変換します' . PHP_EOL;
    }
}

CurrencyCal::calculateToYen(100, 'japaneseYen');
