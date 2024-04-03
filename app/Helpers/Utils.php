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

function checkTypeDocument($document)
{
    if(empty($document)) {
        return false;
    }
    if(strlen($document) == 11){
        return checkDocumentCpf($document);
    }
    if(strlen($document) == 14){
        return checkDocumentCnpj($document);
    }
    return false;

}

function checkDocumentCpf($cpf)
{
    if(empty($cpf)) {
        return false;
    }
    
    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
     
    if (strlen($cpf) != 11) {
        return false;
    }

    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}

function checkDocumentCnpj($cnpj)
{
    if(empty($cnpj)) {
        return false;
    }

    $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

    if (strlen($cnpj) != 14) {
        return false;
    }

    if (preg_match('/(\d)\1{13}/', $cnpj)) {
        return false;
    }

    $b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    for ($i = 0, $n = 0; $i < 12; $n += $cnpj[$i] * $b[++$i]);
        if ($cnpj[12] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }
    
    for ($i = 0, $n = 0; $i <= 12; $n += $cnpj[$i] * $b[$i++]);
        if ($cnpj[13] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }
    
    return true;
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

function getLastFourDigitsCard($card)
{
    if(empty($card)) {
        return false;
    }
    return substr($card, -4);
}
