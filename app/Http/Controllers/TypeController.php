<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\Service;
use App\Models\Product;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type = Type::all();
        return response()->json([
            'status_code' => 200,
            'message' => 'Types',
            'donnees' => $type,
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
        $type = new Type();
        $type->name = $request->name;

        $type->save();

        return response()->json([
            'status_code' => 200,
            "message" => "creation de type réussi",
            "services" => $type,

        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $type = Type::whereId($id)->with('services.products')->get();

        return response()->json([
            'status_code' => 200,
            'message' => 'Type, Service et produits associés',
            'donnees' => $type,
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
        $type = Type::whereId($id)->get();

        return response()->json([
            'status_code' => 200,
            'message' => 'Edit du type',
            'donnees' => $type,
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
        $type = Type::findOrFail($id);
        $type->update($request->all());
        return response([
            'status_code' => 200,
            'message' => 'mise a jour du type réussie',
            'donnees' => $type
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
        $type = Type::findOrFail($id)->with('services, products');

        $type->delete();


        /*
        if ($deleted) {
            $service = Service::where('type_id', $type->id);
            dd($service->id);

            $deleted2 = $service->delete();

            if ($deleted2) {
                $product = Product::whereId('service_id', $service->id);
                $product->delete();
            }
        }*/

        return response([
            'status_code' => 200,
            'message' => 'suppression Type réussie'
        ], 200);
    }
}
