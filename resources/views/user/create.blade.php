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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Tambah User</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">User</a>
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
                <h3 class="card-title">Form User</h3>
            </div>
            <!--begin::Form-->
            <form class="form" autocomplete="off" @submit.prevent="submitForm">
                <div class="card-body">
                    <div class="alert alert-custom alert-light-primary fade show mb-5" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">Password akan dienkripsi dan tidak dapat dilihat setelah user tersimpan</div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="ki ki-close"></i></span>
                            </button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>Nama:<span class="text-danger">*</span></label>
                            <input v-model="name" type="text" class="form-control" placeholder="Enter customer's name" required>

                        </div>
                        <div class="col-lg-6">
                            <label>Jabatan:</label>
                            <input v-model="position" type="text" class="form-control" placeholder="Enter position">

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>Jenis Kelamin:<span class="text-danger">*</span></label>
                            <select v-model="gender" class="form-control" required>
                                <option value="male">Laki-laki</option>
                                <option value="female">Perempuan</option>
                            </select>

                        </div>
                        <div class="col-lg-6">
                            <label>Telepon:</label>
                            <input v-model="phone" type="text" class="form-control" placeholder="Enter phone">

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>Username:<span class="text-danger">*</span></label>
                            <input v-model="username" type="text" class="form-control" placeholder="Enter username" required>

                        </div>
                        <div class="col-lg-6">
                            <label>Email:</label>
                            <input v-model="email" type="email" class="form-control" placeholder="Enter email">

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>Password:<span class="text-danger">*</span></label>
                            <div class="input-group mb-3">
                                <input v-model="password" :type="passwordVisible ? 'text' : 'password'" class="form-control" placeholder="Enter password" required>
                                <div class="input-group-append">
                                    <button type="button" @click="togglePasswordVisibility('passwordVisible')" class="btn btn-outline-secondary" type="button"><i :class="'fas ' + (passwordVisible ? 'fa-eye-slash' : 'fa-eye')"></i></button>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <label>Konfirmasi Password:<span class="text-danger">*</span></label>
                            <div class="input-group mb-3">
                                <input v-model="confirmPassword" :type="confirmPasswordVisible ? 'text' : 'password'" class="form-control" placeholder="Confirm password" required>
                                <div class="input-group-append">
                                    <button type="button" @click="togglePasswordVisibility('confirmPasswordVisible')" class="btn btn-outline-secondary" type="button"><i :class="'fas ' + (confirmPasswordVisible ? 'fa-eye-slash' : 'fa-eye')"></i></button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>Group:<span class="text-danger">*</span></label>
                            <select class="form-control" v-model="group" required>
                                <option value="">Pilih Group</option>
                                @foreach($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
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
            position: '',
            gender: 'male',
            phone: '',
            username: '',
            email: '',
            password: '',
            confirmPassword: '',
            group: '',
            passwordVisible: false,
            confirmPasswordVisible: false,
            loading: false,
        },
        methods: {
            submitForm: function() {
                this.sendData();
            },
            sendData: function() {
                // console.log('submitted');
                let vm = this;

                if (vm.password !== vm.confirmPassword) {
                    return Swal.fire(
                        'Oops!',
                        'Konfirmasi pasword tidak sesuai',
                        'warning'
                    )
                }

                vm.loading = true;
                axios.post('/user', {
                        name: vm.name,
                        position: vm.position,
                        gender: vm.gender,
                        phone: vm.phone,
                        username: vm.username,
                        email: vm.email,
                        password: vm.password,
                        group: vm.group,
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
                                window.location.href = '/user';
                            }
                        })
                        // console.log(response);
                    })
                    .catch(function(error) {
                        vm.loading = false;
                        const {
                            data
                        } = error.response;
                        if (data.error_type == 'validation') {
                            Swal.fire(
                                'Oops!',
                                data.message,
                                'warning'
                            )
                        } else {
                            Swal.fire(
                                'Oops!',
                                'Something wrong',
                                'error'
                            )
                        }
                        console.log(error);
                    });
            },
            togglePasswordVisibility: function(data) {
                this[data] = !this[data];
            },
        }
    })
</script>
@endsection