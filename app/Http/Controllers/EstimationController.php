<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Estimation;
use App\Models\EstimationDigitalItem;
use App\Models\EstimationOffsetItem;
use App\Models\Machine;
use App\Models\PicPo;
use App\Models\PrintType;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class EstimationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('estimation.index');
    }

    public function indexData()
    {
        $estimations = Estimation::with(['customer', 'quotations'])->select('estimations.*');
        return DataTables::of($estimations)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $button = '<div class="text-center"> ';
                $button .= '<a href="/estimation/edit/' . $row->id . '" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <rect x="0" y="0" width="24" height="24"></rect>
                  <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>
                  <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect>
                </g>
              </svg> </span> </a>
                ';

                if (count($row->quotations) < 1) {
                    $button .= '<a href="#" data-id="' . $row->id . '" class="btn btn-sm btn-clean btn-icon btn-delete" title="Delete"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                      <rect x="0" y="0" width="24" height="24"></rect>
                      <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>
                      <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>
                    </g>
                  </svg> </span> </a>';
                }

                $button .= '<div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="left" data-original-title="Quick actions">
                        <a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ki ki-bold-more-hor"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                            <!--begin::Navigation-->
                            <ul class="navi navi-hover">
                                <li class="navi-item">
                                    <a href="/estimation/print/' . $row->id . '" target="_blank" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="flaticon2-print"></i>
                                        </span>
                                        <span class="navi-text">Cetak</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="/estimation/duplicate/' . $row->id . '" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="flaticon-background"></i>
                                        </span>
                                        <span class="navi-text">Salin</span>
                                    </a>
                                </li>
                            </ul>
                            <!--end::Navigation-->
                        </div>
                    </div>';

                $button .= '</div>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return printTest();
        $machines = Machine::all();
        $printTypes = PrintType::all();

        $customers = Customer::all();
        $customersAll = $customers;
        $customers = $customers->map(function ($item, $key) {
            return ['id' => $item->id, 'text' => $item->name];
        });
        $customers->prepend(['id' => '', 'text' => 'Choose Customer']);

        $estimationsByCurrentDateCount = Estimation::query()->where('date', date("Y-m-d"))->get()->count();

        // return $estimationsByCurrentDateCount;

        $estimationNumber = 'NT-' . date('d') . date('m') . date("y") . sprintf('%04d', $estimationsByCurrentDateCount + 1);

        return view('estimation.create', [
            'customers' => $customers,
            'customers_all' => $customersAll,
            'estimation_number' => $estimationNumber,
            'machines' => $machines,
            'print_types' => $printTypes,
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
        // $estimation->number = $request->number;
        $estimation->number = getRecordNumber(new Estimation, 'EST');
        $estimation->date = $request->date;
        $estimation->customer_id = $request->customer_id;
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
        $estimation->pph = $this->clearThousandFormat($request->pph);
        $estimation->total_bill = $this->clearThousandFormat($request->total_bill);
        $estimation->delivery_date = $request->delivery_date;
        $estimation->status = $request->status;
        $estimation->note = $request->note;
        // $estimation->status = "open";
        $request->offsetItems = json_decode($request->offsetItems);
        $request->digitalItems = json_decode($request->digitalItems);

        if ($request->hasFile('file')) {
            try {
                $file = $request->file('file');
                $filePath = 'files/' . time() . '-attachment-' . $estimation->number . '.' . $request->file('file')->extension();
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                $estimation->file = $filePath;
            } catch (Exception $e) {
                return response()->json([
                    'message' => '[Internal error] Upload file failed',
                    'code' => 500,
                    'error' => true,
                    'errors' => $e,
                ], 500);
            }
        }

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
                $offsetItem->item = $offset->item;
                // *NEED TO CHANGE
                $offsetItem->machine_id = $offset->machineType;
                // $offsetItem->machine_id = 0;
                $offsetItem->size_opened_p = $offset->sizeOpenedP;
                $offsetItem->size_opened_l = $offset->sizeOpenedL;
                $offsetItem->size_closed_p = $offset->sizeClosedP;
                $offsetItem->size_closed_l = $offset->sizeClosedL;
                $offsetItem->color_1 = $offset->color1;
                $offsetItem->color_2 = $offset->color2;
                // *NEED TO CHANGE
                $offsetItem->paper_id = $offset->paperType;
                // $offsetItem->paper_id = 0;
                $offsetItem->paper_size_plano_p = $offset->paperSizePlanoP;
                $offsetItem->paper_size_plano_l = $offset->paperSizePlanoL;
                $offsetItem->paper_gramasi = $offset->paperGramasi;
                $offsetItem->paper_price = $this->clearThousandFormat($offset->paperPricePerKg);
                $offsetItem->paper_quantity_plano = $this->clearThousandFormat($offset->paperQuantityPlano);
                $offsetItem->paper_cutting_size_p = $offset->paperCuttingSizeP;
                $offsetItem->paper_cutting_size_l = $offset->paperCuttingSizeL;
                $offsetItem->paper_cutting_size_plano_p = $offset->paperSizePlanoDivCuttingSizeP;
                $offsetItem->paper_cutting_size_plano_l = $offset->paperSizePlanoDivCuttingSizeL;
                $offsetItem->paper_quantity = $this->clearThousandFormat($offset->paperQuantity);
                $offsetItem->paper_unit_price_editable = $this->booleanToNumber($offset->isPaperUnitPriceEditable);
                $offsetItem->paper_unit_price = $this->clearThousandFormat($offset->paperUnitPrice);
                $offsetItem->paper_total = $this->clearThousandFormat($offset->paperTotal);
                $offsetItem->plat_film_quantity_set = $this->clearThousandFormat($offset->filmQuantitySet);
                $offsetItem->plat_film_unit_price = $this->clearThousandFormat($offset->filmUnitPrice);
                $offsetItem->plat_film_total = $this->clearThousandFormat($offset->filmTotal);
                $offsetItem->app_set_design = $this->clearThousandFormat($offset->appSetDesign);
                // *NEED TO CHANGE
                $offsetItem->print_type_id = $offset->printingType;
                // $offsetItem->print_type_id = 0;
                $offsetItem->print_quantity = $this->clearThousandFormat($offset->printingQuantity);
                $offsetItem->print_min_price = $this->clearThousandFormat($offset->printingMinPrice);
                $offsetItem->print_druk_price = $this->clearThousandFormat($offset->printingDrukPrice);
                $offsetItem->print_total = $this->clearThousandFormat($offset->printingDrukPrice);
                $offsetItem->print_total = $this->clearThousandFormat($offset->printingTotal);
                $offsetItem->finishing_item = $this->clearThousandFormat($offset->finishingItem);
                $offsetItem->finishing_qty = $this->clearThousandFormat($offset->finishingQuantity);
                $offsetItem->finishing_unit_price = $this->clearThousandFormat($offset->finishingUnitPrice);
                $offsetItem->finishing_total = $this->clearThousandFormat($offset->finishingTotal);
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

                if (isset($offset->subFinishingItems) && count($offset->subFinishingItems) > 0) {
                    $offsetSubItems = collect($offset->subFinishingItems)->map(function ($offsetSubItem, $key) use ($offsetItem) {
                        return [
                            'finishing_item' => $this->clearThousandFormat($offsetSubItem->item),
                            'finishing_qty' => $this->clearThousandFormat($offsetSubItem->quantity),
                            'finishing_unit_price' => $this->clearThousandFormat($offsetSubItem->unitPrice),
                            'finishing_total' => $this->clearThousandFormat($offsetSubItem->total),
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
                $digitalItem->item = $digital->item;
                // *NEED TO CHANGE
                // $digitalItem->paper_id = $digital->paper;
                $digitalItem->paper_id = 0;
                // *NEED TO CHANGE
                // $digitalItem->print_type_id = $digital->printingType;
                $digitalItem->print_type_id = 0;
                $digitalItem->color_1 = $digital->color1;
                $digitalItem->color_2 = $digital->color2;
                $digitalItem->price = $this->clearThousandFormat($digital->price);
                $digitalItem->quantity = $this->clearThousandFormat($digital->quantity);
                $digitalItem->total = $this->clearThousandFormat($digital->total);
                $digitalItem->finishing_item = $this->clearThousandFormat($digital->finishingItem);
                $digitalItem->finishing_qty = $this->clearThousandFormat($digital->finishingQuantity);
                $digitalItem->finishing_unit_price = $this->clearThousandFormat($digital->finishingUnitPrice);
                $digitalItem->finishing_total = $this->clearThousandFormat($digital->finishingTotal);
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

                if (isset($digital->subFinishingItems) && count($digital->subFinishingItems) > 0) {
                    $digitalSubItems = collect($digital->subFinishingItems)->map(function ($digitalSubItem, $key) use ($digitalItem) {
                        return [
                            'finishing_item' => $this->clearThousandFormat($digitalSubItem->item),
                            'finishing_qty' => $this->clearThousandFormat($digitalSubItem->quantity),
                            'finishing_unit_price' => $this->clearThousandFormat($digitalSubItem->unitPrice),
                            'finishing_total' => $this->clearThousandFormat($digitalSubItem->total),
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
        // Get Estimation By ID
        $estimation = Estimation::with(['offsetItems.subItems', 'digitalItems.subItems', 'picPo.customer'])->findOrFail($id);
        // Set Offset Item to Temp Variable
        $tempOffsetItems = $estimation->offsetItems;
        // Unset Estimation Offset Item
        unset($estimation->offsetItems);
        // Assign Offset Item With The New One
        // Customized Key With Front End
        $estimation->offset_items = collect($tempOffsetItems)->map(function ($item) {
            $subItems = collect($item->sub_items)->map(function ($subItem) {
                return [
                    'id' => $subItem->id,
                    'item' => $subItem->finishing_item,
                    'quantity' => $subItem->finishing_qty,
                    'unitPrice' => $subItem->finishing_unit_price,
                    'total' => $subItem->finishing_total,
                ];
            })->all();

            return [
                'id' => $item->id,
                'item' => $item->item,
                'machineType' => $item->machine_id,
                'sizeOpenedP' => $this->toNumber($item->size_opened_p),
                'sizeOpenedL' => $this->toNumber($item->size_opened_l),
                'sizeClosedP' => $this->toNumber($item->size_closed_p),
                'sizeClosedL' => $this->toNumber($item->size_closed_l),
                'color1' => $item->color_1,
                'color2' => $item->color_2,
                'paperType' => $item->paper_id,
                'paperSizePlanoP' => $this->toNumber($item->paper_size_plano_p),
                'paperSizePlanoL' => $this->toNumber($item->paper_size_plano_l),
                'paperGramasi' => $this->toNumber($item->paper_gramasi),
                'paperPricePerKg' => $item->paper_price,
                'paperQuantityPlano' => $item->paper_quantity_plano,
                'paperCuttingSizeP' => $this->toNumber($item->paper_cutting_size_p),
                'paperSizePlanoDivCuttingSizeP' => $this->toNumber($item->paper_cutting_size_plano_p),
                'paperCuttingSizeL' => $this->toNumber($item->paper_cutting_size_l),
                'paperSizePlanoDivCuttingSizeL' => $this->toNumber($item->paper_cutting_size_plano_l),
                'paperQuantity' => $item->paper_quantity,
                'isPaperUnitPriceEditable' => $this->numberToBoolean($item->paper_unit_price_editable),
                'paperUnitPrice' => $item->paper_unit_price,
                'paperTotal' => $item->paper_total,
                'filmQuantitySet' => $item->plat_film_quantity_set,
                'filmUnitPrice' => $item->plat_film_unit_price,
                'filmTotal' => $item->plat_film_total,
                'appSetDesign' => $item->app_set_design,
                'printingType' => $item->print_type_id,
                'printingQuantity' => $item->print_quantity,
                'printingMinPrice' => $item->print_min_price,
                'printingDrukPrice' => $item->print_druk_price,
                'printingTotal' => $item->print_total,
                'finishingItem' => $item->finishing_item,
                'finishingQuantity' => $item->finishing_qty,
                'finishingUnitPrice' => $item->finishing_unit_price,
                'finishingTotal' => $item->finishing_total,
                'subFinishingItems' => $subItems,
            ];
        })->all();

        // Set Digital Item to Temp Variable
        $tempDigitalItems = $estimation->digitalItems;
        // Unset Estimation Digital Item
        unset($estimation->digitalItems);
        // Assign Digital Item With The New One
        // Customized Key With Front End
        $estimation->digital_items = collect($tempDigitalItems)->map(function ($item) {
            $subItems = collect($item->sub_items)->map(function ($subItem) {
                return [
                    'id' => $subItem->id,
                    'item' => $subItem->finishing_item,
                    'quantity' => $subItem->finishing_qty,
                    'unitPrice' => $subItem->finishing_unit_price,
                    'total' => $subItem->finishing_total,
                ];
            })->all();

            return [
                'id' => $item->id,
                'item' => $item->item,
                'paper' => $item->paper_id,
                'printingType' => $item->print_type_id,
                'color1' => $item->color_1,
                'color2' => $item->color_2,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'total' => $item->total,
                'finishingItem' => $item->finishing_item,
                'finishingQuantity' => $item->finishing_qty,
                'finishingUnitPrice' => $item->finishing_unit_price,
                'finishingTotal' => $item->finishing_total,
                'subFinishingItems' => $subItems,
            ];
        })->all();


        // $estimation->offset_items = '123123';
        // return $estimation;

        $machines = Machine::all();
        $printTypes = PrintType::all();

        // Get Customers
        $customers = Customer::all();
        $customersAll = $customers;
        // Mapping Cucstomers into select2 options
        $customers = $customers->map(function ($item, $key) {
            return ['id' => $item->id, 'text' => $item->name];
        });
        $customers->prepend(['id' => '', 'text' => 'Choose Customer']);

        $customerId = $estimation->picPo->customer->id;

        $picPos = ['id' => '', 'text' => 'Choose '];

        if ($customerId !== null) {
            $picPos = Customer::find($customerId)->picpos;
            $picPos = $picPos->map(function ($item, $key) {
                return ['id' => $item->id, 'text' => $item->name];
            });
            $picPos->prepend(['id' => '', 'text' => 'Choose ']);
        }


        return view('estimation.edit', [
            'customers' => $customers,
            'customers_all' => $customersAll,
            'estimation' => $estimation,
            'picPos' => $picPos,
            'machines' => $machines,
            'print_types' => $printTypes,
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
        $estimation = Estimation::find($id);
        $estimation->number = $request->number;
        $estimation->date = $request->date;
        $estimation->customer_id = $request->customer_id;
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
        $estimation->pph = $this->clearThousandFormat($request->pph);
        $estimation->total_bill = $this->clearThousandFormat($request->total_bill);
        $estimation->delivery_date = $request->delivery_date;
        $estimation->status = $request->status;
        $estimation->note = $request->note;
        $request->offsetItems = json_decode($request->offsetItems);
        $request->digitalItems = json_decode($request->digitalItems);
        // $estimation->status = "open";

        try {
            EstimationOffsetItem::query()->where('estimation_id', $id)->delete();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'internal error',
                'error' => true,
                'code' => 500,
                'errors' => $e->getMessage(),
            ], 500);
        }

        try {
            EstimationDigitalItem::query()->where('estimation_id', $id)->delete();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'internal error',
                'error' => true,
                'code' => 500,
                'errors' => $e->getMessage(),
            ], 500);
        }

        if ($request->hasFile('file')) {
            try {
                $file = $request->file('file');
                $filePath = 'files/' . time() . '-attachment-' . $estimation->number . '.' . $request->file('file')->extension();
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                Storage::disk('s3')->delete($estimation->file);
                $estimation->file = $filePath;
            } catch (Exception $e) {
                return response()->json([
                    'message' => '[Internal error] Upload file failed',
                    'code' => 500,
                    'error' => true,
                    'errors' => $e,
                ], 500);
            }
        } else {
            if ($request->old_file == '' || $request->old_file == null) {
                try {
                    Storage::disk('s3')->delete($estimation->file);
                    $estimation->file = null;
                } catch (Exception $e) {
                    return response()->json([
                        'message' => '[Internal error] Delete file failed',
                        'code' => 500,
                        'error' => true,
                        'errors' => $e,
                    ], 500);
                }
            }
        }

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
                $offsetItem->item = $offset->item;
                // *NEED TO CHANGE
                $offsetItem->machine_id = $offset->machineType;
                // $offsetItem->machine_id = 0;
                $offsetItem->size_opened_p = $offset->sizeOpenedP;
                $offsetItem->size_opened_l = $offset->sizeOpenedL;
                $offsetItem->size_closed_p = $offset->sizeClosedP;
                $offsetItem->size_closed_l = $offset->sizeClosedL;
                $offsetItem->color_1 = $offset->color1;
                $offsetItem->color_2 = $offset->color2;
                // *NEED TO CHANGE
                $offsetItem->paper_id = $offset->paperType;
                // $offsetItem->paper_id = 0;
                $offsetItem->paper_size_plano_p = $offset->paperSizePlanoP;
                $offsetItem->paper_size_plano_l = $offset->paperSizePlanoL;
                $offsetItem->paper_gramasi = $offset->paperGramasi;
                $offsetItem->paper_price = $this->clearThousandFormat($offset->paperPricePerKg);
                $offsetItem->paper_quantity_plano = $this->clearThousandFormat($offset->paperQuantityPlano);
                $offsetItem->paper_cutting_size_p = $offset->paperCuttingSizeP;
                $offsetItem->paper_cutting_size_l = $offset->paperCuttingSizeL;
                $offsetItem->paper_cutting_size_plano_p = $offset->paperSizePlanoDivCuttingSizeP;
                $offsetItem->paper_cutting_size_plano_l = $offset->paperSizePlanoDivCuttingSizeL;
                $offsetItem->paper_quantity = $this->clearThousandFormat($offset->paperQuantity);
                $offsetItem->paper_unit_price_editable = $this->booleanToNumber($offset->isPaperUnitPriceEditable);
                $offsetItem->paper_unit_price = $this->clearThousandFormat($offset->paperUnitPrice);
                $offsetItem->paper_total = $this->clearThousandFormat($offset->paperTotal);
                $offsetItem->plat_film_quantity_set = $this->clearThousandFormat($offset->filmQuantitySet);
                $offsetItem->plat_film_unit_price = $this->clearThousandFormat($offset->filmUnitPrice);
                $offsetItem->plat_film_total = $this->clearThousandFormat($offset->filmTotal);
                $offsetItem->app_set_design = $this->clearThousandFormat($offset->appSetDesign);
                // *NEED TO CHANGE
                $offsetItem->print_type_id = $offset->printingType;
                // $offsetItem->print_type_id = 0;
                $offsetItem->print_quantity = $this->clearThousandFormat($offset->printingQuantity);
                $offsetItem->print_min_price = $this->clearThousandFormat($offset->printingMinPrice);
                $offsetItem->print_druk_price = $this->clearThousandFormat($offset->printingDrukPrice);
                $offsetItem->print_total = $this->clearThousandFormat($offset->printingDrukPrice);
                $offsetItem->print_total = $this->clearThousandFormat($offset->printingTotal);
                $offsetItem->finishing_item = $this->clearThousandFormat($offset->finishingItem);
                $offsetItem->finishing_qty = $this->clearThousandFormat($offset->finishingQuantity);
                $offsetItem->finishing_unit_price = $this->clearThousandFormat($offset->finishingUnitPrice);
                $offsetItem->finishing_total = $this->clearThousandFormat($offset->finishingTotal);
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

                if (isset($offset->subFinishingItems) && count($offset->subFinishingItems) > 0) {
                    $offsetSubItems = collect($offset->subFinishingItems)->map(function ($offsetSubItem, $key) use ($offsetItem) {
                        return [
                            'finishing_item' => $this->clearThousandFormat($offsetSubItem->item),
                            'finishing_qty' => $this->clearThousandFormat($offsetSubItem->quantity),
                            'finishing_unit_price' => $this->clearThousandFormat($offsetSubItem->unitPrice),
                            'finishing_total' => $this->clearThousandFormat($offsetSubItem->total),
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
            };
        }


        if (count($request->digitalItems) > 0) {
            foreach ($request->digitalItems as $digital) {
                $digitalItem = new EstimationDigitalItem;
                $digitalItem->item = $digital->item;
                // *NEED TO CHANGE
                // $digitalItem->paper_id = $digital->paper;
                $digitalItem->paper_id = 0;
                // *NEED TO CHANGE
                // $digitalItem->print_type_id = $digital->printingType;
                $digitalItem->print_type_id = 0;
                $digitalItem->color_1 = $digital->color1;
                $digitalItem->color_2 = $digital->color2;
                $digitalItem->price = $this->clearThousandFormat($digital->price);
                $digitalItem->quantity = $this->clearThousandFormat($digital->quantity);
                $digitalItem->total = $this->clearThousandFormat($digital->total);
                $digitalItem->finishing_item = $this->clearThousandFormat($digital->finishingItem);
                $digitalItem->finishing_qty = $this->clearThousandFormat($digital->finishingQuantity);
                $digitalItem->finishing_unit_price = $this->clearThousandFormat($digital->finishingUnitPrice);
                $digitalItem->finishing_total = $this->clearThousandFormat($digital->finishingTotal);
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

                if (isset($digital->subFinishingItems) && count($digital->subFinishingItems) > 0) {
                    $digitalSubItems = collect($digital->subFinishingItems)->map(function ($digitalSubItem, $key) use ($digitalItem) {
                        return [
                            'finishing_item' => $this->clearThousandFormat($digitalSubItem->item),
                            'finishing_qty' => $this->clearThousandFormat($digitalSubItem->quantity),
                            'finishing_unit_price' => $this->clearThousandFormat($digitalSubItem->unitPrice),
                            'finishing_total' => $this->clearThousandFormat($digitalSubItem->total),
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $estimation = Estimation::find($id);
        try {
            $estimation->delete();
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

    public function duplicate($id)
    {
        // Get Estimation By ID
        $estimation = Estimation::with(['offsetItems.subItems', 'digitalItems.subItems', 'picPo.customer'])->findOrFail($id);
        // Set Offset Item to Temp Variable
        $tempOffsetItems = $estimation->offsetItems;
        // Unset Estimation Offset Item
        unset($estimation->offsetItems);
        // Assign Offset Item With The New One
        // Customized Key With Front End
        $estimation->offset_items = collect($tempOffsetItems)->map(function ($item) {
            $subItems = collect($item->sub_items)->map(function ($subItem) {
                return [
                    'id' => $subItem->id,
                    'item' => $subItem->finishing_item,
                    'quantity' => $subItem->finishing_qty,
                    'unitPrice' => $subItem->finishing_unit_price,
                    'total' => $subItem->finishing_total,
                ];
            })->all();

            return [
                'id' => $item->id,
                'item' => $item->item,
                'machineType' => $item->machine_id,
                'sizeOpenedP' => $this->toNumber($item->size_opened_p),
                'sizeOpenedL' => $this->toNumber($item->size_opened_l),
                'sizeClosedP' => $this->toNumber($item->size_closed_p),
                'sizeClosedL' => $this->toNumber($item->size_closed_l),
                'color1' => $item->color_1,
                'color2' => $item->color_2,
                'paperType' => $item->paper_id,
                'paperSizePlanoP' => $this->toNumber($item->paper_size_plano_p),
                'paperSizePlanoL' => $this->toNumber($item->paper_size_plano_l),
                'paperGramasi' => $this->toNumber($item->paper_gramasi),
                'paperPricePerKg' => $item->paper_price,
                'paperQuantityPlano' => $item->paper_quantity_plano,
                'paperCuttingSizeP' => $this->toNumber($item->paper_cutting_size_p),
                'paperSizePlanoDivCuttingSizeP' => $this->toNumber($item->paper_cutting_size_plano_p),
                'paperCuttingSizeL' => $this->toNumber($item->paper_cutting_size_l),
                'paperSizePlanoDivCuttingSizeL' => $this->toNumber($item->paper_cutting_size_plano_l),
                'paperQuantity' => $item->paper_quantity,
                'isPaperUnitPriceEditable' => $this->numberToBoolean($item->paper_unit_price_editable),
                'paperUnitPrice' => $item->paper_unit_price,
                'paperTotal' => $item->paper_total,
                'filmQuantitySet' => $item->plat_film_quantity_set,
                'filmUnitPrice' => $item->plat_film_unit_price,
                'filmTotal' => $item->plat_film_total,
                'appSetDesign' => $item->app_set_design,
                'printingType' => $item->print_type_id,
                'printingQuantity' => $item->print_quantity,
                'printingMinPrice' => $item->print_min_price,
                'printingDrukPrice' => $item->print_druk_price,
                'printingTotal' => $item->print_total,
                'finishingItem' => $item->finishing_item,
                'finishingQuantity' => $item->finishing_qty,
                'finishingUnitPrice' => $item->finishing_unit_price,
                'finishingTotal' => $item->finishing_total,
                'subFinishingItems' => $subItems,
            ];
        })->all();

        // Set Digital Item to Temp Variable
        $tempDigitalItems = $estimation->digitalItems;
        // Unset Estimation Digital Item
        unset($estimation->digitalItems);
        // Assign Digital Item With The New One
        // Customized Key With Front End
        $estimation->digital_items = collect($tempDigitalItems)->map(function ($item) {
            $subItems = collect($item->sub_items)->map(function ($subItem) {
                return [
                    'id' => $subItem->id,
                    'item' => $subItem->finishing_item,
                    'quantity' => $subItem->finishing_qty,
                    'unitPrice' => $subItem->finishing_unit_price,
                    'total' => $subItem->finishing_total,
                ];
            })->all();

            return [
                'id' => $item->id,
                'item' => $item->item,
                'paper' => $item->paper_id,
                'printingType' => $item->print_type_id,
                'color1' => $item->color_1,
                'color2' => $item->color_2,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'total' => $item->total,
                'finishingItem' => $item->finishing_item,
                'finishingQuantity' => $item->finishing_qty,
                'finishingUnitPrice' => $item->finishing_unit_price,
                'finishingTotal' => $item->finishing_total,
                'subFinishingItems' => $subItems,
            ];
        })->all();


        // $estimation->offset_items = '123123';
        // return $estimation;

        $machines = Machine::all();
        $printTypes = PrintType::all();

        // Get Customers
        $customers = Customer::all();
        $customersAll = $customers;
        // Mapping Cucstomers into select2 options
        $customers = $customers->map(function ($item, $key) {
            return ['id' => $item->id, 'text' => $item->name];
        });
        $customers->prepend(['id' => '', 'text' => 'Choose Customer']);

        $customerId = $estimation->picPo->customer->id;

        $picPos = ['id' => '', 'text' => 'Choose '];

        if ($customerId !== null) {
            $picPos = Customer::find($customerId)->picpos;
            $picPos = $picPos->map(function ($item, $key) {
                return ['id' => $item->id, 'text' => $item->name];
            });
            $picPos->prepend(['id' => '', 'text' => 'Choose ']);
        }


        return view('estimation.duplicate', [
            'customers' => $customers,
            'customers_all' => $customersAll,
            'estimation' => $estimation,
            'picPos' => $picPos,
            'machines' => $machines,
            'print_types' => $printTypes,
        ]);
    }


    /**
     * Print the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print($id)
    {
        $estimation = Estimation::with(['offsetItems.subItems', 'digitalItems.subItems', 'picPo.customer'])->findOrFail($id);

        $totalAppSetDesign = collect($estimation->offsetItems)->map(function ($item) {
            return $item->app_set_design;
        })->sum();

        $pdf = PDF::loadView('estimation.print', [
            'app_set_design' => $totalAppSetDesign,
            'estimation' => $estimation,
        ]);
        return $pdf->stream('invoice.pdf');
    }

    private function clearThousandFormat($number)
    {
        return str_replace(".", "", $number);
    }

    private function toNumber($string)
    {
        return is_numeric($string) ? $string + 0 : $string;
    }

    private function booleanToNumber($boolean)
    {
        return $boolean == true ? 1 : 0;
    }

    private function numberToBoolean($number)
    {
        return (int) $number == 1 ? true : false;
    }
}
