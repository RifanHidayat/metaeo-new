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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Manage Transactions</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Transactions</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Manage</a>
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
<div class="card card-custom overflow-hidden">
    <div class="card-body p-0">
        <!-- begin: Invoice-->
        <!-- begin: Invoice header-->
        <div class="row justify-content-center py-8 px-8 py-md-27 px-md-0">
            <div class="col-md-9">
                <div class="d-flex justify-content-between pb-10 pb-md-20 flex-column flex-md-row">
                    <h1 class="display-4 font-weight-boldest mb-10">{{ $transaction->number }}</h1>
                    <div class="d-flex flex-column align-items-md-end px-0">
                        <!--begin::Logo-->
                        <a href="#" class="mb-5">
                            <img src="/metronic/theme/html/demo1/dist/assets/media/logos/logo-dark.png" alt="">
                        </a>
                        <!--end::Logo-->
                        <span class="d-flex flex-column align-items-md-end opacity-70">
                            <h3>Detail Transaksi</h3>
                            <!-- <span>PT. Magenta Mediatama</span>
                            <span>Jl. Raya Kebayoran Lama No. 15 RT.04 RW.03 Grogol Utara,</span>
                            <span>Kebayoran Lama, Jakarta Selatan DKI Jakarta-12210</span> -->
                            <!-- <span>Phone (021)53660077 - 88; Fax (021)5366099</span> -->
                        </span>
                    </div>
                </div>
                <div class="border-bottom w-100"></div>
                <div class="d-flex justify-content-between pt-6">
                    <div class="d-flex flex-column flex-root">
                        <span class="font-weight-bolder mb-2">TANGGAL</span>
                        <span class="opacity-70">{{ \Carbon\Carbon::parse($transaction->date)->toFormattedDateString() }}</span>
                    </div>
                    <div class="d-flex flex-column flex-root">
                        <span class="font-weight-bolder mb-2">NOMOR TRANSAKSI</span>
                        <span class="opacity-70">{{ $transaction->number }}</span>
                    </div>
                    <div class="d-flex flex-column flex-root">
                        <span class="font-weight-bolder mb-2">CUSTOMER</span>
                        <span class="opacity-70">{{ $transaction->customer->name }}</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- end: Invoice header-->
        <!-- begin: Invoice body-->
        <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
            <div class="col-md-9">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="pl-0 font-weight-bold text-muted text-uppercase">Deskripsi</th>
                                <!-- <th class="text-right font-weight-bold text-muted text-uppercase">Hours</th>
                                <th class="text-right font-weight-bold text-muted text-uppercase">Rate</th> -->
                                <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaction->invoices as $invoice)
                            <tr class="font-weight-boldest">
                                <td class="pl-0 pt-7">Pembayaran Faktur <a href="/invoice/detail/{{ $invoice->id }}" target="_blank">#{{ $invoice->number }}</a></td>
                                <!-- <td class="text-right pt-7">80</td>
                                <td class="text-right pt-7">$40.00</td> -->
                                <td class="text-danger pr-0 pt-7 text-right">Rp {{ number_format($invoice->pivot->amount) }}</td>
                            </tr>
                            @endforeach
                            <!-- <tr class="font-weight-boldest border-bottom-0">
                                <td class="border-top-0 pl-0 py-4">Front-End Development</td>
                                <td class="border-top-0 text-right py-4">120</td>
                                <td class="border-top-0 text-right py-4">$40.00</td>
                                <td class="text-danger border-top-0 pr-0 py-4 text-right">$4800.00</td>
                            </tr>
                            <tr class="font-weight-boldest border-bottom-0">
                                <td class="border-top-0 pl-0 py-4">Back-End Development</td>
                                <td class="border-top-0 text-right py-4">210</td>
                                <td class="border-top-0 text-right py-4">$60.00</td>
                                <td class="text-danger border-top-0 pr-0 py-4 text-right">$12600.00</td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- end: Invoice body-->
        <!-- begin: Invoice footer-->
        <div class="row justify-content-center bg-gray-100 py-8 px-8 py-md-10 px-md-0">
            <div class="col-md-9">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="font-weight-bold text-muted text-uppercase">METODE PEMBAYARAN</th>
                                <th class="font-weight-bold text-muted text-uppercase">NAMA BANK / AKUN</th>
                                <!-- <th class="font-weight-bold text-muted text-uppercase">DUE DATE</th> -->
                                <th class="font-weight-bold text-muted text-uppercase">TOTAL AMOUNT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="font-weight-bolder">
                                @if($transaction->payment_method == 'other')
                                <td>Lainnya</td>
                                @else
                                <td class="text-capitalize">{{ $transaction->payment_method }}</td>
                                @endif
                                @if($transaction->payment_method == 'transfer')
                                <td>{{ $transaction->account_name }}</td>
                                @else if($transaction->payment_method == 'other')
                                <td>{{ $transaction->other_payment_method }}</td>
                                @endif
                                <!-- <td>Jan 07, 2018</td> -->
                                <td class="text-danger font-size-h3 font-weight-boldest">{{ number_format($transaction->total) }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="font-weight-bold text-muted text-uppercase">NOTE</th>
                            </tr>
                            <tr>
                                <td>{{ $transaction->note }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!-- end: Invoice footer-->
        <!-- begin: Invoice action-->
        <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
            <div class="col-md-9">
                <div class="d-flex justify-content-between">
                    <!-- <button type="button" class="btn btn-light-primary font-weight-bold" onclick="window.print();">Download Transaksi</button> -->
                    <a href="/transaction/print/{{ $transaction->id }}" target="_blank" class="btn btn-primary font-weight-bold">Print Transaksi</a>
                </div>
            </div>
        </div>
        <!-- end: Invoice action-->
        <!-- end: Invoice-->
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

        },
        methods: {
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
            }
        }
    })
</script>
<script>
    $(function() {
        $('#basic-table').DataTable();
    })
</script>
@endsection