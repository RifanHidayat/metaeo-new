@extends('layouts.app')

@section('title', 'Metaprint')

@section('head')
<link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('pagestyle')
<style>
    .placeholder-left::placeholder {
        text-align: left;
    }
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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Pembayaran Faktur</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Customers</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Payment</a>
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
<div class="card card-custom gutter-b" id="app">
    <div class="card-header">
        @include('customer.tab')
    </div>
    <div class="card-body">
        <form @submit.prevent="submitForm">
            <div class="row justify-content-between mb-10">
                <div class="col-lg-6 col-sm-12">
                    <!-- <div class="form-group row">
                        <label class="col-lg-4 col-form-label text-lg-right">Nomor Transaksi:</label>
                        <div class="col-lg-8">
                            <span class="label label-xl label-info label-inline ">@{{ number }}</span>
                        </div>
                    </div> -->
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label text-lg-right">Tanggal Transaksi:</label>
                        <div class="col-lg-8">
                            <input type="text" v-model="date" class="form-control transaction-date" placeholder="Masukkan tanggal transaksi" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label text-lg-right">Jumlah Pembayaran:</label>
                        <div class="col-lg-8">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="text" v-model="paymentAmount" v-cleave="cleaveCurrency" @input="validatePaymentAmount" class="form-control text-right placeholder-left" placeholder="Masukkan jumlah pembayaran" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label text-lg-right">Metode Pembayaran:</label>
                        <div class="col-lg-8">
                            <select class="form-control" v-model="paymentMethod" required>
                                <option value="cash">Cash</option>
                                <option value="transfer">Transfer</option>
                                <option value="other">Lainnya</option>
                            </select>
                            <input type="text" v-if="paymentMethod == 'other'" v-model="otherPaymentMethod" class="form-control mt-3" placeholder="Masukkan metode pembayaran" required />
                        </div>
                    </div>
                    <div class="form-group row" v-if="paymentMethod == 'transfer'">
                        <label class="col-lg-4 col-form-label text-lg-right">Akun:</label>
                        <div class="col-lg-8">
                            <select class="form-control" v-model="account" required>
                                <option value="">Pilih Akun</option>
                                <option v-for="acc in accounts" :value="acc.id">@{{acc.bank_name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label text-lg-right">Note:</label>
                        <div class="col-lg-8">
                            <textarea class="form-control" v-model="note"></textarea>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary" :class="loading && 'spinner spinner-white spinner-right'" :disabled="loading || checkedInvoicesIds.length < 1">
                            Save
                        </button>
                    </div>
                </div>
                <div class="col-lg-5 col-sm-12">
                    <div class="alert alert-light mb-10">
                        <!--begin: Item-->
                        <div class="d-flex align-items-center flex-lg-fill mb-4">
                            <span class="mr-4">
                                <i class="flaticon2-list-2 icon-2x text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-50">
                                <span class="font-weight-bolder font-size-sm">Total Faktur</span>
                                <span class="font-weight-bolder font-size-h5">
                                    Rp @{{ Intl.NumberFormat('de-DE').format(totalInvoices) }}
                                </span>
                                <!-- <span class="text-dark-50 font-weight-bold">Pcs</span></span> -->
                            </div>
                        </div>
                        <!--end: Item-->
                        <hr>
                        <!--begin: Item-->
                        <div class="d-flex align-items-center flex-lg-fill mb-4">
                            <span class="mr-4">
                                <i class="flaticon2-check-mark icon-2x text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-50">
                                <span class="font-weight-bolder font-size-sm">Total Faktur Yang Dipilih</span>
                                <span class="font-weight-bolder font-size-h5">
                                    Rp @{{ Intl.NumberFormat('de-DE').format(totalCheckedInvoices) }}
                                </span>
                            </div>
                        </div>
                        <!--end: Item-->
                    </div>
                </div>
            </div>
        </form>
        <hr>
        <!--begin: Datatable-->
        <h5 class="text-dark font-weight-bold mt-1 mr-5 mb-10">List Faktur yang Belum Lunas</h5>
        <table class="table table-bordered" id="basic-table">
            <thead>
                <tr class="text-center">
                    <th>Nomor</th>
                    <th>Tanggal</th>
                    <th>Total Faktur</th>
                    <th>Sisa Pembayaran</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                <tr>
                    <td class="text-center">{{ $invoice->number }}</td>
                    <td class="text-center">{{ $invoice->date }}</td>
                    <td class="text-right">{{ number_format($invoice->total) }}</td>
                    <?php $remainingPayment = $invoice->total - $invoice->total_payment; ?>
                    @if($remainingPayment > 0)
                    <td class="text-right">{{ number_format($remainingPayment) }}</td>
                    <td class="text-center">
                        <label class="checkbox justify-content-center">
                            <input type="checkbox" v-model="checkedInvoicesIds" :value="{{ $invoice->id }}" />
                            <span></span>
                        </label>
                    </td>
                    @else
                    <td class="text-center"><span class="label label-lg label-success label-inline ">Lunas</span></td>
                    <td></td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        <!--end: Datatable-->
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('js/pages/features/miscellaneous/sweetalert2.js') }}"></script>
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
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
            invoices: JSON.parse('{!! json_encode($invoices) !!}'),
            checkedInvoicesIds: [],
            accounts: [],
            number: '{{ $transaction_number }}',
            date: '',
            account: '',
            customerId: '{{ $customer->id }}',
            paymentAmount: '',
            paymentMethod: 'transfer',
            otherPaymentMethod: '',
            note: '',
            cleaveCurrency: {
                delimiter: '.',
                numeralDecimalMark: ',',
                numeral: true,
                numeralThousandsGroupStyle: 'thousand'
            },
            loading: false,
        },
        mounted() {
            this.getBankAccounts();
        },
        methods: {
            getBankAccounts: function() {
                let vm = this;
                axios.get('{{ env("MAGENTA_HRD_URL") }}/api/bank-accounts').then(res => {
                    vm.accounts = res.data.data;
                })
            },
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
                    account_id: vm.accountData.id,
                    account_name: vm.accountData.bank_name,
                    total: vm.totalCheckedInvoices,
                    customer_id: vm.customerId,
                    payment_amount: vm.paymentAmount,
                    payment_method: vm.paymentMethod,
                    other_payment_method: null,
                    note: vm.note,
                    selected_invoices: vm.checkedInvoices,
                }

                if (vm.paymentMethod == 'other') {
                    data.other_payment_method = vm.otherPaymentMethod;
                }

                axios.post('/transaction', data)
                    .then(function(response) {
                        vm.loading = false;
                        Swal.fire({
                            title: 'Success',
                            text: 'Data has been saved',
                            icon: 'success',
                            // allowOutsideClick: false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '/customer';
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
            validatePaymentAmount: function() {
                if (this.clearPaymentAmount > this.totalInvoices) {
                    this.paymentAmount = this.totalInvoices;
                }
            },
            clearThousandFormat: function(number) {
                return number.replaceAll('.', '');
            }
        },
        computed: {
            checkedInvoices: function() {
                return this.invoices.filter(invoice => this.checkedInvoicesIds.indexOf(invoice.id) > -1);
            },
            totalInvoices: function() {
                const total = this.invoices.map(invoice => Number(invoice.total) - Number(invoice.total_payment)).reduce((acc, cur) => {
                    return acc + cur;
                }, 0)

                return total;
            },
            totalCheckedInvoices: function() {
                const total = this.checkedInvoices.map(invoice => Number(invoice.total) - Number(invoice.total_payment)).reduce((acc, cur) => {
                    return acc + cur;
                }, 0)

                return total;
            },
            accountData: function() {
                let vm = this;
                if (vm.accounts.length < 1 || vm.account == '') {
                    return {
                        id: null,
                        bank_name: 'Unknown',
                    }
                }
                return this.accounts.filter(acc => acc.id == vm.account)[0];
            },
            clearPaymentAmount: function() {
                if (this.paymentAmount == '' || typeof(this.paymentAmount) == 'undefined' || this.paymentAmount == null) {
                    return 0;
                }
                return Number(this.paymentAmount.replaceAll('.', ''));
            }
        }
    })
</script>
<script>
    $(function() {
        $('#basic-table').DataTable({
            // "search": false,
            "order": [
                [1, 'desc']
            ],
        });


        $(function() {
            $('.transaction-date').datepicker({
                format: 'yyyy-mm-dd',
                todayBtn: false,
                clearBtn: true,
                clearBtn: true,
                todayHighlight: true,
                orientation: "bottom left",
            }).on('changeDate', function(e) {
                app.$data.date = e.format(0, 'yyyy-mm-dd');
            });
        })

    })
</script>
@endsection