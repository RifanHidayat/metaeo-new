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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Detail Faktur</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Faktur</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">{{ $invoice->number }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Detail</a>
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
<div class="card card-custom position-relative overflow-hidden" id="app">
    <!--begin::Shape-->
    <div class="position-absolute opacity-30">
        <span class="svg-icon svg-icon-10x svg-logo-white">
            <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/shapes/abstract-8.svg-->
            <svg xmlns="http://www.w3.org/2000/svg" width="176" height="165" viewBox="0 0 176 165" fill="none">
                <g clip-path="url(#clip0)">
                    <path d="M-10.001 135.168C-10.001 151.643 3.87924 165.001 20.9985 165.001C38.1196 165.001 51.998 151.643 51.998 135.168C51.998 118.691 38.1196 105.335 20.9985 105.335C3.87924 105.335 -10.001 118.691 -10.001 135.168Z" fill="#AD84FF"></path>
                    <path d="M28.749 64.3117C28.749 78.7296 40.8927 90.4163 55.8745 90.4163C70.8563 90.4163 83 78.7296 83 64.3117C83 49.8954 70.8563 38.207 55.8745 38.207C40.8927 38.207 28.749 49.8954 28.749 64.3117Z" fill="#AD84FF"></path>
                    <path d="M82.9996 120.249C82.9996 144.964 103.819 165 129.501 165C155.181 165 176 144.964 176 120.249C176 95.5342 155.181 75.5 129.501 75.5C103.819 75.5 82.9996 95.5342 82.9996 120.249Z" fill="#AD84FF"></path>
                    <path d="M98.4976 23.2928C98.4976 43.8887 115.848 60.5856 137.249 60.5856C158.65 60.5856 176 43.8887 176 23.2928C176 2.69692 158.65 -14 137.249 -14C115.848 -14 98.4976 2.69692 98.4976 23.2928Z" fill="#AD84FF"></path>
                    <path d="M-10.0011 8.37466C-10.0011 20.7322 0.409554 30.7493 13.2503 30.7493C26.0911 30.7493 36.5 20.7322 36.5 8.37466C36.5 -3.98287 26.0911 -14 13.2503 -14C0.409554 -14 -10.0011 -3.98287 -10.0011 8.37466Z" fill="#AD84FF"></path>
                    <path d="M-2.24881 82.9565C-2.24881 87.0757 1.22081 90.4147 5.50108 90.4147C9.78135 90.4147 13.251 87.0757 13.251 82.9565C13.251 78.839 9.78135 75.5 5.50108 75.5C1.22081 75.5 -2.24881 78.839 -2.24881 82.9565Z" fill="#AD84FF"></path>
                    <path d="M55.8744 12.1044C55.8744 18.2841 61.0788 23.2926 67.5001 23.2926C73.9196 23.2926 79.124 18.2841 79.124 12.1044C79.124 5.92653 73.9196 0.917969 67.5001 0.917969C61.0788 0.917969 55.8744 5.92653 55.8744 12.1044Z" fill="#AD84FF"></path>
                </g>
            </svg>
            <!--end::Svg Icon-->
        </span>
    </div>
    <!--end::Shape-->
    <!--begin::Invoice header-->
    <div class="row justify-content-center py-8 px-8 py-md-36 px-md-0 bg-primary">
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-md-center flex-column flex-md-row">
                <div class="d-flex flex-column px-0 order-2 order-md-1">
                    <!--begin::Logo-->
                    <a href="#" class="mb-5 text-white">
                        <h1>Detail Faktur</h1>
                    </a>
                    <!--end::Logo-->
                    <!-- <span class="d-flex flex-column font-size-h5 font-weight-bold text-white">
                        <span>PT. Magenta Mediatama</span>
                        <span>Jl. Raya Kebayoran Lama No. 15 RT.04 RW.03 Grogol Utara,</span>
                        <span>Kebayoran Lama, Jakarta Selatan DKI Jakarta-12210</span>
                        <span>Phone (021)53660077 - 88; Fax (021)5366099</span>
                    </span> -->
                </div>
                <h1 class="display-3 font-weight-boldest text-white order-1 order-md-2">{{ $invoice->number }}</h1>
            </div>
        </div>
    </div>
    <!--end::Invoice header-->
    <div class="row justify-content-center py-8 px-8 py-md-30 px-md-0">
        <div class="col-md-9">
            <!--begin::Invoice body-->
            <div class="row pb-26">
                <div class="col-md-3 border-right-md pr-md-10 py-md-10">
                    <!--begin::Invoice To-->
                    <div class="text-dark-50 font-size-lg font-weight-bold mb-3">CUSTOMER</div>
                    <div class="font-size-lg font-weight-bold mb-10">{{ $invoice->customer->name }}
                    </div>
                    <!--end::Invoice To-->
                    <!--begin::Invoice No-->
                    <div class="text-dark-50 font-size-lg font-weight-bold mb-3">NOMOR FAKTUR</div>
                    <div class="font-size-lg font-weight-bold mb-10">{{ $invoice->number }}</div>
                    <!--end::Invoice No-->
                    <!--begin::Invoice Date-->
                    <div class="text-dark-50 font-size-lg font-weight-bold mb-3">TANGGAL</div>
                    <div class="font-size-lg font-weight-bold mb-10">{{ \Carbon\Carbon::parse($invoice->date)->toFormattedDateString() }}</div>
                    <!--end::Invoice Date-->
                    <!--begin::Invoice Date-->
                    <div class="text-dark-50 font-size-lg font-weight-bold mb-3">STATUS</div>
                    <div class="font-size-lg font-weight-bold">
                        @if($status == 'complete')
                        <span class="label label-xl label-success label-inline">Lunas</span>
                        @else
                        <span class="label label-xl label-warning label-inline">Belum Lumas</span>
                        @endif
                    </div>
                    <!--end::Invoice Date-->
                </div>
                <div class="col-md-9 py-10 pl-md-10">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="pt-1 pb-9 pl-0 pl-md-5 font-weight-bolder text-muted font-size-lg text-uppercase">Item</th>
                                    <!-- <th class="pt-1 pb-9 text-right font-weight-bolder text-muted font-size-lg text-uppercase">Amount</th>
                                    <th class="pt-1 pb-9 text-right font-weight-bolder text-muted font-size-lg text-uppercase">Paid</th> -->
                                    <th class="pt-1 pb-9 text-right pr-0 font-weight-bolder text-muted font-size-lg text-uppercase">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoice->quotations as $quotation)
                                <tr class="font-weight-bolder {{ $loop->first ? '' : 'border-bottom-0' }} font-size-lg">
                                    <td class="border-top-0 pl-0 pl-md-5 pt-7 d-flex align-items-center">
                                        <span class="navi-icon mr-2">
                                            <i class="fa fa-genderless text-success font-size-h2"></i>
                                        </span>Quotation &nbsp;<a href="#">#{{ $quotation->number }}</a>
                                    </td>

                                    <td class="pr-0 pt-7 font-size-h6 font-weight-boldest text-right">Rp {{ number_format($quotation->selectedEstimation->total_bill) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-10">
                        <h3 class="pl-4">Histori Pembayaran</h3>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="pt-1 pb-9 pl-0 pl-md-5 font-weight-bolder text-muted font-size-lg text-uppercase">Tanggal</th>
                                        <th class="pt-1 pb-9 text-center font-weight-bolder text-muted font-size-lg text-uppercase">Nomor Transaksi</th>
                                        <!-- <th class="pt-1 pb-9 text-right font-weight-bolder text-muted font-size-lg text-uppercase">Paid</th> -->
                                        <th class="pt-1 pb-9 text-right pr-0 font-weight-bolder text-muted font-size-lg text-uppercase">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($invoice->transactions as $transaction)
                                    <tr class="font-weight-bolder font-size-lg">
                                        <td class="border-top-0 pl-0 pl-md-5 pt-7 d-flex align-items-center">
                                            {{ $transaction->date }}
                                        </td>
                                        <td class="border-top-0 pt-7 font-size-h6 font-weight-boldest text-center">
                                            <a href="/transaction/detail/{{ $transaction->id }}">#{{ $transaction->number }}</a>
                                        </td>
                                        <td class="border-top-0 pt-7 font-size-h6 font-weight-boldest text-right">Rp {{ number_format($transaction->pivot->amount) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class=" pt-7 font-size-h6 font-weight-boldest text-right" colspan="3">
                                            Rp {{ number_format($summary[1]['amount']) }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Invoice body-->
            <!--begin::Invoice footer-->
            <div class="row">
                <!-- <div class="col-md-5 border-top pt-14 pb-10 pb-md-18">
                    <div class="d-flex flex-column flex-md-row">
                        <div class="d-flex flex-column">
                            <div class="font-weight-bold font-size-h6 mb-3">BANK TRANSFER</div>
                            <div class="d-flex justify-content-between font-size-lg mb-3">
                                <span class="font-weight-bold mr-15">Account Name:</span>
                                <span class="text-right">Barclays UK</span>
                            </div>
                            <div class="d-flex justify-content-between font-size-lg mb-3">
                                <span class="font-weight-bold mr-15">Account Number:</span>
                                <span class="text-right">1234567890934</span>
                            </div>
                            <div class="d-flex justify-content-between font-size-lg">
                                <span class="font-weight-bold mr-15">Code:</span>
                                <span class="text-right">BARC0032UK</span>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="col-md-12 pt-md-25">
                    <div>
                        @foreach($summary as $sum)
                        <div class="bg-primary rounded d-flex align-items-center justify-content-between text-white max-w-500px position-relative ml-auto p-7 mb-5">
                            <!--begin::Shape-->
                            <div class="position-absolute opacity-30 top-0 right-0">
                                <span class="svg-icon svg-icon-2x svg-logo-white svg-icon-flip">
                                    <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/shapes/abstract-8.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="176" height="165" viewBox="0 0 176 165" fill="none">
                                        <g clip-path="url(#clip0)">
                                            <path d="M-10.001 135.168C-10.001 151.643 3.87924 165.001 20.9985 165.001C38.1196 165.001 51.998 151.643 51.998 135.168C51.998 118.691 38.1196 105.335 20.9985 105.335C3.87924 105.335 -10.001 118.691 -10.001 135.168Z" fill="#AD84FF"></path>
                                            <path d="M28.749 64.3117C28.749 78.7296 40.8927 90.4163 55.8745 90.4163C70.8563 90.4163 83 78.7296 83 64.3117C83 49.8954 70.8563 38.207 55.8745 38.207C40.8927 38.207 28.749 49.8954 28.749 64.3117Z" fill="#AD84FF"></path>
                                            <path d="M82.9996 120.249C82.9996 144.964 103.819 165 129.501 165C155.181 165 176 144.964 176 120.249C176 95.5342 155.181 75.5 129.501 75.5C103.819 75.5 82.9996 95.5342 82.9996 120.249Z" fill="#AD84FF"></path>
                                            <path d="M98.4976 23.2928C98.4976 43.8887 115.848 60.5856 137.249 60.5856C158.65 60.5856 176 43.8887 176 23.2928C176 2.69692 158.65 -14 137.249 -14C115.848 -14 98.4976 2.69692 98.4976 23.2928Z" fill="#AD84FF"></path>
                                            <path d="M-10.0011 8.37466C-10.0011 20.7322 0.409554 30.7493 13.2503 30.7493C26.0911 30.7493 36.5 20.7322 36.5 8.37466C36.5 -3.98287 26.0911 -14 13.2503 -14C0.409554 -14 -10.0011 -3.98287 -10.0011 8.37466Z" fill="#AD84FF"></path>
                                            <path d="M-2.24881 82.9565C-2.24881 87.0757 1.22081 90.4147 5.50108 90.4147C9.78135 90.4147 13.251 87.0757 13.251 82.9565C13.251 78.839 9.78135 75.5 5.50108 75.5C1.22081 75.5 -2.24881 78.839 -2.24881 82.9565Z" fill="#AD84FF"></path>
                                            <path d="M55.8744 12.1044C55.8744 18.2841 61.0788 23.2926 67.5001 23.2926C73.9196 23.2926 79.124 18.2841 79.124 12.1044C79.124 5.92653 73.9196 0.917969 67.5001 0.917969C61.0788 0.917969 55.8744 5.92653 55.8744 12.1044Z" fill="#AD84FF"></path>
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </div>
                            <!--end::Shape-->
                            <div class="font-weight-boldest font-size-h5">{{ $sum['title'] }}</div>
                            <div class="text-right d-flex flex-column">
                                <span class="font-weight-boldest font-size-h3 line-height-sm">Rp {{ number_format($sum['amount']) }}</span>
                                <!-- <span class="font-size-sm">Taxes included</span> -->
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!--end::Invoice footer-->
        </div>
    </div>
    <!-- begin: Invoice action-->
    <div class="row justify-content-center border-top py-8 px-8 py-md-28 px-md-0">
        <div class="col-md-9">
            <div class="d-flex font-size-sm flex-wrap">
                <a href="/invoice/print/{{ $invoice->id }}" target="_blank" class="btn btn-primary font-weight-bolder py-4 mr-3 mr-sm-14 my-1">Cetak Faktur</a>
                <!-- <button type="button" class="btn btn-primary font-weight-bolder py-4 mr-3 mr-sm-14 my-1" onclick="window.print();">Print Invoice</button> -->
                <!-- <button type="button" class="btn btn-light-primary font-weight-bolder mr-3 my-1">Download</button>
                <button type="button" class="btn btn-warning font-weight-bolder ml-sm-auto my-1">Create Invoice</button> -->
            </div>
        </div>
    </div>
    <!-- end: Invoice action-->
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