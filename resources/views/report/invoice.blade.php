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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Laporan Faktur</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Laporan</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Faktur</a>
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
<div id="app">
    <div class="card card-custom gutter-b">
        <div class="card-body">
            <div class="row justify-content-between">
                <div class="col-lg-7 col-md-12">
                    <p class="text-dark-75"><strong>Periode Laporan</strong></p>
                    <div class="form-group row align-items-center">
                        <div class="col-lg-4">
                            <select class="form-control form-control-sm">
                                <option value="custom">Custom Date</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <input type="text" v-model="filter.startDate" class="form-control form-control-sm start-date" placeholder="Start Date" aria-describedby="basic-addon2" />
                                <div class="input-group-append"><span class="input-group-text"><i class="flaticon2-calendar-7"></i></span></div>
                            </div>
                            <!-- <input type="text" class="form-control form-control-sm start-date"> -->
                        </div>
                        <!-- <div class="col-lg-1 text-center">
                        <span>to</span>
                    </div> -->
                        <div class="col-lg-4">
                            <div class="input-group">
                                <input type="text" v-model="filter.endDate" class="form-control form-control-sm end-date" placeholder="End Date" aria-describedby="basic-addon2" />
                                <div class="input-group-append"><span class="input-group-text"><i class="flaticon2-calendar-8"></i></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <!-- <div class="col-lg-4">
                            <p class="text-dark-75"><strong>Status</strong></p>
                            <select v-model="filter.status" class="form-control">
                                <option value="">Semua Status</option>
                                <option value="open">Open</option>
                                <option value="close">Closed</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div> -->
                        <div class="col-lg-4">
                            <p class="text-dark-75"><strong>Customer</strong></p>
                            <select v-model="filter.customer" class="form-control select-customer">
                                <option value="">Semua Customer</option>
                                @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <p class="text-dark-75"><strong>Kolom</strong></p>
                            <select v-model="filter.columnSelections" class="form-control form-control-sm select-column" multiple="multiple">
                                <option v-for="column in filter.columns" :value="column.id">@{{ column.text }}</option>
                                <!-- <option value="number">Nomor</option>
                                <option value="date">Tanggal</option>
                                <option value="customer">Customer</option>
                                <option value="work">Pekerjaan</option>
                                <option value="quantity">Quantity</option>
                                <option value="production">Produksi</option>
                                <option value="hpp">HPP</option>
                                <option value="hpp_per_unit">HPP / Unit</option>
                                <option value="price_per_unit">Price / Unit</option>
                                <option value="margin">Margin</option>
                                <option value="total_price">Total Price</option>
                                <option value="ppn">PPN</option>
                                <option value="pph">PPH</option>
                                <option value="total_bill">Total Piutang</option>
                                <option value="delivery_date">Tanggal Kirim</option>
                                <option value="status">Status</option> -->
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6 col-md-12">
                            <p class="text-dark-75"><strong>Urutkan Berdasarkan</strong></p>
                            <select v-model="filter.sortBy" class="form-control form-control-sm select-sort-by">
                                <option value="" disabled>Pilih Kolom</option>
                                <option v-for="column in sortColumns" :value="column.id">@{{ column.text }}</option>
                                <!-- <option value="date">Tanggal</option>
                                <option value="customer">Customer</option>
                                <option value="work">Pekerjaan</option>
                                <option value="quantity">Quantity</option>
                                <option value="production">Produksi</option>
                                <option value="hpp">HPP</option>
                                <option value="hpp_per_unit">HPP / Unit</option>
                                <option value="price_per_unit">Price / Unit</option>
                                <option value="margin">Margin</option>
                                <option value="total_price">Total Price</option>
                                <option value="ppn">PPN</option>
                                <option value="pph">PPH</option>
                                <option value="total_bill">Total Piutang</option>
                                <option value="delivery_date">Tanggal Kirim</option>
                                <option value="status">Status</option> -->
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <p class="text-dark-75"><strong>Urutkan Dengan</strong></p>
                            <select v-model="filter.sortIn" class="form-control">
                                <option value="asc">Ascending</option>
                                <option value="desc">Descending</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-light-primary font-weight-bold btn-generate" :class="loadingGenerate && 'spinner spinner-white spinner-right'" :disabled="loadingGenerate">Generate</button>
                    </div>
                </div>
                <!-- <div class="col-lg-5 col-md-12">
                    <p class="text-dark-75"><strong>Export As:</strong></p>
                    <div class="d-flex justify-content-center">
                        <div class="mr-5">
                            <img width="100" src="{{ asset('media/svg/reports/excel.svg') }}" alt="Export As .xlsx">
                            <p class="text-center text-dark-75"><strong>.xlsx</strong></p>
                        </div>
                        <div>
                            <img width="100" src="{{ asset('media/svg/reports/pdf.svg') }}" alt="Export As .pdf">
                            <p class="text-center text-dark-75"><strong>.pdf</strong></p>
                        </div>
                    </div>
                </div> -->
                <!-- <div class="col-lg-4 col-md-12">
                <p class="text-dark-75"><strong>Kolom</strong></p>
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    <input type="checkbox" name="Checkboxes1" />
                                    <span></span>
                                    Nomor
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            </div>

        </div>

    </div>
    <!-- <div class="py-5">
        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div> -->
    <div class="card card-custom gutter-b" id="app">
        <div class="card-header">
            <div class="card-title"></div>
            <div class="card-toolbar">
                <a :href="'/report/invoice/sheet' + generatedRequest" target="_blank" class="btn btn-light-success font-weight-bold mr-2">Export As .xlsx</a>
                <a href="#" class="btn btn-light-danger font-weight-bold">Export As .pdf</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="invoice-table">
                    <thead>
                        <tr class="text-center">
                            <th>Nomor Faktur</th>
                            <th>Tanggal Faktur</th>
                            <th>Due Date</th>
                            <th>Customer</th>
                            <th>GR Number</th>
                            <th>Seri Faktur Pajak</th>
                            <th>Syarat Pembayaran</th>
                            <th>Sales Order</th>
                            <th>Quotation</th>
                            <th>Total Sub</th>
                            <th>Diskon</th>
                            <th>PPN</th>
                            <th>PPh</th>
                            <th>Total</th>
                            <th>Total Pembayaran</th>
                            <th>Sisa Pembayaran</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="text-center"></tbody>
                </table>
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
            loadingGenerate: false,
            filter: {
                startDate: '{{ date("Y-m-01") }}',
                endDate: '{{ date("Y-m-t") }}',
                columns: [{
                        id: 'number',
                        text: 'Nomor'
                    },
                    {
                        id: 'date',
                        text: 'Tanggal'
                    },
                    {
                        id: 'due_date',
                        text: 'Due Date'
                    },
                    {
                        id: 'customer',
                        text: 'Customer'
                    },
                    {
                        id: 'gr_number',
                        text: 'GR Number'
                    },
                    {
                        id: 'tax_invoice_series',
                        text: 'Seri Faktur Pajak'
                    },
                    {
                        id: 'terms_of_payment',
                        text: 'Syarat Pembayaran'
                    },
                    {
                        id: 'sales_order',
                        text: 'Sales Order'
                    },
                    {
                        id: 'quotations',
                        text: 'Quotation'
                    },
                    {
                        id: 'netto',
                        text: 'Total Sub'
                    },
                    {
                        id: 'discount',
                        text: 'Diskon'
                    },
                    {
                        id: 'ppn',
                        text: 'PPN'
                    },
                    {
                        id: 'pph',
                        text: 'PPH'
                    },
                    {
                        id: 'total',
                        text: 'Total'
                    },
                    {
                        id: 'total_payment',
                        text: 'Total Pembayaran'
                    },
                    {
                        id: 'unpaid',
                        text: 'Sisa Pembayaran'
                    },
                    {
                        id: 'status',
                        text: 'Keterangan'
                    },
                ],
                columnSelections: ['number', 'date', 'customer', 'due_date', 'gr_number', 'tax_invoice_series', 'terms_of_payment', 'sales_order', 'quotations', 'netto', 'discount', 'ppn', 'pph', 'total', 'total_payment', 'unpaid', 'status'],
                // tes: function() {
                //     return this.startDate;
                // },
                status: '',
                customer: '',
                sortBy: '',
                sortIn: 'asc',
            }
            // customers: JSON.parse(String.raw `{!! $customers !!}`),
        },
        methods: {
            // generateSheet: function() {

            // }
        },
        computed: {
            // columnSelections: function() {
            //     let vm = this;
            //     return this.filter.columns.map(column => column.id);
            // },
            sortColumns: function() {
                let vm = this;
                return this.filter.columns.filter(column => vm.filter.columnSelections.indexOf(column.id) > -1);
            },
            generatedRequest: function() {
                return `?start_date=${this.filter.startDate}` +
                    `&end_date=${this.filter.endDate}` +
                    // `&status=${this.filter.status}` +
                    `&customer=${this.filter.customer}` +
                    `&columns=${this.filter.columnSelections}` +
                    // `&all_columns=${JSON.stringify(this.filter.columns)}` +
                    `&sort_by=${this.filter.sortBy}` +
                    `&sort_in=${this.filter.sortIn}`;
            }
        }
    })
</script>
<script>
    $(function() {
        let urlRequest = function() {
            return `?start_date=${app.$data.filter.startDate}` +
                `&end_date=${app.$data.filter.endDate}` +
                `&status=${app.$data.filter.status}` +
                `&customer=${app.$data.filter.customer}` +
                `&columns=${app.$data.filter.columnSelections}` +
                `&sort_by=${app.$data.filter.sortBy}` +
                `&sort_in=${app.$data.filter.sortIn}`;
        }

        let defineColumnVisible = function(columnSelections = [], columnName) {
            const index = columnSelections.indexOf(columnName);
            return index > -1 ? true : false;
        }

        let dataTableColumns = function(columnSelections = []) {
            return [{
                    data: 'number',
                    name: 'invoices.number',
                    render: function(data, type, row) {
                        return `<div class="text-dark-75 font-weight-bolder font-size-lg mb-0">${data}</div>`;
                    },
                    visible: defineColumnVisible(columnSelections, 'number'),
                },
                {
                    data: 'date',
                    name: 'invoices.date',
                    render: function(data, type) {
                        return `<span class="text-primary font-weight-bolder font-size-lg">${data}</span>`;
                    },
                    visible: defineColumnVisible(columnSelections, 'date'),
                },
                {
                    data: 'due_date',
                    name: 'invoices.due_date',
                    render: function(data, type) {
                        return `<span class="text-dark-75 font-weight-bolder font-size-lg">${data}</span>`;
                    },
                    visible: defineColumnVisible(columnSelections, 'due_date'),
                },
                {
                    data: 'customer.name',
                    name: 'customer.name',
                    render: function(data, type) {
                        return `<span class="text-dark-75 font-weight-bolder font-size-lg">${data}</span>`;
                    },
                    visible: defineColumnVisible(columnSelections, 'customer'),
                },
                {
                    data: 'gr_number',
                    name: 'invoices.gr_number',
                    render: function(data, type) {
                        return `<span class="text-dark-75 font-weight-bolder font-size-lg">${data}</span>`;
                    },
                    visible: defineColumnVisible(columnSelections, 'gr_number'),
                },
                {
                    data: 'tax_invoice_series',
                    name: 'invoices.tax_invoice_series',
                    render: function(data, type) {
                        return `<span class="text-dark-75 font-weight-bolder font-size-lg">${data}</span>`;
                    },
                    visible: defineColumnVisible(columnSelections, 'tax_invoice_series'),
                },
                {
                    data: 'terms_of_payment',
                    name: 'invoices.terms_of_payment',
                    render: function(data, type) {
                        return `<span class="text-dark-75 font-weight-bolder font-size-lg">${data}</span>`;
                    },
                    visible: defineColumnVisible(columnSelections, 'terms_of_payment'),
                },
                {
                    data: 'sales_order.number',
                    name: 'salesOrder.number',
                    render: function(data, type, row) {
                        return `<div class="text-dark-75 font-weight-bolder font-size-lg mb-0">${data}</div>`;
                    },
                    visible: defineColumnVisible(columnSelections, 'sales_order'),
                },
                {
                    data: 'quotation_number',
                    name: 'quotations.number',
                    // render: function(data, type) {
                    //     return `<div class="text-dark-75 font-weight-bolder font-size-lg mb-0">${data.length > 0 && data.map(item => `<span class="label label-light-info label-pill label-inline text-capitalize">${item.number}</span>`).join('')}</div>`;
                    // },
                    visible: defineColumnVisible(columnSelections, 'quotations'),
                },
                {
                    data: 'netto',
                    name: 'invoices.netto',
                    render: function(data, type) {
                        return `<span class="text-dark-75 font-weight-bolder font-size-lg">${Intl.NumberFormat('de-DE').format(data)}</span>`;
                    },
                    visible: defineColumnVisible(columnSelections, 'netto'),
                },
                {
                    data: 'discount',
                    name: 'invoices.discount',
                    render: function(data, type) {
                        return `<span class="text-dark-75 font-weight-bolder font-size-lg">${Intl.NumberFormat('de-DE').format(data)}</span>`;
                    },
                    visible: defineColumnVisible(columnSelections, 'discount'),
                },
                {
                    data: 'ppn',
                    name: 'invoices.ppn',
                    render: function(data, type) {
                        return `<span class="text-dark-75 font-weight-bolder font-size-lg">${Intl.NumberFormat('de-DE').format(data)}</span>`;
                    },
                    visible: defineColumnVisible(columnSelections, 'ppn'),
                },
                {
                    data: 'pph',
                    name: 'invoices.pph',
                    render: function(data, type) {
                        return `<span class="text-dark-75 font-weight-bolder font-size-lg">${Intl.NumberFormat('de-DE').format(data)}</span>`;
                    },
                    visible: defineColumnVisible(columnSelections, 'pph'),
                },
                {
                    data: 'total',
                    name: 'invoices.total',
                    render: function(data, type) {
                        return `<span class="text-dark-75 font-weight-bolder font-size-lg">${Intl.NumberFormat('de-DE').format(data)}</span>`;
                    },
                    visible: defineColumnVisible(columnSelections, 'total'),
                },
                {
                    data: 'transactions',
                    name: 'number',
                    render: function(data, type, row) {
                        const totalPayment = data.map(transaction => transaction.pivot.amount).reduce((acc, cur) => {
                            return acc + cur;
                        }, 0);

                        // const unpaid = row.total - totalPayment;

                        // if (unpaid > 0) {
                        //     return `<div class="text-success font-weight-bolder font-size-lg mb-0">${ Intl.NumberFormat('de-DE').format(unpaid) }</div>`
                        // }

                        return `<div class="text-success font-weight-bolder font-size-lg mb-0">${ Intl.NumberFormat('de-DE').format(totalPayment) }</div>`
                    },
                    visible: defineColumnVisible(columnSelections, 'total_payment'),
                },
                {
                    data: 'transactions',
                    name: 'number',
                    render: function(data, type, row) {
                        const totalPayment = data.map(transaction => transaction.pivot.amount).reduce((acc, cur) => {
                            return acc + cur;
                        }, 0);

                        const unpaid = row.total - totalPayment;

                        return `<div class="text-warning font-weight-bolder font-size-lg mb-0">${ Intl.NumberFormat('de-DE').format(unpaid) }</div>`
                        // if (unpaid > 0) {}

                        // return `<span class="label label-light-success label-pill label-inline text-capitalize">Lunas</span>`;
                    },
                    visible: defineColumnVisible(columnSelections, 'unpaid'),
                },
                {
                    data: 'transactions',
                    name: 'number',
                    render: function(data, type, row) {
                        const totalPayment = data.map(transaction => transaction.pivot.amount).reduce((acc, cur) => {
                            return acc + cur;
                        }, 0);

                        const unpaid = row.total - totalPayment;

                        if (unpaid > 0) {
                            return `<span class="label label-light-warning label-pill label-inline text-capitalize">Belum Lunas</span>`
                        }

                        return `<span class="label label-light-success label-pill label-inline text-capitalize">Lunas</span>`;
                    },
                    visible: defineColumnVisible(columnSelections, 'status'),
                },
            ];
        }
        // $('#basic-table').DataTable();
        let invoicesTable = $('#invoice-table').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: '/datatables/reports/invoices' + urlRequest(),
            order: [
                [1, 'desc']
            ],
            columns: dataTableColumns(app.$data.filter.columnSelections),
        });

        $('.btn-generate').on('click', function() {
            app.$data.loadingGenerate = true;
            invoicesTable = $('#invoice-table').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: '/datatables/reports/invoices' + urlRequest(),
                order: [
                    [1, 'desc']
                ],
                columns: dataTableColumns(app.$data.filter.columnSelections),
                "drawCallback": function(settings) {
                    app.$data.loadingGenerate = false;
                },
            });
        })

        $('.select-column').select2();
        $('.select-column').on('change', function() {
            app.$data.filter.columnSelections = $(this).val();
            // console.log($(this).val());
        })

        $('.select-sort-by').select2();
        $('.select-sort-by').on('change', function() {
            app.$data.filter.sortBy = $(this).val();
        });

        $('.select-customer').select2();
        $('.select-customer').on('change', function() {
            app.$data.filter.customer = $(this).val();
        });

        $('.start-date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: false,
            clearBtn: true,
            orientation: "bottom left",
            todayHighlight: true
        }).on('changeDate', function(e) {
            app.$data.filter.startDate = e.format(0, 'yyyy-mm-dd');
        });
        $('.end-date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: false,
            clearBtn: true,
            orientation: "bottom left",
            todayHighlight: true
        }).on('changeDate', function(e) {
            app.$data.filter.endDate = e.format(0, 'yyyy-mm-dd');
        });
    })
</script>
@endsection