<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    // methode d'inscription
    public function InscrisUtilisateur(Request $request)
    {
        $request->validate([
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|',

        ]);

        $utilisateur = new User();

        $utilisateur->firstname = $request->firstname;
        $utilisateur->lastname = $request->lastname;
        $utilisateur->phone = $request->phone;
        $utilisateur->email =   $request->email;
        $utilisateur->password  = Hash::make('12345678');
        $utilisateur->role = $request->role;
        $utilisateur->firm_id = $request->firm_id;



        $utilisateur->save();

        return response()->json([
            'msg' => 'Utilisateur creation reussie',
            'status_code' => 200,
            'utilisateur' => $utilisateur
        ]);
    }

    // methode d'authentification

    public function connexion(Request $request)
    {
        try {
            $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            $credentials = request(['email', 'password']);

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'non autorisé'
                ]);
            }

            $user = User::where('email', $request->email)->first();

            $tokenResult = $user->createToken('authToken')->plainTextToken;
            $role = $user->role;

            return response()->json([
                'status_code' => 200,
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'role' => $role,

            ]);
        } catch (ValidationException $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in Login',
                'error' => $error,
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        //logout () remove os detalhes do usuário da sessão. Em seguida, invalidamos a sessão do usuário e, por último, regeneramos o token CSRF
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
}
