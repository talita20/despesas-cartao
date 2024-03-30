<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Requests\CardRequest;
use App\Models\Card;

class CardController extends Controller
{
    public function index()
    {
        if(AuthController::isAdmin() === true){
            return Card::all();
        }
        $user_id = AuthController::getUserByToken()->id;
        return Card::whereIn('user_id', $user_id);
    }
    
    public function show(int $card)
    {
        $cardModel = Card::find($card);
        if(empty($cardModel)){
            return response()->json(['message' => 'Cartão não encontrado'], 404);
        }
        return $cardModel;
    }

    public function store(CardRequest $request)
    {
        Card::create($request->all());
        return response()->json($request->all(), 201);       
    }
    
    public function update(Card $card, CardRequest $request)
    {
        $card->fill($request->all());
        $card->save();
        return response()->json($request->all(), 201);
    }

    public function destroy(int $card)
    {
        Card::destroy($card);
        return response()->noContent();
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
