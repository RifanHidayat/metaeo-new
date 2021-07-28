<?php

namespace App\Http\Controllers;

use App\Models\JobOrder;
use App\Models\Quotation;
use App\Models\SalesOrder;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SpkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return $this->indexData();
        return view('spk.index');
    }

    public function indexData()
    {
        $jobOrders = JobOrder::with(['quotations', 'salesOrder']);
        return DataTables::of($jobOrders)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $button = '
                <div class="text-center">
                <a href="/spk/edit/' . $row->id . '" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <rect x="0" y="0" width="24" height="24"></rect>
                  <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>
                  <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect>
                </g>
              </svg> </span> </a>
              <a href="#" data-id="' . $row->id . '" class="btn btn-sm btn-clean btn-icon btn-delete" title="Delete"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <rect x="0" y="0" width="24" height="24"></rect>
                  <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>
                  <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>
                </g>
              </svg> </span> </a>
                </div>
                ';
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
    public function create(Request $request)
    {
        $salesOrderId = $request->query('so');
        $salesOrder = SalesOrder::with(['quotations'])->find($salesOrderId);

        if ($salesOrderId == null || $salesOrder == null) {
            abort(404);
        }

        $jobOrdersByCurrentDateCount = JobOrder::query()->where('date', date("Y-m-d"))->get()->count();
        // return $estimationsByCurrentDateCount;
        $jobOrderNumber = 'JO-' . date('d') . date('m') . date("y") . sprintf('%04d', $jobOrdersByCurrentDateCount + 1);

        // return $salesOrder;

        return view('spk.create', [
            'sales_order' => $salesOrder,
            'job_order_number' => $jobOrderNumber,
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
        $jobOrder = new JobOrder;
        $jobOrder->number = $request->number;
        $jobOrder->date = $request->date;
        $jobOrder->finish_date = $request->finish_date;
        $jobOrder->delivery_date = $request->delivery_date;
        $jobOrder->designer = $request->designer;
        $jobOrder->preparer = $request->preparer;
        $jobOrder->examiner = $request->examiner;
        $jobOrder->production = $request->production;
        $jobOrder->finishing = $request->finishing;
        $jobOrder->warehouse = $request->warehouse;
        $jobOrder->sales_order_id = $request->sales_order_id;

        $quotations = $request->selected_quotations;

        try {
            $jobOrder->save();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        $keyedQuotations = collect($quotations)->mapWithKeys(function ($item) {
            if (!isset($item['production'])) {
                $item['production'] = 0;
            };

            return [
                $item['id'] => [
                    'produced' => $item['production'],
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]
            ];
        });

        try {
            $jobOrder->quotations()->attach($keyedQuotations);
        } catch (Exception $e) {
            $jobOrder->delete();
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        try {
            foreach ($quotations as $quotation) {
                $quotationRow = Quotation::find($quotation['id']);
                if ($quotationRow == null) {
                    continue;
                }

                $quotationRow->produced = $quotationRow->produced + $quotation['production'];
                $quotationRow->save();
            }
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $jobOrder,
            ]);
        } catch (Exception $e) {
            $jobOrder->quotations()->detach();
            $jobOrder->delete();
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
        $jobOrder = JobOrder::with(['quotations', 'salesOrder.quotations'])->findOrFail($id);

        if ($jobOrder->salesOrder == null) {
            abort(500);
        }

        if (count($jobOrder->quotations) > 0) {
            foreach ($jobOrder->quotations as $quotation) {
                $quotation->production = $quotation->pivot->produced;
                $quotation->old_production = $quotation->pivot->produced;
                $quotation->produced = $quotation->produced - $quotation->pivot->produced;
            }
        }


        $checkedQuotations = collect($jobOrder->quotations)->pluck('id')->all();

        return view('spk.edit', [
            'job_order' => $jobOrder,
            'checked_quotations' => $checkedQuotations,
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
        $jobOrder = JobOrder::find($id);
        $jobOrder->number = $request->number;
        $jobOrder->date = $request->date;
        $jobOrder->finish_date = $request->finish_date;
        $jobOrder->delivery_date = $request->delivery_date;
        $jobOrder->designer = $request->designer;
        $jobOrder->preparer = $request->preparer;
        $jobOrder->examiner = $request->examiner;
        $jobOrder->production = $request->production;
        $jobOrder->finishing = $request->finishing;
        $jobOrder->warehouse = $request->warehouse;
        $jobOrder->sales_order_id = $request->sales_order_id;

        $quotations = $request->selected_quotations;

        try {
            $jobOrder->save();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        try {
            $jobOrder->quotations()->detach();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        $keyedQuotations = collect($quotations)->mapWithKeys(function ($item) {
            if (!isset($item['production'])) {
                $item['production'] = 0;
            };

            return [
                $item['id'] => [
                    'produced' => $item['production'],
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]
            ];
        });

        try {
            $jobOrder->quotations()->attach($keyedQuotations);
        } catch (Exception $e) {
            $jobOrder->delete();
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        try {
            foreach ($quotations as $quotation) {
                $quotationRow = Quotation::find($quotation['id']);
                if ($quotationRow == null) {
                    continue;
                }
                // DIfferent formula with store
                $quotationRow->produced = $quotationRow->produced + $quotation['production'] - $quotation['old_production'];
                $quotationRow->save();
            }
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $jobOrder,
            ]);
        } catch (Exception $e) {
            $jobOrder->quotations()->detach();
            $jobOrder->delete();
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
        $jobOrder = JobOrder::find($id);
        $quotations = $jobOrder->quotations;

        try {
            foreach ($quotations as $quotation) {
                $quotationRow = Quotation::find($quotation->id);
                if ($quotationRow == null) {
                    continue;
                }
                // DIfferent formula with store
                $quotationRow->produced = $quotationRow->produced - $quotation->produced;
                $quotationRow->save();
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        try {
            $jobOrder->quotations()->detach();
            $jobOrder->delete();
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
