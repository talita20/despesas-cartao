<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpensesRequest;
use App\Models\Expense;

use function App\Helpers\chechBalance;

class ExpensesController extends Controller
{
    public function index()
    {
        return Expense::all();
    }

    public function store(ExpensesRequest $request)
    {
        $currentBalance = CardController::getCardBalance($request->card_id);
        if(chechBalance($request->value, $currentBalance) === false) {
            return response()->json(['message' => 'Saldo insuficiente para a transação'], 406);
        }

        //init transaction 
        if(Expense::create($request->all()) === false) {
            //rollback transaction
            return response()->json(['message' => 'Erro ao realizar operação.'], 406);
        }
        $newBalance = $currentBalance - $request->value;
        if(CardController::updatebalance($request->card_id, $newBalance) === false) {
            //rollback transaction
            return response()->json(['message' => 'Erro ao realizar operação.'], 406);
        }
        //envia email
        //commit transaction
        
        return response()->json(['message' => 'Transação concluída com sucesso.'], 200);     
    }
}
