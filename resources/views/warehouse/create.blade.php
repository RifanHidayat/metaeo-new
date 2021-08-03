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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Tambah Gudang</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Customer</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Warehouse</a>
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
                <h3 class="card-title">Customer Form</h3>

            </div>
            <!--begin::Form-->
            <form class="form" autocomplete="off" @submit.prevent="submitForm">
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>Nama Gudang:</label>
                            <input v-model="name" type="text" class="form-control" placeholder="Enter warehouse's name">
                            <!-- <span class="form-text text-muted">Please enter customer's name</span> -->
                        </div>
                        <div class="col-lg-6">
                            <label>PIC:</label>
                            <input v-model="pic" type="text" class="form-control" placeholder="Enter PIC">
                            <!-- <span class="form-text text-muted">Please enter customer's contact number (Optional)</span> -->
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>Kontak:</label>
                            <input v-model="contact" type="text" class="form-control" placeholder="Enter PIC contact">
                            <!-- <span class="form-text text-muted">Please enter customer's name</span> -->
                        </div>
                        <div class="col-lg-6">
                            <label>Address:<span class="text-danger">*</span></label>
                            <textarea v-model="address" class="form-control" rows="3" required placeholder="Enter warehouse's address"></textarea>
                            <!-- <span class="form-text text-muted">Please enter customer's contact number (Optional)</span> -->
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
@endsection

@section('pagescript')
<script>
    let app = new Vue({
        el: '#app',
        data: {
            name: '',
            pic: '',
            contact: '',
            address: '',
            customer: '{{ $customer->id }}',
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
                axios.post('/warehouse', {
                        name: vm.name,
                        pic: vm.pic,
                        contact: vm.contact,
                        address: vm.address,
                        customer_id: vm.customer,
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
                                window.location.href = '/customer/warehouse/{{ $customer->id }}';
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
            }
        }
    })
</script>
@endsection