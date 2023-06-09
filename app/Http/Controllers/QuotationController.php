<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Estimation;
use App\Models\Quotation;
use Barryvdh\DomPDF\Facade as PDF;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('quotation.index');
    }

    public function indexData()
    {
        $quotations = Quotation::with(['estimations', 'picPo'])->select('quotations.*');
        return DataTables::eloquent($quotations)
            ->addIndexColumn()
            ->addColumn('estimation_number', function (Quotation $quotation) {
                return $quotation->estimations->map(function ($estimation) {
                    return '<span class="label label-light-info label-pill label-inline text-capitalize">' . $estimation->number . '</span>';
                })->implode("");
            })
            ->addColumn('action', function ($row) {
                $button = ' <div class="text-center">';
                $button .= ' <a href="/quotation/edit/' . $row->id . '" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <rect x="0" y="0" width="24" height="24"></rect>
                  <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>
                  <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect>
                </g>
              </svg> </span> </a>';

                if (count($row->salesOrders) < 1) {
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
                                    <a href="/quotation/print/' . $row->id . '" target="_blank" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="flaticon2-print"></i>
                                        </span>
                                        <span class="navi-text">Cetak</span>
                                    </a>
                                </li>
                            </ul>
                            <!--end::Navigation-->
                        </div>
                    </div>';

                $button .= '</div>';

                return $button;
            })
            ->rawColumns(['estimation_number', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $quotationsByCurrentDateCount = Quotation::query()->where('date', date("Y-m-d"))->get()->count();
        // return $estimationsByCurrentDateCount;
        $quotationNumber = 'QO-' . date('d') . date('m') . date("y") . sprintf('%04d', $quotationsByCurrentDateCount + 1);

        $customers = Customer::all();
        

        return view('quotation.create', [
            'quotation_number' => $quotationNumber,
            'customers' => $customers,
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
        $quotation = new Quotation;
        // $quotation->number = $request->number;
        $quotation->number = getRecordNumber(new Quotation, 'QO');
        $quotation->date = $request->date;
        $quotation->customer_id = $request->customer_id;
        $quotation->up = $request->up;
        $quotation->title = $request->title;
        $quotation->note = $request->note;
        $quotation->description = $request->description;
        $quotation->quantity = $this->clearThousandFormat($request->quantity);
        $quotation->price_per_unit = $this->clearThousandFormat($request->price_per_unit);
        $quotation->ppn = $this->clearThousandFormat($request->ppn);
        $quotation->pph = $this->clearThousandFormat($request->pph);
        $quotation->total_bill = $this->clearThousandFormat($request->total_bill);

        $estimations = $request->selected_estimations;

        try {
            $quotation->save();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        try {
            $quotation->estimations()->attach($estimations);
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $quotation,
            ]);
        } catch (Exception $e) {
            $quotation->delete();
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        // return response()->json([
        //     'message' => 'data has been saved',
        //     'error' => false,
        //     'code' => 200,
        //     'data' => [
        //         'requests' => $request->all(),
        //     ]
        // ], 200);
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
        $quotation = Quotation::with(['estimations.picPo', 'picPo'])->findOrFail($id);

        $customers = Customer::all();
        // return $quotation;
        return view('quotation.edit', [
            'quotation' => $quotation,
            'customers' => $customers,
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
        $quotation = Quotation::find($id);
        $quotation->number = $request->number;
        $quotation->date = $request->date;
        $quotation->customer_id = $request->customer_id;
        $quotation->up = $request->up;
        $quotation->title = $request->title;
        $quotation->note = $request->note;
        $quotation->description = $request->description;
        $quotation->quantity = $this->clearThousandFormat($request->quantity);
        $quotation->price_per_unit = $this->clearThousandFormat($request->price_per_unit);
        $quotation->ppn = $this->clearThousandFormat($request->ppn);
        $quotation->pph = $this->clearThousandFormat($request->pph);
        $quotation->total_bill = $this->clearThousandFormat($request->total_bill);

        $estimations = $request->selected_estimations;

        try {
            $quotation->save();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        try {
            $quotation->estimations()->detach();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        try {
            $quotation->estimations()->attach($estimations);
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $quotation,
            ]);
        } catch (Exception $e) {
            // $quotation->delete();
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
        $quotation = Quotation::find($id);
        try {
            $quotation->estimations()->detach();
            $quotation->delete();
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

    public function print($id)
    {
        $quotation = Quotation::with(['estimations', 'customer', 'picPo'])->findOrFail($id);

        // $customerExist = collect($quotation->estimations)->filter(function ($item) {
        //     return $item->picPo->customer !== null;
        // })->first();

        // $customer = [
        //     'name' => '-',
        // ];

        // if ($customerExist !== null) {
        //     $customer = $customerExist->picPo->customer;
        // }

        $company = Company::all()->first();

        if ($company == null) {
            $newCompany = new Company;
            $newCompany->save();
            $company = Company::all()->first();
        }

        $pdf = PDF::loadView('quotation.print', [
            'quotation' => $quotation,
            // 'customer' => $customer,
            'company' => $company,
        ]);
        return $pdf->stream($quotation->number . '.pdf');
    }

    // GET Datatables Estimation Data
    public function datatablesEstimations(Request $request)
    {
        $customerId = $request->query('customer_id');
        // $users = User::select(['id', 'name', 'email', 'created_at', 'updated_at']);
        $estimations = Estimation::with(['picPo'])->where('customer_id', $customerId)->select('estimations.*');

        return DataTables::of($estimations)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $button = '<button class="btn btn-light-primary btn-choose"><i class="flaticon-add-circular-button"></i> Pilih</button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    private function clearThousandFormat($number)
    {
        return str_replace(".", "", $number);
    }
}
