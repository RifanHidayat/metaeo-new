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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Edit User</h5>
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
                        <a href="" class="text-muted">Edit</a>
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
                            <input v-model="username" type="text" class="form-control" placeholder="Enter username">

                        </div>
                        <div class="col-lg-6">
                            <label>Email:</label>
                            <input v-model="email" type="email" class="form-control" placeholder="Enter email">

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>Password:<span class="text-danger">*</span></label>
                            <input v-model="password" type="password" class="form-control" placeholder="Enter password">
                        </div>
                        <div class="col-lg-6">
                            <label>Konfirmasi Password:<span class="text-danger">*</span></label>
                            <input v-model="confirmPassword" type="password" class="form-control" placeholder="Confirm password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>Group:<span class="text-danger">*</span></label>
                            <select class="form-control" v-model="group">
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
            name: '{{ $user->name }}',
            position: '{{ $user->position }}',
            gender: '{{ $user->gender }}',
            phone: '{{ $user->phone }}',
            username: '{{ $user->username }}',
            email: '{{ $user->email }}',
            password: '',
            confirmPassword: '',
            group: '{{ $user->group_id }}',
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
                axios.patch('/user/{{ $user->id }}', {
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