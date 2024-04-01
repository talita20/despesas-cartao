<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;

use function App\Helpers\formatDocument;
use function App\Helpers\checkDocument;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['index','show','update']);
    }

    public function index()
    {
        return User::all();
    }
    
    public function show(int $user)
    {
        $userModel = User::find($user);
        if(empty($userModel)){
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }
        return $userModel;
    }

    public function store(UserRequest $request)
    {
        if(checkDocument(formatDocument($request->document)) === false) {
            return response()->json(['message' => 'Documento inválido'], 406);
        }

        User::create($request->all());
        return response()->json($request->all(), 201);       
    }
    
    public function update(User $user, UserRequest $request)
    {
        $user->fill($request->all());
        $user->save();
        return response()->json($request->all(), 201);
    }
}
