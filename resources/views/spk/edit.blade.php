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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Edit SPK</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">SPK</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">{{ $job_order->number }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Edit</a>
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
                <h3 class="card-title">Form SPK</h3>
            </div>

            <!--begin::Form-->
            <form class="form" autocomplete="off" @submit.prevent="submitForm">
                <div class="card-body">
                    <div class="d-flex align-items-center flex-wrap alert alert-light mb-10">
                        <!--begin: Item-->
                        <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                            <span class="mr-4">
                                <i class="flaticon2-correct icon-2x text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-50">
                                <span class="font-weight-bolder font-size-sm">Sales Order Number</span>
                                <span class="font-weight-bolder font-size-h5">
                                    {{ $job_order->salesOrder->number }}
                                </span>
                                <!-- <span class="text-dark-50 font-weight-bold">Pcs</span></span> -->
                            </div>
                        </div>
                        <!--end: Item-->
                        <!--begin: Item-->
                        <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                            <span class="mr-4">
                                <i class="flaticon2-calendar-5 icon-2x text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-50">
                                <span class="font-weight-bolder font-size-sm">Tanggal Sales Order</span>
                                <span class="font-weight-bolder font-size-h5">
                                    {{ $job_order->salesOrder->date }}
                                </span>
                            </div>
                        </div>
                        <!--end: Item-->
                        <!--begin: Item-->
                        <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                            <span class="mr-4">
                                <i class="flaticon2-correct icon-2x text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-50">
                                <span class="font-weight-bolder font-size-sm">Purchase Order Number</span>
                                <span class="font-weight-bolder font-size-h5">
                                    {{ $job_order->salesOrder->po_number }}
                                </span>
                                <!-- <span class="text-dark-50 font-weight-bold">Pcs</span></span> -->
                            </div>
                        </div>
                        <!--end: Item-->
                        <!--begin: Item-->
                        <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                            <span class="mr-4">
                                <i class="flaticon2-calendar-5 icon-2x text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-50">
                                <span class="font-weight-bolder font-size-sm">Tanggal Purchase Order</span>
                                <span class="font-weight-bolder font-size-h5">
                                    {{ $job_order->salesOrder->po_date }}
                                </span>
                            </div>
                        </div>
                        <!--end: Item-->
                    </div>

                    <div class="row justify-content-between">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-lg-right">Job Order Number:</label>
                                <div class="col-lg-8">
                                    <input type="text" v-model="number" class="form-control" readonly />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-lg-right">Tanggal Job Order:</label>
                                <div class="col-lg-8">
                                    <input type="text" v-model="date" class="form-control job-order-date" placeholder="Masukkan tanggal job order" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-lg-right">Tanggal Finish:</label>
                                <div class="col-lg-8">
                                    <input type="text" v-model="finishDate" class="form-control finish-date" placeholder="Masukkan tanggal finish" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-lg-right">Tanggal Kirim:</label>
                                <div class="col-lg-8">
                                    <input type="text" v-model="deliveryDate" class="form-control delivery-date" placeholder="Masukkan tanggal kirim" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-lg-right">Desainer:</label>
                                <div class="col-lg-8">
                                    <input type="text" v-model="designer" class="form-control" placeholder="Masukkan nama desainer" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-lg-right">Disiapkan:</label>
                                <div class="col-lg-8">
                                    <input type="text" v-model="preparer" class="form-control" placeholder="Masukkan nama penyiap" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-lg-right">Diperiksa:</label>
                                <div class="col-lg-8">
                                    <input type="text" v-model="examiner" class="form-control" placeholder="Masukkan nama pemeriksa" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-lg-right">Produksi:</label>
                                <div class="col-lg-8">
                                    <input type="text" v-model="production" class="form-control" placeholder="Masukkan penanggung jawab produksi" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-lg-right">Finishing:</label>
                                <div class="col-lg-8">
                                    <input type="text" v-model="finishing" class="form-control" placeholder="Masukkan penanggung jawab finishing" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-lg-right">Gudang:</label>
                                <div class="col-lg-8">
                                    <input type="text" v-model="warehouse" class="form-control" placeholder="Masukkan nama penanggung gudang" />
                                </div>
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
                                        <!-- <label class="checkbox checkbox-lg">
                                            <input type="checkbox" v-model="checkedQuotationsIds" :value="quotation.id" />
                                            <span></span>
                                        </label> -->
                                    </div>
                                    <div class="col-md-11 card card-custom gutter-b card-stretch card-border ribbon ribbon-top">
                                        <!-- <div :class="'ribbon-target bg-primary text-capitalize'" style="top: -2px; left: 20px;">Closed</div> -->
                                        <!--begin::Body-->
                                        <div class="card-body pt-4">
                                            <!--begin::User-->
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
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="text-dark-75 font-weight-bolder mr-2">Quantity:</span>
                                                    <a href="#" class="text-muted text-hover-primary">@{{ Intl.NumberFormat('de-DE').format(quotation.quantity) }}</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="text-dark-75 font-weight-bolder mr-2">Quantity Sudah Diproduksi:</span>
                                                    <a href="#" class="text-muted text-hover-primary">@{{ Intl.NumberFormat('de-DE').format(quotation.produced) }}</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-cente my-1">
                                                    <span class="text-dark-75 font-weight-bolder mr-2">Unit Price:</span>
                                                    <a href="#" class="text-muted text-hover-primary">Rp @{{ Intl.NumberFormat('de-DE').format(quotation.price_per_unit) }}</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="text-dark-75 font-weight-bolder mr-2">Total Piutang:</span>
                                                    <span class="text-muted font-weight-bold">Rp @{{ Intl.NumberFormat('de-DE').format(quotation.total_bill) }}</span>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mt-5">
                                                    <span class="text-dark-75 font-weight-bolder mr-2">Quantity Akan Diproduksi:</span>
                                                    <div>
                                                        <input type="number" v-model="quotation['production']" @input="validateProducedQuantity(quotation)" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mt-5">
                                                    <span class="text-dark-75 font-weight-bolder mr-2">Quantity Sisa:</span>
                                                    <span class="text-muted font-weight-bold">@{{ Intl.NumberFormat('de-DE').format(remainingQuantity(quotation.quantity, quotation.produced, quotation.production)) }}</span>
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
                                        <span class="font-weight-bolder font-size-sm">Quantity</span>
                                        <span class="font-weight-bolder font-size-h5">
                                            @{{ Intl.NumberFormat('de-DE').format(totalQuantity) }}
                                            <span class="text-dark-50 font-weight-bold">Pcs</span></span>
                                    </div>
                                </div>
                                <!--end: Item-->
                                <!--begin: Item-->
                                <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                                    <span class="mr-4">
                                        <i class="flaticon2-reload icon-2x text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-75">
                                        <span class="font-weight-bolder font-size-sm">Quantity Akan Diproduksi</span>
                                        <span class="font-weight-bolder font-size-h5">
                                            @{{ Intl.NumberFormat('de-DE').format(totalProduced) }}
                                            <span class="text-dark-50 font-weight-bold">Pcs</span></span>
                                    </div>
                                </div>
                                <!--end: Item-->
                                <!--begin: Item-->
                                <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                                    <span class="mr-4">
                                        <i class="flaticon2-files-and-folders icon-2x text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-75">
                                        <span class="font-weight-bolder font-size-sm">Quantity Sisa</span>
                                        <span class="font-weight-bolder font-size-h5">
                                            @{{ Intl.NumberFormat('de-DE').format(totalRemainingQuantity) }}
                                            <span class="text-dark-50 font-weight-bold">Pcs</span></span>
                                    </div>
                                </div>
                                <!--end: Item-->
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
                            <button type="submit" class="btn btn-primary" :class="loading && 'spinner spinner-white spinner-right'" :disabled="loading || checkedQuotationsIds.length < 1">
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
@endsection

@section('pagescript')
<script>
    Vue.component('selected-quotation', {
        props: ['quotation', 'index'],
        template: `
        
        `,
    })

    let app = new Vue({
        el: '#app',
        data: {
            quotations: JSON.parse(String.raw `{!! $job_order->quotations !!}`),
            checkedQuotationsIds: JSON.parse('{!! json_encode($checked_quotations) !!}'),
            number: '{{ $job_order->number }}',
            date: '{{ $job_order->date }}',
            finishDate: '{{ $job_order->finish_date }}',
            deliveryDate: '{{ $job_order->delivery_date }}',
            designer: '{{ $job_order->designer }}',
            preparer: '{{ $job_order->preparer }}',
            examiner: '{{ $job_order->examiner }}',
            production: '{{ $job_order->production }}',
            finishing: '{{ $job_order->finishing }}',
            warehouse: '{{ $job_order->warehouse }}',
            salesOrderId: '{{ $job_order->salesOrder->id }}',
            loading: false,
        },
        methods: {
            submitForm: function() {
                this.sendData();
            },
            sendData: function() {
                // console.log('submitted');
                let vm = this;

                const data = {
                    number: vm.number,
                    date: vm.date,
                    finish_date: vm.finishDate,
                    delivery_date: vm.deliveryDate,
                    designer: vm.designer,
                    preparer: vm.preparer,
                    examiner: vm.examiner,
                    production: vm.production,
                    finishing: vm.finishing,
                    warehouse: vm.warehouse,
                    sales_order_id: vm.salesOrderId,
                    selected_quotations: vm.checkedQuotations,
                }

                vm.loading = true;
                axios.patch('/spk/{{ $job_order->id }}', data)
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
                        Swal.fire(
                            'Oops!',
                            'Something wrong',
                            'error'
                        )
                    });
            },
            validateProducedQuantity: function(quotation) {
                const remainingQuantity = this.remainingQuantity(quotation.quantity, quotation.produced, quotation.production);
                if (remainingQuantity < 0) {
                    quotation.production = quotation.quantity - quotation.produced;
                }
            },
            remainingQuantity: function(quantity, produced, production) {
                const newProduction = isNaN(production) ? 0 : production;
                return Number(quantity) - Number(produced) - Number(newProduction);
            }
        },
        computed: {
            checkedQuotations: function() {
                return this.quotations.filter(quotation => this.checkedQuotationsIds.indexOf(quotation.id) > -1);
            },
            totalQuantity: function() {
                return this.checkedQuotations.map(quotation => quotation.quantity).reduce((acc, cur) => {
                    return acc + cur;
                }, 0);
            },
            totalProduced: function() {
                return this.checkedQuotations.map(quotation => {
                    if (isNaN(quotation.production)) {
                        return 0;
                    }
                    return Number(quotation.production);
                }).reduce((acc, cur) => {
                    return acc + cur;
                }, 0);
            },
            totalRemainingQuantity: function() {
                return this.totalQuantity - this.totalProduced;
            },
        }
    })
</script>
<script>
    $(function() {
        $('.job-order-date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: false,
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
        }).on('changeDate', function(e) {
            app.$data.date = e.format(0, 'yyyy-mm-dd');
        });

        $('.finish-date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: false,
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
        }).on('changeDate', function(e) {
            app.$data.finishDate = e.format(0, 'yyyy-mm-dd');
        });

        $('.delivery-date').datepicker({
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