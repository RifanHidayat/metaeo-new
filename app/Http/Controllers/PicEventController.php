<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\PicEvent;
use App\Models\PicPo;
use Exception;
use Illuminate\Http\Request;

class PicEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $picEvents = PicEvent::with(['customer'])->get();
        return view('pic-event.index', ['picEvents' => $picEvents]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::all();
        $customers = $customers->map(function ($item, $key) {
            return ['id' => $item->id, 'text' => $item->name];
        });
        
        $customers->prepend(['id' => '', 'text' => 'Choose Customer']);
        return view('pic-event.create', ['customers' => $customers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pic = new PicEvent();
        $pic->name = $request->name;
        $pic->phone = $request->phone;
        $pic->email = $request->email;
        $pic->position = $request->position;
        $pic->customer_id = $request->customer_id;

        try{
            $pic->save();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $pic,
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
        $pic = PicEvent::findOrFail($id);
        $customers = Customer::all();
        $customers = $customers->map(function ($item, $key) {
            return ['id' => $item->id, 'text' => $item->name];
        });

        $customers->prepend(['id' => '', 'text' => 'Choose Customer']);
        return view('pic-event.edit', ['picEvent' => $pic, 'customers' => $customers]);
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
        $pic = PicEvent::find($id);
        $pic->name = $request->name;
        $pic->phone = $request->phone;
        $pic->email = $request->email;
        $pic->position = $request->position;
        $pic->customer_id = $request->customer_id;

        try{
            $pic->save();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $pic,
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
        $pic = PicEvent::find($id);
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
}
