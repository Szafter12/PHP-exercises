<?php

namespace App;

class Helpers
{
    public static function dd($data)
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        die();
    }

    public static function format_amount($amount)
    {
        return number_format($amount, 2) . '$';
    }

    public static function get_total_income($transactions)
    {
        $income = 0;
        foreach ($transactions as $transaction) {
            if ($transaction['amount'] > 0) {
                $income += $transaction['amount'];
            }
        }
        return $income;
    }

    public static function get_total_expense($transactions)
    {
        $expense = 0;
        foreach ($transactions as $transaction) {
            if ($transaction['amount'] < 0) {
                $expense += $transaction['amount'];
            }
        }
        return $expense;
    }

    public static function get_net_total($transactions)
    {
        return self::get_total_income($transactions) + self::get_total_expense($transactions);
    }

    public static function format_data($data) {
        return date('M d Y', strtotime($data));
    }

}
