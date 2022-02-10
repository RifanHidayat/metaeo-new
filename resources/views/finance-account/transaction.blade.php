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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Detail Transaksi Akun</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Account</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Transaction</a>
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
    <div class="card-header flex-wrap py-3">
        <div class="card-title">
            <h3 class="card-label">List Transaksi
                <!-- <span class="d-block text-muted pt-2 font-size-sm">sorting &amp; pagination remote datasource</span> -->
            </h3>
        </div>
        <div class="card-toolbar">

        </div>
    </div>
    <div class="card-body">
        <div v-if="loading" class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated " role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="d-flex align-items-center flex-wrap alert alert-light mb-10">
            <!--begin: Item-->
            <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                <span class="mr-4">
                    <i class="flaticon2-arrow-down icon-2x text-success font-weight-bold"></i>
                </span>
                <div class="d-flex flex-column text-dark-50">
                    <span class="font-weight-bolder font-size-sm">Total Debit</span>
                    <span class="font-weight-bolder font-size-h5">
                        @{{ currencyFormat(debit) }}
                    </span>
                    <!-- <span class="text-dark-50 font-weight-bold">Pcs</span></span> -->
                </div>
            </div>
            <!--end: Item-->
            <!--begin: Item-->
            <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                <span class="mr-4">
                    <i class="flaticon2-arrow-up icon-2x text-danger font-weight-bold"></i>
                </span>
                <div class="d-flex flex-column text-dark-50">
                    <span class="font-weight-bolder font-size-sm">Total Credit</span>
                    <span class="font-weight-bolder font-size-h5">
                        @{{ currencyFormat(credit) }}
                    </span>
                    <!-- <span class="text-dark-50 font-weight-bold">Pcs</span></span> -->
                </div>
            </div>
            <!--end: Item-->
            <!--begin: Item-->
            <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                <span class="mr-4">
                    <i class="flaticon2-poll-symbol icon-2x text-primary font-weight-bold"></i>
                </span>
                <div class="d-flex flex-column text-dark-50">
                    <span class="font-weight-bolder font-size-sm">Saldo</span>
                    <span class="font-weight-bolder font-size-h5">
                        @{{ currencyFormat(debit - credit) }}
                    </span>
                    <!-- <span class="text-dark-50 font-weight-bold">Pcs</span></span> -->
                </div>
            </div>
            <!--end: Item-->
        </div>
        <!--begin: Datatable-->
        <table class="table table-bordered" id="basic-table">
            <thead class="bg-light">
                <tr class="text-center">
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                     <th>Note</th>
                    <th>Debit</th>
                    <th>Credit</th>
                    <th>Saldo</th>
                </tr>
            </thead>
            <tbody>

                <tr v-for="transaction in account.account_transactions">

                 
              
                    <td style="width: 200px;">@{{ transaction.date }}</td>
                    <td>@{{ transaction.description }}</td>
                    <td>@{{ transaction.note }}</td>
                    <td class="text-right">@{{ transaction.type == 'debit' ? currencyFormat(transaction.amount) : '' }}</td>
                    <td class="text-right">@{{ transaction.type == 'credit' ? currencyFormat(transaction.amount) : '' }}</td>
                    <td class="text-right">
                    @{{transaction.type == 'debit'?balance=balance+transaction.amount:balance=balance-transaction.amount}}</td>
                    
                </tr>
            </tbody>
        </table>
        <!--end: Datatable-->
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
            transactions: [],
            account:null,
            balance:0,
            debit:0,
            credit:0,
            totalIn: 0,
            totalOut: 0,
            loading: true,
        },
        mounted() {
            this.getTransactions();
        },
        methods: {
            getTransactions() {
                let vm = this;
                axios.get('{{ env("MAGENTA_FINANCE_URL") }}/api/v1/account/{{ $id }}/transactions')
                    .then(res => {
                        vm.account = res.data.data;
                        vm.debit = res.data.data.debit;
                        vm.credit = res.data.data.credit;
                        vm.loading = false;
                        console.log(res.data.data)
                    }).catch(err => {
                        console.log(err);
                        vm.loading(false);
                    })
            },
            deleteRecord: function(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "The data will be deleted",
                    icon: 'warning',
                    reverseButtons: true,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        return axios.delete('/customer/' + id)
                            .then(function(response) {
                                console.log(response.data);
                            })
                            .catch(function(error) {
                                console.log(error.data);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops',
                                    text: 'Something wrong',
                                })
                            });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Data has been deleted',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        })
                    }
                })
            },
            currencyFormat: function(number) {
                return Intl.NumberFormat('de-DE').format(number);
            }
        }
    })
</script>
<script>
    $(function() {
        // $('#basic-table').DataTable();
    })
</script>
@endsection