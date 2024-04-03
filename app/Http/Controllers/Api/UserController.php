<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;

use function App\Helpers\checkTypeDocument;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['index','show','update']);
    }

    public function index()
    {
        if(AuthController::isAdmin() === true){
            return User::all();
        }
        return response()->json(['message' => 'Seu usuário não possui permissão para acessar os dados.'], 403);
    }
    
    public function show(int $user_id)
    {
        if(AuthController::isAdmin() === true){
            $user = User::find($user_id);
            if(empty($user)){
                return response()->json(['message' => 'Usuário não encontrado.'], 404);
            }
            return $user;
        }
        return response()->json(['message' => 'Seu usuário não possui permissão para acessar os dados.'], 403);
    }

    public function store(UserRequest $request)
    {
        if(checkTypeDocument($request->document) === false) {
            return response()->json(['message' => 'Documento inválido.'], 422);
        }

        User::create($request->all());
        return response()->json($request->all(), 201);       
    }
    
    public function update(User $user, UserRequest $request)
    {
        if(AuthController::isAdmin() === true){
            $user->fill($request->all());
            $user->save();
            return response()->json($request->all(), 201);
        }

        $user_id = AuthController::getUserByToken()->id;
        if($user_id != $user->id) {
            return response()->json(['message' => 'Seu usuário não possui permissão para editar os dados.'], 403);
        }
        $user->fill($request->all());
        $user->save();
        return response()->json($request->all(), 201);
    }

    public static function getEmailAllAdmins()
    {
        $emails = User::where('level', 'Administrador')->get('email');
        $emailList = array();
        foreach ($emails as $e) {
            array_push($emailList, $e->email);
        }
        return $emailList;
    }
}
