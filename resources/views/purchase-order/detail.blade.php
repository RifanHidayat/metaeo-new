@extends('layouts.app')

@section('title', 'Metaprint')

@section('head')
<link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('pagestyle')
<style>
    .input-group-text {
        padding: 0.45rem 1rem;
    }

    input.form-control:read-only {
        background-color: #fafafa;
    }

    /* table tbody td {
        vertical-align: middle;
    } */
</style>
@endsection

@section('subheader')
<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Page Title-->
                <h5 class="text-dark font-weight-bold my-1 mr-5">Tambah Pesanan Pembelian</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Pesanan Pembelian</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Tambah</a>
                    </li>
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page Heading-->
        </div>
        <!--end::Info-->
        <!--begin::Toolbar-->
        <!--end::Toolbar-->
    </div>
</div>
@endsection

@section('content')
<div class="row" id="app">
    <div class="col-lg-12">
        <h3 class="text-muted"> </h3>
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <h3 class="card-title">Detail Pembelian</h3>

            </div>

              <div class="my-3 bg-light rounded p-5">
                                        <a data-toggle="collapse" href="#collapsePOInfo" role="button" aria-expanded="false" aria-controls="collapsePOInfo" class="d-block text-dark-50">
                                            <div class="row justify-content-between">
                                                <div class="col-sm-6">
                                                    <strong class="d-block"><i class="flaticon2-information align-middle text-success"></i>&nbsp;Informasi Pesanan Pembelian</strong>
                                                </div>
                                                <div class="col-sm-6 text-right">
                                                    <i class="flaticon2-down"></i>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="collapse" id="collapsePOInfo">
                                            <div class="row pt-3">
                                                <div class="col-lg-6 col-md-12">
                                                    <table class="table">
                                                        <tr>
                                                            <td>Nomor</td>
                                                            <td><strong>{{ $purchase_order->number }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tanggal</td>
                                                            <td><strong>{{ \Carbon\Carbon::parse($purchase_order->date)->isoFormat('LL') }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Supplier</td>
                                                            <td><strong>{{ $purchase_order->supplier !== null ? $purchase_order->supplier->name : '' }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Alamat Kirim</td>
                                                            <td><strong>{{ $purchase_order->delivery_address }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tanggal Pengiriman</td>
                                                            <td><strong>{{ \Carbon\Carbon::parse($purchase_order->deliveryDate)->isoFormat('LL') }}</strong></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <table class="table">
                                                        <tr>
                                                            <td>Pengiriman</td>
                                                            <td><strong>{{ $purchase_order->shipment !== null ? $purchase_order->shipment->name : '' }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Syarat Pembayaran</td>
                                                            <td><strong>{{ $purchase_order->payment_term }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>FOB</td>
                                                            <td><strong>{{ $purchase_order->fobItem !== null ? $purchase_order->fobItem->name : '' }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Keterangan</td>
                                                            <td><strong>{{ $purchase_order->description }}</strong></td>
                                                        </tr>

                                                         <tr>
                                                            <td>Total barang Diterima</td>
                                                            <td><strong>{{ $purchase_receives_total }}</strong></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                               
                                               
                                                 <th>Nama Barang</th>
                                                <th>Kode #</th>
                                                <th>Kuantitas</th>
                                                <th>Harga</th>
                                                <th>Diskon</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(goods,index) in purchaseOrder.goods">
                                              
                                                <th>@{{goods.name}}</th>
                                                <th>@{{goods.number}}</th>
                                                <th>@{{toCurrencyFormat(goods.pivot.quantity)}}</th>
                                                <th>@{{toCurrencyFormat(goods.pivot.price)}}</th>
                                                <th>@{{ toCurrencyFormat(goods.pivot.discount)}}</th>
                                                <th>@{{ toCurrencyFormat(goods.pivot.total)}}</th>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                <tr>
                    <td style="border: none; width: 100px;" colspan="4">
                        
                    </td>
                    <td style="text-align: right;">Subtotal :</td>
                    <td style="text-align: right;"> @{{ toCurrencyFormat(purchaseOrder.total)}}</td>
                </tr>
                <tr>
                    <td style="border: none;" colspan="4"></td>
                    <td style="text-align: right;">Diskon :</td>
                    <td style="text-align: right;">@{{toCurrencyFormat(purchaseOrder.discount )}} </td>
                </tr>
               
                <tr v-if="purchaseOrder.ppn_amount>0">
                    <td style="border: none;" colspan="4"></td>
                    <td style="text-align: right;">PPN 11% :</td>
                    <td style="text-align: right;"> @{{toCurrencyFormat(purchaseOrder.ppn_amount )}}</td>
                </tr>

                    <tr v-if="purchaseOrder.pph_amount>0">
                        <td style="border: none;" colspan="4"></td>
                        <td style="text-align: right;">PPH  :</td>
                        <td style="text-align: right;"> @{{ toCurrencyFormat(purchaseOrder.pph_amount)}}</td>
                    </tr>
                <tr>
                    <td style="border: none;" colspan="4"></td>
                    <td style="text-align: right;">Total  :</td>
                    <td style="text-align: right;"> @{{ toCurrencyFormat(purchaseOrder.total)}} </td>
                </tr>
            </tfoot>
         </table>


         <div class="my-3 rounded p-5">
             
                                        <a data-toggle="collapse" href="#collapseReceiveInfo" role="button" aria-expanded="false" aria-controls="collapsePOInfo" class="d-block text-dark-50">
                                            <div class="row justify-content-between">
                                                <div class="col-sm-6">
                                                    <strong class="d-block"><i class="flaticon2-information align-middle text-success"></i>&nbsp;Informasi Penerimaan Pembelian</strong>
                                                </div>
                                                <div class="col-sm-6 text-right">
                                                    <i class="flaticon2-down"></i>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="collapse" id="collapseReceiveInfo">
                                    
                                        <template class="ml-15" v-for="(purchaseReceipt,index) in purchaseReceives"> 
                                                <div class="row pt-3">
                                                <div class="col-lg-6 col-md-12">
                                                    <a href="#" class="ml-2 mt-10"># Pernerimaan @{{index+1}} </a>
                                                    <table class="table">
                                                        <tr>
                                                            <td>Nomor</td>
                                                            <td><strong>@{{ purchaseReceipt.number }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tanggal</td>
                                                            <td><strong>@{{ purchaseReceipt.date }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Shipper</td>
                                                            <td><strong> @{{ purchaseReceipt.shipper }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Peneriman</td>
                                                            <td><strong>@{{ purchaseReceipt.recipient }}   </strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tanggal Pengiriman</td>
                                                            <td><strong>{{ \Carbon\Carbon::parse($purchase_order->deliveryDate)->isoFormat('LL') }}</strong></td>
                                                        </tr>
                                                    </table>
                                                </div>

                                                
                                               
                                            </div>
                                                                                <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                               
                                               
                                                 <th>Nama Barang</th>
                                                <th>Kode #</th>
                                                <th>Kuantitas</th>
                                                <th align="right">Harga</th>
                                              
                                                <th align="right">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <tr v-for="(goods,index) in purchaseReceipt.goods">
                                               
                                                <th>@{{goods.name}}</th>
                                                <th>@{{goods.number}}</th>
                                                <th>@{{toCurrencyFormat(goods.pivot.quantity )}}</th>
                                              <th>@{{  Intl.NumberFormat('De-de').format(goods.purchase_price)}}</th>
                                            
                                         
                                                <th> @{{  Intl.NumberFormat('De-de').format(Number(goods.pivot.quantity) * Number(goods.purchase_price))}}</th>
                                        
                                            </tr>
                                        </tbody>
                                                         <tfoot>
          
                                                         
<!--                    
                <tr>
                    <td style="border: none;" colspan="1"></td>
                    <td style="text-align: right;">Total Penerimaan  :</td>
                    <td style="text-align: right;"> @{{purchaseReceipt.goods.reduce((partialSum, a) => partialSum + a['pivot']['quantity'], 0)}} </td>
                     <td style="text-align: right;">Total Harga  :</td>
                    <td style="text-align: right;"> @{{purchaseReceipt.goods.reduce((partialSum, a) => partialSum + a['purchase_price'], 0)}} </td>
                </tr> -->
            </tfoot>
         </table>

             <div class="mt-20">
                                        <div class="row justify-content-end">
                                            <div class="col-lg-3">
                                                <div class="border">
                                                    <div class="bg-primary w-100" style="height: 5px;"></div>
                                                    <div class="p-3">
                                                        <strong>Total Diterima</strong>
                                                        <p class="text-right font-size-h4">@{{ toCurrencyFormat(purchaseReceipt.goods.reduce((partialSum, a) => partialSum + a['pivot']['quantity'], 0)) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-lg-3">
                                                <div class="border">
                                                    <div class="bg-danger w-100" style="height: 5px;"></div>
                                                    <div class="p-3">
                                                        <h4>Diskon <a data-toggle="collapse" href=".collapseDiscount" role="button" aria-expanded="false" aria-controls="collapseDiscount"><i class="flaticon-edit text-primary"></i></a></h4>
                                                        <div class="collapse show collapseDiscount">
                                                            <p class="text-right font-size-h4">Rp @{{ toCurrencyFormat(discount) }}</p>
                                                        </div>
                                                        <div class="collapse collapseDiscount">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">Rp</span>
                                                                </div>
                                                                <input type="text" v-model="discount" class="form-control form-control text-right">
                                                                <div class="input-group-append">
                                                                    <button type="button" class="btn btn-success" data-toggle="collapse" data-target=".collapseDiscount" aria-expanded="false" aria-controls="collapseDiscount"><i class="fas fa-save"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <div class="col-lg-3">
                                                <div class="border">
                                                    <div class="bg-success w-100" style="height: 5px;"></div>
                                                    <div class="p-3">
                                                        <strong>Total Penerimaan</strong>
                                                        <p class="text-right font-size-h4">@{{ toCurrencyFormat(purchaseReceipt.goods.reduce((partialSum, a) => partialSum + (a['purchase_price'] * a['pivot']['quantity']), 0)) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
  
  
                                        </template>
                                        </div>
                                    </div>


                                             <!-- <div class="my-3 rounded p-5">
                                        <a data-toggle="collapse" href="#collapseReturnInfo" role="button" aria-expanded="false" aria-controls="collapsePOInfo" class="d-block text-dark-50">
                                            <div class="row justify-content-between">
                                                <div class="col-sm-6">
                                                    <strong class="d-block"><i class="flaticon2-information align-middle text-success"></i>&nbsp;Informasi Retur Pembelian</strong>
                                                </div>
                                                <div class="col-sm-6 text-right">
                                                    <i class="flaticon2-down"></i>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="collapse" id="collapseReturnInfo">
                                    
                                        <template v-for="(purchaseReturn,index) in purchaseReturns"> 
                                                <div class="row pt-3">
                                                <div class="col-lg-6 col-md-12">
                                                    <a href="#">#Retur  Barang @{{index+1}} </a>
                                                    <table class="table">
                                                        <tr>
                                                            <td>Nomor</td>
                                                            <td><strong>@{{ purchaseReturn.number }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tanggal</td>
                                                            <td><strong>@{{ purchaseReturn.date }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Deskripsi</td>
                                                            <td><strong> @{{ purchaseReturn.description }}</strong></td>
                                                        </tr>
                                                       
                                                       
                                                    </table>
                                                </div>
                                               
                                            </div>
                                            <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                               
                                               
                                                 <th>Nama Barang</th>
                                                <th>Kode #</th>
                                                <th>Kuantitas</th>
                                                <th align="right">Alasan</th>
                                              
                                                <th align="right">Deskirpsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(goods,index) in purchaseReturn.goods">
                                            
                                                <th>@{{goods.name}}</th>
                                                <th>@{{goods.number}}</th>
                                                <th>@{{toCurrencyFormat(goods.pivot.quantity)}}</th>
                                                <th>@{{goods.pivot.cause=="wrong"?"Tidak Sesuai":"Cacat / Rusak"}}</th>
                                                 <th>@{{goods.pivot.description}}</th>
                                            </tr>
                                        </tbody>
                                        <tfoot>
               
               
               
               
             
            </tfoot>
         </table>
           <div class="mt-20">
                                        <div class="row justify-content-end">
                                            <div class="col-lg-3">
                                                <div class="border">
                                                    <div class="bg-primary w-100" style="height: 5px;"></div>
                                                    <div class="p-3">
                                                        <strong>Total Diretur</strong>
                                                        <p class="text-right font-size-h4">@{{ toCurrencyFormat(purchaseReturn.goods.reduce((partialSum, a) => partialSum + a['pivot']['quantity'], 0))}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                         
                                          
                                        </div>
                                    </div>
  
  
  
                                        </template>
                                        </div>
                                    </div> -->

                                    <div class="my-3  rounded p-5">
                                        <a data-toggle="collapse" href="#collapseTrInfo" role="button" aria-expanded="false" aria-controls="collapseTrInfo" class="d-block text-dark-50">
                                            <div class="row justify-content-between">
                                                <div class="col-sm-6">
                                                    <strong class="d-block"><i class="flaticon2-information align-middle text-success"></i>&nbsp;History Pembayaran</strong>
                                                </div>
                                                <div class="col-sm-6 text-right">
                                                    <i class="flaticon2-down"></i>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="collapse" id="collapseTrInfo">
                                            <div class="row pt-3">
                                               <template v-for="(transaction,index) in purchaseTransactions">
                                                    <div class="col-lg-6 col-md-12">
                                                         <a href="#" class="ml-2 mt-10">#Pembayaran @{{index+1}} </a>
                                                    <table class="table">
                                                        <tr>
                                                            <td>Nomor</td>
                                                            <td><strong>@{{transaction.number }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tanggal</td>
                                                            <td><strong>@{{ transaction.date }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Pembayaran</td>
                                                            <td><strong>@{{toCurrencyFormat(transaction.payment_amount )}}</strong></td>
                                                        </tr>
                                                       
                                                      
                                                    </table>
                                                </div>
                                               </template>
                                          
                                            </div>
                                        </div>
                                    </div>



        </div>

        
    </div>
    <!-- Modal -->
    <div class="modal fade" id="goodsModal" tabindex="-1" aria-labelledby="goodsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="goodsModalLabel">Pilih Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table" id="table-goods">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <!-- <th></th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(good, index) in goods">
                                <td><a href="#" @click.prevent="selectGoods(good)" class="d-block p-3 bg-hover-light text-dark">@{{ good.name }}</a></td>
                                <!-- <td><a href="#">Pilih</a></td> -->
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/pages/features/miscellaneous/sweetalert2.js') }}"></script>
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
@endsection

@section('pagescript')
<script>
    let app = new Vue({
        el: '#app',
        data: {
            suppliers: JSON.parse(String.raw `{!! $suppliers !!}`),
            goods: JSON.parse(String.raw `{!! $goods !!}`),
            shipments: JSON.parse(String.raw `{!! $shipments !!}`),
            fobItems: JSON.parse(String.raw `{!! $fob_items !!}`),
            supplier: '',
            number: '',
            date: '',
            deliveryAddress: '',
            deliveryDate: '',
            shipment: '',
            paymentTerm: 'net_7',
            fob: '',
            description: '',
            selectedGoods: [],
            discount: 0,
            ppn: false,
            ppnValue: 10,
            shippingCost: 0,
            otherCost: 0,
            otherCostDescription: '',
            loading: false,
            purchaseOrder:JSON.parse(`{!! $purchase_order !!}`),
            purchaseReceives:JSON.parse(String.raw`{!! $purchase_order->purchaseReceives !!}`),
            purchaseReturns:JSON.parse(`{!! $purchase_order->purchaseReturns !!}`),
            purchaseTransactions:JSON.parse(`{!! $purchase_order->purchaseTransactions !!}`)
        },
        methods: {
            submitForm: function() {
                this.sendData();
            },
            sendData: function() {
                // console.log('submitted');
                let vm = this;
                vm.loading = true;
                axios.post('/purchase-order', {
                        supplier_id: vm.supplier,
                        number: vm.number,
                        date: vm.date,
                        delivery_address: vm.deliveryAddress,
                        delivery_date: vm.deliveryDate,
                        shipment_id: vm.shipment,
                        payment_term: vm.paymentTerm,
                        fob_item_id: vm.fob,
                        description: vm.description,
                        selected_goods: vm.selectedGoods,
                        discount: vm.discount,
                        ppn: vm.ppn ? 1 : 0,
                        ppn_value: vm.ppnValue,
                        ppn_amount: vm.ppnAmount,
                        shipping_cost: vm.shippingCost,
                        other_cost: vm.otherCost,
                        other_cost_description: vm.otherCostDescription,
                        subtotal: vm.subtotal,
                        total: vm.grandTotal,
                        pph:vm.pphAmount
                    })
                    .then(function(response) {
                        vm.loading = false;
                        Swal.fire({
                            title: 'Success',
                            text: 'Data has been saved',
                            icon: 'success',
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // window.location.href = '/goods';
                            }
                        })
                        // console.log(response);
                    })
                    .catch(function(error) {
                        vm.loading = false;
                        console.log(error);
                        Swal.fire(
                            'Oops!',
                            'Something wrong',
                            'error'
                        )
                    });
            },
            selectGoods: function(item) {
                let vm = this;
                const newGoods = {
                    ...item,
                    quantity: 1,
                    price: item.purchase_price,
                    discount: 0,
                    total: item.purchase_price,
                    pph: item.pph,
                    type:item.type,
                    isPpn:1
                }
                vm.selectedGoods.push(newGoods);
                $('#goodsModal').modal('hide');
            },
            removeGoods: function(index) {
                let vm = this;
                vm.selectedGoods.splice(index, 1);
            },
            toCurrencyFormat: function(number) {
                return new Intl.NumberFormat('De-de').format(number);
            }
        },
        computed: {
            subtotal: function() {
                const subtotal = this.selectedGoods.map(goods => Number(goods.total)).reduce((acc, cur) => {
                    return acc + cur;
                }, 0);

                return subtotal;
            },
            subtotal: function() {
                const subtotal = this.selectedGoods.map(goods => Number(goods.total)).reduce((acc, cur) => {
                    return acc + cur;
                }, 0);

                return subtotal;
            },
            ppnAmount: function() {
                // let vm = this;
                // if (!vm.ppn) {
                //     return 0;
                // }

                // const ppn = (this.subtotal - Number(this.discount)) * (Number(10) / 100);
                // return Math.round(ppn);

                // const subtotal = this.selectedGoods.map(goods => Number(goods.total)).reduce((acc, cur) => {
                //     return acc + cur;
                // }, 0);
                const ppn=this.selectedGoods.filter(goods=>{return goods.isPpn==1}).map(goods=>{
                    const amount=((Number(goods.price)*Number(goods.quantity))-Number(goods.discount))*(Number(11)/100)
                    return amount;
                }).reduce((acc,cur)=>{
                    return Number(acc)+Number(cur)
                },0)
                return Math.round(ppn);
            },
                 pphAmount: function() {
                // let vm = this;
                // if (!vm.ppn) {
                //     return 0;
                // }

                // const ppn = (this.subtotal - Number(this.discount)) * (Number(10) / 100);
                // return Math.round(ppn);

                // const subtotal = this.selectedGoods.map(goods => Number(goods.total)).reduce((acc, cur) => {
                //     return acc + cur;
                // }, 0);
                const pph=this.selectedGoods.filter(goods=>{return goods.type=="jasa" && goods.pph!=0}).map(goods=>{
                    const amount=((Number(goods.price)*Number(goods.quantity))-Number(goods.discount))*(Number(goods.pph)/100)
                    return amount;
                }).reduce((acc,cur)=>{
                    return Number(acc)+Number(cur)
                },0)
                return Math.round(pph);
            },
            grandTotal: function() {
                const grandTotal = this.subtotal - Number(this.discount) + this.ppnAmount + Number(this.shippingCost) + Number(this.otherCost);
                return grandTotal;
            }
        },
        watch: {
            selectedGoods: {
                handler: function(newval, oldval) {
                    this.selectedGoods.forEach(goods => {
                        goods.total = (Number(goods.price) * Number(goods.quantity)) - Number(goods.discount);
                    });
                },
                deep: true
            }
        }
    })
</script>
<script>
    $(function() {
        $('#table-goods').DataTable();

        function hideElement(el) {
            $(el).hide();
        }

        function showElement(el) {
            $(el).show();
        }

        $("#shipment-select").select2({
            width: '100%',
            language: {
                noResults: function() {
                    const searchText = $("#shipment-select").data("select2").dropdown.$search.val();
                    if (!searchText) {
                        return "No Result Found";
                    }
                    return `
                        <a href="#" class="d-block" id="btn-add-shipment"><i class="fas fa-plus fa-sm"></i> Tambah ${searchText} </a>
                        <div class="progress mt-2" id="loadingShipment" style="display: none">
                            <div class="progress-bar bg-primary w-100 progress-bar-striped progress-bar-animated" data-progress="100"></div>
                        </div>
                        `;
                },
            },
            escapeMarkup: function(markup) {
                return markup;
            },
        });
        $("#shipment-select").on('change', function() {
            console.log('clicked');
            app.$data.shipment = $(this).val();
            // console.log(searchText);
        });

        $(document).on('click', '#btn-add-shipment', function(e) {
            e.preventDefault();
            const searchText = $("#shipment-select").data("select2").dropdown.$search.val();
            const data = {
                name: searchText,
                status: 1,
            }

            addShipment(data);
            // console.log('clicked');
        })

        function addShipment(data) {
            showElement('#loadingShipment');
            axios.post('/shipment', data)
                .then(function(response) {
                    const {
                        data
                    } = response.data;
                    app.$data.shipments.push(data);
                    app.$data.shipment = data.id;
                    $('#shipment-select').val(data.id);
                    $('#shipment-select').select2('close');
                    hideElement('#loadingShipment');
                })
                .catch(function(error) {
                    // vm.loading = false;
                    $('#shipment-select').select2('close');
                    hideElement('#loadingShipment');
                    console.log(error);
                    Swal.fire(
                        'Terjadi Kesalahan',
                        'Gagal menambahkan pengiriman',
                        'error'
                    )
                });
        }

        function formatState(state) {
            if (!state.id) {
                return state.text;
            }

            let desc = state.element.getAttribute('data-desc');
            if (!desc) {
                desc = '';
            }

            var $state = $(
                // '<span><img src="' + baseUrl + '/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span>'
                '<div>' +
                '<span class="d-block"><strong>' + state.text + '</strong></span>' + '<small>' + desc + '</small>' +
                '</div>'


            );
            return $state;
        };

        $("#payment-term-select").select2({
            width: '100%',
            templateResult: formatState
        });

        $("#payment-term-select").on('change', function() {
            console.log('clicked');
            app.$data.paymentTerm = $(this).val();
            // console.log(searchText);
        });

        $("#fob-item-select").select2({
            width: '100%',
            language: {
                noResults: function() {
                    const searchText = $("#fob-item-select").data("select2").dropdown.$search.val();
                    if (!searchText) {
                        return "No Result Found";
                    }
                    return `
                        <a href="#" class="d-block" id="btn-add-fob-item"><i class="fas fa-plus fa-sm"></i> Tambah ${searchText} </a>
                        <div class="progress mt-2" id="loadingFobItem" style="display: none">
                            <div class="progress-bar bg-primary w-100 progress-bar-striped progress-bar-animated" data-progress="100"></div>
                        </div>
                        `;
                },
            },
            escapeMarkup: function(markup) {
                return markup;
            },
        });

        $("#fob-item-select").on('change', function() {
            console.log('clicked');
            app.$data.fob = $(this).val();
            // console.log(searchText);
        });

        $(document).on('click', '#btn-add-fob-item', function(e) {
            e.preventDefault();
            const searchText = $("#fob-item-select").data("select2").dropdown.$search.val();
            const data = {
                name: searchText,
                status: 1,
            }

            addFobItem(data);
            // console.log('clicked');
        })

        function addFobItem(data) {
            showElement('#loadingFobItem');
            axios.post('/fob-item', data)
                .then(function(response) {
                    const {
                        data
                    } = response.data;
                    app.$data.fobItems.push(data);
                    app.$data.fob = data.id;
                    $('#fob-item-select').val(data.id);
                    $('#fob-item-select').select2('close');
                    hideElement('#loadingFobItem');
                })
                .catch(function(error) {
                    // vm.loading = false;
                    $('#fob-item-select').select2('close');
                    hideElement('#loadingFobItem');
                    console.log(error);
                    Swal.fire(
                        'Terjadi Kesalahan',
                        'Gagal menambahkan FOB',
                        'error'
                    )
                });
        }

        $("#supplier-select").select2({
            width: '100%',
            language: {
                noResults: function() {
                    const searchText = $("#supplier-select").data("select2").dropdown.$search.val();
                    if (!searchText) {
                        return "No Result Found";
                    }
                    return `
                        <a href="#" class="d-block" id="btn-add-supplier"><i class="fas fa-plus fa-sm"></i> Tambah ${searchText} </a>
                        <div class="progress mt-2" id="loadingSupplier" style="display: none">
                            <div class="progress-bar bg-primary w-100 progress-bar-striped progress-bar-animated" data-progress="100"></div>
                        </div>
                        `;
                },
            },
            escapeMarkup: function(markup) {
                return markup;
            },
        });

        $("#supplier-select").on('change', function() {
            console.log('clicked');
            app.$data.supplier = $(this).val();
            // console.log(searchText);
        });

        $(document).on('click', '#btn-add-supplier', function(e) {
            e.preventDefault();
            const searchText = $("#supplier-select").data("select2").dropdown.$search.val();
            const data = {
                name: searchText,
                status: 1,
            }

            addSupplier(data);
            // console.log('clicked');
        })

        function addSupplier(data) {
            showElement('#loadingSupplier');
            axios.post('/supplier', data)
                .then(function(response) {
                    const {
                        data
                    } = response.data;
                    app.$data.suppliers.push(data);
                    app.$data.supplier = data.id;
                    $('#supplier-select').val(data.id);
                    $('#supplier-select').select2('close');
                    hideElement('#loadingSupplier');
                })
                .catch(function(error) {
                    // vm.loading = false;
                    $('#supplier-select').select2('close');
                    hideElement('#loadingSupplier');
                    console.log(error);
                    Swal.fire(
                        'Terjadi Kesalahan',
                        'Gagal menambahkan Supplier',
                        'error'
                    )
                });
        }

        $('#po-date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: false,
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
        }).on('changeDate', function(e) {
            app.$data.date = e.format(0, 'yyyy-mm-dd');
        });

        $('#delivery-date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: false,
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
        }).on('changeDate', function(e) {
            app.$data.deliveryDate = e.format(0, 'yyyy-mm-dd');
        });
    })
</script>
@endsection