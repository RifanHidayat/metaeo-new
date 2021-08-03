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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Add Quotation</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Quotation</a>
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
                <h3 class="card-title">Quotation Form</h3>
            </div>
            <!--begin::Form-->
            <form class="form" autocomplete="off" @submit.prevent="submitForm">
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>No Quotation:<span class="text-danger">*</span></label>
                            <input v-model="number" type="text" class="form-control form-control-sm" required readonly>
                        </div>
                        <div class="col-lg-6">
                            <label>Tanggal Quotation:<span class="text-danger">*</span></label>
                            <input v-model="date" type="text" class="form-control form-control-sm quotation-date" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>UP:<span class="text-danger">*</span></label>
                            <!-- <input type="text" class="form-control form-control-sm" :value="up" readonly required> -->
                            <select v-model="up" class="form-control form-control-sm">
                                <option v-for="(up, index) in ups" :value="up.id">@{{ up.name }}</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label>Title:<span class="text-danger">*</span></label>
                            <input v-model="title" type="text" class="form-control form-control-sm" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>Item Description:</label>
                            <textarea v-model="description" id="item-description" class="form-control form-control-sm"></textarea>
                        </div>
                        <div class="col-lg-6">
                            <label>Note:</label>
                            <textarea v-model="note" id="note" class="form-control form-control-sm"></textarea>
                        </div>
                    </div>
                    <!-- begin::Estimations List -->
                    <div class="card card-custom card-border">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">
                                    Pilih Estimasi
                                </h3>
                            </div>
                            <div class="card-toolbar">
                                <a href="#" class="btn btn-light-success" data-toggle="modal" data-target="#estimationModal">
                                    <i class="flaticon2-add-1"></i> Tambah
                                </a>
                            </div>
                            <!-- <div class="card-toolbar">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Cari Estimasi" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2"><i class="flaticon2-magnifier-tool"></i></span>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="card-body">
                            <div v-if="selectedEstimations.length < 1" class="text-center">
                                <i class="flaticon2-open-box icon-4x"></i>
                                <p class="text-muted">Belum ada estimasi terpilih</p>
                            </div>
                            <div>
                                <selected-estimation v-for="(estimation, index) in selectedEstimations" :key="estimation.id" :estimation="estimation" :ondelete="unselectEstimation" :index="index">
                                </selected-estimation>
                            </div>
                        </div>
                    </div>
                    <!-- end::Estimations List -->
                    <div class="card card-custom card-border mt-5">
                        <div class="card-body">
                            <div class="d-flex align-items-center flex-wrap">
                                <!--begin: Item-->
                                <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                                    <span class="mr-4">
                                        <i class="flaticon2-layers-1 icon-2x text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-75">
                                        <span class="font-weight-bolder font-size-sm">Quantity</span>
                                        <span class="font-weight-bolder font-size-h5">
                                            @{{ totalQuantity }}
                                            <span class="text-dark-50 font-weight-bold">Pcs</span></span>
                                    </div>
                                </div>
                                <!--end: Item-->
                                <!--begin: Item-->
                                <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                                    <span class="mr-4">
                                        <i class="flaticon2-cube icon-2x text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-75">
                                        <span class="font-weight-bolder font-size-sm">Unit Price</span>
                                        <span class="font-weight-bolder font-size-h5">
                                            <span class="text-dark-50 font-weight-bold">Rp</span> @{{ totalUnitPrice }}</span>
                                    </div>
                                </div>
                                <!--end: Item-->
                                <!--begin: Item-->
                                <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                                    <span class="mr-4">
                                        <i class="flaticon2-cube-1 icon-2x text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-75">
                                        <span class="font-weight-bolder font-size-sm">Amount</span>
                                        <span class="font-weight-bolder font-size-h5">
                                            <span class="text-dark-50 font-weight-bold">Rp</span> @{{ amount }}</span>
                                    </div>
                                </div>
                                <!--end: Item-->
                                <!--begin: Item-->
                                <!-- <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                                    <span class="mr-4">
                                        <i class="flaticon2-graph-1 icon-2x text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-75">
                                        <span class="font-weight-bolder font-size-sm">Netto</span>
                                        <span class="font-weight-bolder font-size-h5">
                                            <span class="text-dark-50 font-weight-bold">Rp</span> @{{ totalNetto }}</span>
                                    </div>
                                </div> -->
                                <!--end: Item-->
                                <!--begin: Item-->
                                <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                                    <span class="mr-4">
                                        <i class="flaticon2-file-1 icon-2x text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-75">
                                        <span class="font-weight-bolder font-size-sm">PPN</span>
                                        <span class="font-weight-bolder font-size-h5">
                                            <span class="text-dark-50 font-weight-bold">Rp</span> @{{ totalPpn }}</span>
                                    </div>
                                </div>
                                <!--end: Item-->
                                <!--begin: Item-->
                                <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                                    <span class="mr-4">
                                        <i class="flaticon2-file-1 icon-2x text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-75">
                                        <span class="font-weight-bolder font-size-sm">PPH</span>
                                        <span class="font-weight-bolder font-size-h5">
                                            <span class="text-dark-50 font-weight-bold">Rp</span> @{{ totalPph }}</span>
                                    </div>
                                </div>
                                <!--end: Item-->
                                <!--begin: Item-->
                                <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                                    <span class="mr-4">
                                        <i class="flaticon2-tag icon-2x text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-75">
                                        <span class="font-weight-bolder font-size-sm">Total</span>
                                        <span class="font-weight-bolder font-size-h5">
                                            <span class="text-dark-50 font-weight-bold">Rp</span> @{{ totalBill }}</span>
                                    </div>
                                </div>
                                <!--end: Item-->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-6">

                        </div>
                        <div class="col-lg-6 text-lg-right">
                            <button type="submit" class="btn btn-primary" :class="loading && 'spinner spinner-white spinner-right'" :disabled="loading || selectedEstimations.length < 1"">
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

    <!-- Modal-->
    <div class="modal fade" id="estimationModal" tabindex="-1" role="dialog" aria-labelledby="estimationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="estimationModalLabel">Pilih Estimasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <select v-model="customer" class="form-control" id="customer">
                            <option value="">Pilih Customer</option>
                            @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <table class="table" id="estimation-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal Estimasi</th>
                                <th>Pekerjaan</th>
                                <th>Customer</th>
                                <th>Status</th>
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
</div>
@endsection

@section('script')
<script src="{{ asset('js/pages/features/miscellaneous/sweetalert2.js') }}"></script>
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js?v=7.2.8') }}"></script>
<script src="{{ asset('plugins/custom/tinymce/tinymce.bundle.js?v=7.2.8') }}"></script>
<!-- <script src="{{ asset('js/pages/crud/forms/editors/quill.js?v=7.2.8') }}"></script> -->
@endsection

@section('pagescript')
<script>
    const itemDescriptionEditor = tinymce.init({
        selector: '#item-description',
        setup: function(editor) {
            editor.on('init', function(e) {
                editor.setContent(`{!! $quotation->description !!}`);
            });
        }
        // max_height: 100,
    });

    const noteEditor = tinymce.init({
        selector: '#note',
        setup: function(editor) {
            editor.on('init', function(e) {
                editor.setContent(`{!! $quotation->note !!}`);
            });
        }
        // max_height: 100,
    });


    Vue.component('selected-estimation', {
        props: ['estimation', 'ondelete', 'index'],
        template: `
        <div class="card card-custom gutter-b card-stretch card-border ribbon ribbon-top">
            <div :class="'ribbon-target bg-' + status(estimation.status) + ' text-capitalize'" style="top: -2px; left: 20px;">@{{ estimation.status }}</div>
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
                        <a href="#" class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-0">@{{ estimation.number }} - @{{ estimation.work }}</a>
                        <span class="text-muted font-weight-bold">PT Kalbe Farma | @{{ estimation.date }}</span>
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
                        <a href="#" class="text-muted text-hover-primary">@{{ Intl.NumberFormat('de-DE').format(estimation.quantity) }}</a>
                    </div>
                    <div class="d-flex justify-content-between align-items-cente my-1">
                        <span class="text-dark-75 font-weight-bolder mr-2">Unit Price:</span>
                        <a href="#" class="text-muted text-hover-primary">Rp @{{ Intl.NumberFormat('de-DE').format(estimation.price_per_unit) }}</a>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-dark-75 font-weight-bolder mr-2">Jumlah:</span>
                        <span class="text-muted font-weight-bold">Rp @{{ Intl.NumberFormat('de-DE').format(estimation.total_bill) }}</span>
                    </div>
                </div>
                <!--end::Info-->

            </div>
            <!--end::Body-->
        </div>
        `,
        methods: {
            status: function(status) {
                switch (status) {
                    case 'open':
                        return 'warning';
                        break;
                    case 'closed':
                        return 'success';
                        break;
                    case 'rejected':
                        return 'danger';
                        break;
                    case 'final':
                        return 'primary';
                        break;
                    default:
                        return 'light';
                }
            }
        }
    })

    let app = new Vue({
        el: '#app',
        data: {
            number: '{{ $quotation->number }}',
            up: '{{ $quotation->picPo->id }}',
            customer: '{{ $quotation->customer_id }}',
            date: '{{ $quotation->date }}',
            title: '{{ $quotation->title }}',
            note: '',
            description: '',
            selectedEstimations: JSON.parse('{!! $quotation->estimations !!}'),
            // ups: [],
            loading: false,
        },
        methods: {
            onClick: function() {
                console.log('asdasd');
            },
            submitForm: function() {
                this.sendData();
            },
            sendData: function() {
                // console.log('submitted');
                let itemDescription = '';
                let note = '';
                if (tinymce !== null) {
                    itemDescription = tinymce.get("item-description").getContent();
                    note = tinymce.get("note").getContent();
                }

                // console.log(itemDescription, note);

                // return;

                let vm = this;
                vm.loading = true;

                const data = {
                    number: vm.number,
                    up: vm.up,
                    date: vm.date,
                    customer_id: vm.customer,
                    title: vm.title,
                    note: note,
                    description: itemDescription,
                    quantity: vm.totalQuantity,
                    price_per_unit: vm.totalUnitPrice,
                    ppn: vm.totalPpn,
                    pph: vm.totalPph,
                    total_bill: vm.totalBill,
                    selected_estimations: vm.selectedEstimations.map(estimation => estimation.id),
                    // .map(estimation => {
                    //     delete estimation.action;
                    //     delete estimation.DT_RowIndex;
                    //     return estimation;
                    // }),
                }

                axios.patch('/quotation/{{ $quotation->id }}', data)
                    .then(function(response) {
                        vm.loading = false;
                        Swal.fire({
                            title: 'Success',
                            text: 'Data has been saved',
                            icon: 'success',
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // window.location.href = '/quotation';
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
            unselectEstimation: function(index) {
                this.selectedEstimations.splice(index, 1);
            },
            totalEstimation: function(object) {
                if (this.selectedEstimations.length == 1) {
                    return Intl.NumberFormat('de-DE').format(object);
                }

                return 0;
            },
        },
        computed: {
            totalQuantity: function() {
                const totalQuantity = this.selectedEstimations
                    .map(estimation => Number(estimation.quantity))
                    .reduce((acc, cur) => {
                        return acc + cur;
                    }, 0);

                return totalQuantity;
            },
            totalUnitPrice: function() {
                const totalUnitPrice = this.selectedEstimations
                    .map(estimation => Number(estimation.price_per_unit))
                    .reduce((acc, cur) => {
                        return acc + cur;
                    }, 0);

                return totalUnitPrice;
            },
            amount: function() {
                const amount = this.totalQuantity * this.totalUnitPrice;
                return amount;
            },
            totalNetto: function() {
                return this.totalEstimation(this.selectedEstimations[0]?.production);
            },
            totalPpn: function() {
                return this.totalEstimation(this.selectedEstimations[0]?.ppn);
            },
            totalPph: function() {
                return this.totalEstimation(this.selectedEstimations[0]?.pph);
            },
            totalBill: function() {
                return this.totalEstimation(this.selectedEstimations[0]?.total_bill);
            },
            ups: function() {
                if (this.selectedEstimations.length < 1) {
                    return [];
                }
                return this.selectedEstimations.filter(estimation => estimation.pic_po !== null).map(estimation => estimation.pic_po);
            },
        }
    })
</script>
<script>
    $(function() {
        let estimationsTable = null;

        $('#customer').select2();

        const customer_id = app.$data.customer;

        if (customer_id !== "" || customer_id !== null) {
            estimationsTable = $('#estimation-table').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                // pageLength: 2,
                ajax: {
                    url: '/datatables/quotations/estimations?customer_id=' + customer_id,
                    type: 'GET',
                    // length: 2,
                },
                columns: [{
                        data: 'number',
                        render: function(data, type) {
                            return `<a href="#" @click.prevent="onClick">${data}</a>`;
                        }
                    },
                    {
                        data: 'date'
                    },
                    {
                        data: 'work',
                    },
                    {
                        data: 'pic_po_id',
                    },
                    {
                        data: 'status',
                        render: function(data, type) {
                            const label = function(text, type) {
                                return `<span class="label label-${type} label-pill label-inline text-capitalized">${text}</span>`;
                            }

                            switch (data) {
                                case 'open':
                                    return label(data, 'warning');
                                    break;
                                case 'closed':
                                    return label(data, 'success');
                                    break;
                                case 'rejected':
                                    return label(data, 'danger');
                                    break;
                                case 'final':
                                    return label(data, 'primart');
                                    break;
                                default:
                                    return label('unknown', 'light');
                            }
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
        }

        $('#customer').on('change', function(e) {
            const customer = $(this).val();
            app.$data.customer = customer;
            estimationsTable = $('#estimation-table').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                // pageLength: 2,
                ajax: {
                    url: '/datatables/quotations/estimations?customer_id=' + customer,
                    type: 'GET',
                    // length: 2,
                },
                columns: [{
                        data: 'number',
                        render: function(data, type) {
                            return `<a href="#" @click.prevent="onClick">${data}</a>`;
                        }
                    },
                    {
                        data: 'date'
                    },
                    {
                        data: 'work',
                    },
                    {
                        data: 'pic_po_id',
                    },
                    {
                        data: 'status',
                        render: function(data, type) {
                            const label = function(text, type) {
                                return `<span class="label label-${type} label-pill label-inline text-capitalized">${text}</span>`;
                            }

                            switch (data) {
                                case 'open':
                                    return label(data, 'warning');
                                    break;
                                case 'closed':
                                    return label(data, 'success');
                                    break;
                                case 'rejected':
                                    return label(data, 'danger');
                                    break;
                                case 'final':
                                    return label(data, 'primart');
                                    break;
                                default:
                                    return label('unknown', 'light');
                            }
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
        })

        $('#estimation-table tbody').on('click', '.btn-choose', function() {
            const data = estimationsTable.row($(this).parents('tr')).data();
            // delete data['DT_RowIndex'];
            // delete data['action'];

            const selectedEstimations = app.$data.selectedEstimations;
            const ups = app.$data.ups;

            const selectedEstimationsIds = app.$data.selectedEstimations.map(estimation => estimation.id);
            // const upsIds = ups.map(up => up.id);

            if (selectedEstimationsIds.indexOf(data.id) < 0) {
                selectedEstimations.push(data);
            }

            // if (data.pic_po !== null) {
            //     if (upsIds.indexOf(data.pic_po.id) < 0) {
            //         ups.push(data.pic_po);
            //     }
            // }

            $('#estimationModal').modal('hide');

            // $(this).prop('disabled', true);
            // $(this).html('<i class="flaticon2-check-mark"></i> Terpilih');

        });

        $('.quotation-date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: true,
            clearBtn: true,
            orientation: "bottom left",
        }).on('changeDate', function(e) {
            app.$data.date = e.format(0, 'yyyy-mm-dd');
        });
    })
</script>
@endsection