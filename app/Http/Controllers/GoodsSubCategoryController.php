<?php

namespace App\Http\Controllers;

use App\Models\GoodsSubCategory;
use Exception;
use Illuminate\Http\Request;

class GoodsSubCategoryController extends Controller
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
        //

        $category = new GoodsSubCategory();
        $category->name = $request->name;

        try {
            $category->save();

            return response()->json([
                'message' => 'data has been saved',
                'data' => $category,
                'code' => 200,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'internal error',
                'code' => 500,
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GoodsSubCategory  $goodsSubCategory
     * @return \Illuminate\Http\Response
     */
    public function show(GoodsSubCategory $goodsSubCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GoodsSubCategory  $goodsSubCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(GoodsSubCategory $goodsSubCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GoodsSubCategory  $goodsSubCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GoodsSubCategory $goodsSubCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GoodsSubCategory  $goodsSubCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(GoodsSubCategory $goodsSubCategory)
    {
        //
    }
}
