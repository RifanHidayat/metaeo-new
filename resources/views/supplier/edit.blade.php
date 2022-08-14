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
        <h5 class="text-dark font-weight-bold my-1 mr-5">Edit Supplier</h5>
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
            <a href="/supplier/create" class="text-muted">Edit</a>
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

<div class="modal fade" id="supplierAccountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form"  @submit.prevent="addSupplierAccount">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">No rekening:</label>
            <input v-model="supplierAccountNumber" type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Nama Pemilik:</label>
       <input v-model="supplierAccountName" type="text" class="form-control" id="recipient-name">
          </div>
           <div class="form-group">
            <label for="message-text" class="col-form-label">Nama Bank:</label>
          <input v-model="supplierAccountBankName" type="text" class="form-control" id="recipient-name">
          </div>
           <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" :class="loading && 'spinner spinner-white spinner-right'" :disabled="loading">
                Save
              </button>
      </div>
        </form>
      </div>
     
    </div>
  </div>
</div>
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
                   <div class="form-row col-8">
                        <div class="form-group col-lg-6">
                         <label>Status:</label>
                                <select v-model="isActive" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">In Active</option>
                                    
                                </select>
                        </div>
                      
                        
                        </div>
                

               <div class="form-row col-8" >
                  <div class="form-group col-lg-6">
                      <label>Divisi: <span class="text-danger">*</span></label>
                       <select  name="division" id="division-ids" multiple="multiple"   class="form-control division"    required >

                           
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

                 <div class="card-body border-top">

              <div class="section-block m-0 mb-4">
                  <h3 class="section-title">Informasi Pajak</h3>
                  
                </div>

                  <div class="form-group col-lg-8">
                      <label>No. NPWP:</label>
                      <input v-model="npwpNumber" type="text" class="form-control npwp" >
                      <!-- <span class="form-text text-muted">Please enter supplier's name</span> -->
                   </div>
                   <div class="form-group col-lg-8">
                      <label>Jenis Dokumen:</label>
                      <select  class="form-control" v-model="supplierTaxId">
                        <option v-for="(tax,index) in supplierTax" :value='tax.id'>
                            @{{tax.name}}

                        </option>
                      </select>
                      <!-- <input v-model="npwpNumber" type="text" class="form-control npwp" > -->
                      <!-- <span class="form-text text-muted">Please enter supplier's name</span> -->
                   </div>
                   <div class="form-group col-lg-8">
                      <label>Jenis Transaksi</label>
                       <select class="form-control" v-model="supplierTaxItemId">
                        <option v-for="(taxItem,index) in supplierTaxItem" :value='taxItem.id'>
                            @{{taxItem.name}}

                        </option>
                      </select>
                   </div>
                      <div class="form-row col-8" >
                  <div class="form-group col-lg-12">
                      <label>Alamat NPWP:</label>
                      <textarea v-model="npwpAddress" type="text" class="form-control"  rows="4"></textarea>
                     
                   </div>
                  
                      
                </div>
                      
                </div>
                

              <div class="card-body border-top">

              <div class="section-block m-0 mb-4">
                  <h3 class="section-title">Informasi Pembelian</h3>
                  
                </div>

                  <div class="form-group col-lg-8">
                      <label>Akun Hutang:</label>
                      <select class="form-control" v-model="hutangId" >
                        <option v-for="(account,index) in accounts" :value="account.id">
                           @{{account.number}} -  @{{account.name}}
                       
                        </option>
                      </select>
                      <!-- <span class="form-text text-muted">Please enter supplier's name</span> -->
                   </div>
                   <div class="form-group col-lg-8">
                      <label>Akun Piutang:</label>
                      <select class="form-control" v-model="piutangId">
                        <option v-for="(account,index) in accounts"  :value="account.id">
                           @{{account.number}} -  @{{account.name}}
                       
                        </option>
                      </select>
                      <!-- <span class="form-text text-muted">Please enter supplier's name</span> -->
                   </div>
                   <div class="form-group col-lg-8">
                     <div class="col-lg-12 flex-row" >
                        <label>Rekening Asset Bank</label>
                     <div class="text-right">
                       <a type="button" class="btn btn-success" data-toggle="modal" data-target="#supplierAccountModal" ><i class="flaticon2-plus"></i> Tambah</a>
                      </div>
                     </div>
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <td>
                              No Rekening
                            </td>
                            <td>
                              Atas Nama

                            </td>
                            <td>
                              Nama Bank

                            </td>
                             <td>
                              Aksi

                            </td>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(account,index) in supplierAccounts">
                            <td>@{{account.number}}</td>
                            <td>@{{account.name}}</td>
                            <td>@{{account.bank_name}}</td>
                            <td align="center">
                               <a type="button" class="btn btn-danger" @click="removeItem(index)" ></i>Hapus</a>
                            </td>
                          </tr>
                          
                        </tbody> 
                      </table> 
                      <!-- <span class="form-text text-muted">Please enter supplier's name</span> -->
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
      divisionId:'{{ $supplier->division_id }}',
    
      name: '{{ $supplier->name }}',
      address: '{{ $supplier->address }}',
      telephone: '{{ $supplier->telephone}}',
      handphone: '{{ $supplier->handphone }}',
      email: '{{ $supplier->email }}',
      npwpNumber:'{{ $supplier->npwp_number }}',
      npwpAddress:"{{ $supplier->npwp_address }}",
      isIndividual:parseInt("{{$supplier->is_individual}}"),
      supplierTaxItem:JSON.parse('{!!$supplier_tax_item!!}'), 
      supplierTax:JSON.parse('{!!$supplier_tax!!}'),

       contactName: '{{ $supplier->contact_name }}',
      contactAddress:'{{ $supplier->contact_address }}',
      contactPosition: '{{ $supplier->contact_position }}',
      contactNumber: '{{ $supplier->number  }}',
      contactEmail: '{{ $supplier->contact_email  }}',
      accounts:JSON.parse('{!!$accounts!!}'),

      divisions:JSON.parse('{!! $divisions !!}'),
      
      id:'{{$supplier->id}}',
      loading: false,
      supplierAccounts:JSON.parse('{!!$supplier_account!!}'),
      supplierAccountName:"",
      supplierAccountBankName:"",
      supplierAccountNumber:'',
      hutangId:'{{$supplier->supplier_tax_id}}',
      piutangId:'{{$supplier->piutang_id}}',
      supplierTaxId:'{{$supplier->supplier_tax_id}}',
      supplierTaxItemId:'{{$supplier->supplier_tax_item_id}}',
      isActive:'{{$supplier->is_active}}'
    },
    methods: {
      submitForm: function() {
        this.sendData();
      },
      addSupplierAccount:function(){
     
        this.supplierAccounts.push({
          "number":this.supplierAccountNumber,
          "name":this.supplierAccountName,
          'bank_name':this.supplierAccountBankName
        })
        $('#supplierAccountModal').modal('hide');

      },
      sendData: function() {
        // console.log('submitted');
        let vm = this;
        vm.loading = true;
        axios.patch('/supplier/'+this.id, {
            division_ids:$('#division-ids').val(),
            number: this.number,
            name: this.name,
            address: this.address,
            telephone: this.telephone,
            handphone: this.handphone,
            email: this.email,
            npwp_number:this.npwpNumber,
            npwp_address:this.npwpAddress,
            is_individual:this.isIndividual, 
            contact_name: this.contactName,
            contact_address: this.contactAddress,
            contact_telephone: this.contactTelephone,
            contact_number: this.contactNumber,
            contact_email: this.contactEmail,
            contact_position: this.contactPosition,
            hutang_id:this.hutangId,
            piutang_id:this.piutangId,
            supplier_accounts:this.supplierAccounts,
            supplier_tax_id:this.supplierTaxId,
            supplier_tax_item_id:this.supplierTaxItemId,
            is_active:this.isActive
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
      $('.division').select2();

    // // Format mata uang.
    // $( '.uang' ).mask('0.000.000.000', {reverse: true});

    // // Format nomor HP.
    // $( '.no_hp' ).mask('0000−0000−0000');

    // Format tahun pelajaran.
    $( '.npwp' ).mask('00.000.000.0-000.000');
})
</script>


  
@endsection