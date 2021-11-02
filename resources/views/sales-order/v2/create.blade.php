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
                                        <input type="text" v-model="number" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Tanggal:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="flaticon2-calendar-9"></i></span>
                                        </div>
                                        <input type="text" v-model="date" id="date" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="bg-gray-100 p-3 rounded"> -->
                            <div class="form-row">
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Nomor Quotation:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">#</span>
                                        </div>
                                        <input type="text" v-model="quotationNumber" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Tanggal Quotation:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="flaticon2-calendar-9"></i></span>
                                        </div>
                                        <input type="text" v-model="quotationDate" id="quotation-date" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Nomor PO:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">#</span>
                                        </div>
                                        <input type="text" v-model="poNumber" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Tanggal PO:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="flaticon2-calendar-9"></i></span>
                                        </div>
                                        <input type="text" v-model="poDate" id="po-date" class="form-control">
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
                                    <span class="nav-text">info Lainnya</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="goods" role="tabpanel" aria-labelledby="goods-tab">
                                <div class="mt-2">
                                    <div class="my-3 text-right">
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#quotationModal"><i class="flaticon2-plus"></i> Pilih Quotation</button>
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#poModal"><i class="flaticon2-plus"></i> Pilih PO</button>
                                    </div>
                                    <div v-if="!selectedData">
                                        <p class="text-center">
                                            <i class="flaticon2-open-box font-size-h1"></i>
                                        </p>
                                        <p class="text-center text-dark-50"><strong>Tidak ada data</strong></p>
                                    </div>
                                    <div v-if="selectedData">
                                        <div v-if="selectedData.source == 'purchase_order'">
                                            <h1>Purchase Order <a href="#">#@{{ selectedData.data.number }}</a></h1>
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
                                                            <td><strong>-</strong></td>
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
                                                            <th>No</th>
                                                            <th>Kode</th>
                                                            <th>Deskripsi</th>
                                                            <th>Tanggal Kirim</th>
                                                            <th>Qty</th>
                                                            <th>Price</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(item, index) in selectedData.data.items">
                                                            <td>@{{ index + 1 }}</td>
                                                            <td>@{{ item.code }}</td>
                                                            <td>@{{ item.description }}</td>
                                                            <td>@{{ item.delivery_date }}</td>
                                                            <td class="text-right">@{{ toCurrencyFormat(item.quantity) }}</td>
                                                            <td class="text-right">@{{ toCurrencyFormat(item.price) }}</td>
                                                            <td class="text-right">@{{ toCurrencyFormat(item.amount) }}</td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td class="text-right" colspan="6"><strong>TOTAL</strong></td>
                                                            <td class="text-right"><strong>@{{ toCurrencyFormat(selectedData.data.total) }}</strong></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <div v-if="selectedData.source == 'quotation'">
                                            <h1>Quotation <a href="#">#@{{ selectedData.data.number }}</a></h1>
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
                                                            <td><strong>-</strong></td>
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
                                                            <td>UP</td>
                                                            <td><strong>@{{ selectedData.data.up }}</strong></td>
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
                                                            <th>No</th>
                                                            <th>Kode</th>
                                                            <th>Deskripsi</th>
                                                            <th>Tanggal Kirim</th>
                                                            <th>Qty</th>
                                                            <th>Price</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(item, index) in selectedData.data.items">
                                                            <td>@{{ index + 1 }}</td>
                                                            <td>@{{ item.code }}</td>
                                                            <td>@{{ item.description }}</td>
                                                            <td>@{{ item.delivery_date }}</td>
                                                            <td class="text-right">@{{ toCurrencyFormat(item.quantity) }}</td>
                                                            <td class="text-right">@{{ toCurrencyFormat(item.price) }}</td>
                                                            <td class="text-right">@{{ toCurrencyFormat(item.amount) }}</td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td class="text-right" colspan="6"><strong>TOTAL</strong></td>
                                                            <td class="text-right"><strong>@{{ toCurrencyFormat(selectedData.data.total) }}</strong></td>
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
                                                <label>File (Max. 2MB)</label>
                                                <div class="custom-file">
                                                    <input type="file" id="customFile" accept=".jpg, .jpeg, .png, .pdf, .doc, .xls, .xlsx" class="custom-file-input" disabled>
                                                    <label id="file-upload-label" for="customFile" class="custom-file-label">Choose file</label>
                                                </div>
                                                <!---->
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
            number: '',
            date: '',
            quotationId: '',
            quotationNumber: '',
            quotationDate: '',
            poId: '',
            poNumber: '',
            poDate: '',
            description: '',
            loading: false,
            selectedData: null,
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
                    customer_id: vm.selectedData.data.customer_id || '',
                    source: vm.selectedData.source,
                    quotation_id: vm.selectedData.source == 'quotation' ? vm.selectedData.data.id : '',
                    quotation_number: vm.quotationNumber,
                    quotation_date: vm.quotationDate,
                    purchase_order_id: vm.selectedData.source == 'purchase_order' ? vm.selectedData.data.id : '',
                    purchase_order_number: vm.poNumber,
                    purchase_order_date: vm.poDate,
                    po_number: vm.poNumber,
                    po_date: vm.poDate,
                    description: vm.description,
                };

                let formData = new FormData();
                for (var key in data) {
                    formData.append(key, data[key]);
                }

                axios.post('/sales-order', formData)
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
            ajax: '/datatables/v2/sales-orders/quotations',
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
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $('#quotation-table tbody').on('click', '.btn-choose', function() {
            const data = quotationsTable.row($(this).parents('tr')).data();
            app.$data.selectedData = {
                data,
                source: 'quotation',
            };

            app.$data.quotationNumber = app.$data.selectedData.data.number;
            const newDate = app.$data.selectedData.data.date;
            app.$data.quotationDate = newDate;
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

        $('#po-date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: false,
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
        }).on('changeDate', function(e) {
            app.$data.poDate = e.format(0, 'yyyy-mm-dd');
        });

        $('#quotation-date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: false,
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
        }).on('changeDate', function(e) {
            app.$data.quotationDate = e.format(0, 'yyyy-mm-dd');
        });

    })
</script>
@endsection