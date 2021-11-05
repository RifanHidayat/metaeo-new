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
                        <div>
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
                                            <td><strong>@{{ selectedData.data.customer_purchase_order_number }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal PO</td>
                                            <td><strong>@{{ selectedData.data.customer_purchase_order_date }}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <h3>Delivery Order</h3>
                            <table class="table table-bordered">
                                <thead class="bg-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Jumlah Pengiriman</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td v-if="!filteredDeliveryOrders.length" class="text-center" colspan="10"><em>Tidak ada delivery order</em></td>
                                    </tr>
                                    <tr v-for="(deliveryOrder, index) in filteredDeliveryOrders">
                                        <td class="align-middle text-center">@{{ index + 1 }}</td>
                                        <td class="align-middle text-center"><a href="#" target="_blank">@{{ deliveryOrder.number }}</a></td>
                                        <td class="align-middle text-center">@{{ getDeliveryOrderTotal(deliveryOrder, selectedData.data.source) }}</td>
                                        <td class="align-middle text-center">
                                            <button v-if="deliveryOrder.invoices.length < 1" type="button" @click="selectDeliveryOrder(deliveryOrder)" class="btn btn-icon btn-sm btn-light">
                                                <i class="flaticon2-plus"></i>
                                            </button>
                                            <div v-else>
                                                <i class="flaticon2-protected text-success"></i>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div v-if="selectedData" class="mt-20">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="delivery-item-tab" data-toggle="tab" href="#delivery-item">
                                    <span class="nav-icon">
                                        <i class="flaticon-signs-1"></i>
                                    </span>
                                    <span class="nav-text">Delivery Order&nbsp;<span class="label label-primary mr-2">@{{ selectedDeliveryOrders.length }}</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="info-tab" data-toggle="tab" href="#info">
                                    <span class="nav-icon">
                                        <i class="flaticon-signs-1"></i>
                                    </span>
                                    <span class="nav-text">Info Invoice</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="other-tab" data-toggle="tab" href="#other">
                                    <span class="nav-icon">
                                        <i class="flaticon-signs-1"></i>
                                    </span>
                                    <span class="nav-text">Info Lainnya</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="delivery-item" role="tabpanel" aria-labelledby="delivery-item-tab">
                                <div class="card card-custom card-border mt-5">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h3 class="card-label">
                                                List Delivery Order
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div v-if="selectedDeliveryOrders.length < 1" class="text-center">
                                            <i class="flaticon2-open-box icon-4x"></i>
                                            <p class="text-muted">Pilih delivery order</p>
                                        </div>
                                        <div>
                                            <div class="row align-items-center" v-for="(deliveryOrder, index) in selectedDeliveryOrders" :key="deliveryOrder.id">
                                                <div class="col-md-11 card card-custom gutter-b card-stretch card-border ribbon ribbon-top">
                                                    <div class="card-body pt-4">
                                                        <!--begin::User-->
                                                        <div class="d-flex align-items-center my-7">
                                                            <!--begin::Title-->
                                                            <div class="d-flex flex-column">
                                                                <a href="#" class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-0">@{{ deliveryOrder.number }} | @{{ deliveryOrder.date }}</a>
                                                                <!-- <span class="text-muted font-weight-bold">Tanggal Kirim: @{{ deliveryOrder.date }}</span> -->
                                                            </div>
                                                            <!--end::Title-->
                                                        </div>
                                                        <!--end::User-->
                                                        <!--begin::Info-->
                                                        <div class="mb-7">
                                                            <div class="mt-5">
                                                                <div>
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Pengirim</th>
                                                                                <th>Gudang</th>
                                                                                <th>Nomor Kendaraan</th>
                                                                                <th>Alamat</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>@{{ deliveryOrder.shipper }}</td>
                                                                                <td>@{{ deliveryOrder.warehouse }}</td>
                                                                                <td>@{{ deliveryOrder.number_of_vehicle }}</td>
                                                                                <td>@{{ deliveryOrder.shipping_address }}</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--end::Info-->

                                                    </div>
                                                    <!--end::Body-->
                                                </div>
                                                <div class="col-md-1 text-right">
                                                    <a href="#" @click.prevent="unselectDeliveryOrder(index)"><i class="flaticon2-trash text-danger"></i></a>
                                                </div>
                                            </div>
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
                                                    <span class="font-weight-bolder font-size-sm">Subtotal</span>
                                                    <span class="font-weight-bolder font-size-h5">
                                                        <span class="text-dark-50 font-weight-bold">Rp </span>
                                                        @{{ Intl.NumberFormat('de-DE').format(subtotal) }}
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
                                                        (@{{ Intl.NumberFormat('de-DE').format(clearCurrencyMask(discount)) }})
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
                            </div>
                            <div class="tab-pane" id="info" role="tabpanel" aria-labelledby="info-tab">
                                <div class="row justify-content-between mt-5">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label text-lg-right">Nomor Faktur:</label>
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
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label text-lg-right">Seri Faktur Pajak:</label>
                                            <div class="col-lg-8">
                                                <input type="text" v-model="taxInvoiceSeries" class="form-control" placeholder="Masukkan seri faktur pajak" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
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
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="other" role="tabpanel" aria-labelledby="other-tab">
                                <div class="row justify-content-between mt-5">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Note:</label>
                                            <div>
                                                <textarea rows="5" v-model="note" class="form-control" placeholder="Masukkan note"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-6">

                        </div>
                        <div class="col-lg-6 text-lg-right">
                            <button type="submit" class="btn btn-primary" :class="loading && 'spinner spinner-white spinner-right'" :disabled="loading || selectedDeliveryOrders.length < 1 || !isDueDateValid">
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
            quotations: [],
            checkedQuotationsIds: [],
            number: '{{ $number }}',
            date: '',
            dueDate: '',
            dueDateTerm: 'custom',
            customer: 1,
            taxInvoiceSeries: '',
            termsOfPayment: '',
            grNumber: '',
            discount: 0,
            picPo: '',
            picPoPosition: '',
            note: '',
            salesOrderId: '',
            loading: false,
            cleaveCurrency: {
                delimiter: '.',
                numeralDecimalMark: ',',
                numeral: true,
                numeralThousandsGroupStyle: 'thousand'
            },
            selectedData: null,
            selectedDeliveryOrders: [],
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
                    selected_delivery_orders: vm.selectedDeliveryOrders,
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
                console.log(invoiceDate, dueDate);
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
            },
            getDeliveryOrderTotal(deliveryOrder, source = '') {

                function getTotal(items) {
                    if (typeof items == "undefined") {
                        return 0;
                    } else {
                        if (Array.isArray(items)) {
                            return items.map(item => Number(item.pivot.amount)).reduce((acc, cur) => {
                                return acc + cur;
                            }, 0);
                        } else {
                            return 0;
                        }
                    }
                }

                if (source == 'quotation') {
                    return getTotal(deliveryOrder.v2_quotation_items);
                } else if (source == 'purchase_order') {
                    return getTotal(deliveryOrder.cpo_items);
                } else {
                    return 0;
                }
            },
            selectDeliveryOrder: function(deliveryOrder) {
                let vm = this;
                deliveryOrder.source = vm.selectedData.source;
                vm.selectedDeliveryOrders.push(deliveryOrder);
            },
            unselectDeliveryOrder: function(index) {
                let vm = this;
                vm.selectedDeliveryOrders.splice(index, 1);
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
            // netto: function() {
            //     let vm = this;
            //     return this.checkedQuotations.map(quotation => {
            //         if (quotation.pivot.estimation == null || typeof quotation.pivot.estimation == 'undefined') {
            //             return 0;
            //         }

            //         const netto = (Number(quotation.pivot.estimation.quantity) * Number(quotation.pivot.estimation.price_per_unit));

            //         return netto;
            //     }).reduce((acc, cur) => {
            //         return acc + cur;
            //     }, 0);
            // },
            netto: () => 0,
            subtotal: function() {
                let vm = this;

                function getTotal(items) {
                    if (typeof items == "undefined") {
                        return 0;
                    } else {
                        if (Array.isArray(items)) {
                            return items.map(item => Number(item.pivot.amount) * Number(item.price)).reduce((acc, cur) => {
                                return acc + cur;
                            }, 0);
                        } else {
                            return 0;
                        }
                    }
                }

                const subtotal = vm.selectedDeliveryOrders.map(order => {
                    if (order.source == 'quotation') {
                        return getTotal(order.v2_quotation_items);
                    } else if (order.source == 'purchase_order') {
                        return getTotal(order.cpo_items);
                    } else {
                        return 0;
                    }
                }).reduce((acc, cur) => {
                    return acc + cur;
                }, 0)

                return subtotal;
            },
            ppn: function() {
                const PERCENTAGE = 10;
                const subtotal = isNaN(this.subtotal) ? 0 : (this.subtotal - Number(this.clearCurrencyMask(this.discount)));
                const ppn = subtotal * (PERCENTAGE / 100);
                return ppn;
            },
            pph: function() {
                const PERCENTAGE = 2;
                const subtotal = isNaN(this.subtotal) ? 0 : (this.subtotal - Number(this.clearCurrencyMask(this.discount)));
                const pph = subtotal * (PERCENTAGE / 100);
                return pph;
            },
            total: function() {
                const total = (this.subtotal - Number(this.clearCurrencyMask(this.discount))) + this.ppn - this.pph;
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
            },
            filteredDeliveryOrders: function() {
                let vm = this;
                if (vm.selectedData.data !== null) {
                    let deliveryOrders = vm.selectedData.data.delivery_orders;
                    if (Array.isArray(deliveryOrders)) {
                        deliveryOrders = deliveryOrders.filter(order => order.invoices.length < 1);
                        if (typeof deliveryOrders !== "undefined") {
                            const selectedDeliveryOrdersIds = vm.selectedDeliveryOrders.map(order => order.id);
                            return deliveryOrders.filter(order => selectedDeliveryOrdersIds.indexOf(order.id) < 0);
                        } else {
                            return [];
                        }
                    } else {
                        return [];
                    }
                } else {
                    return [];
                }
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
        salesOrdersTable = $('#sales-order-table').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: '/datatables/v2/invoices/sales-orders',
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
            app.$data.salesOrderId = data.id;
            app.$data.selectedData = {
                data,
                source: data.source,
            };

            // app.$data.salesOrderNumber = app.$data.selectedData.data.number;
            // const newDate = app.$data.selectedData.data.date;
            // app.$data.salesOrderDate = newDate;
            // $('#salesOrder-date').datepicker('update', newDate);

            $('#salesOrderModal').modal('hide');
        });


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