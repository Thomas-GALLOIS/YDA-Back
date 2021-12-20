<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Odetail;
use App\Models\User;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = Order::with('odetails')->get();
        return response()->json([
            'status_code' => 200,
            'message' => ' liste des orders',
            'donnees' => $order,
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
        $order = new Order();
        $order->user_id = $request->user_id;
        $order->comments = 'teste-lundi-midi';
        $order->firm_id = User::find(5)->getFirmId();
        $order->status = "en attente";
        $order->save();

        $products = $request->products;
        dd($request->products);
        foreach ($products as $product) {
            $odetail = new Odetail();
            $odetail->product_id = $product['id'];
            $odetail->price_product = Product::getPrice($odetail->product_id);
            $odetail->qtty = $product['quantity'];
            $odetail->order_id = $order->id;
            $odetail->comments = $product['comment'];
            $odetail->total_odetail = $odetail->qtty * $odetail->price_product;

            $odetail->save();
        }

        $order->total = Odetail::where('order_id', $order->id)->sum('price_product');
        $order->save();


        return response()->json([
            'status_code' => 200,
            "message" => "new order + odetail ok",
            "order" => $order,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $order = Order::whereId($id)->with('odetails')->get();

        //$order_id = $id;
        //$total = Order::whereId($id)
        //  ->select(DB::raw('SUM(price_product) as total'))->get();
        // dd($total);


        return response()->json([
            'status_code' => 200,
            'message' => 'orders et odetails ont été trouvés',
            'tab_firms' => $order
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
        $order = Order::whereId($id)->get();

        return response()->json([
            'status_code' => 200,
            'message' => 'Edit de order',
            'donnees' => $order,
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
        $order = Order::findOrFail($id);

        if ($order->status == "en attente") {
            $order->update($request->all());

            return response([
                'status_code' => 200,
                'message' => 'success update order',
                'donnees' => $order,
            ]);
        } else {
            return response([
                'message' => 'La commande est en cours ou terminé',
                'order->status' => $order->status,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $order = Order::findOrFail($id);
        $deleted = $order->delete();

        if ($deleted) {
            $odetail = Odetail::where('order_id', $order->id);
            $odetail->delete();
        }
        return response([
            'status_code' => 200,
            'message' => 'suppression réussie ainsi que les odetails associés'
        ], 200);
    }
}
