<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();
        return response()->json([
            'status_code' => 200,
            'message' => 'liste des Users',
            'donnees' => $user,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::whereId($id)->with('orders')->get();

        return response()->json([
            'status_code' => 200,
            'message' => 'Données du user + orders',
            'donnees' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::whereId($id)->get();

        return response()->json([
            'status_code' => 200,
            'message' => 'Affichage du user',
            'donnees' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /*$request->validate([

            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%#?&]/'
            ]
        ]);*/


        $user = User::findOrFail($id);

        /*$user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->birthday = $request->birthday;
        $user->phone = $request->phone;
        $user->email =  $request->email;
        $user->role = $request->role;
        $user->firm_id = $request->firm_id;*/

        // $user->password = Hash::make($request->password);
        // $user->update();

        $user->update($request->all());

        return response([
            'status_code' => 200,
            'message' => 'mise a jour du profil user réussie',
            'donnees' => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response([
            'status_code' => 200,
            'message' => 'suppression réussie du user'
        ], 200);
    }
}
