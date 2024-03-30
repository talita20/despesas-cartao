<?php

namespace App\Helpers;

function chechBalance($value, $currentBalance)
{
    $newBalance = $currentBalance - $value;
    if($newBalance < 0){
        return false;
    }
    return $newBalance;
}