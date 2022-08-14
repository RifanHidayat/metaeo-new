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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Laporan Delivery Order</h5>
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
                        <a href="" class="text-muted">Delivery Order</a>
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
                <a :href="'/report/delivery-order/sheet' + generatedRequest" target="_blank" class="btn btn-light-success font-weight-bold mr-2">Export As .xlsx</a>
                <a href="#" class="btn btn-light-danger font-weight-bold">Export As .pdf</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="delivery-order-table">
                    <thead>
                        <tr class="text-center">
                            <th>Nomor</th>
                            <th>Tanggal</th>
                            <th>Customer</th>
                            <th>Gudang</th>
                            <th>Pengirim</th>
                            <th>Nomor Kendaraan</th>
                            <th>Alamat Penagihan</th>
                            <th>Alamat Pengiriman</th>
                            <th>Sales Order</th>
                            <th>Quotation</th>
                            <th>Total Kirim</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
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
                        id: 'customer',
                        text: 'Customer'
                    },
                    {
                        id: 'warehouse',
                        text: 'Gudang'
                    },
                    {
                        id: 'shipper',
                        text: 'Pengirim'
                    },
                    {
                        id: 'number_of_vehicle',
                        text: 'Nomor Kendaraan'
                    },
                    {
                        id: 'billing_address',
                        text: 'Alamat Penagihan'
                    },
                    {
                        id: 'shipping_address',
                        text: 'Alamat Pengiriman'
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
                        id: 'total_shipping',
                        text: 'Total Kirim'
                    },
                ],
                columnSelections: ['number', 'date', 'customer', 'warehouse', 'shipper', 'number_of_vehicle', 'billing_address', 'shipping_address', 'sales_order', 'quotations', 'total_shipping'],
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
                    name: 'delivery_orders.number',
                    render: function(data, type, row) {
                        return `<div class="text-dark-75 font-weight-bolder font-size-lg mb-0">${data}</div>`;
                    },
                    visible: defineColumnVisible(columnSelections, 'number'),
                },
                {
                    data: 'date',
                    name: 'delivery_orders.date',
                    render: function(data, type) {
                        return `<span class="text-primary font-weight-bolder font-size-lg">${data}</span>`;
                    },
                    visible: defineColumnVisible(columnSelections, 'date'),
                },
                {
                    data: 'customer.name',
                    name: 'customer.name',
                    render: function(data, type) {
                        return `<span class="text-dark-74 font-weight-bolder font-size-lg">${data}</span>`;
                    },
                    visible: defineColumnVisible(columnSelections, 'customer'),
                },
                {
                    data: 'warehouse',
                    name: 'delivery_orders.warehouse',
                    render: function(data, type) {
                        return `<span class="text-dark-74 font-weight-bolder font-size-lg">${data}</span>`;
                    },
                    visible: defineColumnVisible(columnSelections, 'warehouse'),
                },
                {
                    data: 'shipper',
                    name: 'delivery_orders.shipper',
                    render: function(data, type) {
                        return `<span class="text-dark-74 font-weight-bolder font-size-lg">${data}</span>`;
                    },
                    visible: defineColumnVisible(columnSelections, 'shipper'),
                },
                {
                    data: 'number_of_vehicle',
                    name: 'delivery_orders.number_of_vehicle',
                    render: function(data, type) {
                        return `<span class="text-dark-74 font-weight-bolder font-size-lg">${data}</span>`;
                    },
                    visible: defineColumnVisible(columnSelections, 'number_of_vehicle'),
                },
                {
                    data: 'billing_address',
                    name: 'delivery_orders.billing_address',
                    render: function(data, type) {
                        const limit = 30;
                        const ellipsis = '...'
                        return `<span class="text-dark-74 font-weight-bolder font-size-lg">${(data.length > limit ? data.substr(1, limit - ellipsis.length) + ellipsis : data)}</span>`;
                    },
                    visible: defineColumnVisible(columnSelections, 'billing_address'),
                },
                {
                    data: 'shipping_address',
                    name: 'delivery_orders.shipping_address',
                    render: function(data, type) {
                        const limit = 30;
                        const ellipsis = '...'
                        return `<span class="text-dark-74 font-weight-bolder font-size-lg">${(data.length > limit ? data.substr(1, limit - ellipsis.length) + ellipsis : data)}</span>`;
                    },
                    visible: defineColumnVisible(columnSelections, 'shipping_address'),
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
                    visible: defineColumnVisible(columnSelections, 'quotations'),
                    // className: 'text-right',
                    // render: function(data, type) {
                    //     return `<div class="text-muted font-weight-bolder font-size-lg mb-0">${data.length > 0 && Intl.NumberFormat('de-DE').format(data.map(item => Number(item.pivot.produced)).reduce((acc, cur) => { return acc + cur }, 0))}</div>`;
                    // },
                },
                {
                    data: 'quotations',
                    name: 'number',
                    className: 'text-right',
                    render: function(data, type) {
                        return `<div class="text-muted font-weight-bolder font-size-lg mb-0">${data.length > 0 && Intl.NumberFormat('de-DE').format(data.map(item => Number(item.pivot.amount)).reduce((acc, cur) => { return acc + cur }, 0))}</div>`;
                    },
                    visible: defineColumnVisible(columnSelections, 'total_shipping'),
                },
            ];
        }
        // $('#basic-table').DataTable();
        let deliveryOrdersTable = $('#delivery-order-table').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: '/datatables/reports/delivery-orders' + urlRequest(),
            order: [
                [2, 'desc']
            ],
            columns: dataTableColumns(app.$data.filter.columnSelections),
        });

        $('.btn-generate').on('click', function() {
            app.$data.loadingGenerate = true;
            deliveryOrdersTable = $('#delivery-order-table').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: '/datatables/reports/delivery-orders' + urlRequest(),
                order: [
                    [2, 'desc']
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