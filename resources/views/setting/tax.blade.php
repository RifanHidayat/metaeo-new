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
                        <a href="" class="text-muted">Pajak</a>
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
                    <h1>Pajak</h1>
                    <form class="form" @submit.prevent="sendData">
                        <div class="card-body">
                        <div class="row form-group col-lg-6">
                            <label>PPN: <span class="text-danger">*</span></label>
                             <div class="input-group">
                                                        <input type="text" v-model="ppnValue" class="form-control text-right" placeholder="Tarif PP N" >
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><strong class="text-dark-50">%</strong></span>
                                                        </div>
                                                    </div>
                   </div>
                    

                      <div class="row form-group col-lg-6">
                            <label>PPh21: <span class="text-danger">*</span></label>
                             <div class="input-group">
                              <input type="text" v-model="pph21Value" class="form-control text-right" placeholder="Tarif PPh21" >
                            <div class="input-group-append">
                                            <span class="input-group-text"><strong class="text-dark-50">%</strong></span>
                                                        </div>
                                                    </div>
                   </div>

                       <div class="row form-group col-lg-6">
                            <label>PPh23: <span class="text-danger">*</span></label>
                             <div class="input-group">
                             <input type="text" v-model="pph23Value" class="form-control text-right" placeholder="Tarif PPh23" >
                            <div class="input-group-append">
                                                            <span class="input-group-text"><strong class="text-dark-50">%</strong></span>
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
                ppnValue:'{!!$tax->ppn_value!!}',
                pph23Value:  '{!!$tax->pph23_value!!}',
                pph21Value:  '{!!$tax->pph21_value!!}',
                tax_id: '{!!$tax->tax_id!!}',
                previewFile: {
                    name: '',
                    size: '',
                    type: '',
                },
                
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
                    this.oldFile = '';
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
                        ppn_value: vm.ppnValue,
                        pph21_value: vm.pph21Value,
                        pph23_value: vm.ppn23Value,
                      
                    };

                    axios.patch('/tax/{{ $tax->id }}',  {
                        ppn_value: vm.ppnValue,
                        pph21_value: vm.pph21Value,
                        pph23_value: vm.pph23Value,
                      
                    })
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