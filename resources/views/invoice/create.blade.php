@extends('layouts.app')

@section('title', 'Metaprint')

@section('head')
<link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('subheader')
<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Page Title-->
                <h5 class="text-dark font-weight-bold my-1 mr-5">Tambah Faktur</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Faktur</a>
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
                <h3 class="card-title">Form Faktur</h3>
            </div>

            <!--begin::Form-->
            <form class="form" autocomplete="off" @submit.prevent="submitForm">
                <div class="card-body">
                    <div class="row justify-content-between">
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-lg-right">Nomor Faktur:</label>
                                <!-- <div class="col-lg-8">
                                    <span class="label label-xl label-info label-inline ">@{{ number }}</span>
                                </div> -->
                                <div class="col-lg-8">
                                    <input type="text" v-model="number" class="form-control" placeholder="Masukkan nomor faktur" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-lg-right">Tanggal Faktur:</label>
                                <div class="col-lg-8">
                                    <input type="text" v-model="date" class="form-control invoice-date" placeholder="Masukkan tanggal faktur" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-lg-right">Tenggat Waktu:</label>
                                <div class="col-lg-8">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <select class="form-control" v-model="dueDateTerm" @change="onChangeDueDateSelect($event)" style="border-radius: 0.42rem 0 0 0.42rem;">
                                                <option value="custom">Custom</option>
                                                @for($i = 15; $i <= 90; $i +=15) <option value="{{ $i }}" :disabled="!date">{{ $i }} Hari</option>
                                                    @endfor
                                            </select>
                                        </div>
                                        <input type="text" v-model="dueDate" class="form-control due-date" placeholder="Masukkan tanggal faktur" required />
                                    </div>
                                    <em v-if="!isDueDateValid" class="text-muted"><i class="flaticon-warning text-warning"></i> Tanggal tidak valid</em>
                                </div>
                                <!-- <div class="col-lg-4">
                                    <div class="input-group">
                                        <input type="text" @input="onInputDueDayAmount($event)" :value="dueDayAmount" class="form-control text-right placeholder-left" required />
                                        <div class="input-group-append">
                                            <span class="input-group-text">Hari</span>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-lg-right">Seri Faktur Pajak:</label>
                                <div class="col-lg-8">
                                    <input type="text" v-model="taxInvoiceSeries" class="form-control" placeholder="Masukkan seri faktur pajak" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-lg-right">Nomor GR:</label>
                                <div class="col-lg-8">
                                    <input type="text" v-model="grNumber" class="form-control" placeholder="Masukkan nomor GR" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-lg-right">Syarat Pembayaran:</label>
                                <div class="col-lg-8">
                                    <input type="text" v-model="termsOfPayment" class="form-control" placeholder="Masukkan syarat pembayaran" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-lg-right">Diskon:</label>
                                <div class="col-lg-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="text" v-model="discount" v-cleave="cleaveCurrency" class="form-control text-right placeholder-left" placeholder="Masukkan diskon" required />
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-lg-right">PIC PO:</label>
                                <div class="col-lg-8">
                                    <input type="text" v-model="picPo" class="form-control" placeholder="Masukkan nama PIC PO" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-lg-right">Jabatan PIC PO:</label>
                                <div class="col-lg-8">
                                    <input type="text" v-model="picPoPosition" class="form-control" placeholder="Masukkan jabatan PIC PO" />
                                </div>
                            </div> -->
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-lg-right">Note:</label>
                                <div class="col-lg-8">
                                    <textarea rows="5" v-model="note" class="form-control" placeholder="Masukkan note"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-sm-12">
                            <div class="alert alert-light mb-10">
                                <!--begin: Item-->
                                <div class="d-flex align-items-center flex-lg-fill mb-4">
                                    <span class="mr-4">
                                        <i class="flaticon2-correct icon-2x text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-50">
                                        <span class="font-weight-bolder font-size-sm">Sales Order Number</span>
                                        <span class="font-weight-bolder font-size-h5">
                                            {{ $sales_order->number }}
                                        </span>
                                        <!-- <span class="text-dark-50 font-weight-bold">Pcs</span></span> -->
                                    </div>
                                </div>
                                <!--end: Item-->
                                <hr>
                                <!--begin: Item-->
                                <div class="d-flex align-items-center flex-lg-fill mb-4">
                                    <span class="mr-4">
                                        <i class="flaticon2-calendar-9 icon-2x text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-50">
                                        <span class="font-weight-bolder font-size-sm">Tanggal Sales Order</span>
                                        <span class="font-weight-bolder font-size-h5">
                                            {{ $sales_order->date }}
                                        </span>
                                    </div>
                                </div>
                                <!--end: Item-->
                                <hr>
                                <!--begin: Item-->
                                <div class="d-flex align-items-center flex-lg-fill mb-4">
                                    <span class="mr-4">
                                        <i class="flaticon2-correct icon-2x text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-50">
                                        <span class="font-weight-bolder font-size-sm">Purchase Order Number</span>
                                        <span class="font-weight-bolder font-size-h5">
                                            {{ $sales_order->po_number }}
                                        </span>
                                        <!-- <span class="text-dark-50 font-weight-bold">Pcs</span></span> -->
                                    </div>
                                </div>
                                <!--end: Item-->
                                <hr>
                                <!--begin: Item-->
                                <div class="d-flex align-items-center flex-lg-fill mb-4">
                                    <span class="mr-4">
                                        <i class="flaticon2-calendar-9 icon-2x text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-50">
                                        <span class="font-weight-bolder font-size-sm">Tanggal Purchase Order</span>
                                        <span class="font-weight-bolder font-size-h5">
                                            {{ $sales_order->po_date }}
                                        </span>
                                    </div>
                                </div>
                                <!--end: Item-->
                                <hr>
                                <!--begin: Item-->
                                <div class="d-flex align-items-center flex-lg-fill mb-4">
                                    <span class="mr-4">
                                        <i class="flaticon2-user-outline-symbol icon-2x text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-50">
                                        <span class="font-weight-bolder font-size-sm">Customer</span>
                                        <span class="font-weight-bolder font-size-h5">
                                            @if($sales_order->customer !== null)
                                            {{ $sales_order->customer->name }}
                                            @else
                                            -
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <!--end: Item-->
                                <hr>
                                <!--begin: Item-->
                                <div class="d-flex align-items-center flex-lg-fill mb-4">
                                    <span class="mr-4">
                                        <i class="flaticon2-position icon-2x text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-50">
                                        <span class="font-weight-bolder font-size-sm">Alamat Customer</span>
                                        <span class="font-weight-bolder font-size-h5">
                                            @if($sales_order->customer !== null)
                                            {{ $sales_order->customer->address }}
                                            @else
                                            -
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <!--end: Item-->
                                <hr>
                                <!--begin: Item-->
                                <div class="d-flex align-items-center flex-lg-fill mb-4">
                                    <span class="mr-4">
                                        <i class="flaticon2-crisp-icons icon-2x text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-50">
                                        <span class="font-weight-bolder font-size-sm">NPWP Customer</span>
                                        <span class="font-weight-bolder font-size-h5">
                                            @if($sales_order->customer !== null)
                                            {{ $sales_order->customer->npwp }}
                                            @else
                                            -
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <!--end: Item-->
                            </div>
                        </div>
                    </div>


                    <!-- begin::Estimations List -->
                    <div class="card card-custom card-border">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">
                                    List Quotation
                                </h3>
                            </div>
                            <!-- <div class="card-toolbar">
                                <a href="#" class="btn btn-light-success">
                                    <i class="flaticon2-add-1"></i> Tambah
                                </a>
                            </div> -->
                        </div>
                        <div class="card-body">
                            <div v-if="quotations.length < 1" class="text-center">
                                <i class="flaticon2-open-box icon-4x"></i>
                                <p class="text-muted">Belum ada quotation terpilih</p>
                            </div>
                            <div>
                                <div class="row align-items-center" v-for="(quotation, index) in quotations" :key="quotation.id" :quotation="quotation">
                                    <div class="col-md-1">
                                        <div v-if="quotation.paid !== 1">
                                            <label class="checkbox checkbox-lg">
                                                <input type="checkbox" v-model="checkedQuotationsIds" :value="quotation.id" />
                                                <span></span>
                                            </label>
                                        </div>
                                        <div v-else>
                                            <i class="flaticon2-correct text-success icon-2x"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-11 card card-custom gutter-b card-stretch card-border ribbon ribbon-top">
                                        <!-- <div :class="'ribbon-target bg-primary text-capitalize'" style="top: -2px; left: 20px;">Closed</div> -->
                                        <!--begin::Body-->
                                        <div class="card-body pt-4">
                                            <!--begin::User-->
                                            <!-- <span v-if="quotation.paid == 1" class="label label-inline label-light-success label-lg  font-weight-bolder">Dibayarkan</span> -->
                                            <div class="d-flex align-items-center my-7">
                                                <!--begin::Title-->
                                                <div class="d-flex flex-column">
                                                    <a href="#" class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-0">@{{ quotation.number }} - @{{ quotation.title }}</a>
                                                    <span class="text-muted font-weight-bold">@{{ quotation.customer.name }} | @{{ quotation.date }}</span>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                            <!--end::User-->
                                            <!--begin::Desc-->
                                            <!-- <p class="mb-7">I distinguish three main text objectives. First, your objective
                        <a href="#" class="text-primary pr-1">#xrs-54pq</a>
                    </p> -->
                                            <!--end::Desc-->
                                            <!--begin::Info-->
                                            <div class="mb-7">
                                                <div class="d-flex justify-content-between align-items-center my-1">
                                                    <span class="text-dark-75 font-weight-bolder mr-2">Quantity:</span>
                                                    <a href="#" class="text-muted text-hover-primary">@{{ Intl.NumberFormat('de-DE').format(quotation.selected_estimation.quantity) }}</a>
                                                </div>
                                                <!-- <div class="d-flex justify-content-between align-items-center my-1">
                                                    <span class="text-dark-75 font-weight-bolder mr-2">Quantity Sudah Diproduksi:</span>
                                                    <a href="#" class="text-muted text-hover-primary">@{{ Intl.NumberFormat('de-DE').format(quotation.produced) }}</a>
                                                </div> -->
                                                <div class="d-flex justify-content-between align-items-center my-1">
                                                    <span class="text-dark-75 font-weight-bolder mr-2">Quantity Sudah Dikirim:</span>
                                                    <a href="#" class="text-muted text-hover-primary">@{{ Intl.NumberFormat('de-DE').format(quotation.shipped) }}</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-cente my-1">
                                                    <span class="text-dark-75 font-weight-bolder mr-2">Unit Price:</span>
                                                    <a href="#" class="text-muted text-hover-primary">Rp @{{ Intl.NumberFormat('de-DE').format(quotation.selected_estimation.price_per_unit) }}</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center my-1">
                                                    <span class="text-dark-75 font-weight-bolder mr-2">Netto:</span>
                                                    <span class="text-muted font-weight-bold">Rp @{{ Intl.NumberFormat('de-DE').format(quotation.selected_estimation.quantity * quotation.selected_estimation.price_per_unit) }}</span>
                                                </div>
                                            </div>
                                            <!--end::Info-->

                                        </div>
                                        <!--end::Body-->
                                    </div>
                                </div>
                                <!-- <selected-quotation v-for="(quotation, index) in quotations" :key="quotation.id" :quotation="quotation" :index="index">
                                </selected-quotation> -->
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex align-items-center flex-wrap">
                                <!--begin: Item-->
                                <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                                    <span class="mr-4">
                                        <i class="flaticon2-layers-1 icon-2x text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-75">
                                        <span class="font-weight-bolder font-size-sm">Netto</span>
                                        <span class="font-weight-bolder font-size-h5">
                                            <span class="text-dark-50 font-weight-bold">Rp </span>
                                            @{{ Intl.NumberFormat('de-DE').format(netto) }}
                                        </span>
                                    </div>
                                </div>
                                <!--end: Item-->
                                <!--begin: Item-->
                                <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                                    <span class="mr-4">
                                        <i class="flaticon2-pie-chart-4 icon-2x text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-75">
                                        <span class="font-weight-bolder font-size-sm">Diskon</span>
                                        <span class="font-weight-bolder font-size-h5">
                                            <span class="text-dark-50 font-weight-bold">Rp </span>
                                            @{{ Intl.NumberFormat('de-DE').format(clearCurrencyMask(discount)) }}
                                        </span>
                                    </div>
                                </div>
                                <!--end: Item-->
                                <!--begin: Item-->
                                <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                                    <span class="mr-4">
                                        <i class="flaticon2-file-1 icon-2x text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-75">
                                        <span class="font-weight-bolder font-size-sm">PPN</span>
                                        <span class="font-weight-bolder font-size-h5">
                                            <span class="text-dark-50 font-weight-bold">Rp </span>
                                            @{{ Intl.NumberFormat('de-DE').format(ppn) }}
                                        </span>
                                    </div>
                                </div>
                                <!--end: Item-->
                                <!--begin: Item-->
                                <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                                    <span class="mr-4">
                                        <i class="flaticon2-file-1 icon-2x text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-75">
                                        <span class="font-weight-bolder font-size-sm">PPH</span>
                                        <span class="font-weight-bolder font-size-h5">
                                            <span class="text-dark-50 font-weight-bold">Rp </span>
                                            (@{{ Intl.NumberFormat('de-DE').format(pph) }})
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                                    <span class="mr-4">
                                        <i class="flaticon2-tag icon-2x text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-75">
                                        <span class="font-weight-bolder font-size-sm">Total</span>
                                        <span class="font-weight-bolder font-size-h5">
                                            <span class="text-dark-50 font-weight-bold">Rp </span>
                                            @{{ Intl.NumberFormat('de-DE').format(total) }}
                                        </span>
                                    </div>
                                </div>
                                <!--end: Item-->
                            </div>
                            <div class="alert alert-light font-weight-bold mt-7" role="alert">
                                @{{ terbilang == '' ? 'Nol Rupiah' : terbilang + ' Rupiah' }}
                            </div>
                        </div>
                    </div>
                    <!-- end::Estimations List -->
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-6">

                        </div>
                        <div class="col-lg-6 text-lg-right">
                            <button type="submit" class="btn btn-primary" :class="loading && 'spinner spinner-white spinner-right'" :disabled="loading || checkedQuotationsIds.length < 1 || !isDueDateValid">
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
</div>
@endsection

@section('script')
<script src="{{ asset('js/pages/features/miscellaneous/sweetalert2.js') }}"></script>
<script src="{{ asset('js/terbilang.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
@endsection

@section('pagescript')
<script>
    Vue.directive('cleave', {
        inserted: (el, binding) => {
            el.cleave = new Cleave(el, binding.value || {})
        },
        update: (el) => {
            const event = new Event('input', {
                bubbles: true
            });
            setTimeout(function() {
                el.value = el.cleave.properties.result
                el.dispatchEvent(event)
            }, 100);
        }
    })

    let app = new Vue({
        el: '#app',
        data: {
            quotations: JSON.parse(String.raw `{!! $sales_order->quotations !!}`),
            checkedQuotationsIds: [],
            number: '{{ $invoice_number }}',
            date: '',
            dueDate: '',
            dueDateTerm: 'custom',
            customer: '{{ $sales_order->customer->id }}',
            taxInvoiceSeries: '',
            termsOfPayment: '',
            grNumber: '',
            discount: 0,
            picPo: '',
            picPoPosition: '',
            note: '',
            salesOrderId: '{{ $sales_order->id }}',
            loading: false,
            cleaveCurrency: {
                delimiter: '.',
                numeralDecimalMark: ',',
                numeral: true,
                numeralThousandsGroupStyle: 'thousand'
            },
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
                    date: vm.date,
                    due_date: vm.dueDate,
                    due_date_term: vm.dueDateTerm,
                    customer_id: vm.customer,
                    tax_invoice_series: vm.taxInvoiceSeries,
                    terms_of_payment: vm.termsOfPayment,
                    gr_number: vm.grNumber,
                    discount: vm.discount,
                    pic_po: vm.picPo,
                    pic_po_position: vm.picPoPosition,
                    note: vm.note,
                    netto: vm.netto,
                    ppn: vm.ppn,
                    pph: vm.pph,
                    total: vm.total,
                    terbilang: vm.terbilang,
                    sales_order_id: vm.salesOrderId,
                    // customer_id: vm.customerId,
                    selected_quotations: vm.checkedQuotations,
                }

                axios.post('/invoice', data)
                    .then(function(response) {
                        vm.loading = false;
                        Swal.fire({
                            title: 'Success',
                            text: 'Data has been saved',
                            icon: 'success',
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // window.location.href = '/customer';
                            }
                        })
                        // console.log(response);
                    })
                    .catch(function(error) {
                        vm.loading = false;
                        console.log(error);
                        if (error.response.data.error_type == 'exist_number') {
                            const {
                                title,
                                text,
                                icon
                            } = error.response.data.data.swal;
                            Swal.fire({
                                title: title,
                                text: text,
                                icon: icon,
                                allowOutsideClick: false,
                            })
                        } else {
                            Swal.fire(
                                'Oops!',
                                'Something wrong',
                                'error'
                            )
                        }
                    });
            },
            validateShippingQuantity: function(quotation) {
                const remainingQuantity = this.remainingShippingQuantity(quotation.produced, quotation.shipped, quotation.shipping_amount);
                if (remainingQuantity < 0) {
                    quotation.shipping_amount = quotation.produced - quotation.shipped;
                }
            },
            remainingShippingQuantity: function(produced, shipped, ship) {
                // const newProduction = isNaN(production) ? 0 : production;
                // return Number(quantity) - Number(produced) - Number(newProduction);
                return Number(produced) - Number(shipped) - Number(ship);
            },
            clearCurrencyMask: function(masked) {
                if (masked == '' || masked == 0 || typeof(masked) == 'undefined') {
                    return 0;
                }
                return masked.toString().replaceAll('.', '');
            },
            onChangeDueDateSelect: function(event) {
                const invoiceDate = new Date(this.date);
                const dueDate = new Date();
                const dueDateTerm = event.target.value;
                if (dueDateTerm !== 'custom') {
                    const numDays = Number(dueDateTerm);
                    dueDate.setDate(invoiceDate.getDate() + numDays);
                    this.dueDate = `${dueDate.getFullYear()}-${this.pad(dueDate.getMonth() + 1, 2)}-${this.pad(dueDate.getDate() + 1, 2)}`;
                    $('.due-date').datepicker('setDate', this.dueDate);
                }
                this.dueDateTerm = dueDateTerm;
            },
            pad: function(num, size) {
                num = num.toString();
                while (num.length < size) num = "0" + num;
                return num;
            }
            // dateDiffInDays: function(a, b) {
            //     const _MS_PER_DAY = 1000 * 60 * 60 * 24;
            //     // Discard the time and time-zone information.
            //     const utc1 = Date.UTC(a.getFullYear(), a.getMonth(), a.getDate());
            //     const utc2 = Date.UTC(b.getFullYear(), b.getMonth(), b.getDate());

            //     return Math.floor((utc2 - utc1) / _MS_PER_DAY);
            // },
            // addDays: function(date, days) {
            //     var result = new Date(date);
            //     result.setDate(result.getDate() + days);
            //     return result;
            // },
            // onInputDueDayAmount: function(event) {
            //     console.log(event.target.value);
            //     if (this.date == '') {
            //         return;
            //     }
            //     const days = event.target.value;
            //     const newDate = this.addDays(this.date, days);
            //     this.dueDate = newDate.getFullYear() + '-' + (newDate.getMonth() + 1) + '-' + newDate.getDate();
            // }
            // validateProducedQuantity: function(quotation) {
            //     const remainingQuantity = this.remainingQuantity(quotation.quantity, quotation.produced, quotation.production);
            //     if (remainingQuantity < 0) {
            //         quotation.production = quotation.quantity - quotation.produced;
            //     }
            // },
            // remainingQuantity: function(quantity, produced, production) {
            //     const newProduction = isNaN(production) ? 0 : production;
            //     return Number(quantity) - Number(produced) - Number(newProduction);
            // }
        },
        computed: {
            checkedQuotations: function() {
                return this.quotations.filter(quotation => this.checkedQuotationsIds.indexOf(quotation.id) > -1);
            },
            netto: function() {
                let vm = this;
                return this.checkedQuotations.map(quotation => {
                    if (quotation.pivot.estimation == null || typeof quotation.pivot.estimation == 'undefined') {
                        return 0;
                    }

                    const netto = (Number(quotation.pivot.estimation.quantity) * Number(quotation.pivot.estimation.price_per_unit));

                    return netto;
                }).reduce((acc, cur) => {
                    return acc + cur;
                }, 0);
            },
            ppn: function() {
                const PERCENTAGE = 10;
                const netto = isNaN(this.netto) ? 0 : (this.netto - Number(this.clearCurrencyMask(this.discount)));
                const ppn = netto * (PERCENTAGE / 100);
                return ppn;
            },
            pph: function() {
                const PERCENTAGE = 2;
                const netto = isNaN(this.netto) ? 0 : (this.netto - Number(this.clearCurrencyMask(this.discount)));
                const pph = netto * (PERCENTAGE / 100);
                return pph;
            },
            total: function() {
                const total = (this.netto - Number(this.clearCurrencyMask(this.discount))) + this.ppn - this.pph;
                return total;
            },
            terbilang: function() {
                let newTerbilang = terbilang(this.total.toString());
                newTerbilang = newTerbilang.replaceAll(' ', '').split('').map((letter, index) => {
                    if (index > 0 && letter == letter.toUpperCase()) {
                        return ' ' + letter;
                    }
                    return letter;
                }).join('');
                return newTerbilang;
            },
            totalQuantity: function() {
                return this.checkedQuotations.map(quotation => quotation.selected_estimation.quantity).reduce((acc, cur) => {
                    return acc + cur;
                }, 0);
            },
            totalProduced: function() {
                return this.checkedQuotations.map(quotation => {
                    if (isNaN(quotation.produced)) {
                        return 0;
                    }
                    return Number(quotation.produced);
                }).reduce((acc, cur) => {
                    return acc + cur;
                }, 0);
            },
            totalShipping: function() {
                return this.checkedQuotations.map(quotation => {
                    if (isNaN(quotation.shipping_amount)) {
                        return 0;
                    }
                    return Number(quotation.shipping_amount);
                }).reduce((acc, cur) => {
                    return acc + cur;
                }, 0);
            },
            isDueDateValid: function() {
                let vm = this;
                const date = new Date(vm.date);
                const dueDate = new Date(vm.dueDate);

                if (vm.date && vm.dueDate) {
                    if (dueDate < date) {
                        return false;
                    }

                    return true;
                }

                return true;
            }
            // dueDayAmount: function() {
            //     if (this.date == '' || this.dueDate == '') {
            //         return 0;
            //     }
            //     const a = new Date(this.date)
            //     const b = new Date(this.dueDate);
            //     const difference = this.dateDiffInDays(a, b);
            //     return difference;
            // }
            // totalRemainingQuantity: function() {
            //     return this.totalQuantity - this.totalProduced;
            // },
        }
    })
</script>
<script>
    $(function() {
        $('.invoice-date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: false,
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
        }).on('changeDate', function(e) {
            app.$data.date = e.format(0, 'yyyy-mm-dd');
        });

        $('.due-date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: false,
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
        }).on('changeDate', function(e) {
            app.$data.dueDateTerm = 'custom';
            app.$data.dueDate = e.format(0, 'yyyy-mm-dd');
        });
    })
</script>
@endsection