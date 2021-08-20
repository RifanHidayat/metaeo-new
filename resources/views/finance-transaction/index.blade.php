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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Finance</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Finance</a>
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
                <h3 class="card-title">Tambah Transaksi</h3>

            </div>
            <!--begin::Form-->
            <form class="form" autocomplete="off" @submit.prevent="submitForm">
                <div class="card-body">
                    <div v-if="accountLoading" class="row mb-3">
                        <div class="col-lg-8">
                            Memuat data akun...
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4 col-md-6">
                            <label>Akun In:<span class="text-danger">*</span></label>
                            <select v-model="inAccount" class="form-control">
                                <option value="">Pilih Akun</option>
                                <option v-for="account in accounts" :value="account.id">@{{ account.bank_name }} (@{{ account.account_number }})</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label>Akun Out:<span class="text-danger">*</span></label>
                            <select v-model="outAccount" class="form-control">
                                <option value="">Pilih Akun</option>
                                <option v-for="account in accounts" :value="account.id">@{{ account.bank_name }} (@{{ account.account_number }})</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label>Tanggal:<span class="text-danger">*</span></label>
                            <input v-model="date" type="text" class="form-control date" placeholder="Masukkan tanggal" required>

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label>Deskripsi:</label>
                            <textarea v-model="description" type="text" class="form-control" placeholder="Masukkan deskripsi" required></textarea>
                        </div>
                        <div class="col-lg-4">
                            <label>Jumlah:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="text" v-model="amount" v-cleave="cleaveCurrency" class="form-control text-right placeholder-left" placeholder="Masukkan jumlah" required />
                            </div>
                        </div>
                    </div>
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
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <h3 class="card-title">In Out</h3>
            </div>
            <div class="card-body">
                <!--begin: Datatable-->
                <table class="table table-bordered" id="basic-table">
                    <thead class="bg-light">
                        <tr class="text-center">
                            <th>Tanggal</th>
                            <th>Deskripsi</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->date }}</td>
                            <td>{{ $transaction->description }}</td>
                            <td class="text-right">{{ number_format($transaction->amount) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!--end: Datatable-->
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/pages/features/miscellaneous/sweetalert2.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
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
            inAccount: '',
            date: '',
            outAccount: '',
            description: '',
            amount: '',
            cleaveCurrency: {
                delimiter: '.',
                numeralDecimalMark: ',',
                numeral: true,
                numeralThousandsGroupStyle: 'thousand'
            },
            accounts: [],
            loading: false,
            accountLoading: true,
        },
        mounted() {
            this.getAccounts();
        },
        methods: {
            getAccounts: function() {
                let vm = this;
                let accounts = axios.get('{{ env("MAGENTA_HRD_URL") }}/api/bank-accounts').then(res => {
                    vm.accounts = res.data.data;
                    vm.accountLoading = false;
                }).catch(err => {
                    console.log(err);
                    vm.accountLoading = false;
                });
            },
            submitForm: function() {
                this.sendData();
            },
            sendData: function() {
                // console.log('submitted');
                let vm = this;
                vm.loading = true;
                axios.post('/in-out-transaction', {
                        in_account: vm.inAccount,
                        out_account: vm.outAccount,
                        date: vm.date,
                        description: vm.description,
                        amount: vm.amount,
                        // source: 'add',
                    })
                    .then(function(response) {
                        // vm.loading = false;
                        // Swal.fire({
                        //     title: 'Success',
                        //     text: 'Data has been saved',
                        //     icon: 'success',
                        //     allowOutsideClick: false,
                        // }).then((result) => {
                        //     if (result.isConfirmed) {
                        //         window.location.reload();
                        //     }
                        // })
                        axios.post('{{ env("MAGENTA_HRD_URL") }}/api/transaction-accounts', {
                                in_account: vm.inAccount,
                                out_account: vm.outAccount,
                                date: vm.date,
                                description: vm.description,
                                amount: vm.amount,
                                source: 'add',
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
                                        // window.location.href = '/user';
                                        window.location.reload();
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
            }
        }
    })
</script>
<script>
    $(function() {
        $('#basic-table').DataTable();

        $('.date').datepicker({
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