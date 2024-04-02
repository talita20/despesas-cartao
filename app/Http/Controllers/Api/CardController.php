<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Requests\CardRequest;
use App\Models\Card;
use App\Models\User;

use function App\Helpers\checkFormatDate;

class CardController extends Controller
{
    public function index()
    {
        if(AuthController::isAdmin() === true){
            return Card::all();
        }
        $user_id = AuthController::getUserByToken()->id;
        return Card::where('user_id', $user_id)->get();
    }
    
    public function show(int $card_id)
    {
        $card = Card::find($card_id);
        if(empty($card)){
            return response()->json(['message' => 'Cartão não encontrado.'], 404);
        }
        if(AuthController::isAdmin() === true){
            return $card;
        }
        $user_id = AuthController::getUserByToken()->id;
        if($card->user_id != $user_id){
            return response()->json(['message' => 'Seu usuário não possui permissão para acessar os dados.'], 403);
        }
        return $card;
    }

    public function store(CardRequest $request)
    {
        $user_id = User::find($request->user_id);
        if(empty($user_id)){
            return response()->json(['message' => 'Usuário do cartão não encontrado.'], 404);
        }
        if(checkFormatDate($request->expire_date) === false) {
            return response()->json(['message' => 'Data de expiração do cartão inválida.'], 406);
        }
        Card::create($request->all());
        return response()->json($request->all(), 201);       
    }
    
    public function update(Card $card, CardRequest $request)
    {
        if(AuthController::isAdmin() === true){
            $card->fill($request->all());
            $card->save();
            return response()->json($request->all(), 201);
        }
        $user_id_session = AuthController::getUserByToken()->id;
        if($user_id_session != $card->user_id) {
            return response()->json(['message' => 'Seu usuário não possui permissão para editar os dados.'], 403);
        }
        $card->fill($request->all());
        $card->save();
        return response()->json($request->all(), 201);
    }

    public function destroy(int $card)
    {
        if(AuthController::isAdmin() === true){
            Card::destroy($card);
            return response()->noContent();
        }
        return response()->json(['message' => 'Seu usuário não possui permissão para executar operação.'], 403);
    }

    public static function getCardBalance(int $card_id)
    {
        $balance = Card::find($card_id)->current_balance;
        if(empty($balance)){
            return response()->json(['message' => 'Cartão não encontrado'], 404);
        }
        return $balance;
    }

    public static function updatebalance(int $card_id, $newBalance)
    {
        $card = Card::find($card_id);
        $card->current_balance = $newBalance;
        $card->save();

        return response()->json(['message' => 'Transação concluída com sucesso.'], 200);
    }
}
