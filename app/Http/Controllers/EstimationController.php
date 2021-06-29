<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Estimation;
use App\Models\EstimationDigitalItem;
use App\Models\EstimationOffsetItem;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $estimationsByCurrentDateCount = Estimation::query()->where('date', date("Y-m-d"))->get()->count();

        $estimationNumber = 'NT-' . date('d') . date('m') . date("y") . sprintf('%04d', $estimationsByCurrentDateCount + 1);

        return view('estimation.create', [
            'customers' => $customers,
            'customers_all' => $customersAll,
            'estimation_number' => $estimationNumber
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
        $estimation->number = $request->number;
        $estimation->date = $request->date;
        $estimation->pic_po_id = $request->pic_po_id;
        $estimation->work = $request->work;
        $estimation->quantity = $this->clearThousandFormat($request->quantity);
        $estimation->production = $this->clearThousandFormat($request->production);
        $estimation->hpp = $this->clearThousandFormat($request->hpp);
        $estimation->hpp_per_unit = $this->clearThousandFormat($request->hpp_per_unit);
        $estimation->price_per_unit = $this->clearThousandFormat($request->price_per_unit);
        $estimation->margin = $this->clearThousandFormat($request->margin);
        $estimation->total_price = $this->clearThousandFormat($request->total_price);
        $estimation->ppn = $this->clearThousandFormat($request->ppn);
        // $estimation->pph = $this->clearThousandFormat($request->pph);
        $estimation->pph = 0;
        $estimation->total_bill = $this->clearThousandFormat($request->total_bill);
        $estimation->delivery_date = $request->delivery_date;
        // $estimation->status = $request->status;
        $estimation->status = "open";

        try {
            $estimation->save();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'internal error',
                'error' => true,
                'code' => 500,
                'errors' => $e->getMessage(),
            ], 500);
        }

        if (count($request->offsetItems) > 0) {
            // collect($request->offsetItems)->each(function ($offset, $key) use ($estimation) {
            foreach ($request->offsetItems as $offset) {
                $offsetItem = new EstimationOffsetItem;
                $offsetItem->item = $offset['item'];
                // *NEED TO CHANGE
                // $offsetItem->machine_id = $offset['machineType'];
                $offsetItem->machine_id = 0;
                $offsetItem->size_opened_p = $offset['sizeOpenedP'];
                $offsetItem->size_opened_l = $offset['sizeOpenedL'];
                $offsetItem->size_closed_p = $offset['sizeClosedP'];
                $offsetItem->size_closed_l = $offset['sizeClosedL'];
                $offsetItem->color_1 = $offset['color1'];
                $offsetItem->color_2 = $offset['color2'];
                // *NEED TO CHANGE
                // $offsetItem->paper_id = $offset['paperType'];
                $offsetItem->paper_id = 0;
                $offsetItem->paper_size_plano_p = $offset['paperSizePlanoP'];
                $offsetItem->paper_size_plano_l = $offset['paperSizePlanoL'];
                $offsetItem->paper_gramasi = $offset['paperGramasi'];
                $offsetItem->paper_price = $this->clearThousandFormat($offset['paperPricePerKg']);
                $offsetItem->paper_quantity_plano = $this->clearThousandFormat($offset['paperQuantityPlano']);
                $offsetItem->paper_cutting_size_p = $offset['paperCuttingSizeP'];
                $offsetItem->paper_cutting_size_l = $offset['paperCuttingSizeL'];
                $offsetItem->paper_cutting_size_plano_p = $offset['paperSizePlanoDivCuttingSizeP'];
                $offsetItem->paper_cutting_size_plano_l = $offset['paperSizePlanoDivCuttingSizeL'];
                $offsetItem->paper_quantity = $this->clearThousandFormat($offset['paperQuantity']);
                $offsetItem->paper_unit_price = $this->clearThousandFormat($offset['paperUnitPrice']);
                $offsetItem->paper_total = $this->clearThousandFormat($offset['paperTotal']);
                $offsetItem->plat_film_quantity_set = $this->clearThousandFormat($offset['filmQuantitySet']);
                $offsetItem->plat_film_unit_price = $this->clearThousandFormat($offset['filmUnitPrice']);
                $offsetItem->plat_film_total = $this->clearThousandFormat($offset['filmTotal']);
                $offsetItem->app_set_design = $this->clearThousandFormat($offset['appSetDesign']);
                // *NEED TO CHANGE
                // $offsetItem->print_type_id = $offset['printingType'];
                $offsetItem->print_type_id = 0;
                $offsetItem->print_quantity = $this->clearThousandFormat($offset['printingQuantity']);
                $offsetItem->print_min_price = $this->clearThousandFormat($offset['printingMinPrice']);
                $offsetItem->print_druk_price = $this->clearThousandFormat($offset['printingDrukPrice']);
                $offsetItem->print_total = $this->clearThousandFormat($offset['printingDrukPrice']);
                $offsetItem->print_total = $this->clearThousandFormat($offset['printingTotal']);
                $offsetItem->finishing_item = $this->clearThousandFormat($offset['finishingItem']);
                $offsetItem->finishing_qty = $this->clearThousandFormat($offset['finishingQuantity']);
                $offsetItem->finishing_unit_price = $this->clearThousandFormat($offset['finishingUnitPrice']);
                $offsetItem->finishing_total = $this->clearThousandFormat($offset['finishingTotal']);
                $offsetItem->estimation_id = $estimation->id;
                $offsetItem->created_at = Carbon::now()->toDateTimeString();
                $offsetItem->updated_at = Carbon::now()->toDateTimeString();

                try {
                    $offsetItem->save();
                } catch (Exception $e) {
                    return response()->json([
                        'message' => 'internal error',
                        'error' => true,
                        'code' => 500,
                        'errors' => $e->getMessage(),
                    ], 500);
                }

                if (isset($offset['subFinishingItems']) && count($offset['subFinishingItems']) > 0) {
                    $offsetSubItems = collect($offset['subFinishingItems'])->map(function ($offsetSubItem, $key) use ($offsetItem) {
                        return [
                            'finishing_item' => $this->clearThousandFormat($offsetSubItem['item']),
                            'finishing_qty' => $this->clearThousandFormat($offsetSubItem['quantity']),
                            'finishing_unit_price' => $this->clearThousandFormat($offsetSubItem['unitPrice']),
                            'finishing_total' => $this->clearThousandFormat($offsetSubItem['total']),
                            'estimation_offset_item_id' => $offsetItem->id,
                            'created_at' => Carbon::now()->toDateTimeString(),
                            'updated_at' => Carbon::now()->toDateTimeString(),
                        ];
                    })->all();

                    try {
                        DB::table('estimation_offset_sub_items')->insert($offsetSubItems);
                    } catch (Exception $e) {
                        return response()->json([
                            'message' => 'internal error',
                            'error' => true,
                            'code' => 500,
                            'errors' => $e->getMessage(),
                        ], 500);
                    }
                }



                // return [
                //     'item' => $offset->item,
                //     'machine_id' => $offset->machineType,
                //     'size_opened_p' => $offset->sizeOpenedP,
                //     'size_opened_l' => $offset->sizeOpenedL,
                //     'size_close_p' => $offset->sizeCloseP,
                //     'size_close_l' => $offset->sizeCloseL,
                //     'color_1' => $offset->color1,
                //     'color_2' => $offset->color2,
                //     'paper_id' => $offset->paperType,
                //     'paper_size_plano_p' => $offset->paperSizePlanoP,
                //     'paper_size_plano_l' => $offset->paperSizePlanoL,
                //     'paper_gramasi' => $offset->paperGramasi,
                //     'paper_price' => $offset->paperPricePerKg,
                //     'paper_quantity_plano' => $offset->paperQuantityPlano,
                //     'paper_cutting_size_p' => $offset->paperCuttingSizeP,
                //     'paper_cutting_size_l' => $offset->paperCuttingSizeL,
                //     'paper_cutting_size_plano_p' => $offset->paperSizePlanoDivCuttingSizeP,
                //     'paper_cutting_size_plano_l' => $offset->paperSizePlanoDivCuttingSizeL,
                //     'paper_quantity' => $offset->paperQuantity,
                //     'paper_unit_price' => $offset->paperUnitPrice,
                //     'paper_total' => $offset->paperTotal,
                //     'plat_film_quantity_set' => $offset->filmQuantitySet,
                //     'plat_film_unit_price' => $offset->filmUnitPrice,
                //     'plat_film_total' => $offset->filmTotal,
                //     'app_set_design' => $offset->appSetDesign,
                //     'print_type_id' => $offset->printingType,
                //     'print_quantity' => $offset->printingQuantity,
                //     'print_min_price' => $offset->printingMinPrice,
                //     'print_druk_price' => $offset->printingDrukPrice,
                //     'print_total' => $offset->printingDrukPrice,
                //     'print_total' => $offset->printingTotal,
                //     'finishing_item' => $offset->finishingItem,
                //     'finishing_qty' => $offset->finishingQuantity,
                //     'finishing_unit_price' => $offset->finishingUnitPrice,
                //     'finishing_total' => $offset->finishingTotal,
                //     'estimation_id' => $estimation->id,
                //     'created_at' => Carbon::now()->toDateTimeString(),
                //     'updated_at' => Carbon::now()->toDateTimeString(),
                // ];
            };
        }


        if (count($request->digitalItems) > 0) {
            foreach ($request->digitalItems as $digital) {
                $digitalItem = new EstimationDigitalItem;
                $digitalItem->item = $digital['item'];
                // *NEED TO CHANGE
                // $digitalItem->paper_id = $digital['paper'];
                $digitalItem->paper_id = 0;
                // *NEED TO CHANGE
                // $digitalItem->print_type_id = $digital['printingType'];
                $digitalItem->print_type_id = 0;
                $digitalItem->color_1 = $digital['color1'];
                $digitalItem->color_2 = $digital['color2'];
                $digitalItem->price = $this->clearThousandFormat($digital['price']);
                $digitalItem->quantity = $this->clearThousandFormat($digital['quantity']);
                $digitalItem->total = $this->clearThousandFormat($digital['total']);
                $digitalItem->finishing_item = $this->clearThousandFormat($digital['finishingItem']);
                $digitalItem->finishing_qty = $this->clearThousandFormat($digital['finishingQuantity']);
                $digitalItem->finishing_unit_price = $this->clearThousandFormat($digital['finishingUnitPrice']);
                $digitalItem->finishing_total = $this->clearThousandFormat($digital['finishingTotal']);
                $digitalItem->estimation_id = $estimation->id;
                $digitalItem->created_at = Carbon::now()->toDateTimeString();
                $digitalItem->updated_at = Carbon::now()->toDateTimeString();

                try {
                    $digitalItem->save();
                } catch (Exception $e) {
                    return response()->json([
                        'message' => 'internal error',
                        'error' => true,
                        'code' => 500,
                        'errors' => $e->getMessage(),
                    ], 500);
                }

                if (isset($digital['subFinishingItems']) && count($digital['subFinishingItems']) > 0) {
                    $digitalSubItems = collect($digital['subFinishingItems'])->map(function ($digitalSubItem, $key) use ($digitalItem) {
                        return [
                            'finishing_item' => $this->clearThousandFormat($digitalSubItem['item']),
                            'finishing_qty' => $this->clearThousandFormat($digitalSubItem['quantity']),
                            'finishing_unit_price' => $this->clearThousandFormat($digitalSubItem['unitPrice']),
                            'finishing_total' => $this->clearThousandFormat($digitalSubItem['total']),
                            'estimation_digital_item_id' => $digitalItem->id,
                            'created_at' => Carbon::now()->toDateTimeString(),
                            'updated_at' => Carbon::now()->toDateTimeString(),
                        ];
                    })->all();

                    try {
                        DB::table('estimation_digital_sub_items')->insert($digitalSubItems);
                    } catch (Exception $e) {
                        return response()->json([
                            'message' => 'internal error',
                            'error' => true,
                            'code' => 500,
                            'errors' => $e->getMessage(),
                        ], 500);
                    }
                }
            };
        }

        return response()->json([
            'message' => 'data has been saved',
            'error' => false,
            'code' => 200,
            'data' => [
                'offset_count' => count($request->offsetItems),
            ]
        ], 200);
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
