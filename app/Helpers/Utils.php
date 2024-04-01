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

function formatDocument($document){
    if(empty($document)) {
        return false;
    }
    return str_replace(array('.', ',', '-', '/', '_'), '', trim($document));
}

function checkDocument($document)
{
    if (empty($document)) {
        return false;
    }

    $document = preg_replace("/[^0-9]/", "", $document);

    if (strlen($document) <= 11) {
        $cpf = str_pad($document, 11, '0', STR_PAD_LEFT);

        if (
            $cpf == '00000000000' ||
            $cpf == '11111111111' ||
            $cpf == '22222222222' ||
            $cpf == '33333333333' ||
            $cpf == '44444444444' ||
            $cpf == '55555555555' ||
            $cpf == '66666666666' ||
            $cpf == '77777777777' ||
            $cpf == '88888888888' ||
            $cpf == '99999999999'
        ) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * ( ( $t + 1 ) - $c );
            }
            $d = ( ( 10 * $d ) % 11 ) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return $cpf;
    } else {
        $cnpj = str_pad($document, 14, '0', STR_PAD_LEFT);
        if (
            $cnpj == '00000000000000' ||
            $cnpj == '11111111111111' ||
            $cnpj == '22222222222222' ||
            $cnpj == '33333333333333' ||
            $cnpj == '44444444444444' ||
            $cnpj == '55555555555555' ||
            $cnpj == '66666666666666' ||
            $cnpj == '77777777777777' ||
            $cnpj == '88888888888888' ||
            $cnpj == '99999999999999'
        ) {
            return false;
        }

        $j = 5;
        $k = 6;
        $soma1 = "";
        $soma2 = "";

        for ($i = 0; $i < 13; $i++) {
            $j = $j == 1 ? 9 : $j;
            $k = $k == 1 ? 9 : $k;
            $soma2 += ( $cnpj[$i] * $k );
            if ($i < 12) {
                $soma1 += ($cnpj[$i] * $j);
            }
            $k--;
            $j--;
        }
        $digito1 = $soma1 % 11 < 2 ? 0 : 11 - $soma1 % 11;
        $digito2 = $soma2 % 11 < 2 ? 0 : 11 - $soma2 % 11;

        if (( $cnpj[12] == $digito1 ) && ( $cnpj[13] == $digito2 )) {
            return $cnpj;
        } else {
            return false;
        }
    }
}

function checkFormatDate($expireDate) 
{
    if(empty($expireDate)) {
        return false;
    }

    $month = substr($expireDate, 0, 2);
    $year = substr($expireDate, 3, 4);
    if($month < 1 || $month > 12 || $year < date("y")) {
        return false;
    }
    return true;
}
