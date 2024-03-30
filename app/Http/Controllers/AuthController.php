<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if(Auth::attempt($request->only('email','password'))) {
            $user = Auth::user();
            $token = $user->createToken('token');

            return response()->json($token->plainTextToken);
            /*return $this->response('Authorized', 200, [
                'token' => $request->user()->createToken(['*'])->plainTextToken //ADMIN
                //'token' => $request->user()->createToken('comum',['user.store','user.update','card.index','card.show','card.store','card.update'])->plainTextToken
            ]);*/
        }
        return $this->response('Not Authorized', 403);
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
