<?php

namespace App\Http\Controllers;

use App\Mail\Expenses;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public static function store(array $request)
    {
        Mail::to($request['emails'])->send(new Expenses([
            'fromName' => 'Teste Onfly',
            'fromEmail' => 'test_email_onfly@test.com.br',
            'subject' => $request['subject'],
            'message' => 'Uma nova despesa foi cadastrada no cartão de final ' . $request['final_card'] . ' Valor: R$ ' . $request['value'] . '.'
        ]));
    }
}
