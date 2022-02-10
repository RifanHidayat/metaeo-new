<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bast;
use App\Models\Company;
use App\Models\Customer;
use App\Models\CustomerPurchaseOrder;
use App\Models\EventQuotation;
use App\Models\OtherQuotationItem;
use App\Models\Project;
use App\Models\ProjectBudget;
use App\Models\ProjectBudgetTransaction;
use App\Models\ProjectMember;
use App\Models\ProjectProfitLostTransaction;
use App\Models\PurchaseOrder;
use App\Models\V2Quotation;
use App\Models\V2SalesOrder;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\ErrorHandler\Collecting;
use PhpParser\Node\Expr\Cast\Array_;
use Yajra\DataTables\Facades\DataTables;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

        private function formatDate($date = "", $format = "Y-m-d")
    {
        return date_format(date_create($date), $format);
    }
    public function index()
    {
        return view('project.index');
    }

    /**
     * Send datatable form.
     *
     * @return \Yajra\DataTables\Facades\DataTables
     */
    public function indexData()
    {
        // $salesOrders = V2SalesOrder::with(['v2Quotation', 'customerPurchaseOrder', 'jobOrders', 'invoices', 'deliveryOrders'])->select('v2_sales_orders.*');
        // return $salesOrders;
          $bast = Project::with("eventQuotations")->select('projects.*');
        return DataTables::eloquent($bast)
            ->addIndexColumn()
            
            
           
            ->addColumn('action', function ($row) {
               if ($row->source=="sales-order"){
                    $mapping='';
                   

               }else{
                    $mapping='<a href="/project/mapping/' . $row->id . '" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="flaticon2-list-2"></i>
                                        </span>
                                        <span class="navi-text">Mapping</span>
                                    </a>';
                   
               }
                $button = ' <div class="text-center">';   
                    $button .= ' <a href="/quotation/edit/' . $row->id . '" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <rect x="0" y="0" width="24" height="24"></rect>
                  <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>
                  <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect>
                </g>
              </svg> </span> </a>';

                    $button .= '<a href="#" data-id="' . $row->id . '" class="btn btn-sm btn-clean btn-icon btn-delete" title="Delete"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <rect x="0" y="0" width="24" height="24"></rect>
                  <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>
                  <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>
                </g>
              </svg> </span> </a>';

            
                

                $button .= '<div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="left" data-original-title="Quick actions">
                        <a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon btn-po" 
                        data-id="' . $row->id .'" 
                           data-number="' . $row->po_quotation_id .'" 
                          
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ki ki-bold-more-hor"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                            <!--begin::Navigation-->
                            <ul class="navi navi-hover">
                                <li class="navi-item">
                                   '.$mapping.'
                                </li>
                                
                                
                                  <li class="navi-item">
                                    <a href="/project/profit-lost/' . $row->id . '"  class="navi-link">
                                        <span class="navi-icon">
                                            <i class="flaticon2-file"></i>
                                        </span>
                                        <span class="navi-text">Laba Rugi</span>
                                    </a>
                                </li>
                                   <li class="navi-item">
                                    <a href="/event-quotation/print/' . $row->id . '" target="_blank" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="flaticon-information"></i>
                                        </span>
                                        <span class="navi-text">Advance Transaksi</span>
                                    </a>
                                </li>
                               
                                

                                
                            </ul>
                            <!--end::Navigation-->
                        </div>
                    </div>';

                $button .= '</div>';

                return $button;
            })
            ->rawColumns(['quotation_number', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::all();
        return view('project.create', [
            'customers' => $customers,
        ]);
    }

    public function mapping($id){
         
         $project=Project::with(['members','tasks','budgets','budgets.projectBudgetTransactions'])->find($id);
         

         $members=collect($project->members)->each(function($item){
             $item['first_name']=$item['name'];
             $item['daily_money_regular']=$item['daily_money_reguler'];
         
           });
       // return $project->budgets;
         if ($project->budgets!=null){
              $budgets=collect($project->budgets->projectBudgetTransactions)->each(function($item){
             $item['accountId']=$item['account_id'];
             $item['recipient_account']=$item['transfer_to'];
         });
             
        }else{
            $budgets=Array();
        }
        //      $budgets=collect($project->budgets->projectBudgetTransactions)->each(function($item){
        //      $item['accountId']=$item['account_id'];
        //      $item['recipient_account']=$item['transfer_to'];
        //  });
        //return $budgets;
        // if ($project->budgets!=="null"){
        //     return "tes";
        // }else{
        //     return "tos";
        // }
        
    


        return view('project.mapping', [
            
            'project_id'=>$id,
            'project'=>$project,
            'members'=>$members,
            'budgets'=>$project->budgets!=null?$budgets:$members,
        ]);

    }
        public function profitLost($id){
         
         $project=Project::with(['members','tasks','budgets.projectBudgetTransactions'])->find($id);
         
         $projectProfitLostTransactions=ProjectProfitLostTransaction::where('project_id',$id)->get();

         $outProjectTransactions=collect($projectProfitLostTransactions)->filter(function($item){
             return $item['source']=="out_project_transactions";
         });
         $balance=0;
         $projectProfitLostTransactions=collect($projectProfitLostTransactions)->each(function($item) use ($balance){
             $item['type']=="in"?$balance=$balance+$item['amount']:$balance=$balance-$item['amount'];
             $item['balance']=$balance;  

         })->firstWhere('init',1)->where('project_id',$id)->get();
    

            

        return view('project.profit-lost', [
            
            'project_id'=>$id,
            'project'=>$project,
            'out_project_transactions'=>$outProjectTransactions,
            'project_profit_lost_transactions'=>$projectProfitLostTransactions,
            
        
 
        ]);

    }
 public function member(Request $request){
     //return $request->selected_members;
    $projectId=$request->project_id;
   // return $request->selected_members;
     DB::beginTransaction();
     try{
         DB::table('project_members')->where('project_id', $request->project_id)->delete();
             $items = collect($request->selected_members)->map(function ($item) use ($projectId) {
                return [
                    'name' => $item['first_name'],
                    'identity_number' => $item['identity_number'],
                    'daily_money_reguler' => $item['daily_money_regular'],
                    'status' => $item['status'],
                    'number' => $item['number'],
                    'employee_id' => $item['id'],
                    'project_id'=>$projectId,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ];
            })->all();            
             DB::table('project_members')->insert($items);
               DB::commit();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => [],
            ]);
              
     }catch(Exception $e){
           DB::rollBack();
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e.'',
            ], 500);

     }

     
 }

  public function task(Request $request){
     //return $request->selected_members;
    
    $projectId=$request->project_id;
     DB::beginTransaction();
     try{
         DB::table('project_tasks')->where('project_id', $request->project_id)->delete();
             $items = collect($request->selected_tasks)->map(function ($item) use ($projectId) {
                return [
                    'name' => $item['name'],
                    'project_id'=>$projectId
                ];
            })->all();            
             DB::table('project_tasks')->insert($items);
               DB::commit();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => [],
            ]);
              
     }catch(Exception $e){
           DB::rollBack();
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e.'',
            ], 500);

     }

     
 }

 public function budget(Request $request){
    // return $request->selected_budgets;
    $projectId=$request->project_id;
    $budgetStartDate=$request->budget_start_date;
    $budgetEndDate=$request->budget_end_date;
    $initBalance=$request->init_balance;
    $balance=$request->balance;
     //return "tes";
    // return $request->selected_budgets;
     DB::beginTransaction();
     try{
         $projectBudgets=ProjectBudget::where('project_id',$projectId)->first();
         if ($projectBudgets!=null){
                      DB::table('project_budget_transactions')->where('project_budget_id',$projectBudgets->id)->delete();
                        $projectBudgets->delete();
         }
       
        
            $budgetProject=new ProjectBudget();
            $budgetProject->start_date=$budgetStartDate;
            $budgetProject->end_date=$budgetEndDate;
            // $budgetProject->in=1;
            // $budgetProject->out=2;
            $budgetProject->balance=$balance;
            $budgetProject->init_balance=$balance;
            $budgetProject->project_id=$projectId;
            $budgetProject->save();

             $items = collect($request->selected_budgets)->map(function ($item) use ($budgetProject,$budgetStartDate) {
                return [
                    'date'=>$budgetStartDate,
                    'amount'=>$item['amount'],
                    'project_budget_id'=>$budgetProject->id,
                    'type'=>'in',
                    'status'=>'approved',
                    'account_id'=>$item['account_id']['account_id'],
                    'account_name'=>$item['account_id']['account']['name'],
                    'account_number'=>$item['account_id']['account']['number'],
                    'transfer_to'=>$item['recipient_account'],
                    'init'=>1
                ];
            })->all();            
             DB::table('project_budget_transactions')->insert($items);




            DB::commit();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => [],
            ]);
              
     }catch(Exception $e){
           DB::rollBack();
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e.'',
            ], 500);

     }


 }

 public function outStore(Request $request){
 
         
      DB::beginTransaction();
      try{
        $amount=$request->amount;
        $note=$request->description;
        $account=$request->account;
        $date=$request->date;
        $projectProfitLostTransaction=new ProjectProfitLostTransaction();
        $source='out_project_transactions';
        $projectProfitLostTransaction->date=$date;
        $projectProfitLostTransaction->amount=$amount;
        $projectProfitLostTransaction->note=$note;
        $projectProfitLostTransaction->type="out";
        $projectProfitLostTransaction->project_id=$request->project_id;
        $projectProfitLostTransaction->account_id=$account['account']['id'];
        $projectProfitLostTransaction->account_number=$account['account']['number'];
        $projectProfitLostTransaction->account_name=$account['account']['name'];
        $projectProfitLostTransaction->source=$source;
        $projectProfitLostTransaction->save();
          DB::commit();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' =>  $projectProfitLostTransaction,
            ]);

      }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e.'',
            ], 500);

      }

 }
 
     public function OutDestroy($id)
    {
        //
             DB::beginTransaction();
            
        try{
             $project=ProjectProfitLostTransaction::find($id);
              
              $project->delete();

              
            DB::commit();
            return response()->json([
                'message' => 'Data has been deleted',
                'code' => 200,
                'error' => false,
                'data' => null,
            ]);

        }catch(Exception $e){
              DB::rollBack();
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e.'',
            ], 500);

        }
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
$transactionsByCurrentDateCount = Project::query()->where('start_date', $request->start_date)->get()->count();
        $number = "PR".'-' . $this->formatDate($request->start_date, "d") . $this->formatDate($request->start_date, "m") . $this->formatDate($request->start_date, "y") . '-' . sprintf('%04d', $transactionsByCurrentDateCount + 1);
        try {
       

            $project = new Project();
            $projectProfitLostTransaction=new ProjectProfitLostTransaction();
            $project->start_date=$request->start_date;
            $project->number=$number;
            $project->end_date=$request->end_date;
            $project->customer_id=1;
            $project->pic_event_id=$request->pic_id;
            $project->address=$request->address;
            $project->source=$request->source;
            $project->amount=$request->amount;
            $project->pic_event="1";
            $project->customer=$request->customer;
            $project->description=$request->description;   
            $project->source=$request->source;  
            $project->po_number=$request->po_number;
            $project->save();
                 $source=$request->source;

            if ($source=="quotation"){
                 $keyedQuotations = collect($request->items)->mapWithKeys(function ($item) use($project) {
            return [
                $item['id']=>[
                    
                    'project_id' => $project->id,
                    'sales_order_id' => 0,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),

                ]
                  
            ];
        })->all();
             $project->eventQuotations()->attach($keyedQuotations);
      

            }

            if ($source=="sales-order"){
            $keyedSalesOrder = collect($request->items)->mapWithKeys(function ($item) use($project) {
            return [
                $item['id']=>[
                    'project_id' => $project->id,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),

                ]
                  
            ];
        })->all();
           $project->v2SalesOrders()->attach($keyedSalesOrder);
            }

           

        $source='projects';
        $projectProfitLostTransaction->date=$request->start_date;
        $projectProfitLostTransaction->amount=$request->amount;
        $projectProfitLostTransaction->type="in";
        $projectProfitLostTransaction->source=$source;
        $projectProfitLostTransaction->init=1;
        $projectProfitLostTransaction->project_id=$project->id;
        $projectProfitLostTransaction->description="Total Biaya Project";
        $projectProfitLostTransaction->save();

        DB::commit();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => [],
            ]);


            
        } catch (Exception $e) {
                 DB::rollBack();
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e.'',
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
          $bast = Bast::with(['eventQuotation','customer','eventQuotation.poQuotation'])->findOrFail($id);

             $quotations = EventQuotation::with(['items','subItems' , 'picEvent','picPo','customer','poQuotation'])
        ->where('id',$bast->event_quotation_id)
        ->get();

        $quotations=collect($quotations)->each(function($row){
            $otherQuotationItem=OtherQuotationItem::with('goods')->where('event_quotation_id',$row->id)->get();
            $row['other_quotation_items']=$otherQuotationItem;
            $items=collect($row['items'])->each(function($item) use ($row){ 
                $subitems=collect($row['subItems'])->filter(function($value) use ($item){
                    return $value['item_id']==$item['id'];
                })->values()->all();
                // $sum=collect($quotation['subItems'])->sum('pivot.subtotal');
                 $sum=collect($row['subItems'])->filter(function($value) use ($item){
                    return $value['item_id']==$item['id'];
                })->sum('pivot.subtotal');
                $item['subtotal']=$sum;
                $item['pivot']=$item['pivot'];
                $item['sub_items']=$subitems;
            });

        })->first();
        

        $customers = Customer::all();
        return view('bast.edit', [
            'customers' => $customers,
            'bast'=>$bast,
            'quotation'=>$quotations
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
        //return $request->all();
        
        // $bastNumber = Bast::where('number', $request->number)->first();
        // if ($bastNumber !== null) {
        //     return response()->json([
        //         'message' => 'number or code already used',
        //         'code' => 400,
        //         // 'errors' => $/e,
        //     ], 400);
        // }
        DB::beginTransaction();
        try {

           
            
            $quotations=EventQuotation::findOrFail($request->event_quotation_id);
            $bast = Bast::findOrFail($id);
            $bast->number = $request->number;
            $bast->date = $request->date;
            $bast->customer_id = $request->customer_id;
            $bast->gr_number=$request->gr_number;
            $bast->pic_event=$request->event_pic_name;
            $bast->pic_event_position=$request->event_pic_position;
            $bast->pic_magenta=$request->magenta_pic_name;
            $bast->pic_magenta_position=$request->magenta_pic_position;
            $bast->po_file=null;
            $bast->gr_file=null;
            $bast->amount=$request->amount;
            
            $bast->event_quotation_id=$request->event_quotation_id;
            $bast->save();

            $quotations->total_bast=($quotations->total_bast-$request->amount_previously
            )+$request->amount;
            $quotations->save();
            DB::commit();

            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $bast,
            ]);
        } catch (Exception $e) {
                 DB::rollBack();
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e.'',
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
        //
             DB::beginTransaction();
            
        try{
            $project=Project::find($id);
            DB::table('event_quotation_project')->where('project_id', $id)->delete();
            DB::table('project_v2_sales_order')->where('project_id', $id)->delete();
            DB::table('project_profit_lost_transactions')->where('project_id', $id)->delete();

            $budgetProject=ProjectBudget::where('project_id')->first();
            if ($budgetProject!=null){
                DB::table('project_budget_transactions')->where('project_budget_id',  $budgetProject->id)->delete();
                $budgetProject->delete();
            }
            
              $project->delete();

              
            DB::commit();
            return response()->json([
                'message' => 'Data has been deleted',
                'code' => 200,
                'error' => false,
                'data' => null,
            ]);

        }catch(Exception $e){
              DB::rollBack();
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e.'',
            ], 500);

        }
    }


    public function print($id){
        $bast = Bast::with(['eventQuotation','customer','eventQuotation.poQuotation'])->findOrFail($id);
    

        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4',
            'mode' => 'utf-8',
            'orientation' => 'P',
            'margin_left' => 10,
            'margin_top' => 3,
            'margin_right' => 10,
            'margin_bottom' => 3,
        ]);

       
        

        $html = view('bast.print', [
            'bast' => $bast,
        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
        exit;

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function datatablesQuotations(Request $request)
    {
        
               $customerId = $request->query('customer_id');
        // $users = User::select(['id', 'name', 'email', 'created_at', 'updated_at']);
        $quotations = EventQuotation::with(['items','subItems' , 'picEvent','picPo','customer','poQuotation'])
        ->where('po_quotation_id','!=',null)
       
        ->get();
        $quotations=collect($quotations)->each(function($row){
            $otherQuotationItem=OtherQuotationItem::with('goods')->where('event_quotation_id',$row->id)->get();
            $row['other_quotation_items']=$otherQuotationItem;
            $items=collect($row['items'])->each(function($item) use ($row){ 
                $subitems=collect($row['subItems'])->filter(function($value) use ($item){
                    return $value['item_id']==$item['id'];
                })->values()->all();
                // $sum=collect($quotation['subItems'])->sum('pivot.subtotal');
                 $sum=collect($row['subItems'])->filter(function($value) use ($item){
                    return $value['item_id']==$item['id'];
                })->sum('pivot.subtotal');
                $item['subtotal']=$sum;
                $item['pivot']=$item['pivot'];
                $item['sub_items']=$subitems;
            });

        });
        return DataTables::of($quotations)
            ->addIndexColumn()
           
            ->addColumn('action', function (EventQuotation $quotation) {
                 $content = '<button class="btn btn-light-primary btn-choose"><i class="flaticon-add-circular-button"></i> Pilih</button>';
                return $content;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
        public function datatablesSalesOrders(Request $request)
    {        
       $customerId = $request->query('customer_id');
        // $users = User::select(['id', 'name', 'email', 'created_at', 'updated_at']);
        $quotations = EventQuotation::with(['items','subItems' , 'picEvent','picPo','customer','poQuotation'])
        ->where('po_quotation_id','!=',null)
        ->get();
         $salesOrders = V2SalesOrder::with(['v2Quotation', 'customerPurchaseOrder', 'customer'])->where('v2_sales_orders.source','!=','');



    
     
        return DataTables::of($salesOrders)
            ->addIndexColumn()
           
            ->addColumn('action', function (V2SalesOrder $salesOrders) {
                 $content = '<button class="btn btn-light-primary btn-choose"><i class="flaticon-add-circular-button"></i> Pilih</button>';
                return $content;
            })
            ->addColumn('netto', function ($row) {
                 
                return $row->source=='quotation'?$row->v2Quotation->total:$row->customerPurchaseOrder->total;
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function datatablesCustomerPurchaseOrders(Request $request)
    {
        $customerId = $request->query('customer_id');
        // $users = User::select(['id', 'name', 'email', 'created_at', 'updated_at']);
        $customerPurchaseOrders = CustomerPurchaseOrder::with(['items', 'v2SalesOrder', 'customer'])
            ->get();
        // ->filter(function ($quotation) {
        //     return count($quotation->salesOrders) < 1;
        // })->all();

        return DataTables::of($customerPurchaseOrders)
            ->addIndexColumn()
            ->addColumn('action', function (CustomerPurchaseOrder $purchaseOrder) {
                if ($purchaseOrder->v2SalesOrder !== null) {
                    $content = '<a href="/sales-order/detail/' . $purchaseOrder->v2SalesOrder->id . '" target="_blank"><span class="label label-success label-inline">#' . $purchaseOrder->v2SalesOrder->number . '</span></a>';
                } else {
                    $content = '<button class="btn btn-light-primary btn-choose"><i class="flaticon-add-circular-button"></i> Pilih</button>';
                }
                return $content;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
