@extends('layouts.app')

@section('title', 'Metaprint')

@section('head')
<link href="{{ asset('css/pages/wizard/wizard-2.css') }}" rel="stylesheet" type="text/css" />
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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Manage Customers</h5>
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
<div class="card card-custom">
    <div class="card-body p-0">
        <!--begin: Wizard-->
        <div class="wizard wizard-2" id="kt_wizard" data-wizard-state="first" data-wizard-clickable="false">
            <!--begin: Wizard Nav-->
            <div class="wizard-nav border-right py-8 px-8 py-lg-20 px-lg-10">
                <!--begin::Wizard Step 1 Nav-->
                @include('setting.menu')
                <!--end: Wizard Nav-->
                <!--begin: Wizard Body-->
                <div class="wizard-body py-8 px-8 py-lg-20 px-lg-10">
                    <!--begin: Wizard Form-->
                    <div class="row">
                        <h1>TESTING</h1>
                        <!-- <div class="offset-xxl-2 col-xxl-8">
                    </div> -->
                        <!--end: Wizard-->
                    </div>
                    <!--end: Wizard Form-->
                </div>
                <!--end: Wizard Body-->
            </div>
            <!--end: Wizard-->
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