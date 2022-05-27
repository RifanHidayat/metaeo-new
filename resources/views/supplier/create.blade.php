@extends('layouts.app')

@section('title', 'Metaprint')

@section('head')
<link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css">
<script src="https://cdn.rawgit.com/igorescobar/jQuery-Mask-Plugin/1ef022ab/dist/jquery.mask.min.js"></script>
@endsection

@section('subheader')
<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
  <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
    <!--begin::Info-->
    <div class="d-flex align-items-center flex-wrap mr-1">
      <!--begin::Page Heading-->
      <div class="d-flex align-items-baseline flex-wrap mr-5">
        <!--begin::Page Title-->
        <h5 class="text-dark font-weight-bold my-1 mr-5">Tambah Supplier</h5>
        <!--end::Page Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
          <li class="breadcrumb-item">
            <a href="/dashboard" class="text-muted">Dashboard</a>
          </li>
          <li class="breadcrumb-item">
            <a href="/supplier" class="text-muted">Supplier</a>
          </li>
          <li class="breadcrumb-item">
            <a href="/supplier/create" class="text-muted">Tambah</a>
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
        <h3 class="card-title">Form Supplier</h3>

      </div>
      <!--begin::Form-->
      <form class="form" autocomplete="off" @submit.prevent="submitForm">
        <div class="card-body ">
       
            <!-- <div class="form-group col-lg-6">
              {{-- <div class=""> --}}
                <label>Number:</label>
                
                <input v-model="number" type="text" class="form-control" disabled>
              {{-- </div> --}}
              </div> -->
              <div class="section-block m-0 mb-4">
                  <h3 class="section-title">Informasi Perusahaan</h3>
                  
                </div>
                 <div class="form-group col-md-4">
                                                    <label class="checkbox">
                                                        <input v-model="isIndividual" type="checkbox">
                                                        <span></span>&nbsp;
                                                        Ya, Penjual jasa orang pribadi (Dikenakan PPh 21)
                                                    </label>
                                                </div>

               <div class="form-row col-8" >
                  <div class="form-group col-lg-6">
                      <label>Divisi: <span class="text-danger">*</span></label>
                       <select v-model="divisionId"  class="form-control"    required >
                         <option selected>Pilih divisi supplier</option>
                           
                            <option v-for="(division,index) in divisions" v-bind:value="division.id" >@{{division.name}}</option>                                             
                            </select>
                   </div>
                  <div class="form-group col-lg-6">
                      <label>Nama: <span class="text-danger">*</span></label>
                      <input v-model="name" type="text" class="form-control" >
                      <!-- <span class="form-text text-muted">Please enter supplier's name</span> -->
                   </div>                  
                </div>

                  <div class="form-row col-8" >
                  <div class="form-group col-lg-6">
                      <label>Email kantor:</label>
                      <input v-model="email" type="text" class="form-control">
                     
                   </div>
                  <div class="form-group col-lg-6">
                      <label>No. Telp kantor:</label>
                      <input v-model="telephone" type="text" class="form-control">
                      <!-- <span class="form-text text-muted">Please enter supplier's name</span> -->
                   </div>
                      
                </div>
                 <div class="form-row col-8" >
                 
                  <div class="form-group col-lg-6">
                      <label>No. Handphone Kantor:</label>
                      <input v-model="handphone" type="text" class="form-control">
                      <!-- <span class="form-text text-muted">Please enter supplier's name</span> -->
                   </div>
                      
                </div>
                    <div class="form-row col-8" >
                  <div class="form-group col-lg-12">
                      <label>Alamat Kantor:</label>
                      <textarea v-model="address" type="text" class="form-control"  rows="4"></textarea>
                     
                   </div>
                  
                      
                </div>
                  <div class="form-row col-8" >
                 
                  <div class="form-group col-lg-12">
                      <label>No. NPWP:</label>
                      <input v-model="npwpNumber" type="text" class="form-control npwp" >
                      <!-- <span class="form-text text-muted">Please enter supplier's name</span> -->
                   </div>
                      
                </div>
                 <div class="form-row col-8" >
                  <div class="form-group col-lg-12">
                      <label>Alamat NPWP:</label>
                      <textarea v-model="npwpAddress" type="text" class="form-control"  rows="4"></textarea>
                     
                   </div>
                  
                      
                </div>
                

                
 
   
     

          <!-- begin: Example Code-->

          <!-- end: Example Code-->
        </div>
           <div class="card-body border-top">
       
            <!-- <div class="form-group col-lg-6">
              {{-- <div class=""> --}}
                <label>Number:</label>
                
                <input v-model="number" type="text" class="form-control" disabled>
              {{-- </div> --}}
              </div> -->
              <div class="section-block m-0 mb-4">
                  <h3 class="section-title">Informasi Kontak</h3>
                  
                </div>

               
                    
                 
               
                  <div class="form-row col-8" >
                  <div class="form-group col-lg-6">
                      <label>Nama  lengkap:</label>
                      <input v-model="contactName" type="text" class="form-control" >
                     
                   </div>
                  <div class="form-group col-lg-6">
                      <label>Jabatan:</label>
                      <input v-model="contactPosition" type="text" class="form-control" >
                      <!-- <span class="form-text text-muted">Please enter supplier's name</span> -->
                   </div>  
                </div>

                  <div class="form-row col-8" >
                  <div class="form-group col-lg-6">
                      <label>Email:</label>
                      <input v-model="contactEmail" type="text" class="form-control" >
                     
                   </div>
                  <div class="form-group col-lg-6">
                      <label>Hanphone:</label>
                      <input v-model="contactNumber" type="text" class="form-control" >
                      <!-- <span class="form-text text-muted">Please enter supplier's name</span> -->
                   </div>
                      
                </div>
                   <div class="form-row col-8" >
                  <div class="form-group col-lg-12">
                      <label>Alamat:</label>
                      <textarea v-model="contactAddress" type="text" class="form-control"  rows="4"></textarea>
                     
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
      divisionId:'',
      number: '{{ $number }}',
      name: '',
      address: '',
      telephone: '',
      handphone: '',
      email: '',
      npwpNumber:'',
      npwpAddress:"",


       contactName: '',
      contactAddress: '',
      contactPosition: '',
      contactNumber: '',
      contactEmail: '',
      isIndividual:'',

      divisions:JSON.parse('{!! $divisions !!}'),
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
        axios.post('/supplier', {
            division_id:this.divisionId,
            number: this.number,
            name: this.name,
            address: this.address,
            telephone: this.telephone,
            handphone: this.handphone,
            email: this.email,
            is_individual:this.isIndividual,
            npwp_number:this.npwpNumber,
            npwp_address:this.npwpAddress,
            contact_name: this.contactName,
            contact_address: this.contactAddress,
            contact_telephone: this.contactTelephone,
            contact_number: this.contactNumber,
            contact_email: this.contactEmail,
            contact_position: this.contactPosition,
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
                window.location.href = '/supplier';
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

<script>
  $(document).ready(function(){

    // // Format mata uang.
    // $( '.uang' ).mask('0.000.000.000', {reverse: true});

    // // Format nomor HP.
    // $( '.no_hp' ).mask('0000−0000−0000');

    // Format tahun pelajaran.
    $( '.npwp' ).mask('00.000.000.0-000.000');
})
</script>


@endsection