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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Tambah Quotation</h5>
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
                <h3 class="card-title">Form Quotation</h3>

            </div>
            <!--begin::Form-->
            <form class="form" autocomplete="off" @submit.prevent="submitForm" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <div class="form-row">
                                <div class="col-lg-6 col-md-12">
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
                            <div class="form-row">
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Tanggal:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="flaticon2-calendar-9"></i></span>
                                        </div>
                                        <input type="text" v-model="date" id="po-date" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Customer:</label>
                                    <select v-model="customer" class="form-control" required>
                                        <option value="">Pilih Customer</option>
                                        @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>UP:</label>
                                    <input type="text" v-model="up" class="form-control">
                                </div>
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Title:</label>
                                    <input type="text" v-model="title" class="form-control">
                                </div>
                            </div>
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
                                <a class="nav-link" id="other-cost-tab" data-toggle="tab" href="#other-cost">
                                    <span class="nav-icon">
                                        <i class="flaticon-signs-1"></i>
                                    </span>
                                    <span class="nav-text">Biaya Lain</span>
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
                                        <button type="button" class="btn btn-success" @click="addItem"><i class="flaticon2-plus"></i> Tambah</button>
                                    </div>
                                    <div>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr v-if="!items.length">
                                                    <td colspan="6">
                                                        <p class="text-center">
                                                            <i class="flaticon2-open-box font-size-h1"></i>
                                                        </p>
                                                        <p class="text-center text-dark-50"><strong>Belum ada item</strong></p>

                                                    </td>
                                                </tr>
                                                <template v-for="(item, index) in items">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Kode</th>
                                                        <!-- <th>Deskripsi</th> -->
                                                        <th>Tanggal Kirim</th>
                                                        <th>Qty</th>
                                                        <th>Price</th>
                                                        <th>Amount</th>
                                                        <th>Kode Pajak</th>
                                                    </tr>
                                                    <tr>
                                                        <th rowspan="2" class="align-middle text-center">@{{ index + 1 }}</th>
                                                        <td>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">#</span>
                                                                </div>
                                                                <input type="text" v-model="item.code" class="form-control form-control-sm">
                                                            </div>
                                                        </td>
                                                        <!-- <td>
                                                        <textarea class="form-control form-control-sm"></textarea>
                                                    </td> -->
                                                        <td>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="flaticon2-calendar-9"></i></span>
                                                                </div>
                                                                <input type="date" v-model="item.deliveryDate" class="form-control form-control-sm">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="text" v-model="item.quantity" class="form-control form-control-sm text-right">
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">Rp</span>
                                                                </div>
                                                                <input type="text" v-model="item.price" class="form-control form-control-sm text-right">
                                                            </div>
                                                        </td>
                                                        <td class="text-right align-middle">
                                                            <span class="text-dark-75"><strong>@{{ toCurrencyFormat(item.amount) }}</strong></span>
                                                        </td>
                                                        <td class="align-middle">
                                                            <select v-model="item.taxCode" class="form-control form-control-sm">
                                                                <option value=""></option>
                                                                <option value="p">P</option>
                                                                <option value="ps">PS</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6">
                                                            <div class="row">
                                                                <div class="col-md-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label><strong>Nama Item</strong></label>
                                                                        <input type="text" v-model="item.name" class="form-control form-control-sm">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label><strong>Deskripsi Item</strong></label>
                                                                <textarea v-model="item.description" rows="5" class="form-control form-control-sm"></textarea>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12 col-lg-6">
                                                                </div>
                                                            </div>
                                                            <div class="text-right">
                                                                <button type="button" class="btn btn-danger" @click="removeItem(index)">Hapus</button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6">
                                                            <div style="height: 5px;" class="w-100 bg-gray-200"></div>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                        <div class="mt-20">
                                            <div class="row justify-content-end">
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="border">
                                                        <div class="bg-success w-100" style="height: 5px;"></div>
                                                        <div class="p-3">
                                                            <h4>Total</h4>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <span>Subtotal</span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span>@{{ toCurrencyFormat(subtotal) }}</span>
                                                                </div>
                                                            </div>
                                                            <div v-if="ppn" class="row">
                                                                <div class="col-sm-6">
                                                                    <span>PPN @{{ ppnValue }}%</span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span>@{{ toCurrencyFormat(ppnAmount) }}</span>
                                                                </div>
                                                            </div>
                                                            <div v-if="pph23" class="row">
                                                                <div class="col-sm-6">
                                                                    <span>PPh 23 @{{ pph23Value }}%</span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span>(@{{ toCurrencyFormat(pph23Amount) }})</span>
                                                                </div>
                                                            </div>
                                                            <div v-if="otherCost > 0" class="row">
                                                                <div class="col-sm-6">
                                                                    <span>Biaya Lain (@{{ otherCostDescription }})</span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span>@{{ toCurrencyFormat(otherCost) }}</span>
                                                                </div>
                                                            </div>
                                                            <p class="text-right font-size-h4">Rp @{{ toCurrencyFormat(grandTotal) }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="other-cost" role="tabpanel" aria-labelledby="other-cost-tab">
                                <div class="pt-5">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-row align-items-center">
                                                <div class="form-group col-md-4">
                                                    <label class="checkbox">
                                                        <input v-model="ppn" type="checkbox">
                                                        <span></span>&nbsp;PPN
                                                    </label>
                                                </div>
                                                <div class="form-group col-md-8">
                                                    <div class="input-group">
                                                        <input type="text" v-model="ppnValue" class="form-control text-right" placeholder="Tarif PPN" :readonly="!ppn">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><strong class="text-dark-50">%</strong></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row align-items-center">
                                                <div class="form-group col-md-4">
                                                    <label class="checkbox">
                                                        <input v-model="pph23" type="checkbox">
                                                        <span></span>&nbsp;PPh 23
                                                    </label>
                                                </div>
                                                <div class="form-group col-md-8">
                                                    <div class="input-group">
                                                        <input type="text" v-model="pph23Value" class="form-control text-right" placeholder="Tarif PPN" :readonly="!ppn">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><strong class="text-dark-50">%</strong></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Biaya Lain:</label>
                                                <div class="form-row">
                                                    <div class="col-lg-6 col-md-12">
                                                        <input type="text" v-model="otherCostDescription" class="form-control" placeholder="Keterangan Biaya Lain">
                                                    </div>
                                                    <div class="col-lg-6 col-md-12">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><strong class="text-dark-50">Rp</strong></span>
                                                            </div>
                                                            <input type="text" v-model="otherCost" class="form-control text-right">
                                                        </div>
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
                                            <div class="form-group">
                                                <label>File (Max. 2MB)</label>
                                                <div class="custom-file">
                                                    <input type="file" id="customFile" accept=".jpg, .jpeg, .png, .pdf, .doc, .xls, .xlsx" class="custom-file-input" disabled>
                                                    <label id="file-upload-label" for="customFile" class="custom-file-label">Choose file</label>
                                                </div>
                                                <!---->
                                            </div>
                                            <div class="form-group">
                                                <label>Note:</label>
                                                <textarea v-model="note" class="form-control"></textarea>
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
            up: '',
            title: '',
            note: '',
            customer: '',
            number: '',
            date: '',
            description: '',
            loading: false,
            items: [],
            ppn: false,
            ppnValue: 10,
            pph23: false,
            pph23Value: 2,
            shippingCost: 0,
            otherCost: 0,
            otherCostDescription: '',
        },
        methods: {
            submitForm: function() {
                this.sendData();
            },
            sendData: function() {
                // console.log('submitted');
                let vm = this;
                vm.loading = true;
                axios.post('/quotation', {
                        customer_id: vm.customer,
                        up: vm.up,
                        title: vm.title,
                        note: vm.note,
                        number: vm.number,
                        date: vm.date,
                        description: vm.description,
                        subtotal: vm.subtotal,
                        ppn: vm.ppn ? 1 : 0,
                        ppn_value: vm.ppnValue,
                        ppn_amount: vm.ppnAmount,
                        pph23: vm.pph23 ? 1 : 0,
                        pph23_value: vm.pph23Value,
                        pph23_amount: vm.pph23Amount,
                        other_cost: vm.otherCost,
                        other_cost_description: vm.otherCostDescription,
                        total: vm.grandTotal,
                        items: vm.items,
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
            addItem: function() {
                let vm = this;
                vm.items.push({
                    code: '',
                    name: '',
                    description: '',
                    deliveryDate: '{{ date("Y-m-d") }}',
                    quantity: 1,
                    price: 0,
                    amount: 0,
                    taxCode: '',
                })
            },
            removeItem: function(index) {
                let vm = this;
                vm.items.splice(index, 1);
            },
            toCurrencyFormat: function(number) {
                return new Intl.NumberFormat('De-de').format(number);
            }
        },
        computed: {
            subtotal: function() {
                const grandTotal = this.items.map(item => Number(item.amount)).reduce((acc, cur) => {
                    return acc + cur;
                }, 0);

                return grandTotal;
            },
            ppnAmount: function() {
                let vm = this;
                if (!vm.ppn) {
                    return 0;
                }

                const ppn = this.subtotal * (Number(vm.ppnValue) / 100);
                return Math.round(ppn);
            },
            pph23Amount: function() {
                let vm = this;
                if (!vm.pph23) {
                    return 0;
                }

                const pph23 = this.subtotal * (Number(vm.pph23Value) / 100);
                return Math.round(pph23);
            },
            grandTotal: function() {
                const grandTotal = this.items.map(item => Number(item.amount)).reduce((acc, cur) => {
                    return acc + cur;
                }, 0);

                return grandTotal + this.ppnAmount - this.pph23Amount + Number(this.otherCost);
            }
        },
        watch: {
            items: {
                handler: function(newval, oldval) {
                    this.items.forEach(item => {
                        item.amount = Number(item.price) * Number(item.quantity);
                    });
                },
                deep: true
            }
        }
    })
</script>
<script>
    $(function() {
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