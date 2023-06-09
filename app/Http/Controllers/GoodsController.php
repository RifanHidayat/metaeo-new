<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Goods;
use App\Models\unit;
use App\Models\GoodsCategory;
use App\Models\GoodsSubCategory;
use App\Models\PphRate;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
       
        $units=Unit::all();
        return view('goods.index', [
            'goods' => $goods,
            'units'=>$units
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
        $subCategories = GoodsSubCategory::all();
        $units=Unit::all();
         $pphRate=PphRate::all();
         $accounts=Account::all();
       
       // return $units;
        return view('goods.create', [
            'categories' => $categories,
            'sub_categories'=>$subCategories,
            'units'=>$units,
            'pph_rate'=>$pphRate,
            'accounts'=>$accounts
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
        DB::beginTransaction();
          if (strlen($request->number) < 15) {
            return response()->json([
                'message' => 'Kode produk diisi dengan 15 karakter',
                'code' => 400,
                // 'errors' => $/e,
            ], 400);
        }



        
        $goods = new Goods();
        $goods->goods_category = $request->category;
        $goods->goods_category_id = $request->category;
        $goods->number = $request->number;
        $goods->name = $request->name;
        $goods->unit = $request->unit;
        $goods->purchase_price = $request->purchase_price;
        $goods->goods_sub_category_id= $request->goods_sub_category_id ;
        $goods->pph_rate_id= $request->type=="persediaan"?0:$request->pph_rate_id;
        $goods->type=$request->type;
        $goods->pph=$request->type=="persediaan"?0:0;
        $goods->expense_account=$request->expense_account;
        $goods->sales_account=$request->sales_account;
        $goods->discount_sales_account=$request->discount_sales_account;
        $goods->purchases_unbilled_account=$request->purchases_unbilled_account;
        $goods->stock = "0";



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
            DB::commit();
            return response()->json([
                'message' => 'data has been saved',
                'data' => $goods,
                'code' => 200,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
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
        $units=Unit::all();
        return view('goods.edit', [
            'goods' => $goods,
            'categories' => $categories,
             'units'=>$units,
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

          //return $request->all();
        $goods = Goods::findOrFail($id);
        $goods->goods_category = $request->category;
        $goods->number = $request->number;
        $goods->name = $request->name;
        $goods->unit = $request->unit;
        $goods->purchase_price = $request->purchase_price;
        $goods->type=$request->type;
        $goods->is_active=$request->is_active;
        $goods->pph=$request->type=="persedian"?0:$request->pph;
        $goods->stock = "0";

        // $goodsWithNumber = Goods::where('number', $request->number)->first();
        // if ($goodsWithNumber !== null) {
        //     return response()->json([
        //         'message' => 'number or code already used',
        //         'code' => 400,
        //         // 'errors' => $/e,
        //     ], 400);
        // }

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
