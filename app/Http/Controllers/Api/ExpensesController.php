<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExpensesRequest;
use App\Models\Card;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;

use function App\Helpers\chechBalance;

class ExpensesController extends Controller
{
    public function index()
    {
        if(AuthController::isAdmin() === true){
            return Expense::all();
        }
        $user_id = AuthController::getUserByToken()->id;
        return Expense::where('user_id', $user_id)->get();
    }

    public function store(ExpensesRequest $request)
    {
        $currentBalance = CardController::getCardBalance($request->card_id);
        if(chechBalance($request->value, $currentBalance) === false) {
            return response()->json(['message' => 'Saldo insuficiente para a transação'], 406);
        }

        if(empty(AuthController::isAdmin())) {
            $user_id_session = AuthController::getUserByToken()->id;
            $card = Card::find($request->card_id);

            if($user_id_session != $request->user_id || $user_id_session != $card->user_id) {
                return response()->json(['message' => 'Seu usuário não possui permissão para realizar operação.'], 403);
            }
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
