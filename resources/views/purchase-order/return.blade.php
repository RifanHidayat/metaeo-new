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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Tambah Retur</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Retur</a>
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
                <h3 class="card-title">Form Retur</h3>

            </div>
            <!--begin::Form-->
            <form class="form" autocomplete="off" @submit.prevent="submitForm">
                <div class="card-body">
                    <div class="row justify-content-between">
                        <div class="col-lg-6 col-md-12">
                            <!-- <div class="form-group">
                                <label>Supplier:</label>
                                <select v-model="supplier" class="form-control" id="supplier-select">
                                    <option value="">Pilih Pengiriman</option>
                                    <option v-for="(supplier, index) in suppliers" :value="supplier.id">@{{ supplier.name }}</option>
                                </select>
                            </div> -->
                            <div class="form-group">
                                <label>Tanggal:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="flaticon2-calendar-9"></i></span>
                                    </div>
                                    <input type="text" v-model="date" id="po-date" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="form-group">
                                <label>Nomor:</label>
                                <!-- <input type="text" class="form-control"> -->
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">#</span>
                                    </div>
                                    <input type="text" v-model="number" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>Tanggal:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="flaticon2-calendar-9"></i></span>
                                    </div>
                                    <input type="text" v-model="date" id="po-date" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="mt-5">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="goods-tab" data-toggle="tab" href="#goods">
                                    <span class="nav-icon">
                                        <i class="flaticon-signs-1"></i>
                                    </span>
                                    <span class="nav-text">List Barang</span>
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
                                    <!-- <div class="my-3 text-right">
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#goodsModal"><i class="flaticon2-plus"></i> Tambah</button>
                                    </div> -->
                                    <div class="my-3 bg-light rounded p-5">
                                        <a data-toggle="collapse" href="#collapsePOInfo" role="button" aria-expanded="false" aria-controls="collapsePOInfo" class="d-block text-dark-50">
                                            <div class="row justify-content-between">
                                                <div class="col-sm-6">
                                                    <strong class="d-block"><i class="flaticon2-information align-middle text-success"></i>&nbsp;Informasi Pesanan Pembelian</strong>
                                                </div>
                                                <div class="col-sm-6 text-right">
                                                    <i class="flaticon2-down"></i>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="collapse" id="collapsePOInfo">
                                            <div class="row pt-3">
                                                <div class="col-lg-6 col-md-12">
                                                    <table class="table">
                                                        <tr>
                                                            <td>Nomor</td>
                                                            <td><strong>{{ $purchase_order->number }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tanggal</td>
                                                            <td><strong>{{ \Carbon\Carbon::parse($purchase_order->date)->isoFormat('LL') }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Supplier</td>
                                                            <td><strong>{{ $purchase_order->supplier !== null ? $purchase_order->supplier->name : '' }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Alamat Kirim</td>
                                                            <td><strong>{{ $purchase_order->delivery_address }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tanggal Pengiriman</td>
                                                            <td><strong>{{ \Carbon\Carbon::parse($purchase_order->deliveryDate)->isoFormat('LL') }}</strong></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <table class="table">
                                                        <tr>
                                                            <td>Pengiriman</td>
                                                            <td><strong>{{ $purchase_order->shipment !== null ? $purchase_order->shipment->name : '' }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Syarat Pembayaran</td>
                                                            <td><strong>{{ $purchase_order->payment_term }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>FOB</td>
                                                            <td><strong>{{ $purchase_order->fobItem !== null ? $purchase_order->fobItem->name : '' }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Keterangan</td>
                                                            <td><strong>{{ $purchase_order->description }}</strong></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Nama Barang</th>
                                                <th>Kode #</th>
                                                <th>Satuan</th>
                                                <th>Diterima</th>
                                                <th>Diretur</th>
                                                <th>Kuantitas</th>
                                                <th>Alasan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-if="!selectedGoods.length">
                                                <td colspan="8">
                                                    <p class="text-center">
                                                        <i class="flaticon2-open-box font-size-h1"></i>
                                                    </p>
                                                    <p class="text-center">Tidak ada barang</p>
                                                </td>
                                            </tr>
                                            <tr v-for="(good, index) in selectedGoods">
                                                <td class="text-center align-middle">
                                                    <label class="checkbox justify-content-center">
                                                        <input type="checkbox" v-model="checkedGoodsIds" :value="good.id">
                                                        <span></span>
                                                    </label>
                                                </td>
                                                <td style="vertical-align: middle;">@{{ good.name }}</td>
                                                <td style="vertical-align: middle;">@{{ good.number }}</td>
                                                <td style="vertical-align: middle;">@{{ good.unit }}</td>
                                                <td style="vertical-align: middle;" class="text-center">@{{ good.received_quantity }}</td>
                                                <td style="vertical-align: middle;" class="text-center">@{{ good.returned_quantity }}</td>
                                                <td><input type="text" v-model="good.return_quantity" class="form-control form-control-sm text-right"></td>
                                                <td class="align-middle">
                                                    <select class="form-control form-control-sm" v-model="good.cause">
                                                        <option value="defective">Cacat / Rusak</option>
                                                        <option value="wrong">Tidak Sesuai</option>
                                                    </select>
                                                </td>
                                                <!-- <td style="vertical-align: middle;" class="text-center">
                                                    <a href="#" @click.prevent="removeGoods(index)"><i class="flaticon2-trash text-danger"></i></a>
                                                </td> -->
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="mt-20">
                                        <div class="row justify-content-end">
                                            <div class="col-lg-3">
                                                <div class="border">
                                                    <div class="bg-primary w-100" style="height: 5px;"></div>
                                                    <div class="p-3">
                                                        <strong>Total Diretur</strong>
                                                        <p class="text-right font-size-h4">@{{ toCurrencyFormat(totalReturnedQuantity) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-lg-3">
                                                <div class="border">
                                                    <div class="bg-danger w-100" style="height: 5px;"></div>
                                                    <div class="p-3">
                                                        <h4>Diskon <a data-toggle="collapse" href=".collapseDiscount" role="button" aria-expanded="false" aria-controls="collapseDiscount"><i class="flaticon-edit text-primary"></i></a></h4>
                                                        <div class="collapse show collapseDiscount">
                                                            <p class="text-right font-size-h4">Rp @{{ toCurrencyFormat(discount) }}</p>
                                                        </div>
                                                        <div class="collapse collapseDiscount">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">Rp</span>
                                                                </div>
                                                                <input type="text" v-model="discount" class="form-control form-control text-right">
                                                                <div class="input-group-append">
                                                                    <button type="button" class="btn btn-success" data-toggle="collapse" data-target=".collapseDiscount" aria-expanded="false" aria-controls="collapseDiscount"><i class="fas fa-save"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <div class="col-lg-3">
                                                <div class="border">
                                                    <div class="bg-success w-100" style="height: 5px;"></div>
                                                    <div class="p-3">
                                                        <strong>Total Akan Diretur</strong>
                                                        <p class="text-right font-size-h4">@{{ toCurrencyFormat(totalWillBeReturned) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="other" role="tabpanel" aria-labelledby="other-tab">
                                <div class="pt-5 pb-3">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <!-- <div class="form-group">
                                                <label>Pengirim:</label>
                                                <input type="text" v-model="shipper" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Penerima:</label>
                                                <input type="text" v-model="recipient" class="form-control">
                                            </div> -->
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
            suppliers: [],
            goods: [],
            shipments: [],
            fobItems: [],
            supplier: '',
            number: '',
            date: '',
            shipper: '',
            recipient: '',
            deliveryAddress: '',
            deliveryDate: '',
            shipment: '',
            paymentTerm: 'net_7',
            fob: '',
            description: '',
            selectedGoods: JSON.parse(String.raw `{!! json_encode($selected_goods) !!}`),
            checkedGoodsIds: [],
            discount: 0,
            purchaseOrderId: '{{ $purchase_order->id }}',
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
                axios.post('/purchase-return', {

                        // supplier_id: vm.supplier,
                        purchase_order_id: vm.purchaseOrderId,
                        number: vm.number,
                        date: vm.date,
                        // delivery_address: vm.deliveryAddress,
                        // delivery_date: vm.deliveryDate,
                        // shipper: vm.shipper,
                        // recipient: vm.recipient,
                        // shipment_id: vm.shipment,
                        // payment_term: vm.paymentTerm,
                        // fob_item_id: vm.fob,
                        description: vm.description,
                        selected_goods: vm.checkedGoods,
                        // discount: vm.discount,
                        // subtotal: vm.subtotal,
                        // total: vm.grandTotal,
                    })
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
            selectGoods: function(item) {
                let vm = this;
                const newGoods = {
                    ...item,
                    quantity: 1,
                    price: item.purchase_price,
                    discount: 0,
                    total: item.purchase_price,
                }
                vm.selectedGoods.push(newGoods);
                $('#goodsModal').modal('hide');
            },
            removeGoods: function(index) {
                let vm = this;
                vm.selectedGoods.splice(index, 1);
            },
            toCurrencyFormat: function(number) {
                return new Intl.NumberFormat('De-de').format(number);
            }
        },
        computed: {
            // subtotal: function() {
            //     const subtotal = this.selectedGoods.map(goods => Number(goods.total)).reduce((acc, cur) => {
            //         return acc + cur;
            //     }, 0);

            //     return subtotal;
            // },
            // grandTotal: function() {
            //     const grandTotal = this.subtotal - Number(this.discount);
            //     return grandTotal;
            // }
            checkedGoods: function() {
                return this.selectedGoods.filter(goods => this.checkedGoodsIds.indexOf(goods.id) > -1);
            },
            totalReturnedQuantity: function() {
                const returnedQuantity = this.selectedGoods.map(goods => Number(goods.returned_quantity)).reduce((acc, cur) => {
                    return acc + cur;
                }, 0);

                return returnedQuantity;
            },
            totalWillBeReturned: function() {
                const total = this.checkedGoods.map(goods => Number(goods.return_quantity)).reduce((acc, cur) => {
                    return acc + cur;
                }, 0);

                return total;
            }
        },
        watch: {
            selectedGoods: {
                handler: function(newval, oldval) {
                    this.selectedGoods.forEach(goods => {
                        goods.total = (Number(goods.price) * Number(goods.quantity)) - Number(goods.discount);
                    });
                },
                deep: true
            }
        }
    })
</script>
<script>
    $(function() {
        $('#table-goods').DataTable();

        function hideElement(el) {
            $(el).hide();
        }

        function showElement(el) {
            $(el).show();
        }

        $("#shipment-select").select2({
            width: '100%',
            language: {
                noResults: function() {
                    const searchText = $("#shipment-select").data("select2").dropdown.$search.val();
                    if (!searchText) {
                        return "No Result Found";
                    }
                    return `
                        <a href="#" class="d-block" id="btn-add-shipment"><i class="fas fa-plus fa-sm"></i> Tambah ${searchText} </a>
                        <div class="progress mt-2" id="loadingShipment" style="display: none">
                            <div class="progress-bar bg-primary w-100 progress-bar-striped progress-bar-animated" data-progress="100"></div>
                        </div>
                        `;
                },
            },
            escapeMarkup: function(markup) {
                return markup;
            },
        });
        $("#shipment-select").on('change', function() {
            console.log('clicked');
            app.$data.shipment = $(this).val();
            // console.log(searchText);
        });

        $(document).on('click', '#btn-add-shipment', function(e) {
            e.preventDefault();
            const searchText = $("#shipment-select").data("select2").dropdown.$search.val();
            const data = {
                name: searchText,
                status: 1,
            }

            addShipment(data);
            // console.log('clicked');
        })

        function addShipment(data) {
            showElement('#loadingShipment');
            axios.post('/shipment', data)
                .then(function(response) {
                    const {
                        data
                    } = response.data;
                    app.$data.shipments.push(data);
                    app.$data.shipment = data.id;
                    $('#shipment-select').val(data.id);
                    $('#shipment-select').select2('close');
                    hideElement('#loadingShipment');
                })
                .catch(function(error) {
                    // vm.loading = false;
                    $('#shipment-select').select2('close');
                    hideElement('#loadingShipment');
                    console.log(error);
                    Swal.fire(
                        'Terjadi Kesalahan',
                        'Gagal menambahkan pengiriman',
                        'error'
                    )
                });
        }

        function formatState(state) {
            if (!state.id) {
                return state.text;
            }

            let desc = state.element.getAttribute('data-desc');
            if (!desc) {
                desc = '';
            }

            var $state = $(
                // '<span><img src="' + baseUrl + '/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span>'
                '<div>' +
                '<span class="d-block"><strong>' + state.text + '</strong></span>' + '<small>' + desc + '</small>' +
                '</div>'


            );
            return $state;
        };

        $("#payment-term-select").select2({
            width: '100%',
            templateResult: formatState
        });

        $("#payment-term-select").on('change', function() {
            console.log('clicked');
            app.$data.paymentTerm = $(this).val();
            // console.log(searchText);
        });

        $("#fob-item-select").select2({
            width: '100%',
            language: {
                noResults: function() {
                    const searchText = $("#fob-item-select").data("select2").dropdown.$search.val();
                    if (!searchText) {
                        return "No Result Found";
                    }
                    return `
                        <a href="#" class="d-block" id="btn-add-fob-item"><i class="fas fa-plus fa-sm"></i> Tambah ${searchText} </a>
                        <div class="progress mt-2" id="loadingFobItem" style="display: none">
                            <div class="progress-bar bg-primary w-100 progress-bar-striped progress-bar-animated" data-progress="100"></div>
                        </div>
                        `;
                },
            },
            escapeMarkup: function(markup) {
                return markup;
            },
        });

        $("#fob-item-select").on('change', function() {
            console.log('clicked');
            app.$data.fob = $(this).val();
            // console.log(searchText);
        });

        $(document).on('click', '#btn-add-fob-item', function(e) {
            e.preventDefault();
            const searchText = $("#fob-item-select").data("select2").dropdown.$search.val();
            const data = {
                name: searchText,
                status: 1,
            }

            addFobItem(data);
            // console.log('clicked');
        })

        function addFobItem(data) {
            showElement('#loadingFobItem');
            axios.post('/fob-item', data)
                .then(function(response) {
                    const {
                        data
                    } = response.data;
                    app.$data.fobItems.push(data);
                    app.$data.fob = data.id;
                    $('#fob-item-select').val(data.id);
                    $('#fob-item-select').select2('close');
                    hideElement('#loadingFobItem');
                })
                .catch(function(error) {
                    // vm.loading = false;
                    $('#fob-item-select').select2('close');
                    hideElement('#loadingFobItem');
                    console.log(error);
                    Swal.fire(
                        'Terjadi Kesalahan',
                        'Gagal menambahkan FOB',
                        'error'
                    )
                });
        }

        $("#supplier-select").select2({
            width: '100%',
            language: {
                noResults: function() {
                    const searchText = $("#supplier-select").data("select2").dropdown.$search.val();
                    if (!searchText) {
                        return "No Result Found";
                    }
                    return `
                        <a href="#" class="d-block" id="btn-add-supplier"><i class="fas fa-plus fa-sm"></i> Tambah ${searchText} </a>
                        <div class="progress mt-2" id="loadingSupplier" style="display: none">
                            <div class="progress-bar bg-primary w-100 progress-bar-striped progress-bar-animated" data-progress="100"></div>
                        </div>
                        `;
                },
            },
            escapeMarkup: function(markup) {
                return markup;
            },
        });

        $("#supplier-select").on('change', function() {
            console.log('clicked');
            app.$data.supplier = $(this).val();
            // console.log(searchText);
        });

        $(document).on('click', '#btn-add-supplier', function(e) {
            e.preventDefault();
            const searchText = $("#supplier-select").data("select2").dropdown.$search.val();
            const data = {
                name: searchText,
                status: 1,
            }

            addSupplier(data);
            // console.log('clicked');
        })

        function addSupplier(data) {
            showElement('#loadingSupplier');
            axios.post('/supplier', data)
                .then(function(response) {
                    const {
                        data
                    } = response.data;
                    app.$data.suppliers.push(data);
                    app.$data.supplier = data.id;
                    $('#supplier-select').val(data.id);
                    $('#supplier-select').select2('close');
                    hideElement('#loadingSupplier');
                })
                .catch(function(error) {
                    // vm.loading = false;
                    $('#supplier-select').select2('close');
                    hideElement('#loadingSupplier');
                    console.log(error);
                    Swal.fire(
                        'Terjadi Kesalahan',
                        'Gagal menambahkan Supplier',
                        'error'
                    )
                });
        }

        $('#po-date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: false,
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
        }).on('changeDate', function(e) {
            app.$data.date = e.format(0, 'yyyy-mm-dd');
        });

        $('#delivery-date').datepicker({
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