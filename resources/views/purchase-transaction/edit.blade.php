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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Tambah Pembayaran</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Pembayaran</a>
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
                <h3 class="card-title">Form Pembayaran</h3>

            </div>
            <!--begin::Form-->
            <form class="form" autocomplete="off" @submit.prevent="submitForm">
                <div class="card-body">
                    <div class="row justify-content-between">
                        <div class="col-lg-6 col-md-12">
                                 <div class="form-group col-lg-8">
                         <label>Tanggal:</label>
                                   <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="flaticon2-calendar-9"></i></span>
                                    </div>
                                    <input type="text" v-model="date" id="po-date" class="form-control">
                                </div>
                            <!-- <span class="form-text text-muted">Please enter supplier's name</span> -->
                        </div> 
                            <div class="form-group col-lg-8">
                         <label>Supplier:</label>
                                <select v-model="supplier" class="form-control" id="supplier-select">
                                    <option value="">Pilih Supplier</option>
                                    <option v-for="(supplier, index) in suppliers" :value="supplier.id">@{{ supplier.name }}  </option>
                                </select>
                            <!-- <span class="form-text text-muted">Please enter supplier's name</span> -->
                        </div> 
                        
                    

                         <div class="form-group col-lg-8">
                         <label>Pembayaran:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" v-model="paymentAmount" class="form-control text-right" @input="validateAmount">
                                </div>
                                <span class="text-danger">Pembayaran : @{{ toCurrencyFormat(subtotal )}}</span>
                            <!-- <span class="form-text text-muted">Please enter supplier's name</span> -->
                        </div> 
                            <!-- <div class="form-group">
                                <label>Supplier:</label>
                                <select v-model="supplier" class="form-control" id="supplier-select" :disabled="selectedPurchaseOrders.length > 0">
                                    <option value="">Pilih Supplier</option>
                                    <option v-for="(supplier, index) in suppliers" :value="supplier.id">@{{ supplier.name }}</option>
                                </select>
                                <em v-if="selectedPurchaseOrders.length > 0" class="text-muted">Kosongkan list pembelian untuk mengganti supplier</em>
                            </div> -->
                        </div>
                        <!-- <div class="col-lg-4 col-md-12">
                            <div class="form-group">
                                <label>Nomor:</label>
                                
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">#</span>
                                    </div>
                                    <input type="text" v-model="number" class="form-control">
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class="row">
                    
                    </div>
                    <div class="mt-5">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="goods-tab" data-toggle="tab" href="#goods">
                                    <span class="nav-icon">
                                        <i class="flaticon-signs-1"></i>
                                    </span>
                                    <span class="nav-text">List Pembelian</span>
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
                                        <!-- <button type="button" class="btn btn-success" data-toggle="modal" data-target="#POModal"><i class="flaticon2-plus"></i> Tambah</button> -->
                                    </div>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                             <td></td>
                                                <td>Tgl Invoice</td>
                                                <td>No. invoice</td>
                                                <td>Kuantitas</td>
                                                 <!-- <td>discount</td> -->
                                                 <td>Harga</td>
                                               
                                                
                                                 <td>Pembayaran</td>
                                                <td>Sisa Bayar</td>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-if="!selectedPurchaseOrders.length">
                                                <td colspan="8">
                                                    <p class="text-center">
                                                        <i class="flaticon2-open-box font-size-h1"></i>
                                                    </p>
                                                    <p class="text-center">Belum ada penerimaan</p>
                                                </td>
                                            </tr>
                                            <tr v-for="(po, index) in selectedPurchaseOrders">
                                                   <td class="text-center align-middle">
                                                    <label class="checkbox justify-content-center">
                                                        <input type="checkbox" v-model="po.is_checked">
                                                        <span></span>
                                                    </label>
                                                </td>
                                                <td class="align-middle">@{{po.invoice_number}}</td>
                                                <td class="align-middle">
                                                    @{{po.invoice_date}}
                                                </td>
                                                <td class="align-middle text-right">
                                                     @{{po.quantity}}
                                                </td>
                                                
                                                <!-- <td class="align-middle text-right">
                                                      @{{po.discount}}
                                                </td> -->
                                                <td class="align-middle text-right">
                                                        @{{Number(po.total)}}

                                                </td>
                                                
                                                <td class="align-middle text-right">
                                                      @{{po.payment}}
                                                </td>
                                                <td class="align-middle text-right">
                                                      @{{Number(po.total) - Number(po.payment)}}
                                                </td>
                                               
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="mt-20">
                                        <div class="row justify-content-end">
                                            <div class="col-lg-3">
                                                <div class="border">
                                                    <div class="bg-primary w-100" style="height: 5px;"></div>
                                                    <div class="p-3">
                                                        <strong>Total Pembayaran</strong>
                                                        <p class="text-right font-size-h4">Rp @{{ toCurrencyFormat(subtotal) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="border">
                                                    <div class="bg-danger w-100" style="height: 5px;"></div>
                                                    <div class="p-3">
                                                        <strong>Total Hutang</strong>
                                                        <p class="text-right font-size-h4">Rp @{{ toCurrencyFormat(remainingPayments) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-lg-3">
                                                <div class="border">
                                                    <div class="bg-success w-100" style="height: 5px;"></div>
                                                    <div class="p-3">
                                                        <strong>Sisa Bayar</strong>
                                                        <p class="text-right font-size-h4">Rp @{{ toCurrencyFormat(grandTotal) }}</p>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="other" role="tabpanel" aria-labelledby="other-tab">
                                <div class="pt-5 pb-3">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
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
    <div class="modal fade" id="POModal" tabindex="-1" aria-labelledby="POModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="POModalLabel">Pilih Pesanan Pembelian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table" id="table-po" ref="POTable">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th></th>
                                <!-- <th></th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(po, index) in purchaseOrders">
                                <td>@{{ po.number }}</td>
                                <td class="text-right">
                                    <button v-if="!isSelectedPO(po.id)" type="button" href="#" @click.prevent="selectPurchaseOrder(po)" class="btn btn-primary btn-sm" :class="isSelectedPO(po.id) ? 'disabled' : ''">Pilih</button>
                                    <span v-if="isSelectedPO(po.id)" class="label label-outline-warning label-pill label-inline mr-2">Selected</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
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
            suppliers: JSON.parse(String.raw `{!! $suppliers !!}`),
            supplier: '{{$transaction->supplier_id}}',
            number: '',
            date: '{{$transaction->date}}',
            paymentAmount: '{{$transaction->total}}',
            description: '',
            loading: false,
            purchaseOrders: [],
            selectedPurchaseOrders: JSON.parse(String.raw`{!!$selected_purchase_orders!!}`),
            dataTable: null,
            id:'{!!  $transaction->id !!}'
        },
        mounted() {
            this.dataTable = $(this.$refs.POTable).DataTable();
        },
        methods: {
            submitForm: function() {
                this.sendData();
            },
            sendData: function() {
                // console.log('submitted');
                let vm = this;
                vm.loading = true;
                axios.patch('/purchase-transaction/'+this.id, {
                        supplier_id: vm.supplier,
                        number: vm.number,
                        date: vm.date,
                        payment_amount: vm.paymentAmount,
                        description: vm.description,
                        total: 0,
                        selected_purchase_orders: vm.selectedPurchaseOrders,
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
            selectPurchaseOrder: function(item) {
                let vm = this;
                const newPO = {
                    ...item,
                }
                vm.selectedPurchaseOrders.push(newPO);
                $('#POModal').modal('hide');
            },
            removePurchaseOrder: function(index) {
                let vm = this;
                vm.selectedPurchaseOrders.splice(index, 1);
            },
            toCurrencyFormat: function(number) {
                return new Intl.NumberFormat('De-de').format(number);
            },
            onChangeSupplier: function() {
                let vm = this;
                const supplierId = vm.supplier;
                axios.get('/api/suppliers/' + supplierId + '/purchase-orders')
                    .then(res => {
                        vm.purchaseOrders = res.data.data;
                    }).catch(err => {
                        Swal.fire(
                            'Oops!',
                            'Something wrong',
                            'error'
                        )
                    })
            },
            isSelectedPO: function(id) {
                const selectedPurchaseOrdersIds = this.selectedPurchaseOrders.map(po => po.id);
                if (selectedPurchaseOrdersIds.indexOf(id) > -1) {
                    return true;
                } else {
                    return false;
                }

                return false;
            },
            validateAmount:function(){
                if (this.paymentAmount>this.subtotal){
                    this.paymentAmount=this.subtotal;
                }

            }
        },
        computed: {
            remainingPayments: function() {
                return this.selectedPurchaseOrders.map(po => Number(po.total) - Number(po.  payment)).reduce((acc, cur) => {
                    return acc + cur;
                }, 0)
            },
            subtotal: function() {
                  return this.selectedPurchaseOrders.filter(po =>{
                      return po.is_checked==true;
                    

                  }).map(po=>{
                      const amount=Number(po.total)-Number(po.payment);
                      return amount;
                  }).reduce((acc, cur) => {
                    return acc + cur;
                }, 0)
            },
            grandTotal: function() {
                const grandTotal = 0;
                return grandTotal;
            },
            // filteredPurchaseOrders: function() {
            //     const selectedPurchaseOrdersIds = this.selectedPurchaseOrders.map(po => po.id);
            //     return this.purchaseOrders.filter(po => selectedPurchaseOrdersIds.indexOf(po.id) < 0);
            // },
        },
        watch: {
            selectedGoods: {
                handler: function(newval, oldval) {
                    this.selectedGoods.forEach(goods => {
                        goods.total = (Number(goods.price) * Number(goods.quantity)) - Number(goods.discount);
                    });
                },
                deep: true
            },
            supplier: {
                handler: function(newval) {
                    let vm = this;
                    vm.dataTable.destroy();
                    if (newval) {
                        axios.get('/api/suppliers/' + newval + '/purchase-orders')
                            .then(res => {
                                vm.purchaseOrders = Array.isArray(res.data.data) ? res.data.data : [];
                                // const newPurchaseOrders = vm.purchaseOrders.map(po => [po.number]);
                                // $('#table-po').DataTable().rows.add(newPurchaseOrders).draw(false);
                                // $('#table-po').DataTable().draw(false);
                                // console.log($('#table-po'));
                                vm.$nextTick(() => {
                                    vm.dataTable = $(vm.$refs.POTable).DataTable()
                                    console.log('NEXT TICK FILLED')
                                });
                            }).catch(err => {
                                Swal.fire(
                                    'Oops!',
                                    'Something wrong',
                                    'error'
                                )
                            })
                    } else {
                        // $('#table-po').DataTable().rows.remove().draw(false);
                        vm.purchaseOrders = [];
                        vm.$nextTick(() => {
                            vm.dataTable = $(vm.$refs.POTable).DataTable()
                            console.log('NEXT TICK EMPTY')
                        });
                    }
                }
            }
        }
    })
</script>
<script>
    $(function() {
        // $('#table-po').DataTable();

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
            
            app.$data.supplier = $(this).val();

            axios.get(`/purchase-transaction/supplier/${$(this).val()}`)
            .then((response)=>{
                app.$data.selectedPurchaseOrders=response.data.data;
                 console.log(response.data.data);

            
            
            }).catch((err)=>{

            
            
            });
           
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