<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Odetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = Order::all();
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
        $order->user_id = $request->user_id; // vaut mieux prendre Auth de l'utilisateur logado
        $order->comments = 'teste-order-dim-soir';
        $order->save();

        $products = $request->products;
        //dd($request->products);
        foreach ($products as $product) {
            $odetail = new Odetail();
            $odetail->product_id = $product['id'];
            $odetail->price_product = 300.00;
            $odetail->qtty = $product['quantity'];
            $odetail->order_id = $order->id;
            $odetail->comments = 'teste-odetail-dim-soir';
            $odetail->save();
        }

        /* var_dump("values=> ");
        dd($request->cart);
        array_push($values, $unit);

        array_push($values, $unit);
        $fakerequest = [ //comme si cetait la vrai request
            0 => [
                "product_id" => "4",
                "price" => "4",
                "quantity" => "3"
            ],
            1 => [
                "product_id" => "4",
                "price" => "4",
                "quantity" => "3"
            ]
        ];

        $order->user_id = 1; //en vrai cest $request->user_id;
        $result = $order->save();

        if ($result) {
            $order->odetails()->saveMany($fakerequest);
        }


        // $odetails = $request->products;
        /*
        dd($request->cart);
        $donnes = $request->cart;
        return response()->json([
            'status_code' => 200,
            "message" => "teste",
            "request" => $donnes,
        ], 201);
        dd($request);

        //$odetail->save($request->all());
        /*
        $odetail2 = new Odetail();

        $odetail2->product_id = '2';
        $odetail2->price_product = Product::where('id', $odetail->product_id)->value('price');
        $odetail2->qtty = 3;
        $odetail2->total_odetail = $odetail2->qtty * $odetail2->price_product;
        $odetail2->order_id = $order->id;

        $odetail2->save($request->all());
*/

        //$order->total = Odetail::where('id', $order->id)->sum('price_product');


        //$order->total->save($total);


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
        if ($order) {
            $order->delete();
            return response([
                'status_code' => 200,
                'message' => 'success delete order'
            ], 200);
        } else {
            return response([
                'message' => 'The order don\'t exist'
            ], 200);
        }
    }
}
