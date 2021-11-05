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

    /* .finishing-item:nth-child(even) {
        background-color: #F3F6F9;
    } */

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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Tambah Job Order</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Job Order</a>
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
                <h3 class="card-title">Form Job Order</h3>

            </div>
            <!--begin::Form-->
            <form class="form" autocomplete="off" @submit.prevent="submitForm" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="mt-2">
                        <div class="my-3 text-right">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#salesOrderModal"><i class="flaticon2-plus"></i> Pilih Sales Order</button>
                        </div>
                        <div v-if="!selectedData">
                            <p class="text-center">
                                <i class="flaticon2-open-box font-size-h1"></i>
                            </p>
                            <p class="text-center text-dark-50"><strong>Pilih sales order</strong></p>
                        </div>
                        <div v-if="selectedData">
                            <div v-if="selectedData.source == 'sales_order'">
                                <!-- <h1>Sales Order <a href="#">#@{{ selectedData.data.number }}</a></h1> -->
                                <div class="row">
                                    <div class="col-md-12 col-lg-6">
                                        <div class="px-3 py-4 mb-3 rounded">
                                            <h3 class="mb-0"><i class="flaticon2-correct text-success icon-lg mr-2"></i> Sales Order <a href="#">#@{{ selectedData.data.number }}</a></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-4">
                                        <table class="table">
                                            <tr>
                                                <td>Nomor SO</td>
                                                <td><strong>@{{ selectedData.data.number }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Tanggal SO</td>
                                                <td><strong>@{{ selectedData.data.date }}</strong></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-12 col-lg-4">
                                        <table class="table">
                                            <tr>
                                                <td>Nomor Quotation</td>
                                                <td><strong>@{{ selectedData.data.quotation_number }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Tanggal Quotation</td>
                                                <td><strong>@{{ selectedData.data.quotation_date }}</strong></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-12 col-lg-4">
                                        <table class="table">
                                            <tr>
                                                <td>Nomor PO</td>
                                                <td><strong>@{{ selectedData.data.purchase_order_number }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Tanggal PO</td>
                                                <td><strong>@{{ selectedData.data.purchase_order_date }}</strong></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="mt-5">
                                    <table class="table table-bordered">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Kode</th>
                                                <th>Nama</th>
                                                <th>Deskripsi</th>
                                                <th>Tanggal Kirim</th>
                                                <th>Qty</th>
                                                <th>Price</th>
                                                <th>Amount</th>
                                                <th>Diproduksi</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td v-if="!dataItems.length" class="text-center" colspan="10"><em>Tidak ada item</em></td>
                                            </tr>
                                            <tr v-for="(item, index) in dataItems">
                                                <td>@{{ index + 1 }}</td>
                                                <td>@{{ item.code }}</td>
                                                <td>@{{ item.name }}</td>
                                                <td>@{{ item.description }}</td>
                                                <td>@{{ item.delivery_date }}</td>
                                                <td class="text-right">@{{ toCurrencyFormat(item.quantity) }}</td>
                                                <td class="text-right">@{{ toCurrencyFormat(item.price) }}</td>
                                                <td class="text-right">@{{ toCurrencyFormat(item.amount) }}</td>
                                                <td class="text-right">@{{ toCurrencyFormat(getProduced(item.job_orders)) }}</td>
                                                <td class="text-center">
                                                    <div v-if="getProduced(item.job_orders) < Number(item.quantity)">
                                                        <button v-if="selectedItem && selectedItem.id == item.id" type="button" @click="unselectItem()" class="btn btn-icon btn-warning btn-sm"><i class="flaticon2-writing"></i></button>
                                                        <button v-else type="button" @click="selectItem(index)" class="btn btn-icon btn-primary btn-sm"><i class="flaticon2-writing"></i></button>
                                                    </div>
                                                    <div v-else>
                                                        <i class="flaticon2-protected text-success"></i>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-20" v-if="selectedItem">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="goods-tab" data-toggle="tab" href="#goods">
                                    <span class="nav-icon">
                                        <i class="flaticon-signs-1"></i>
                                    </span>
                                    <span class="nav-text">Info Job Order</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="item-detail-tab" data-toggle="tab" href="#item-detail">
                                    <span class="nav-icon">
                                        <i class="flaticon-signs-1"></i>
                                    </span>
                                    <span class="nav-text">Detail Item</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="finishing-tab" data-toggle="tab" href="#finishing">
                                    <span class="nav-icon">
                                        <i class="flaticon-signs-1"></i>
                                    </span>
                                    <span class="nav-text">Finishing</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="other-tab" data-toggle="tab" href="#other">
                                    <span class="nav-icon">
                                        <i class="flaticon-information"></i>
                                    </span>
                                    <span class="nav-text">Info Lainnya</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="goods" role="tabpanel" aria-labelledby="goods-tab">
                                <div class="row mt-5">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="row justify-content-between">
                                            <div class=" col-lg-4 col-md-12">
                                                <div class="form-group">
                                                    <label>Tanggal:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="flaticon2-calendar-9"></i></span>
                                                        </div>
                                                        <input type="date" v-model="date" ref="date" id="date" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Jenis Pesanan:</label>
                                                    <textarea v-model="title" class="form-control"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label>Jumlah Pesanan:</label>
                                                    <input type="text" v-model="orderAmount" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tanggal Kirim:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="flaticon2-calendar-9"></i></span>
                                                        </div>
                                                        <input type="date" v-model="deliveryDate" id="delivery-date" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" col-lg-4 col-md-12">
                                                <div class="form-group">
                                                    <label>Nomor:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">#</span>
                                                        </div>
                                                        <input type="text" v-model="number" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Nomor Estimasi:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">#</span>
                                                        </div>
                                                        <input type="text" v-model="estimationNumber" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="item-detail" role="tabpanel" aria-labelledby="other-tab">
                                <div class="row mt-10">
                                    <div class="col-md-12 col-lg-4">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Cara Cetak:</label>
                                            <div class="col-sm-8">
                                                <select v-model="printType" class="form-control">
                                                    <option value="offset">Offset</option>
                                                    <option value="digital">Digital</option>
                                                    <option value="indigo">Indigo</option>
                                                    <option value="sablon">Sablon</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-4">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Dummy:</label>
                                            <div class="col-sm-8">
                                                <select v-model="dummy" class="form-control">
                                                    <option value="warna">Warna</option>
                                                    <option value="bw">BW</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-4">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">OKL:</label>
                                            <div class="col-sm-8">
                                                <select v-model="okl" class="form-control">
                                                    <option value="">...</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Ke</label>
                                            <div class="col-sm-8">
                                                <input type="text" v-model="oklNth" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="my-3 text-right">
                                        <button type="button" @click="addItem" class="btn btn-success"><i class="flaticon2-plus"></i> Tambah Item</button>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th rowspan="2" class="align-middle text-center">Item</th>
                                                    <th rowspan="2" class="align-middle text-center">Paper</th>
                                                    <th colspan="2" class="align-middle text-center">Plano</th>
                                                    <th colspan="2" class="align-middle text-center">Ukuran Potong</th>
                                                    <th colspan="2" class="align-middle text-center">Jumlah</th>
                                                    <th rowspan="2" class="align-middle text-center">Warna</th>
                                                    <th colspan="2" class="align-middle text-center">Film/CTP</th>
                                                    <th rowspan="2" class="align-middle text-center">Tipe Cetak</th>
                                                    <th rowspan="2" class="align-middle text-center"><i class="flaticon-more"></i></th>
                                                </tr>
                                                <tr>
                                                    <th class="align-middle text-center">Ukuran</th>
                                                    <th class="align-middle text-center">Jumlah</th>
                                                    <th class="align-middle text-center">Ukuran</th>
                                                    <th class="align-middle text-center">Jumlah</th>
                                                    <th class="align-middle text-center">Pesanan</th>
                                                    <th class="align-middle text-center">Cetakan</th>
                                                    <th class="align-middle text-center">Set</th>
                                                    <th class="align-middle text-center">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-if="!items.length">
                                                    <td colspan="12">
                                                        <p class="text-center">
                                                            <i class="flaticon2-open-box font-size-h1"></i>
                                                        </p>
                                                        <p class="text-center text-dark-50"><strong>Belum ada item</strong></p>
                                                    </td>
                                                </tr>
                                                <tr v-for="(item, index) in items">
                                                    <td>
                                                        <input type="text" v-model="item.item" class="form-control" style="width: 200px;">
                                                    </td>
                                                    <td>
                                                        <select v-model="item.paper" class="form-control" style="width: 200px;">
                                                            <option value="">Pilih Barang</option>
                                                            @foreach($goods as $good)
                                                            <option value="{{ $good->id }}">{{ $good->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" v-model="item.planoSize" class="form-control text-center" style="width: 200px;">
                                                    </td>
                                                    <td>
                                                        <input type="text" v-model="item.planoAmount" class="form-control text-right" style="width: 200px;">
                                                    </td>
                                                    <td>
                                                        <input type="text" v-model="item.cuttingSize" class="form-control text-center" style="width: 200px;">
                                                    </td>
                                                    <td>
                                                        <input type="text" v-model="item.cuttingAmount" class="form-control text-right" style="width: 200px;">
                                                    </td>
                                                    <td>
                                                        <input type="text" v-model="item.orderAmount" class="form-control" style="width: 200px;">
                                                    </td>
                                                    <td>
                                                        <input type="text" v-model="item.printAmount" class="form-control" style="width: 200px;">
                                                    </td>
                                                    <td>
                                                        <input type="text" v-model="item.color" class="form-control text-center" style="width: 200px;">
                                                    </td>
                                                    <td>
                                                        <input type="text" v-model="item.filmSet" class="form-control text-center" style="width: 200px;">
                                                    </td>
                                                    <td>
                                                        <input type="text" v-model="item.filmTotal" class="form-control text-center" style="width: 200px;">
                                                    </td>
                                                    <td>
                                                        <select v-model="item.printType" class="form-control" style="width: 200px;">
                                                            <option value="">1 Muka</option>
                                                            <option value="">BBL</option>
                                                            <option value="">BBS</option>
                                                            <option value="">BB</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <button type="button" @click="removeItem(index)" class="btn btn-icon btn-danger">
                                                            <i class="flaticon2-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="finishing" role="tabpanel" aria-labelledby="other-tab">
                                <div class="pt-5 pb-3">
                                    <div class="row">
                                        <div v-for="(category, index) in finishingItemCategories" class="col-lg-6 col-md-12 mt-5 mb-10">
                                            <h4>@{{ category.name }}</h4>
                                            <ul class="p-0 m-0" style="list-style: none;">
                                                <li v-for="item in category.finishing_items" class="finishing-item py-1 px-3 border-bottom">
                                                    <div class="row align-items-center my-2">
                                                        <div class="col-lg-6 col-md-12">
                                                            <label class="checkbox">
                                                                <input type="checkbox" v-model="item.checked">
                                                                <span></span>&nbsp; @{{ item.name }}
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-6 col-md-12">
                                                            <input type="text" v-model="item.description" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="p-3 bg-light">
                                                    <div class="row">
                                                        <div class="col-lg-8 .col-md-12">
                                                            <input type="text" class="form-control form-control-sm" placeholder="Masukkan item">
                                                        </div>
                                                        <div class="col-lg-4 .col-md-12">
                                                            <button class="btn btn-sm btn-primary w-100" :class="itemLoading && 'spinner spinner-white spinner-right'">Tambah</button>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mt-5 mb-10">
                                            <h4 class="text-success">Tambah Kategori</h4>
                                            <ul class="p-0 m-0" style="list-style: none;">
                                                <li class="p-3 bg-light">
                                                    <div class="row">
                                                        <div class="col-lg-8 .col-md-12">
                                                            <input type="text" class="form-control" placeholder="Masukkan kategori">
                                                        </div>
                                                        <div class="col-lg-4 .col-md-12">
                                                            <button class="btn btn-success w-100" :class="categoryLoading && 'spinner spinner-white spinner-right'">Tambah</button>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="other" role="tabpanel" aria-labelledby="other-tab">
                                <div class="pt-5 pb-3">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-group">
                                                <label>Designer:</label>
                                                <input type="text" v-model="designer" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Disiapkan:</label>
                                                <input type="text" v-model="preparer" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Diperiksa:</label>
                                                <input type="text" v-model="examiner" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Produksi:</label>
                                                <input type="text" v-model="production" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Finishing:</label>
                                                <input type="text" v-model="finishing" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Gudang:</label>
                                                <input type="text" v-model="warehouse" class="form-control">
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
    <div class="modal fade" id="salesOrderModal" tabindex="-1" aria-labelledby="salesOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="salesOrderModalLabel">Pilih Sales Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table" id="sales-order-table">
                        <thead>
                            <th>Nomor</th>
                            <th>Tanggal</th>
                            <th>Action</th>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
            number: '',
            estimationNumber: '',
            date: '',
            title: '',
            orderAmount: '',
            deliveryDate: '',
            printType: '',
            dummy: '',
            okl: '',
            oklNth: '',
            designer: '',
            preparer: '',
            examiner: '',
            production: '',
            finishing: '',
            warehouse: '',
            description: '',
            items: [{
                item: '',
                paper: '',
                planoSize: '',
                planoAmount: '',
                cuttingSize: '',
                cuttingAmount: '',
                orderAmount: '',
                printAmount: '',
                color: '',
                filmSet: '',
                filmTotal: '',
                printType: '',
            }],
            finishingItemCategories: JSON.parse(String.raw `{!! $finishing_item_categories !!}`),
            selectedData: null,
            selectedItem: null,
            loading: false,
            itemLoading: false,
            categoryLoading: false,
        },
        methods: {
            submitForm: function() {
                this.sendData();
            },
            sendData: function() {
                // console.log('submitted');
                let vm = this;
                vm.loading = true;

                const data = {
                    number: vm.number,
                    estimation_number: vm.estimationNumber,
                    date: vm.date,
                    title: vm.title,
                    order_amount: vm.orderAmount,
                    delivery_date: vm.deliveryDate,
                    print_type: vm.printType,
                    dummy: vm.dummy,
                    okl: vm.okl,
                    okl_nth: vm.oklNth,
                    designer: vm.designer,
                    preparer: vm.preparer,
                    examiner: vm.examiner,
                    production: vm.production,
                    finishing: vm.finishing,
                    warehouse: vm.warehouse,
                    description: vm.description,
                    sales_order_id: vm.selectedData.data.id,
                    cpo_item_id: vm.selectedItem.source == 'purchase_order' ? vm.selectedItem.id : '',
                    quotation_item_id: vm.selectedItem.source == 'quotation' ? vm.selectedItem.id : '',
                    customer_id: '',
                    items: vm.items,
                    finishing_items: vm.finishingItemCategories.map(item => item.finishing_items).flat(),
                }

                // let formData = new FormData();
                // for (var key in data) {
                //     formData.append(key, data[key]);
                // }

                axios.post('/job-order', data)
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
            addItem: function() {
                this.items.push({
                    item: '',
                    paper: '',
                    planoSize: '',
                    planoAmount: '',
                    cuttingSize: '',
                    cuttingAmount: '',
                    orderAmount: '',
                    printAmount: '',
                    color: '',
                    filmSet: '',
                    filmTotal: '',
                    printType: '',
                })
            },
            removeItem: function(index) {
                this.items.splice(index, 1);
            },
            selectItem: function(index) {
                let vm = this;
                let item = vm.dataItems[index];
                vm.title = item.code + ' ' + item.name;
                vm.deliveryDate = item.delivery_date;

                const produced = vm.getProduced(item.job_orders);
                const notProduced = item.quantity - produced;
                console.log(notProduced);
                vm.orderAmount = notProduced < 0 ? 0 : notProduced;

                vm.selectedItem = item;
                // this.selectedItem.source = this.dataItems[index].source;
                // if (this.dataItems[index].hasOwnProperty('v2_quotation_id')) {
                //     this.selectedItem.source = 'quotation';
                // } else if (dataItems[index].hasOwnProperty('customer_purchase_order_id')) {
                //     this.selectedItem.source = 'purchase_order';
                // }
            },
            unselectItem: function(index = null) {
                this.selectedItem = null;
            },
            toCurrencyFormat: function(number) {
                if (!number) {
                    number = 0;
                }
                return new Intl.NumberFormat('De-de').format(number);
            },
            getProduced: function(jobOrders, property = 'order_amount') {
                if (typeof jobOrders !== "undefined") {
                    return jobOrders.map(jobOrder => Number(jobOrder[property])).reduce((acc, cur) => {
                        return acc + cur;
                    }, 0);
                } else {
                    return 0;
                }

                return 0;
            }
        },
        computed: {
            grandTotal: function() {
                const grandTotal = this.items.map(item => Number(item.amount)).reduce((acc, cur) => {
                    return acc + cur;
                }, 0);

                return grandTotal;
            },
            dataItems: function() {
                let vm = this;
                if (vm.selectedData) {
                    let items = [];
                    const {
                        source
                    } = vm.selectedData.data;
                    if (source == 'quotation') {
                        items = vm.selectedData.data.v2_quotation.items.map(item => {
                            item.source = 'quotation';
                            return item;
                        });
                    } else if (source == 'purchase_order') {
                        items = vm.selectedData.data.customer_purchase_order.items.map(item => {
                            item.source = 'purchase_order';
                            return item;
                        });
                    }
                    // if (vm.selectedData.data.v2_quotation && vm.selectedData.data.customer_purchase_order == null) {
                    //     items = vm.selectedData.data.v2_quotation.items;
                    // } else if (vm.selectedData.data.customer_purchase_order !== null) {
                    //     items = vm.selectedData.data.customer_purchase_order.items;
                    // }

                    return items;
                }

                return [];
            }
        },
        watch: {
            selectedItem: function(newVal) {
                let vm = this;
                // console.log(newVal)
                // if (newVal !== null) {
                // $(vm.$refs.date).datepicker({
                //     format: 'yyyy-mm-dd',
                //     todayBtn: false,
                //     clearBtn: true,
                //     todayHighlight: true,
                //     orientation: "bottom left",
                // }).on('changeDate', function(e) {
                //     app.$data.date = e.format(0, 'yyyy-mm-dd');
                // });

                // $('#delivery-date').datepicker({
                //     format: 'yyyy-mm-dd',
                //     todayBtn: false,
                //     clearBtn: true,
                //     todayHighlight: true,
                //     orientation: "bottom left",
                // }).on('changeDate', function(e) {
                //     app.$data.deliveryDate = e.format(0, 'yyyy-mm-dd');
                // });
                // }
            },
            orderAmount: function(newVal) {
                let vm = this;
                let item = vm.selectedItem;
                const produced = vm.getProduced(item.job_orders);
                const notProduced = item.quantity - produced;
                if (newVal > notProduced) {
                    vm.orderAmount = notProduced;
                }
            }
        }
    })
</script>
<script>
    $(function() {

        salesOrdersTable = $('#sales-order-table').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: '/datatables/v2/job-orders/sales-orders',
            columns: [{
                    data: 'number',
                    name: 'v2_sales_orders.number',
                    render: function(data, type) {
                        return `<a href="#">${data}</a>`;
                    }
                },
                {
                    data: 'date',
                    name: 'v2_sales_orders.date'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $('#sales-order-table tbody').on('click', '.btn-choose', function() {
            const data = salesOrdersTable.row($(this).parents('tr')).data();
            app.$data.selectedData = {
                data,
                source: 'sales_order',
            };

            // app.$data.salesOrderNumber = app.$data.selectedData.data.number;
            // const newDate = app.$data.selectedData.data.date;
            // app.$data.salesOrderDate = newDate;
            // $('#salesOrder-date').datepicker('update', newDate);

            $('#salesOrderModal').modal('hide');
        });

    })
</script>
@endsection