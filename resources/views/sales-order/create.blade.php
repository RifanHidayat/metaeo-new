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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Add Sales Order</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Sales Order</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Add</a>
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
                <h3 class="card-title">Add Sales Order</h3>

            </div>
            <!--begin::Form-->
            <form class="form" autocomplete="off" @submit.prevent="submitForm">
                <div class="card-body">

                    <div class="row justify-content-between">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-lg-right">Sales Order Number:<span class="text-danger">*</span></label>
                                <div class="col-lg-8">
                                    <input type="text" v-model="number" class="form-control" readonly required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-lg-right">Tanggal Sales Order:<span class="text-danger">*</span></label>
                                <div class="col-lg-8">
                                    <input type="text" v-model="date" class="form-control so-date" placeholder="Masukkan tanggal sales order" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-lg-right">PO Number:</label>
                                <div class="col-lg-8">
                                    <input type="text" v-model="poNumber" class="form-control" placeholder="Masukkan PO number" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-lg-right">Tanggal PO:</label>
                                <div class="col-lg-8">
                                    <input type="text" v-model="poDate" class="form-control po-date" placeholder="Masukkan tanggal PO" />
                                </div>
                            </div>
                            <!-- <div class="form-group row">
                                    <label class="col-lg-4 col-form-label text-lg-right">Total Piutang:</label>
                                    <div class="col-lg-8">
                                        <input type="email" class="form-control" placeholder="Enter full name" />
                                        <span class="form-text text-muted">Please enter your full name</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label text-lg-right">Quantity:</label>
                                    <div class="col-lg-8">
                                        <input type="email" class="form-control" placeholder="Enter full name" />
                                        <span class="form-text text-muted">Please enter your full name</span>
                                    </div>
                                </div> -->
                        </div>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="col-form-label text-lg-right">File:</label>
                                <div>
                                    <div class="dropzone dropzone-default" id="kt_dropzone_1">
                                        <div class="dropzone-msg dz-message needsclick">
                                            <h3 class="dropzone-msg-title">Drop files here or click to upload.</h3>
                                            <!-- <span class="dropzone-msg-desc">This is just a demo dropzone. Selected files are
                                                    <strong>not</strong>actually uploaded.</span> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- begin::Quotations List -->
                    <div class="card card-custom card-border">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">
                                    Pilih Quotation
                                </h3>
                            </div>
                            <div class="card-toolbar">
                                <a href="#" class="btn btn-light-success" data-toggle="modal" data-target="#quotationModal">
                                    <i class="flaticon2-add-1"></i> Tambah
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div v-if="selectedQuotations.length < 1" class="text-center">
                                <i class="flaticon2-open-box icon-4x"></i>
                                <p class="text-muted">Belum ada quotation terpilih</p>
                            </div>
                            <div>
                                <selected-quotation v-for="(quotation, index) in selectedQuotations" :key="quotation.id" :quotation="quotation" :estimationdata="estimationData" :ondelete="unselectQuotation" :index="index">
                                </selected-quotation>
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
                                        <i class="flaticon2-graphic-1 icon-2x text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-75">
                                        <span class="font-weight-bolder font-size-sm">Total Piutang</span>
                                        <span class="font-weight-bolder font-size-h5">
                                            <span class="text-dark-50 font-weight-bold">Rp</span> @{{ Intl.NumberFormat('de-DE').format(grandTotalBill) }}</span>
                                    </div>
                                </div>
                                <!--end: Item-->
                            </div>
                        </div>
                    </div>
                    <!-- end::Quotations List -->
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-6">

                        </div>
                        <div class="col-lg-6 text-lg-right">
                            <button type="submit" class="btn btn-primary" :class="loading && 'spinner spinner-white spinner-right'" :disabled="loading || selectedQuotations.length < 1">
                                Save
                            </button>
                            <!-- <button type=" reset" class="btn btn-secondary">Cancel</button> -->
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
    </div>
</div>

<!-- Modal-->
<div class="modal fade" id="quotationModal" tabindex="-1" role="dialog" aria-labelledby="quotationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quotationModalLabel">Modal Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <select class="form-control" id="customer">
                        <option value="">Pilih Customer</option>
                        @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <table class="table" id="quotation-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal Quotation</th>
                            <th>Title</th>
                            <th>UP</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/pages/features/miscellaneous/sweetalert2.js') }}"></script>
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js?v=7.2.8') }}"></script>
@endsection

@section('pagescript')
<script>
    Vue.component('selected-quotation', {
        props: ['quotation', 'ondelete', 'index'],
        methods: {
            estimationData: function(id, estimations) {
                if (id == null || typeof(id) == 'undefined') {
                    return null;
                }

                const estimation = estimations.filter(est => est.id == id)[0];

                return estimation;

            },
            toCurrency: function(number) {
                return Intl.NumberFormat('de-DE').format(number);
            }
        },
        template: `
        <div class="card card-custom gutter-b card-stretch card-border ribbon ribbon-top">
            <!-- <div :class="'ribbon-target bg-primary text-capitalize'" style="top: -2px; left: 20px;">Closed</div> -->
            <!--begin::Body-->
            <div class="card-body pt-4">
                <div class="d-flex justify-content-end">
                    <a href="#" @click.prevent="ondelete(index)" class="btn btn-clean btn-hover-light-danger btn-sm btn-icon">
                        <i class="ki ki-bold-close"></i>
                    </a>
                </div>
                <!--begin::User-->
                <div class="d-flex align-items-center mb-7">
                    <!--begin::Title-->
                    <div class="d-flex flex-column">
                        <a href="#" class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-0">@{{ quotation.number }} - @{{ quotation.title }}</a>
                        <span class="text-muted font-weight-bold">PT Kalbe Farma | @{{ quotation.date }}</span>
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
                        <span v-if="typeof(quotation.selected_estimation) !== 'undefined'" class="text-muted text-hover-primary">@{{ toCurrency(estimationData(quotation.selected_estimation, quotation.estimations)?.quantity) }}</span>
                        <span v-else class="text-muted text-hover-primary">Pilih Estimasi</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-cente my-1">
                        <span class="text-dark-75 font-weight-bolder mr-2">Unit Price:</span>
                        <span v-if="typeof(quotation.selected_estimation) !== 'undefined'" class="text-muted text-hover-primary">@{{ toCurrency(estimationData(quotation.selected_estimation, quotation.estimations)?.price_per_unit) }}</span>
                        <span v-else class="text-muted text-hover-primary">Pilih Estimasi</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center my-1">
                        <span class="text-dark-75 font-weight-bolder mr-2">Total Piutang:</span>
                        <span v-if="typeof(quotation.selected_estimation) !== 'undefined'" class="text-muted text-hover-primary">@{{ toCurrency(estimationData(quotation.selected_estimation, quotation. estimations)?.total_bill) }}</span>
                        <span v-else class="text-muted text-hover-primary">Pilih Estimasi</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-5">
                        <span class="text-dark-75 font-weight-bolder mr-2">Estimasi yang Digunakan:</span>
                        <div>
                            <select v-model="quotation['selected_estimation']" class="form-control" required>
                                <option v-for="estimation in quotation.estimations" :key="estimation.id" :value="estimation.id">@{{ estimation.number }}</option>
                            </select>
                        </div>
                    </div>
                    <a v-if="typeof(quotation.selected_estimation) !== 'undefined'" data-toggle="collapse" :href="'#collapseEstmationDetail' + quotation.id" role="button" aria-expanded="false" :aria-controls="'collapseEstmationDetail' + quotation.id">
                        Detail Estimasi <i class="flaticon2-down icon-sm text-primary"></i>
                    </a>
                    <div class="p-3"></div>
                    <div class="collapse" :id="'collapseEstmationDetail' + quotation.id">
                        <div class="card card-body bg-gray-100">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th>Number</th>
                                                    <td class="text-right">@{{ estimationData(quotation.selected_estimation, quotation. estimations)?.number }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <td class="text-right">@{{ estimationData(quotation.selected_estimation, quotation. estimations)?.date }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Pengiriman</th>
                                                    <td class="text-right">@{{ estimationData(quotation.selected_estimation, quotation. estimations)?.delivery_date }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Pekerjaan</th>
                                                    <td class="text-right">@{{ estimationData(quotation.selected_estimation, quotation. estimations)?.work }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Quantity</th>
                                                    <td class="text-right">@{{ toCurrency(estimationData(quotation.selected_estimation, quotation. estimations)?.quantity) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Produksi</th>
                                                    <td class="text-right">@{{ toCurrency(estimationData(quotation.selected_estimation, quotation. estimations)?.production) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>HPP</th>
                                                    <td class="text-right">@{{ toCurrency(estimationData(quotation.selected_estimation, quotation. estimations)?.hpp) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th>HPP / Unit</th>
                                                    <td class="text-right">@{{ toCurrency(estimationData(quotation.selected_estimation, quotation. estimations)?.hpp_per_unit) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Price / Unit</th>
                                                    <td class="text-right">@{{ toCurrency(estimationData(quotation.selected_estimation, quotation. estimations)?.price_per_unit) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Margin</th>
                                                    <td class="text-right">@{{ toCurrency(estimationData(quotation.selected_estimation, quotation. estimations)?.margin) }} %</td>
                                                </tr>
                                                <tr>
                                                    <th>Total</th>
                                                    <td class="text-right">@{{ toCurrency(estimationData(quotation.selected_estimation, quotation. estimations)?.total_price) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>PPN</th>
                                                    <td class="text-right">@{{ toCurrency(estimationData(quotation.selected_estimation, quotation. estimations)?.ppn) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>PPH</th>
                                                    <td class="text-right">(@{{ toCurrency(estimationData(quotation.selected_estimation, quotation. estimations)?.pph) }})</td>
                                                </tr>
                                                <tr>
                                                    <th>Total Piutang</th>
                                                    <td class="text-right">@{{ toCurrency(estimationData(quotation.selected_estimation, quotation. estimations)?.total_bill) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Info-->

            </div>
            <!--end::Body-->
        </div>
        `,
    })

    let app = new Vue({
        el: '#app',
        data: {
            number: '{{ $sales_order_number }}',
            date: '',
            customer: '',
            poNumber: '',
            poDate: '',
            selectedQuotations: [],
            loading: false,
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
                    customer_id: vm.customer,
                    date: vm.date,
                    po_number: vm.poNumber,
                    po_date: vm.poDate,
                    selected_quotations: vm.selectedQuotations,
                };

                axios.post('/sales-order', data)
                    .then(function(response) {
                        vm.loading = false;
                        Swal.fire({
                            title: 'Success',
                            text: 'Data has been saved',
                            icon: 'success',
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // window.location.href = '/sales-order';
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
            unselectQuotation: function(index) {
                this.selectedQuotations.splice(index, 1);
            },
            estimationData: function(id, estimations) {
                if (id == null || typeof(id) == 'undefined') {
                    return null;
                }

                const estimation = estimations.filter(est => est.id == id)[0];

                return estimation;

            }
        },
        computed: {
            totalQuantity: function() {
                if (this.selectedQuotations.length > 0) {
                    return this.selectedQuotations.map(quotation => quotation.quantity).reduce((acc, cur) => {
                        return acc + cur;
                    }, 0)
                }

                return 0;
            },
            grandTotalBill: function() {
                if (this.selectedQuotations.length > 0) {
                    return this.selectedQuotations.map(quotation => quotation.total_bill).reduce((acc, cur) => {
                        return acc + cur;
                    }, 0)
                }

                return 0;
            }
        }
    })
</script>
<script>
    $(function() {

        let quotationsTable = null;

        $('#customer').select2();

        $('#customer').on('change', function(e) {
            const customer = $(this).val();
            app.$data.customer = customer;
            quotationsTable = $('#quotation-table').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: '/datatables/sales-orders/quotations?customer_id=' + customer,
                columns: [{
                        data: 'number',
                        render: function(data, type) {
                            return `<a href="#">${data}</a>`;
                        }
                    },
                    {
                        data: 'date'
                    },
                    {
                        data: 'title',
                    },
                    {
                        data: 'up',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },

                ]
            });
        })

        $('#quotation-table tbody').on('click', '.btn-choose', function() {
            const data = quotationsTable.row($(this).parents('tr')).data();
            // delete data['DT_RowIndex'];
            // delete data['action'];

            const selectedQuotations = app.$data.selectedQuotations;

            const selectedQuotationsIds = app.$data.selectedQuotations.map(quotation => quotation.id);

            if (selectedQuotationsIds.indexOf(data.id) < 0) {
                selectedQuotations.push(data);
            }

            $('#quotationModal').modal('hide');

            // $(this).prop('disabled', true);
            // $(this).html('<i class="flaticon2-check-mark"></i> Terpilih');

        });

        $('#kt_dropzone_1').dropzone({
            url: "https://keenthemes.com/scripts/void.php", // Set the url for your upload script location
            paramName: "file", // The name that will be used to transfer the file
            maxFiles: 1,
            maxFilesize: 5, // MB
            addRemoveLinks: true,
            accept: function(file, done) {
                if (file.name == "justinbieber.jpg") {
                    done("Naha, you don't.");
                } else {
                    done();
                }
            }
        });

        $('.so-date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: true,
            clearBtn: true,
            orientation: "bottom left",
        }).on('changeDate', function(e) {
            app.$data.date = e.format(0, 'yyyy-mm-dd');
        });

        $('.po-date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: true,
            clearBtn: true,
            orientation: "bottom left",
        }).on('changeDate', function(e) {
            app.$data.poDate = e.format(0, 'yyyy-mm-dd');
        });
    })
</script>
@endsection