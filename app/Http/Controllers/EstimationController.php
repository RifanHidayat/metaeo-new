<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Estimation;
use Illuminate\Http\Request;

class EstimationController extends Controller
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
        $customers = Customer::all();
        $customersAll = $customers;
        $customers = $customers->map(function ($item, $key) {
            return ['id' => $item->id, 'text' => $item->name];
        });
        $customers->prepend(['id' => '', 'text' => 'Choose Customer']);
        return view('estimation.create', ['customers' => $customers, 'customers_all' => $customersAll]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $table->string('number', 30);
        //     $table->date('date');
        //     $table->foreignId('pic_po_id')
        //     $table->string('work', 255);
        //     $table->integer('quantity');
        //     $table->bigInteger('production');
        //     $table->bigInteger('hpp');
        //     $table->bigInteger('hpp_per_unit');
        //     $table->bigInteger('price_per_unit');
        //     $table->integer('margin');
        //     $table->bigInteger('total_price');
        //     $table->bigInteger('ppn');
        //     $table->bigInteger('pph');
        //     $table->bigInteger('total_bill');
        //     $table->date('delivery_date');
        //     $table->string('file', 255)->nullable();
        //     $table->string('status', 255)->default('open');
        //     $table->tinyInteger('final')->default(0);
        $estimation = new Estimation;
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
