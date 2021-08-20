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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Tambah Group</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Group</a>
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
                <h3 class="card-title">Form Grup</h3>

            </div>
            <!--begin::Form-->
            <form class="form" autocomplete="off" @submit.prevent="submitForm">
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>Nama:<span class="text-danger">*</span></label>
                            <input v-model="name" type="text" class="form-control" placeholder="Enter group's name" required>
                            <span class="form-text text-muted">Please enter group's name</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Hak Akses:<span class="text-danger">*</span></label>
                            <table class="table">
                                <thead>
                                    <tr class="text-center">
                                        <th></th>
                                        <th>View</th>
                                        <th>Tambah</th>
                                        <th>Edit</th>
                                        <th>Hapus</th>
                                        <th>Print</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="permission in permissions">
                                        <th class="py-5">@{{ permission.title }}</th>
                                        <td v-for="attribute in permission.attributes" class="text-center py-5">
                                            <label v-if="attribute !== null" class="checkbox justify-content-center">
                                                <input type="checkbox" v-model="checkedPermissions" :value="attribute" />
                                                <span></span>
                                            </label>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
            permissions: [{
                    title: 'User',
                    attributes: ['view_user', 'add_user', 'edit_user', 'delete_user', 'print_user'],
                },
                {
                    title: 'Group',
                    attributes: ['view_group', 'add_group', 'edit_group', 'delete_group', 'print_group'],
                },
                {
                    title: 'Customer',
                    attributes: ['view_customer', 'add_customer', 'edit_customer', 'delete_customer', 'print_customer'],
                },
                {
                    title: 'PIC PO',
                    attributes: ['view_pic_po', 'add_pic_po', 'edit_pic_po', 'delete_pic_po', null],
                },
                {
                    title: 'Estimation',
                    attributes: ['view_estimation', 'add_estimation', 'edit_estimation', 'delete_estimation', 'print_estimation'],
                },
                {
                    title: 'Quotation',
                    attributes: ['view_quotation', 'add_quotation', 'edit_quotation', 'delete_quotation', 'print_quotation'],
                },
                {
                    title: 'Sales Order',
                    attributes: ['view_sales_order', 'add_sales_order', 'edit_sales_order', 'delete_sales_order', 'print_sales_order'],
                },
                {
                    title: 'SPK',
                    attributes: ['view_spk', 'add_spk', 'edit_spk', 'delete_spk', 'print_spk'],
                },
                {
                    title: 'Delivery Order',
                    attributes: ['view_delivery_order', 'add_delivery_order', 'edit_delivery_order', 'delete_delivery_order', 'print_delivery_order'],
                },
                {
                    title: 'Faktur',
                    attributes: ['view_faktur', 'add_faktur', 'edit_faktur', 'delete_faktur', 'print_faktur'],
                },
            ],
            checkedPermissions: [],
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
                axios.post('/group', {
                        name: this.name,
                        permission: this.checkedPermissions,
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
                                window.location.href = '/group';
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