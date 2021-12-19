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
            'message' => 'Index Types',
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
        $request->validate([
            'name' => 'required|string',
        ]);

        $type = new Type();
        $type->name = $request->name;

        $type->save();

        return response()->json([
            'status_code' => 200,
            "message" => "The type was created",
            "type" => $type,

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
            'message' => 'Show the Type with yours services and products',
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
            'message' => 'Edit Type',
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
        $request->validate([
            'name' => 'required|string',
        ]);

        $type = Type::findOrFail($id);
        $type->update($request->all());
        return response([
            'status_code' => 200,
            'message' => 'Type updated',
            'Type' => $type
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
        $type = Type::findOrFail($id);
        $type->delete();

        $services = Service::all()->where('type_id', $type->id);

        foreach ($services as $service) {
            var_dump("DELET SERVICE");
            var_dump($service->name);
            $service->delete();

            $products = Product::all()->where('service_id', $service->id);

            foreach ($products as $product) {
                $product->delete();
                var_dump("DELET PRODUIT");
                var_dump($product->name);
            }
        }

        // c'est presque, mais cote vue il dit qu'il manque l'authentication ?? mais sur postman ça marche

        return response([
            'status_code' => 200,
            'message' => 'Type, Services and Products deleted'
        ], 200);
    }
}
