<?php

namespace App\Http\Controllers  ;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Customer;
use App\Models\EventQuotation;
use App\Models\Goods;
use App\Models\PicEvent;
use App\Models\PicPo;
use App\Models\Item;
use App\Models\OtherQuotationItem;
use App\Models\QuotationOtherItem;
use App\Models\V2Quotation;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\PHPMailer;
use Yajra\DataTables\Facades\DataTables;

use function GuzzleHttp\Promise\each;

class OtherQuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // all data
        // $eventQuotations=EventQuotation::with(['items','subItems','picPo','picEvent','customer'])->where('id',18)->get();
        // $eventQuotations=collect($eventQuotations)->each(function($quotation){
        //     $items=collect($quotation['items'])->each(function($item) use ($quotation){ 
        //         $subitems=collect($quotation['subItems'])->filter(function($value) use ($item){
        //             return $value['item_id']==$item['id'];

        //         });
        //         $item['pivot']=$item['pivot'];
        //         $item['sub_items']=$subitems;
                
                
         
        //     });
            
        // })->first();


        return view('other-quotation.index');
    }

      private function formatDate($date = "", $format = "Y-m-d")
    {
        return date_format(date_create($date), $format);
    }

    /**
     * Send datatable form.
     *
     * @return \Yajra\DataTables\Facades\DataTables
     */
      public function indexData()
    {
        $quotations = EventQuotation::with('poQuotation')->select('event_quotations.*')->where('type','other');
        return DataTables::eloquent($quotations)
            ->addIndexColumn()
              ->addColumn('po_quotation_number',function($row){
                return $row->poQuotation!=null?$row->poQuotation->number:"";
            })
            ->addColumn('action', function ($row) {
                  $poNumber='<li class="navi-item">
                                    <a  href="/other-quotation/detail/' . $row->id . '"" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="flaticon2-list-2"></i>
                                        </span>
                                        <span class="navi-text">Detail</span>
                                    </a>
                                </li>';
                //        if ($row->poQuotation==null){
                //          $poNumber='<li class="navi-item">
                //                     <a data-toggle="modal" data-target="#poModal" href="/event-quotation/email/' . $row->id . '"" class="navi-link">
                //                         <span class="navi-icon">
                //                             <i class="flaticon2-plus"></i>
                //                         </span>
                //                         <span class="navi-text">PO</span>
                //                     </a>
                //                 </li>';
                // }else{
                //          $poNumber='<li class="navi-item">
                //                     <a data-toggle="modal" data-target="#poModal" href="/event-quotation/email/' . $row->id . '"" class="navi-link">
                //                         <span class="navi-icon">
                //                             <i class="flaticon2-edit"></i>
                //                         </span>
                //                         <span class="navi-text">PO</span>
                //                     </a>
                //                 </li>';
                // }
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
                           
                          
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ki ki-bold-more-hor"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                            <!--begin::Navigation-->
                            <ul class="navi navi-hover">
                                <li class="navi-item">
                                    <a href="/other-quotation/print/' . $row->id . '" target="_blank" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="flaticon2-print"></i>
                                        </span>
                                        <span class="navi-text">Cetak</span>
                                    </a>
                                </li>
                               
                                 <li class="navi-item">
                                    <a href="/event-quotation/email/' . $row->id . '"" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="flaticon2-email"></i>
                                        </span>
                                        <span class="navi-text">Email</span>
                                    </a>
                                </li>

                                 '.$poNumber.'
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
        $customers = Customer::all();      
        $eventPics=PicEvent::with('customer')->get();
       
        //return $eventPics;
        $eventPics = $eventPics->map(function ($item, $key) {
            return ['id' => $item->id, 'text' => $item->name.' | '.$item->customer->name,'customer'=>$item->customer->name];
        });
        $eventPics->prepend(['id' => '', 'text' => 'Choose Event Pic']);
        $poPics=PicPo::with('customer')->get();
        $poPics = $poPics->map(function ($item, $key) {
            return ['id' => $item->id, 'text' => $item->name .' | '.$item->customer->name,'customer'=>$item->customer->name];
        });
        $poPics->prepend(['id' => '', 'text' => 'Choose PO Pic']);
        $eventPic=PicEvent::with('customer')->get();

        $goods=Goods::all();
        
        $eventPic=collect($eventPic)->map(function($value,$key){
           return [
               'id'=>$value['id'],
               'customer_id'=>$value['customer']['id'],
               'customer_name'=>$value['customer']['name'],
               'ppn'=>$value['customer']['with_ppn'],
               'pph23'=>$value['customer']['with_pph'],
            ];

          

        });

        return view('other-quotation.create', [
            'customers' => $customers,
            'eventPics'=>$eventPics,
            'poPics'=>$poPics,
            'eventPic'=>$eventPic,
            'goods'=>$goods,
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

        //phpreturn $request->all();
        DB::beginTransaction();

          $transactionsByCurrentDateCount = EventQuotation::query()->where('date', $request->date)->get()->count();
            $number = 'QO-' . $this->formatDate($request->date, "d") . $this->formatDate($request->date, "m") . $this->formatDate($request->date, "y") . '-' . sprintf('%04d', $transactionsByCurrentDateCount + 1);

        try {

            $quotation = new EventQuotation();
            $selectedItems=$request->selected_items;
            $quotation->number = $number;
            $quotation->date = $request->date;
           
  
            $quotation->asf = $request->asf_amount;
            $quotation->asf_percent = $request->percent_asf;
            $quotation->discount =$request->discount_amount;
            $quotation->discount_percent = $request->percent_discount;
            $quotation->ppn = $request->ppn;
            $quotation->ppn_amount = $request->ppn_amount;
            $quotation->pph = $request->pph23;
            $quotation->pph23_amount = $request->pph23_amount;
            $quotation->total=$request->total;
            $quotation->netto=$request->netto;
            $quotation->customer_id=$request->customer_id;
            $quotation->file="1";
            $quotation->title=$request->title;

            $quotation->subtotal=$request->subtotal;
            $quotation->pic_po_id=$request->po_pic_id;
            $quotation->pic_event_id=$request->event_pic_id;
           
            $quotation->type="other";
           // return $selectedItems;
            $quotation->save();


             foreach ($selectedItems as $item){
                  if ($item['isStock']!=0){
                    $goodsRow = Goods::find($item['goodsId']);
                     if ($goodsRow == null) {
                        continue;
                     }
                     $goodsRow->stock=$goodsRow->stock-$item['quantity'];
                     $goodsRow->save();
                    }
            }

             $items = collect($selectedItems)->map(function ($item) use ($quotation) {
                return [
                    'name'=>$item['name'],
                    'quantity'=>$item['quantity'],
                    'frequency'=>$item['frequency'],
                    'price'=>$item['price'],
                    'is_stock'=>$item['isStock'],
                    'stock'=>$item['isStock'],
                    'event_quotation_id'=>$quotation->id,
                    'goods_id'=>$item['goodsId'],
                    'amount'=>$item['amount'],
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ];
            })->all();

             DB::table('other_quotation_items')->insert($items);
          
            DB::commit();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $quotation,
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
        $customers = Customer::all();      
        $eventPics=PicEvent::with('customer')->get();
        $eventQuotation=EventQuotation::with('customer')->findOrFail($id);
        $otherQuotationitems=OtherQuotationItem::with('goods')->where('event_quotation_id',$id)->get();
        $otherQuotationitems=collect($otherQuotationitems)->each(function($item){
            if ($item->goods!==null){
            $item['purchasePrice']=$item->goods->purchase_price;
            $item['goodsId']=$item->goods->id;
            $item['goodsName']=$item->goods->name;
            $item['isStock']=1;
            $item['stock']=$item['stock']+$item->quantity;

        
            }else{
            $item['purchasePrice']=0;
            $item['goodsId']=0;
            $item['goodsName']=null;
             $item['isStock']=0;

            }
   

        });
        
       
       
        //return $eventPics;
        $eventPics = $eventPics->map(function ($item, $key) {
            return ['id' => $item->id, 'text' => $item->name.' | '.$item->customer->name,'customer'=>$item->customer->name];
        });
        $eventPics->prepend(['id' => '', 'text' => 'Choose Event Pic']);
        $poPics=PicPo::with('customer')->get();
        $poPics = $poPics->map(function ($item, $key) {
            return ['id' => $item->id, 'text' => $item->name .' | '.$item->customer->name,'customer'=>$item->customer->name];
        });
        $poPics->prepend(['id' => '', 'text' => 'Choose PO Pic']);
        $eventPic=PicEvent::with('customer')->get();

        $goods=Goods::all();
       // return $otherQuotationitems;
        $eventPic=collect($eventPic)->map(function($value,$key){
           return [
               'id'=>$value['id'],
               'customer_id'=>$value['customer']['id'],
               'customer_name'=>$value['customer']['name'],
               'ppn'=>$value['customer']['with_ppn'],
               'pph23'=>$value['customer']['with_pph'],
            ];
        });

         return view('other-quotation.edit', [
            'customers' => $customers,
            'eventPics'=>$eventPics,
            'poPics'=>$poPics,
            'eventPic'=>$eventPic,
            'goods'=>$goods,
            'event_quotation'=>$eventQuotation,
            'other_quotation_items'=>$otherQuotationitems
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
       
        //phpreturn $request->all();
        DB::beginTransaction();

          
        try {

            $quotation = EventQuotation::find($id);
            $selectedItems=$request->selected_items;
           
            $quotation->date = $request->date;
           
  
            $quotation->asf = $request->asf_amount;
            $quotation->asf_percent = $request->percent_asf;
            $quotation->discount =$request->discount_amount;
            $quotation->discount_percent = $request->percent_discount;
            $quotation->ppn = $request->ppn;
            $quotation->ppn_amount = $request->ppn_amount;
            $quotation->pph = $request->pph23;
            $quotation->pph23_amount = $request->pph23_amount;
            $quotation->total=$request->total;
            $quotation->netto=$request->netto;
            $quotation->customer_id=$request->customer_id;
            $quotation->file="1";
            $quotation->title=$request->title;
            $quotation->subtotal=$request->subtotal;
            $quotation->pic_po_id=$request->po_pic_id;
            $quotation->pic_event_id=$request->event_pic_id;
            $quotation->type="other";
           // return $selectedItems;

            $quotation->save();

            //update product
             foreach ($selectedItems as $item){
                  if ($item['isStock']!=0){
                    $goodsRow = Goods::find($item['goodsId']);
                     if ($goodsRow == null) {
                        continue;
                     }
                     $goodsRow->stock=$item['stock']-$item['quantity'];
                     $goodsRow->save();
                    }
            }
              DB::table('other_quotation_items')->where('event_quotation_id', $id)->delete();

            //save item

             $items = collect($selectedItems)->map(function ($item) use ($quotation) {
                return [
                    'name'=>$item['name'],
                    'quantity'=>$item['quantity'],
                    'frequency'=>$item['frequency'],
                    'price'=>$item['price'],
                    'is_stock'=>$item['isStock'],
                    'stock'=>$item['isStock'],
                    'event_quotation_id'=>$quotation->id,
                    'goods_id'=>$item['goodsId'],
                    'amount'=>$item['amount'],
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ];
            })->all();

          
             DB::table('other_quotation_items')->insert($items);
             DB::commit();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $quotation,
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
       // return "tes";
        DB::beginTransaction();
        //
        
        try{
        $quotationEvent=EventQuotation::findOrFail($id);
        //event_quotation_id	
        $otherQuotationItems=OtherQuotationItem::where('event_quotation_id',$id)->get();
        //return $otherQuotationItems;
        foreach ($otherQuotationItems as $otherQuotationItem){
            if ($otherQuotationItem['is_stock']==1){
                $goodsRow = Goods::find($otherQuotationItem['goods_id']);
                     if ($goodsRow == null) {
                        continue;
                     }
                     $goodsRow->stock=$goodsRow->stock+$otherQuotationItem['quantity'];
                     $goodsRow->save();
                     $otherQuotationItem->delete();
            }else{
                 $otherQuotationItem->delete();
            }
        }
        $quotationEvent->delete();
        DB::commit();
            return response()->json([
                'message' => 'Data has been saved',
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print($id)
    {
        $eventQuotations=EventQuotation::with(['picPo','picEvent','customer'])->where('id',$id)->get();
        $otherQuotationItem=OtherQuotationItem::with('goods')->where('event_quotation_id',$id)->get();
      

        $eventQuotations=collect($eventQuotations)->each((function($item) use($otherQuotationItem){
            $item['items']=$otherQuotationItem;

        }))->first();
   //     return $eventQuotations;

     
       //return $eventQuotations;

        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4',
            'mode' => 'utf-8',
            'orientation' => 'P',
            'margin_left' => 3,
            'margin_top' => 3,
            'margin_right' => 3,
            'margin_bottom' => 3,
        ]);

        $company = Company::all()->first();

        if ($company == null) {
            $newCompany = new Company;
            $newCompany->save();
            $company = Company::all()->first();
        }
        
        $html = view('other-quotation.print', [
            'company' => $company,
            'quotation' => $eventQuotations,
    
        ]   );

        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    public function email($id){
       // return $id;
       $eventQuotation=EventQuotation::with(['picEvent','picPo'])->findOrFail($id);
        return view('other-quotation.email', [
            'event_quotation'=>$eventQuotation,
            'id'=>$id
        ]);
    }

    public function sendEmail(Request $request,$id){
        return $request->all();
           require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);     // Passing `true` enables exceptions
      //  return  $request->body;

       // return $request->all();

        try {

            // Email server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';             //  smtp host
            $mail->SMTPAuth = true;
            $mail->Username = 'rezha.arenzha@gmail.com';   //  sender username
            $mail->Password = 'pajak123';       // sender password
            $mail->SMTPSecure = 'tls';                  // encryption - ssl/tls
            $mail->Port = 587;                          // port - 587/465
            //email pengirim
            $mail->setFrom('rezha.arenzha@gmail.com', 'Magenta EO');
            $mail->addReplyTo('rezha.arenzha@gmail.com', 'MagentaEO');
            // Add a recipient
            $mail->addAddress($request->event_pic_email); //email penerima
            $mail->addAddress($request->po_pic_email);
            



   $eventQuotations=EventQuotation::with(['picPo','picEvent','customer'])->where('id',$id)->get();
        $otherQuotationItem=OtherQuotationItem::with('goods')->where('event_quotation_id',$id)->get();
      

        $eventQuotations=collect($eventQuotations)->each((function($item) use($otherQuotationItem){
            $item['items']=$otherQuotationItem;

        }))->first();


        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4',
            'mode' => 'utf-8',
            'orientation' => 'P',
            'margin_left' => 3,
            'margin_top' => 3,
            'margin_right' => 3,
            'margin_bottom' => 3,
        ]);

        $company = Company::all()->first();

        if ($company == null) {
            $newCompany = new Company;
            $newCompany->save();
            $company = Company::all()->first();
        }
        
        $html = view('other-quotation.print', [
            'company' => $company,
            'quotation' => $eventQuotations,
          
        ]   );

        $mpdf->WriteHTML($html);// Set email content format to HTML

        $pdf = $mpdf->output("", "S");
        $mail->Subject = $request->subject;
        $mail->addStringAttachment($pdf, "laporan" . ".pdf");
        // Set email format to HTML
        $mail->isHTML(true);
           $mail->Body = $request->body;
            if( !$mail->send() ) {
                //return back()->with("failed", "Email not sent.")->withErrors($mail->ErrorInfo);
                return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => 'e',
            ], 500);
            }
            
            else {
                //return back()->with("success", "Email has been sent.");

                  return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => null,
            ]);
            }

        } catch (Exception $e) {
             //return back()->with('error','Message could not be sent.');
             return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e.'',
            ], 500);
        }
    }

    public function datatablesEventQuotationItems()
    {
       
        $goods=Goods::all();
        $quotations = Item::with(['subitems'])->get();
        $quotations=collect($quotations)->each(function($item) use ($goods){
            if ($item['is_stock']==1){
                $item['goods']=$goods;
            }
        });
        return DataTables::of($quotations)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $button = '<button class="btn btn-light-primary btn-choose"><i class="flaticon-add-circular-button"></i> Pilih</button>';
                // $button='<label class="checkbox"> <input v-model="ppn" class="btn-choose" type="checkbox" value="false">   <span></span>&nbsp;  </label>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

}
