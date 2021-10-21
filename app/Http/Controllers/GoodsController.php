<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use App\Models\GoodsCategory;
use Exception;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $goods = Goods::with(['goodsCategory'])->get();
        return view('goods.index', [
            'goods' => $goods,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = GoodsCategory::all();
        return view('goods.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $goods = new Goods();
        $goods->goods_category_id = $request->category;
        $goods->number = $request->number;
        $goods->name = $request->name;
        $goods->unit = $request->unit;
        $goods->purchase_price = $request->purchase_price;
        $goods->stock = $request->stock;

        $goodsWithNumber = Goods::where('number', $request->number)->first();
        if ($goodsWithNumber !== null) {
            return response()->json([
                'message' => 'number or code already used',
                'code' => 400,
                // 'errors' => $/e,
            ], 400);
        }

        try {
            $goods->save();

            return response()->json([
                'message' => 'data has been saved',
                'data' => $goods,
                'code' => 200,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'internal error',
                'code' => 500,
                'errors' => $e,
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $goods = Goods::findOrFail($id);
        $categories = GoodsCategory::all();
        return view('goods.edit', [
            'goods' => $goods,
            'categories' => $categories,
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
        try {
            $goods = Goods::findOrFail($id);
            $goods->delete();
            return response()->json([
                'message' => 'data has been saved',
                'data' => $goods,
                'code' => 200,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'internal error',
                'code' => 500,
                'errors' => $e,
            ], 500);
        }
    }
}
