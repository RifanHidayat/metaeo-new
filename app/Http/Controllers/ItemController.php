<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\QuotationItem;
use App\Models\SubItem;
use App\Models\Goods;
use App\Models\Item;
use App\Models\Quotation;
use Exception;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::with("subitems")->get();
        $itemsCollect=collect($items)->each(function($item){
           $item['subitem_total']=collect($item->subitems)->count(); 

        });
     //   return $itemsCollect;
        return view('item.index', ['items' =>  $itemsCollect]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    
    
    
       
        return view('item.create');

    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = new Item();
        $item->name = $request->name;
        $item->type = $request->type;
        $item->is_active = $request->is_active;
        $item->is_stock=$request->is_stock;
        $item->pph_object=$request->pph_object;
        try{
            $item->save();
            
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $item,
            ]);

        } catch(Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
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
        $items = Item::findOrFail($id);
        return view('item.edit', ['item' => $items]);
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
        $item = Item::find($id);
      $item->name = $request->name;
        $item->type = $request->phone;
        $item->is_active = $request->is_active;
        $item->is_stock=$request->is_stock;
        $item->pph_object=$request->pph_object;

        try{
            $item->save();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $item,
            ]);
        } catch(Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
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
        $pic = Item::find($id);
        try {
            $pic->delete();
            return [
                'message' => 'data has been deleted',
                'error' => false,
                'code' => 200,     
            ];
        } catch (Exception $e) {
            return [
                'message' => 'internal error',
                'error' => true,
                'code' => 500,
                'errors' => $e,
            ];
        }
    }

     public function subitem($id){
        $item = Item::with('subitems')->findOrFail($id);
       // return $item;
          

         // return $items->subitems;
        return view('item.subitem.index', ['item' => $item]);

     }
     public function detail($id){
        $subitems= subitem::with('item','goods')->get()->where('item_id',$id)->values()->all();
        $subtems=collect($subitems)->each(function($item){
            $item['quantity']=0;
            $item['frequency']=1;
            $item['duration']=1;
            $item['rate']=0;
            $item['subtotal']=0;
            $item['disabled']=true;
            $item['is_checked']=false;
            $item['is_asf']=false;
            $item['is_pph23']=false;
            $item['is_pphfinal']=false;



        });
        

        return response()->json([
            'status' => 'OK',
        
            'code' => 200,
            'data'=>$subitems
        ]);
        


   }

       public function subitemStore(Request $request)
    {
        $subitem = new Subitem();
        $subitem->name = $request->name;
        $subitem->unit_quantity = $request->unit_quantity;
        $subitem->unit_frequency = $request->unit_frequency;
        $subitem->item_id = $request->item_id;
        $subitem->is_active = $request->is_active;
        $subitem->is_stock=$request->is_stock;
        $subitem->product_id=$request->product_id;


        try{
            $subitem->save();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $subitem,
            ]);
        } catch(Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }   
    }

     public function subitemCreate($id){
          $item = Item::with('subitems')->findOrFail($id);
         // return $item;

          if ($item->is_stock==0){
               //return view('item.subitem.create.nonstock', ['item' => $item]);

               $goods=Goods::with('goodsCategory')->get();
               $products = $goods->map(function ($item, $key) {
               return ['id' => $item->id, 'text' => $item->name];
               });
               $products->prepend(['id' => '', 'text' => 'Choose goods']);
                
                  return view('item.subitem.create.stock',
                   ['item' => $item ,
                   'goods'=>$goods,
                   'products'=>$products
                   
                   ]
               
               );
   

          }else{
              $goods=Goods::with('goodsCategory')->get();
            $products = $goods->map(function ($item, $key) {
            return ['id' => $item->id, 'text' => $item->name];
            });
            $products->prepend(['id' => '', 'text' => 'Choose goods']);
             
               return view('item.subitem.create.stock',
                ['item' => $item ,
                'goods'=>$goods,
                'products'=>$products
                
                ]
            
            );

          }
     }

          public function subitemEdit($item_id,$subitem_id){
       
          $item = Item::with('subitems')->findOrFail($item_id);
          $subitem=Subitem::findOrFail($subitem_id);
          if ($item->is_stock==0){
               return view('item.subitem.edit.nonstock', ['item' => $item,
               'subitem'=>$subitem
               ]);

          }else{
              $goods=Goods::with('goodsCategory')->get();
            $products = $goods->map(function ($item, $key) {
            return ['id' => $item->id, 'text' => $item->name];
            });
            $products->prepend(['id' => '', 'text' => 'Choose goods']);
            //return $products;
             
               return view('item.subitem.edit.stock',
                ['item' => $item ,
                'goods'=>$goods,
                'products'=>$products,
                'subitem'=>$subitem
                
                ]
            
            );

          }
     }
         public function subitemUpdate(Request $request,$item_id,$subitem_id)
    {
        $subitem = subitem::findOrFail($subitem_id);
       // return $subitem;

        $subitem->name = $request->name;
        $subitem->unit_quantity = $request->unit_quantity;
        $subitem->unit_frequency = $request->unit_frequency;
    
        $subitem->is_active = $request->is_active;
        $subitem->is_stock=$request->is_stock;
        $subitem->product_id=$request->product_id;


        try{
            $subitem->save();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $subitem,
            ]);
        } catch(Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }   
    }

         public function subitemDestroy($id)
    {
        return $id;
        $subitem = Subitem::find($id);
        return $subitem;
        try {
            $subitem->delete();
            return [
                'message' => 'data has been deleted',
                'error' => false,
                'code' => 200,     
            ];
        } catch (Exception $e) {
            return [
                'message' => 'internal error',
                'error' => true,
                'code' => 500,
                'errors' => $e,
            ];
        }
    }


     
  
}
