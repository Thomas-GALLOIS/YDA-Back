<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Odetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        $order->total = $request->total;
        $order->comments = $request->comments;
        $order->user_id = $request->user_id;


        $order->save();

        /* return response()->json([
            'status_code' => 200,
            "message" => "new order ok",
            "produits" => $order,
        ], 201);*/
        $odetail = new Odetail();

        $odetail->product_id = '1';
        $odetail->price_product = '10';
        $odetail->order_id = $order->id;

        $odetail->save($request->all());

        $odetail2 = new Odetail();

        $odetail2->product_id = '2';
        $odetail2->price_product = '15';
        $odetail2->order_id = $order->id;

        $odetail2->save($request->all());

        return response()->json([
            'status_code' => 200,
            "message" => "new odetail ok",
            "produits" => $odetail, $odetail2
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


        return response()->json([
            'status_code' => 200,
            'message' => 'orders et odetails ont été trouvés',
            'tab_firms' => $order,
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
