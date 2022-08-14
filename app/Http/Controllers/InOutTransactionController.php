<?php

namespace App\Http\Controllers;

use App\Models\InOutTransaction;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;

class InOutTransactionController extends Controller
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
        $dataCount = InOutTransaction::query()->where('date', date("Y-m-d"))->get()->count();
        $number = 'IO' . '-' . date('d') . date('m') . date("y") . sprintf('%04d', $dataCount + 1);

        $transaction = new InOutTransaction;
        $transaction->number = $number;
        $transaction->date = $request->date;
        $transaction->in_account = $request->in_account;
        $transaction->out_account = $request->out_account;
        $transaction->description = $request->description;
        $transaction->amount = $this->clearThousandFormat($request->amount);

        try {
            $transaction->save();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $transaction,
            ]);
        } catch (Exception $e) {
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

    private function clearThousandFormat($number)
    {
        return str_replace(".", "", $number);
    }
}
