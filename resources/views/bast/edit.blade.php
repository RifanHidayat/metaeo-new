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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Tambah BAST</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">BAST</a>
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
                <h3 class="card-title">Form BAST</h3>

            </div>
            <!--begin::Form-->
            <form class="form" autocomplete="off" @submit.prevent="submitForm" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <div class="form-row">
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Nomor:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">#</span>
                                        </div>
                                        <input type="text" v-model="number" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>PIC Event:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        
                                        <input type="text" v-model="eventPicName" id="eventPicName" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="bg-gray-100 p-3 rounded"> -->
                            <div class="form-row">
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Nomor GR:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">#</span>
                                        </div>
                                        <input type="text" v-model="grNumber" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Jabatan:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        
                                        <input type="text" v-model="eventPicPosition" id="eventPicPosition" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Tanggal:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="flaticon2-calendar-9"></i></span>
                                        </div>
                                        <input type="text" v-model="date" class="form-control" id="date">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>PIC Magenta:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        
                                        <input type="text" v-model="magentaPicName" id="magentaPicName" class="form-control">
                                    </div>
                                </div>
                            </div>

                              <div class="form-row">
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Customer:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        
                                        <input type="text" v-model="customer" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>jabatan:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        
                                        <input type="text" v-model="magentaPicPosition" id="po-date" class="form-control">
                                    </div>
                                </div>
                            </div>

                             <div class="form-row">
                                
                                <div class="form-group col-lg-12 col-md-12">
                                    <label>Nominal:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp </span>
                                        </div>
                                        <input type="text" v-model="amount" id="amount" class="form-control text-right" @input="validateAmount"><br>
                                        
                                    </div>
                                    <div  v-if="selectedData">
                                    <span class="text-danger">Sisa BAST @{{toCurrencyFormat(bastRemaining)}}</span>
                                    </div>
                                        
                                </div>
                            </div>
                            <!-- </div> -->
                        </div>
                    </div>
                    <div class="mt-5">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="goods-tab" data-toggle="tab" href="#goods">
                                    <span class="nav-icon">
                                        <i class="flaticon-signs-1"></i>
                                    </span>
                                    <span class="nav-text">List Item</span>
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
                                <div class="mt-2">
                                    <div class="my-3 text-right">
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#quotationModal"><i class="flaticon2-plus"></i> Pilih Quotation</button>
                                      
                                    </div>
                                    <div v-if="!selectedData">
                                        <p class="text-center">
                                            <i class="flaticon2-open-box font-size-h1"></i>
                                        </p>
                                        <p class="text-center text-dark-50"><strong>Tidak ada data</strong></p>
                                    </div>
                                    <div v-if="selectedData">
                                        <div v-if="selectedData.source == 'purchase_order'">
                                            <div class="row">
                                                <div class="col-md-12 col-lg-12">
                                                    <div class="px-3 py-4 mb-3 rounded">
                                                        <h3 class="mb-0"><i class="flaticon2-correct text-success icon-lg mr-2"></i> Purchase Order <a href="#">#@{{ selectedData.data.number }}</a></h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-lg-6">
                                                    <table class="table">
                                                        <tr>
                                                            <td>Nomor PO</td>
                                                            <td><strong>@{{ selectedData.data.number }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tanggal PO</td>
                                                            <td><strong>@{{ selectedData.data.date }}</strong></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-12 col-lg-6">
                                                    <table class="table">
                                                        <tr>
                                                            <td>Customer</td>
                                                            <td><strong>@{{ selectedData.data.customer?.name }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Keterangan</td>
                                                            <td><strong>@{{ selectedData.data.description }}</strong></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="mt-5">
                                                <table class="table table-bordered">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th class="text-center">No</th>
                                                            <th>Kode</th>
                                                            <th class="text-center">Deskripsi</th>
                                                            <th class="text-center">Tanggal Kirim</th>
                                                            <th class="text-center">Kode Pajak</th>
                                                            <th class="text-right">Qty</th>
                                                            <th class="text-right">Price</th>
                                                            <th class="text-right">Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(item, index) in selectedData.data.items">
                                                            <td class="text-center">@{{ index + 1 }}</td>
                                                            <td>@{{ item.code }}</td>
                                                            <td><strong>@{{ item.name }}</strong> <br> <em class="text-dark-50">@{{ item.description }}</em></td>
                                                            <td class="text-center">@{{ item.delivery_date }}</td>
                                                            <td class="text-center text-capitalize">@{{ item.tax_code }}</td>
                                                            <td class="text-right">@{{ toCurrencyFormat(item.quantity) }}</td>
                                                            <td class="text-right">@{{ toCurrencyFormat(item.price) }}</td>
                                                            <td class="text-right">@{{ toCurrencyFormat(item.amount) }}</td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td class="text-right" colspan="7"><strong>TOTAL</strong></td>
                                                            <td class="text-right"><strong>@{{ toCurrencyFormat(selectedData.data.total) }}</strong></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <div v-if="selectedData.source == 'quotation'">
                                            <!-- <h1>Quotation <a href="#">#@{{ selectedData.data.number }}</a></h1> -->
                                            <div class="row">
                                                <div class="col-md-12 col-lg-12">
                                                    <div class="px-3 py-4 mb-3 rounded">
                                                        <h3 class="mb-0"><i class="flaticon2-correct text-success icon-lg mr-2"></i> Quotation <a href="#">#@{{ selectedData.data.number }}</a></h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-lg-6">
                                                    <table class="table">
                                                        <tr>
                                                            <td>Nomor Quotation</td>
                                                            <td><strong>@{{ selectedData.data.number }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tanggal Quotation</td>
                                                            <td><strong>@{{ selectedData.data.date }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Customer</td>
                                                            <td><strong>@{{ selectedData.data.customer?.name }}</strong></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-12 col-lg-6">
                                                    <table class="table">
                                                        <tr>
                                                            <td>Title</td>
                                                            <td><strong>@{{ selectedData.data.title }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>PIC Event</td>
                                                            <td><strong>@{{ selectedData.data.pic_event.name }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Keterangan</td>
                                                            <td><strong>@{{ selectedData.data.description }}</strong></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="mt-5">
                                                <table class="table table-bordered" v-if="selectedData.data.type=='event'">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th style="width: 50px;">No</th>
                                                            <th>Deskripsi</th>
                                                            <th  style="width: 20%;">Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(item, index) in selectedData.data.items">
                                                            <td>@{{ index + 1 }}</td>
                                                            <td>@{{ item.name }}</td>
                                                            <td class="text-right">@{{ toCurrencyFormat(item.subtotal) }} </td>
                                                            <!-- <td class="text-center text-uppercase">@{{ item.tax_code }}</td>
                                                            <td>@{{ item.delivery_date }}</td>
                                                            <td class="text-right">@{{ toCurrencyFormat(item.quantity) }}</td>
                                                            <td class="text-right">@{{ toCurrencyFormat(item.price) }}</td>
                                                            <td class="text-right">@{{ toCurrencyFormat(item.amount) }}</td> -->
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td class="text-right" colspan="2"><strong>Subtotal</strong></td>
                                                            <td class="text-right"><strong>@{{ toCurrencyFormat(selectedData.data.commissionable_cost+selectedData.data.nonfee_cost) }}</strong></td>
                                                        </tr>
                                                         <tr>
                                                            <td class="text-right" colspan="2"><strong>ASF @{{selectedData.data.asf_percent}}%</strong></td>
                                                            <td class="text-right"><strong>@{{ toCurrencyFormat(selectedData.data.asf) }}</strong></td>
                                                        </tr>
                                                           <tr>
                                                            <td class="text-right" colspan="2"><strong>Discount @{{selectedData.data.discount_percent}} %</strong></td>
                                                            <td class="text-right"><strong>@{{ toCurrencyFormat(selectedData.data.discount) }}</strong></td>
                                                        </tr>

                                                        <!-- <tr v-if="selectedData.data.ppn == '1'">
                                                            <td class="text-right" colspan="2"><strong>PPN @{{ selectedData.data.ppn_value }}%</strong></td>
                                                            <td class="text-right"><strong>@{{ toCurrencyFormat(selectedData.data.ppn_amount) }}</strong></td>
                                                        </tr> -->
                                                        <!-- <tr v-if="selectedData.data.pph23 == '1'">
                                                            <td class="text-right" colspan="2"><strong>PPh 23 @{{ selectedData.data.pph23_value }}</strong></td>
                                                            <td class="text-right"><strong>@{{ toCurrencyFormat(selectedData.data.pph23_amount) }}</strong></td>
                                                        </tr> -->
                                                    
                                                        <tr>
                                                            <td class="text-right" colspan="2"><strong>TOTAL</strong></td>
                                                            <td class="text-right"><strong>@{{ toCurrencyFormat(selectedData.data.netto) }}</strong></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>


                                                    <table class="table table-bordered" v-if="selectedData.data.type=='other'">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th class="text-center">No</th>
                                                            <th class="text-center" style="width: 30%;">Nama</th>
                                                            <th class="text-center">Qty</th>
                                                            <th class="text-center">Frequency</th>
                                                            <th class="text-center">Unit Price</th>
                                                            <th class="text-center">Amount</th>
                                                         
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(item, index) in selectedData.data.other_quotation_items">
                                                            <td class="text-right">@{{ index + 1 }}</td>
                                                            <td>@{{ item.name }}</td>
                                                            <td class="text-right">@{{ item.quantity }}</td>
                                                            
                                                           
                                                            <td class="text-right">@{{ toCurrencyFormat(item.frequency) }}</td>
                                                            <td class="text-right">@{{ toCurrencyFormat(item.price) }}</td>
                                                            <td class="text-right">@{{ toCurrencyFormat(item.amount) }}</td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td class="text-right" colspan="5"><strong>Subtotal</strong></td>
                                                            <td class="text-right"><strong>@{{ toCurrencyFormat(selectedData.data.subtotal) }}</strong></td>
                                                        </tr>
                                                         <tr>
                                                            <td class="text-right" colspan="5"><strong>ASF @{{selectedData.data.asf_percent}}%</strong></td>
                                                            <td class="text-right"><strong>@{{ toCurrencyFormat(selectedData.data.asf) }}</strong></td>
                                                        </tr>
                                                         <tr>
                                                            <td class="text-right" colspan="5"><strong>Diskon @{{selectedData.data.discount_percent}}%</strong></td>
                                                            <td class="text-right"><strong>@{{ toCurrencyFormat(selectedData.data.discount) }}</strong></td>
                                                        </tr>
                                                         <!-- <tr>
                                                            <td class="text-right" colspan="5"><strong>Netto</strong></td>
                                                            <td class="text-right"><strong>@{{ toCurrencyFormat(selectedData.data.subtotal) }}</strong></td>
                                                        </tr>
                                                        <tr v-if="selectedData.data.ppn == '1'">
                                                            <td class="text-right" colspan="5"><strong>PPN @{{ selectedData.data.ppn_value }}%</strong></td>
                                                            <td class="text-right"><strong>@{{ toCurrencyFormat(selectedData.data.ppn_amount) }}</strong></td>
                                                        </tr>
                                                        <tr v-if="selectedData.data.pph23 == '1'">
                                                            <td class="text-right" colspan="5"><strong>PPh 23 @{{ selectedData.data.pph23_value }}</strong></td>
                                                            <td class="text-right"><strong>@{{ toCurrencyFormat(selectedData.data.pph23_amount) }}</strong></td>
                                                        </tr>
                                                        <tr v-if="selectedData.data.other_cost > 0">
                                                            <td class="text-right" colspan="5"><strong>Biaya Lain (@{{ selectedData.data.other_cost_description }})</strong></td>
                                                            <td class="text-right"><strong>@{{ toCurrencyFormat(selectedData.data.other_cost) }}</strong></td>
                                                        </tr> -->
                                                        <tr>
                                                            <td class="text-right" colspan="5"><strong>TOTAL</strong></td>
                                                            <td class="text-right"><strong>@{{ toCurrencyFormat(selectedData.data.netto) }}</strong></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
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
                                                <label>File PO (Max. 2MB)</label>
                                                <div class="custom-file">
                                                    <input type="file" id="customFile" accept=".jpg, .jpeg, .png, .pdf, .doc, .xls, .xlsx" class="custom-file-input" disabled>
                                                    <label id="file-upload-label" for="customFile" class="custom-file-label">Choose file</label>
                                                </div>
                                                <!---->
                                            </div>
                                            <div class="form-group">
                                                <label>File GR (Max. 2MB)</label>
                                                <div class="custom-file">
                                                    <input type="file" id="customFile" accept=".jpg, .jpeg, .png, .pdf, .doc, .xls, .xlsx" class="custom-file-input" disabled>
                                                    <label id="file-upload-label" for="customFile" class="custom-file-label">Choose file</label>
                                                </div>
                                                <!---->
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
    <div class="modal fade" id="quotationModal" tabindex="-1" aria-labelledby="quotationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quotationModalLabel">Pilih Quotation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table" id="quotation-table">
                        <thead>
                            <th>Nomor</th>
                            <th>Tanggal</th>
                            <th>Title</th>
                            <th>Sisa BAST</th>
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
    <!-- Modal -->
    <div class="modal fade" id="poModal" tabindex="-1" aria-labelledby="poModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="poModalLabel">Pilih Purchase Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table" id="cpo-table">
                        <thead>
                            <th>Nomor</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
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
            number: '{!! $bast->number!!}',
            id:'{!!$bast->id!!}',
            date: '{!!$bast->date!!}',
            grNumber:'{!!$bast->gr_number!!}',
            customer:'{!!$bast->customer->name!!}',
            eventPicId:'',
            eventPicName:'{!!$bast->pic_event!!}',
            eventPicPosition:'{!!$bast->pic_event_position!!}',
            magentaPicName:'{!!$bast->pic_magenta!!}',
            magentaPicPosition:'{!!$bast->pic_magenta_position!!}',
            commisinableCost:[],
            nonfeeCost:[],
            quotationId: '',
            quotationNumber: '',
            quotationDate: '',
            amount:'{!!$bast->amount!!}',
            amountPreviously:`{!!$bast->amount!!}`,
            poId: '',
            poNumber: '',
            poDate: '',
            termOfPayment: '',
            dueDate: '',
            description: '',
            bastRemaining:'{!!($bast->eventQuotation->netto-$bast->eventQuotation->total_bast)+($bast->amount)!!}',
            
            loading: false,
            selectedData: null,
        },
        methods: {
            submitForm: function() {
                this.sendData();
               // console.log(this.selectedData.data.id);
               // console.log(this.selectedData.data.id);
            },
            sendData: function() {
                // console.log('submitted');
                let vm = this;
                vm.loading = true;

           

                const data = {
                    number: vm.number,
                    date: vm.date,
                    gr_number:vm.grNumber,
                    customer_id: vm.selectedData.data.customer_id || '0',
                    event_quotation_id:  vm.selectedData.data.id ,
                    event_pic_name:vm.eventPicName,
                    event_pic_position:vm.eventPicPosition,
                    magenta_pic_name:vm.magentaPicName,
                    magenta_pic_position:vm.magentaPicPosition,
                    po_file:null,
                    gr_file:null,
                    amount:vm.amount,  
                    amount_previously:vm.amountPreviously     
                };

               
                axios.patch('/bast/'+this.id, data)
                    .then(function(response) {
                        vm.loading = false;
                        Swal.fire({
                            title: 'Success',
                            text: 'Data has been saved',
                            icon: 'success',
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '/bast';
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
            validateAmount:function(){
                 
                if (Number(this.amount)>Number(this.bastRemaining)){
                    
                    this.amount=this.bastRemaining
                }

            },
            toCurrencyFormat: function(number) {
                if (!number) {
                    number = 0;
                }
                return new Intl.NumberFormat('De-de').format(number);
            }
        },
        computed: {
            grandTotal: function() {
                const grandTotal = this.items.map(item => Number(item.amount)).reduce((acc, cur) => {
                    return acc + cur;
                }, 0);

                return grandTotal;
            }
        },
    })
</script>
<script>
    $(function() {

        quotationsTable = $('#quotation-table').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: '/datatables/bast/quotations',
            columns: [{
                    data: 'number',
                    name: 'number',
                    render: function(data, type) {
                        return `<a href="#">${data}</a>`;
                    }
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                 {
                    data: 'bastRemaining',
                    name: 'bastRemaining',
                    render: function(data, type) {
                        return `${data}`;
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $('#quotation-table tbody').on('click', '.btn-choose', function() {
            const data = quotationsTable.row($(this).parents('tr')).data();
            console.log(data)
            app.$data.selectedData = {
                data,
                source: 'quotation',
            };
           
            app.$data.quotationNumber = app.$data.selectedData.data.number;
            const newDate = app.$data.selectedData.data.date;
            app.$data.quotationDate = newDate;
            app.$data.eventPicName=data.pic_event.name
            app.$data.eventPicPosition=data.pic_event.position;
            app.$data.customer=data.customer.name
            app.$data.bastRemaining=Number(data.netto)-Number(data.total_bast)
            app.$data.title=data.title;

            // if (data.type=="event"){
            //     app.$data.commissionableCost={
            //         ...data.items.filter((item)=>item.type=="cost")
            //     }
            //     app.$data.nonfeeCost={
            //         ...data.items.filter((item)=>item.type=="")
            //     }
            // }







            number();

            $('#quotation-date').datepicker('update', newDate);
            $('#quotationModal').modal('hide');
        });

        cpoTable = $('#cpo-table').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: '/datatables/v2/sales-orders/customer-purchase-orders',
            columns: [{
                    data: 'number',
                    name: 'number',
                    render: function(data, type) {
                        return `<a href="#">${data}</a>`;
                    }
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $('#cpo-table tbody').on('click', '.btn-choose', function() {
            const data = cpoTable.row($(this).parents('tr')).data();
            app.$data.selectedData = {
                data,
                source: 'purchase_order',
            };

            app.$data.poNumber = app.$data.selectedData.data.number;
            const newDate = app.$data.selectedData.data.date;
            app.$data.poDate = newDate;
            $('#po-date').datepicker('update', newDate);

            $('#poModal').modal('hide');
        });

        $('#date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: false,
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
        }).on('changeDate', function(e) {
            app.$data.date = e.format(0, 'yyyy-mm-dd');
        });

    
    })
</script>
<script>

  function number() {

    var date = new Date();
    var tahun = date.getFullYear();
    var t = tahun.toString()
    var bulan = date.getMonth();
    var tanggal = date.getDate();
    var hari = date.getDay();
    var angka;

    if (String(bulan + 1) == "1") {
      angka = "I";

    } else if (String(bulan + 1) == "2") {
      angka = "II";


    } else if (String(bulan + 1) == "3") {
      angka = "III";


    } else if (String(bulan + 1) == "4") {
      angka = "IV";


    } else if (String(bulan + 1) == "5") {
      angka = "V";


    } else if (String(bulan + 1) == "6") {
      angka = "VI";


    } else if (String(bulan + 1) == "7") {
      angka = "VII";



    } else if (String(bulan + 1) == "8") {
      angka = "VIII";


    } else if (String(bulan + 1) == "9") {
      angka = "IX";


    } else if (String(bulan + 1) == "10") {
      angka = "X";


    } else if (String(bulan + 1) == "11") {
      angka = "XI";


    } else if (String(bulan + 1) == "12") {
      angka = "XII";


    }

    let title=app.$data.title;
    let number="NO. " + t.substring(2, 4) + (bulan + 1) + tanggal + "/" + title + "/" + angka + "/" + t
    app.$data.number=number;


  }

</script>

<script>
$(function(){
    console.log(JSON.parse(String.raw`{!! $quotation !!}`))
    let data=JSON.parse(String.raw`{!! $quotation !!}`);
 
    app.$data.selectedData = {
               data,
                source: 'quotation',
            };
})
</script>
@endsection