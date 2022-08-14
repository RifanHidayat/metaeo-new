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
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <h3 class="card-title">Form Pesanan Pembelian</h3>

            </div>
            <!--begin::Form-->
            <form class="form" autocomplete="off" @submit.prevent="submitForm">
                <div class="card-body">
                      <div class="form-row col-8" >
                  <div class="form-group col-lg-6">
                       <label>Tanggal:</label>
                               
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="flaticon2-calendar-9"></i></span>
                                    </div>
                                    <input type="text" v-model="date" id="po-date" class="form-control">
                                </div>
                   </div>
                  <!-- <div class="form-group col-lg-6">
                      <label>Number: <span class="text-danger">*</span></label>
                      <input v-model="number" type="text" class="form-control" disabled  >
                   
                   </div>                   -->
                </div>

                     <div class="form-row col-8" >
                  
                  <div class="form-group col-lg-6">
                         <label>Supplier:</label>
                                <select v-model="supplier" class="form-control" id="supplier-select">
                                    <option value="">Pilih Supplier</option>
                                    <option v-for="(supplier, index) in suppliers" :value="supplier.id">@{{ supplier.name }}  </option>
                                </select>
                      <!-- <span class="form-text text-muted">Please enter supplier's name</span> -->
                   </div>                  
                </div>
                    <!-- <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>Supplier:</label>
                                <select v-model="supplier" class="form-control" id="supplier-select">
                                    <option value="">Pilih Supplier</option>
                                    <option v-for="(supplier, index) in suppliers" :value="supplier.id">@{{ supplier.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="form-group">
                                <label>Nomor:</label>
                               
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">#</span>
                                    </div>
                                    <input type="text" v-model="number" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div> -->
                    
                    <!-- <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>Tanggal:</label>
                               
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="flaticon2-calendar-9"></i></span>
                                    </div>
                                    <input type="text" v-model="date" id="po-date" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="mt-5">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="goods-tab" data-toggle="tab" href="#goods">
                                    <span class="nav-icon">
                                        <i class="flaticon-signs-1"></i>
                                    </span>
                                    <span class="nav-text">List Barang</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="other-cost-tab" data-toggle="tab" href="#other-cost">
                                    <span class="nav-icon">
                                        <i class="flaticon-signs-1"></i>
                                    </span>
                                    <span class="nav-text">Biaya Lain</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="other-tab" data-toggle="tab" href="#other">
                                    <span class="nav-icon">
                                        <i class="flaticon-information"></i>
                                    </span>
                                    <span class="nav-text">info Lainnya</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="goods" role="tabpanel" aria-labelledby="goods-tab">
                                <div class="mt-2">
                                    <div class="my-3 text-right">
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#goodsModal"><i class="flaticon2-plus"></i> Tambah</button>
                                    </div>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td>PPN</td>
                                                <td>Nama Barang</td>
                                                <td>Kode #</td>
                                                <td>Kuantitas</td>
                                            
                                                <td>Harga</td>
                                                <td>Diskon</td>
                                                <td>Total Harga</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-if="!selectedGoods.length">
                                                <td colspan="8">
                                                    <p class="text-center">
                                                        <i class="flaticon2-open-box font-size-h1"></i>
                                                    </p>
                                                    <p class="text-center">Belum ada barang</p>
                                                </td>
                                            </tr>
                                            <tr v-for="(good, index) in selectedGoods">
                                                <td>
                                                    <div class="form-group col-md-4">
                                                    <label class="checkbox">
                                                        <input v-model="good.isPpn" type="checkbox">
                                                        <span></span>
                                                    </label>
                                                </div>
                                                </td>
                                                <td style="vertical-align: middle;">@{{ good.name }}</td>
                                                <td style="vertical-align: middle;">@{{ good.number }}</td>
                                                <td><input type="text" v-model="good.quantity" class="form-control form-control-sm text-right"></td>
                                                
                                                <td>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Rp</span>
                                                        </div>
                                                        <input type="text" v-model="good.price" class="form-control form-control-sm text-right">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Rp</span>
                                                        </div>
                                                        <input type="text" v-model="good.discount" class="form-control form-control-sm text-right">
                                                    </div>
                                                </td>
                                                <td style="vertical-align: middle;" class="text-right">@{{ toCurrencyFormat(good.total) }}</td>
                                                <td style="vertical-align: middle;" class="text-center">
                                                    <a href="#" @click.prevent="removeGoods(index)"><i class="flaticon2-trash text-danger"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- <div class="mt-20">
                                        <div class="row justify-content-end">
                                            <div class="col-lg-4 col-md-12">
                                                
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="mt-20">
                                        <div class="row justify-content-end">
                                            <div class="col-lg-2">
                                                <div class="border">
                                                    <div class="bg-primary w-100" style="height: 5px;"></div>
                                                    <div class="p-3">
                                                        <h4>Subtotal</h4>
                                                        <p class="text-right font-size-h4">Rp @{{ toCurrencyFormat(subtotal) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                              <div class="col-lg-2" v-if="ppnAmount>0">
                                                <div class="border">
                                                    <div class="bg-primary w-100" style="height: 5px;"></div>
                                                    <div class="p-3">
                                                        <h4>PPN</h4>
                                                        <p class="text-right font-size-h4">Rp @{{ toCurrencyFormat(ppnAmount) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                               <div class="col-lg-2" v-if="pphAmount>0">
                                                <div class="border">
                                                    <div class="bg-primary w-100" style="height: 5px;"></div>
                                                    <div class="p-3">
                                                        <h4>PPh</h4>
                                                        <p class="text-right font-size-h4">Rp @{{ toCurrencyFormat(pphAmount) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
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
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="border">
                                                    <div class="bg-success w-100" style="height: 5px;"></div>
                                                    <div class="p-3">
                                                        <h4>Total</h4>
                                                        <div v-if="ppn" class="row">
                                                            <div class="col-sm-6">
                                                                <span>PPN @{{ ppnValue }}%</span>
                                                            </div>
                                                            <div class="col-sm-6 text-right">
                                                                <span>@{{ toCurrencyFormat(ppnAmount) }}</span>
                                                            </div>
                                                        </div>
                                                        <div v-if="shippingCost > 0" class="row">
                                                            <div class="col-sm-6">
                                                                <span>Biaya Kirim</span>
                                                            </div>
                                                            <div class="col-sm-6 text-right">
                                                                <span>@{{ toCurrencyFormat(shippingCost) }}</span>
                                                            </div>
                                                        </div>
                                                        <div v-if="otherCost > 0" class="row">
                                                            <div class="col-sm-6">
                                                                <span>Biaya Lain (@{{ otherCostDescription }})</span>
                                                            </div>
                                                            <div class="col-sm-6 text-right">
                                                                <span>@{{ toCurrencyFormat(otherCost) }}</span>
                                                            </div>
                                                        </div>
                                                        <!-- <p v-if="ppn" class="text-right"> </p> -->
                                                        <p class="text-right font-size-h4">Rp @{{ toCurrencyFormat(grandTotal) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="other-cost" role="tabpanel" aria-labelledby="other-cost-tab">
                                <div class="pt-5">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-row align-items-center">
                                                <!-- <div class="form-group col-md-4">
                                                    <label class="checkbox">
                                                        <input v-model="ppn" type="checkbox">
                                                        <span></span>&nbsp;PPN
                                                    </label>
                                                </div> -->
                                                <!-- <div class="form-group col-md-8">
                                                    <div class="input-group">
                                                        <input type="text" v-model="ppnValue" class="form-control text-right" placeholder="Tarif PPN" :readonly="!ppn">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><strong class="text-dark-50">%</strong></span>
                                                        </div>
                                                    </div>
                                                </div> -->
                                            </div>
                                            <div class="form-group">
                                                <label>Ongkos Kirim:</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><strong class="text-dark-50">Rp</strong></span>
                                                    </div>
                                                    <input type="text" v-model="shippingCost" class="form-control text-right">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Biaya Lain:</label>
                                                <div class="form-row">
                                                    <div class="col-lg-6 col-md-12">
                                                        <input type="text" v-model="otherCostDescription" class="form-control" placeholder="Keterangan Biaya Lain">
                                                    </div>
                                                    <div class="col-lg-6 col-md-12">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><strong class="text-dark-50">Rp</strong></span>
                                                            </div>
                                                            <input type="text" v-model="otherCost" class="form-control text-right">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="other" role="tabpanel" aria-labelledby="other-tab">
                                <div class="pt-5 pb-3">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-group">
                                                <label>Alamat Kirim:</label>
                                                <textarea class="form-control" v-model="deliveryAddress"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Tanggal Pengiriman:</label>
                                                <!-- <input type="text" class="form-control"> -->
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="flaticon2-calendar-9"></i></span>
                                                    </div>
                                                    <input type="text" v-model="deliveryDate" id="delivery-date" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label d-block">Pengiriman:</label>
                                                <select v-model="shipment" class="form-control" id="shipment-select">
                                                    <option value="">Pilih Pengiriman</option>
                                                    <option v-for="(shipment, index) in shipments" :value="shipment.id">@{{ shipment.name }}</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Syarat Pembayaran:</label>
                                                <select v-model="paymentTerm" class="form-control d-block" id="payment-term-select">
                                                    <option value="net_7" data-desc="Jatuh tempo 7 hari">Net 7</option>
                                                    <option value="net_15" data-desc="Jatuh tempo 15 hari">Net 15</option>
                                                    <option value="net_30" data-desc="Jatuh tempo 30 hari">Net 30</option>
                                                    <option value="net_45" data-desc="Jatuh tempo 45 hari">Net 45</option>
                                                    <option value="net_60" data-desc="Jatuh tempo 60 hari">Net 60</option>
                                                    <option value="cod" data-desc="Tunai saat pengantaran (COD)">COD</option>
                                                    <option value="manual" data-desc="Set syarat pembayaran manual">Set Manual</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>FOB:</label>
                                                <select v-model="fob" class="form-control" id="fob-item-select">
                                                    <option value="">Pilih FOB</option>
                                                    <option v-for="(fob, index) in fobItems" :value="fob.id">@{{ fob.name }}</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Keterangan:</label>
                                                <textarea v-model="description" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- begin: Example Code-->

                    <!-- end: Example Code-->
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-6">

                        </div>
                        <div class="col-lg-6 text-lg-right">
                            <button type="submit" class="btn btn-primary" :class="loading && 'spinner spinner-white spinner-right'" :disabled="loading">
                                Save
                            </button>
                            <!-- <button type="reset" class="btn btn-secondary">Cancel</button> -->
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
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
                                 <th>Jenis</th>
                                <!-- <th></th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(good, index) in goods">
                                <td><a href="#" @click.prevent="selectGoods(good)" class="d-block p-3 bg-hover-light text-dark">@{{ good.name }}</a>
                            </td>
                            <td><a href="#" @click.prevent="selectGoods(good)" class="d-block p-3 bg-hover-light text-dark">@{{ good.type }}</a>
                            </td>
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
            supplier: '{{$purchase_order->supplier_id}}',
            number: '',
            date: '{{$purchase_order->date}}',
            deliveryAddress: '{!!$purchase_order->delivery_address!!}',
            deliveryDate: '{!!$purchase_order->date!!}',
            shipment:'{!!$purchase_order->shipment_id!!}',
            paymentTerm: '{!!$purchase_order->payment_term!!}',
            fob: '{!!$purchase_order->fob_item_id!!}',
            description: '{!!$purchase_order->description!!}',
            selectedGoods:JSON.parse(String.raw `{!! $purhase_goods !!}`) ,
            discount: 0,
            ppn: false,
            ppnValue: 10,
            shippingCost: '{!!$purchase_order->shipping_cost!!}',
            otherCost: '{!!$purchase_order->other_cost!!}',
            otherCostDescription: '{!!$purchase_order->other_cost_description!!}',
            loading: false,
            id:'{{$purchase_order->id}}'
        },
        methods: {
            submitForm: function() {
                this.sendData();
            },
            sendData: function() {
                // console.log('submitted');
                let vm = this;
                vm.loading = true;
                axios.patch('/purchase-order/'+this.id, {
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
                        pph_amount:vm.pphAmount
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
                                 window.location.href = '/purchase-order';
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
                const pph=this.selectedGoods.filter(goods=>{return goods.type=="jasa"}).map(goods=>{
                    const  percentage=goods.pph_rates!=null?goods.pph_rates.amount:0;
                    const amount=((Number(goods.price)*Number(goods.quantity))-Number(goods.discount))*(Number(percentage)/100)
                    return amount;
                }).reduce((acc,cur)=>{
                    return Number(acc)+Number(cur)
                },0)
                return Math.round(pph);
            },
            grandTotal: function() {
                const grandTotal = Number(this.subtotal) - Number(this.discount) + Number(this.ppnAmount) + Number(this.shippingCost) + Number(this.otherCost)-Number(this.pphAmount);
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