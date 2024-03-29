<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CardRequest;
use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index()
    {
        return Card::all();
    }
    
    public function show(int $card)
    {
        $cardModel = Card::find($card);
        if(empty($cardModel)){
            return response()->json(['message' => 'Usuário não encontrado'], 404);
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
}
