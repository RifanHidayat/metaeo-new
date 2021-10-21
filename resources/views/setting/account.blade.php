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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Pengaturan</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Setting</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Account</a>
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
<div class="card card-custom" id="app">
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
                    <h1>Akun</h1>
                    <h3><i class="flaticon2-user-1 text-dark-75 icon-lg"></i> Informasi Pengguna</h3>
                    <form class="form" @submit.prevent="sendData">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nama:</label>
                                <input type="text" v-model="name" class="form-control form-control-solid" placeholder="Masukkan nama" />
                                <span class="form-text text-muted">Please enter name</span>
                            </div>
                            <div class="form-group">
                                <label>Jabatan:</label>
                                <input type="text" v-model="position" class="form-control form-control-solid" placeholder="Masukkan jabatan" />
                                <span class="form-text text-muted">Please enter positin</span>
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin:</label>
                                <select v-model="gender" class="form-control form-control-solid">
                                    <option value="male">Laki-laki</option>
                                    <option value="female">Perempuan</option>
                                </select>
                                <span class="form-text text-muted">Please enter gender</span>
                            </div>
                            <div class="form-group">
                                <label>Telepon:</label>
                                <input type="text" v-model="phone" class="form-control form-control-solid" placeholder="Masukkan nomor telepon" />
                                <span class="form-text text-muted">Please enter phone number</span>
                            </div>
                            <div class="form-group">
                                <label>Email:</label>
                                <input type="email" v-model="email" class="form-control form-control-solid" placeholder="Masukkan email" />
                                <span class="form-text text-muted">Please enter email</span>
                            </div>
                            <button type="submit" class="btn btn-primary" :class="loading && 'spinner spinner-white spinner-right'" :disabled="loading">
                                Simpan
                            </button>
                        </div>

                        <!-- <button type="reset" class="btn btn-secondary">Cancel</button> -->
                        <div class="card-footer">
                        </div>
                    </form>
                    <h3><i class="flaticon2-lock text-dark-75 icon-lg"></i> Informasi Keamanan</h3>
                    <form class="form" @submit.prevent="updateAccount">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Username:</label>
                                <input type="text" v-model="username" class="form-control form-control-solid" placeholder="Masukkan username" />
                                <!-- <span class="form-text text-muted">Please enter username</span> -->
                            </div>
                            <div class="form-group">
                                <label>Password Baru: (Kosongkan jika tidak diubah)</label>
                                <input type="password" v-model="password" class="form-control form-control-solid" placeholder="" />
                                <!-- <span class="form-text text-muted">Please enter password</span> -->
                            </div>
                            <div class="form-group">
                                <label>Konfirmasi Password:</label>
                                <input type="password" v-model="confirmPassword" class="form-control form-control-solid" placeholder="" />
                                <!-- <span class="form-text text-muted">Please enter password</span> -->
                            </div>
                            <div class="form-group">
                                <label>Password:</label>
                                <input type="password" v-model="currentPassword" class="form-control form-control-solid" placeholder="" required />
                                <!-- <span class="form-text text-muted">Please enter password</span> -->
                            </div>
                            <button type="submit" class="btn btn-primary" :class="loading && 'spinner spinner-white spinner-right'" :disabled="loading">
                                Simpan
                            </button>
                        </div>
                        <div class="card-footer">

                            <!-- <button type="reset" class="btn btn-secondary">Cancel</button> -->
                        </div>
                    </form>
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
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        let app = new Vue({
            el: '#app',
            data: {
                name: '{{ $user->name }}',
                position: '{{ $user->position }}',
                gender: '{{ $user->gender }}',
                phone: '{{ $user->phone }}',
                email: '{{ $user->email }}',
                username: '{{ $user->username }}',
                password: '',
                confirmPassword: '',
                currentPassword: '',
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

                    const data = {
                        name: vm.name,
                        position: vm.position,
                        gender: vm.gender,
                        phone: vm.phone,
                        email: vm.email,
                    };

                    axios.post('/user/action/update-info/{{ $user->id }}', data)
                        .then(function(response) {
                            vm.loading = false;
                            toastr.success("Perubahan telah disimpan");
                            // Swal.fire({
                            //     title: 'Success',
                            //     text: 'Data has been saved',
                            //     icon: 'success',
                            //     allowOutsideClick: false,
                            // }).then((result) => {
                            //     if (result.isConfirmed) {
                            //         // window.location.href = '/sales-order';
                            //     }
                            // })
                            // console.log(response);
                        })
                        .catch(function(error) {
                            vm.loading = false;
                            console.log(error);
                            toastr.error("Perubahan gagal disimpan");
                            // Swal.fire(
                            //     'Oops!',
                            //     'Something wrong',
                            //     'error'
                            // )
                        });
                },

                updateAccount: function() {
                    let vm = this;
                    if ((vm.password !== '' && vm.password !== null) || (vm.confirmPassword !== '' && vm.confirmPassword !== null)) {
                        if (vm.password !== vm.confirmPassword) {
                            toastr.warning("Konfirmasi password tidak sesuai");
                            return;
                        }
                    }

                    vm.loading = true;

                    const data = {
                        username: vm.username,
                        password: vm.password,
                        current_password: vm.currentPassword,
                    };

                    axios.post('/user/action/update-account/{{ $user->id }}', data)
                        .then(function(response) {
                            vm.loading = false;
                            toastr.success("Perubahan telah disimpan");
                            setTimeout(() => {
                                window.location.reload();
                            }, 500)
                            // Swal.fire({
                            //     title: 'Success',
                            //     text: 'Data has been saved',
                            //     icon: 'success',
                            //     allowOutsideClick: false,
                            // }).then((result) => {
                            //     if (result.isConfirmed) {
                            //         // window.location.href = '/sales-order';
                            //     }
                            // })
                            // console.log(response);
                        })
                        .catch(function(error) {
                            vm.loading = false;
                            console.log(error);
                            const {
                                data
                            } = error.response;
                            toastr.error(data.message);
                        });
                }
            }
        })
    </script>
    <script>
        $(function() {

            $('#company-logo').dropzone({
                url: "https://keenthemes.com/scripts/void.php", // Set the url for your upload script location
                paramName: "file", // The name that will be used to transfer the file
                maxFiles: 1,
                maxFilesize: 5, // MB
                addRemoveLinks: true,
                accept: function(file, done) {
                    if (file.name == "justinbieber.jpg") {
                        done("Naha, you don't.");
                    } else {
                        done();
                    }
                }
            });
        })
    </script>
    @endsection