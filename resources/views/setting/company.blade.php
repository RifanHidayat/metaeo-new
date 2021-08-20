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
                        <a href="" class="text-muted">Perusahaan</a>
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
                    <h1>Perusahaan</h1>
                    <form class="form" @submit.prevent="sendData">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nama Perusahaan:</label>
                                <input type="text" v-model="name" class="form-control form-control-solid" placeholder="Masukkan nama perusahaan" />
                                <span class="form-text text-muted">Please enter company name</span>
                            </div>
                            <div class="form-group">
                                <label>Telepon:</label>
                                <input type="text" v-model="phone" class="form-control form-control-solid" placeholder="Masukkan telepon perusahaan" />
                                <span class="form-text text-muted">Please enter company phone</span>
                            </div>
                            <div class="form-group">
                                <label>Fax:</label>
                                <input type="text" v-model="fax" class="form-control form-control-solid" placeholder="Masukkan fax perusahaan" />
                                <span class="form-text text-muted">Please enter company fax</span>
                            </div>
                            <div class="form-group">
                                <label>Penandatangan:</label>
                                <input type="text" v-model="head" class="form-control form-control-solid" placeholder="Masukkan nama penandatangan" />
                                <span class="form-text text-muted">Please enter head of company</span>
                            </div>
                            <div class="form-group">
                                <label>Alamat:</label>
                                <textarea v-model="address" class="form-control form-control-solid" placeholder="Masukkan alamat perusahaan"></textarea>
                                <span class="form-text text-muted">Please enter company address</span>
                            </div>
                            <div class="form-group">
                                <label>Logo Perusahaan (Max. 2MB)</label>
                                <div></div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile" ref="fileUpload" v-on:change="handleFileUpload" accept=".jpg, .jpeg, .png">
                                    <label ref="fileUploadLabel" id="file-upload-label" class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                                <p v-if="previewFile.size !== '' && previewFile.size > (2048 * 1000)"><i class="flaticon-warning text-warning"></i> Ukuran file max. 2 MB. File tidak akan terkirim</p>
                            </div>
                            <div v-if="file">
                                <div class="card card-custom gutter-b card-stretch">
                                    <div class="card-body">
                                        <div class="d-flex flex-column align-items-center">
                                            <!--begin: Icon-->
                                            <img alt="" class="max-h-100px" :src="imageSource">
                                            <!--end: Icon-->
                                            <!--begin: Tite-->
                                            <span href="#" class="text-dark-75 font-weight-bold mt-5 font-size-lg">@{{ previewFile.name }}</span>
                                            <a href="#" @click.prevent="removeFile" class="d-block text-danger font-weight-bold">Remove</a>
                                            <!--end: Tite-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" :class="loading && 'spinner spinner-white spinner-right'" :disabled="loading">
                                Simpan
                            </button>
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
                name: '{{ $company->name }}',
                phone: '{{ $company->phone }}',
                fax: '{{ $company->fax }}',
                head: '{{ $company->head }}',
                address: '{{ $company->address }}',
                file: '{{ $company->logo }}',
                previewFile: {
                    name: '',
                    size: '',
                    type: '',
                },
                imageSource: `{{ $company->logo !== null ? Storage::disk('s3')->url($company->logo) : '' }}`,
                loading: false,
            },
            methods: {
                handleFileUpload: function() {
                    let file = this.$refs.fileUpload.files[0];

                    if (!file) {
                        this.$refs.fileUpload.value = '';
                        // this.resetFileUploadLabel();
                        return;
                    }

                    const MAX_SIZE = 2.048;
                    const MULTIPLIER = 1000000;

                    console.log(file);
                    if (file.size > MAX_SIZE * MULTIPLIER) {
                        this.$refs.fileUpload.value = '';
                        this.resetFileUploadLabel();
                        // document.getElementById('file-upload-label').innerHTML = 'Choose file';
                        toastr.warning("Ukuran file max. 2MB");
                        return;
                    }

                    this.$refs.fileUploadLabel.innerHTML = file.name;

                    this.previewFile.name = file.name;
                    this.previewFile.size = file.size;
                    let splittedFileName = file.name.split('.');
                    this.previewFile.type = splittedFileName[splittedFileName.length - 1];
                    this.file = file;
                    this.imageSource = URL.createObjectURL(file);
                },
                removeFile: function() {
                    this.file = '';
                    this.$refs.fileUpload.value = '';
                    this.resetFileUploadLabel();
                    // Object.keys(this.previewFile).forEach(function(index) {
                    //     this.previewFile[index] = '';
                    // });
                },
                resetFileUploadLabel: function() {
                    this.$refs.fileUploadLabel.classList.remove('selected');
                    this.$refs.fileUploadLabel.innerHTML = 'Choose file';
                },
                submitForm: function() {
                    this.sendData();
                },
                sendData: function() {
                    // console.log('submitted');
                    let vm = this;
                    vm.loading = true;

                    const data = {
                        name: vm.name,
                        phone: vm.phone,
                        fax: vm.fax,
                        head: vm.head,
                        address: vm.address,
                        logo: vm.file,
                    };

                    let formData = new FormData();
                    for (var key in data) {
                        formData.append(key, data[key]);
                    }

                    axios.post('/company/{{ $company->id }}', formData)
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