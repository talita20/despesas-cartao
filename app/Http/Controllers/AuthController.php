<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //16|jLPfw1gEvEirK9qQE0Ip5Dmi5IWq9puVo8leNO2fef44272a ==> ADMIN
    //17|R5QeO2kVAVPMOhpP5Qmt0F0Lfk97Z8EQUKFjigp09553c034 ==> COMUM gustavo_melo@simoesmendonca.adv.br
    //18|jSJtj68JlWBtCNjbxvtk3GN1enOBCRv8RaS91cfEb7844677 ==> COMUM erick.otavio.bernardes@recoferindustria.com.br

    use MakesHttpRequests;
    
    public function login(Request $request)
    {
        if(Auth::attempt($request->only('email','password'))) {
            $user = Auth::user();
            //$token = $user->createToken('*'); //ADMIN
            $token = $user->createToken('comum',['user.store','user.update','card.index','card.show','card.store','card.update', 'expenses.index', 'expenses.store']); //COMUM
            return response()->json($token->plainTextToken);
        }
        return response()->json(['message' => 'Not Authorized'], 403);
    }

    public static function isAdmin() {
        if(Auth::check() && Auth::user()->level == "Administrador") {
            return true;
        }
    }

    public static function getUserByToken() {
        return Auth::user();
    }
}