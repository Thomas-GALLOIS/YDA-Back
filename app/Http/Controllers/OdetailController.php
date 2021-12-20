<?php

namespace App\Http\Controllers;

use App\Models\Odetail;
use Illuminate\Http\Request;

class OdetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $odetail = Odetail::all();
        return response()->json([
            'status_code' => 200,
            'message' => ' liste des orders',
            'donnees' => $odetail,
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
        $odetail = Odetail::whereId($id)->get();

        //$order_id = $id;
        //$total = Order::whereId($id)
        //  ->select(DB::raw('SUM(price_product) as total'))->get();
        // dd($total);


        return response()->json([
            'status_code' => 200,
            'message' => 'details ont été trouvés',
            'tab_firms' => $odetail
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
        $odetail = Odetail::whereId($id)->get();

        return response()->json([
            'status_code' => 200,
            'message' => 'Edit de odetail',
            'donnees' => $odetail,
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
        $odetail = Odetail::findOrFail($id);
        $odetail->update($request->all());
        return response([
            'status_code' => 200,
            'message' => 'mise a jour du odetail',
            'donnees' => $odetail
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
        $odetail = Odetail::findOrFail($id);
        if ($odetail) {
            $odetail->delete();
            return response([
                'status_code' => 200,
                'message' => 'success delete odetail'
            ], 200);
        } else {
            return response([
                'message' => 'The odetail don\'t exist'
            ], 200);
        }
    }
}
