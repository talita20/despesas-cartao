<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpensesRequest;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;

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
        
        DB::beginTransaction();
        if(Expense::create($request->all()) === false) {
            DB::rollback();
            return response()->json(['message' => 'Erro ao realizar operação.'], 406);
        }
        $newBalance = $currentBalance - $request->value;
        if(CardController::updatebalance($request->card_id, $newBalance) === false) {
            DB::rollback();
            return response()->json(['message' => 'Erro ao realizar operação.'], 406);
        }
        DB::commit();
        //envia email
        return response()->json(['message' => 'Transação concluída com sucesso.'], 200);     
    }
}
