<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use \App\Models\LoginToken;

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
            //'password' => 'required|string|min:8|',

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

    public function showLogin()
    {
        return view('welcome');
    }

    public function login(Request $request) //update password
    {
        $data = $request->validate(['email' => ['required', 'email', 'exists:users,email']]);
        $user = User::whereEmail($data['email'])->first();
        $user->sendLoginLink(); //sendCreatePasswordLink()
        //dd($user);
        return view('auth.login', compact('user'));

        //creer la function sendLoginLink
    }

    public function verifyLogin(Request $request, $token)
    {
        $token = LoginToken::whereToken(hash('sha256', $token))->firstOrFail();
        abort_unless($request->hasValidSignature() && $token->isValid(), 401);
        $token->consume();
        dd($token->user);
        User::login($token->user);
        //Auth::login($token->user);

        return redirect('auth.login');
    }
    /*public function login(Request $request)
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
            return view('auth.login', compact('user'));
        } catch (ValidationException $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in Login',
                'error' => $error,
            ]);
        }
    }*/

    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json([
            'status_code' => 200,
            'message' => 'logout',

        ]);


        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
        //logout () remove os detalhes do usuário da sessão. Em seguida, invalidamos a sessão do usuário e, por último, regeneramos o token CSRF
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
}
