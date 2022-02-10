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
        <h5 class="text-dark font-weight-bold my-1 mr-5">Tamba Subitem</h5>
        <!--end::Page Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
          <li class="breadcrumb-item">
            <a href="" class="text-muted">Dashboard</a>
          </li>
          <li class="breadcrumb-item">
            <a href="" class="text-muted">Item</a>
          </li>
          <li class="breadcrumb-item">
            <a href="" class="text-muted">Manage</a>
          </li>

          <li class="breadcrumb-item">
            <a href="" class="text-muted">Subitem</a>
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
        <h3 class="card-title">Form Subitem</h3>

      </div>
      <!--begin::Form-->
      <form class="form" autocomplete="off" @submit.prevent="submitForm">
        <div class="card-body">
          <div class="form-group">
            <div class="col-lg-6">
              <label>Nama:<span class="text-danger">*</span></label>
              <input v-model="name" type="text" class="form-control" placeholder="Enter item's name" required>
             <span class="form-text text-muted">Please enter subitem's name</span>
            </div>
            <div class="col-lg-6">
              <label>Satuan Quantity:<span class="text-danger">*</span></label></label>
              <input v-model="unitFrequency" type="text" class="form-control" placeholder="Enter subitem's unit quantity" required>
              <span class="form-text text-muted">Please enter subitem's unit quantity</span>
            </div>
              <div class="col-lg-6">
              <label>Satuan Frekuensi:<span class="text-danger">*</span></label></label>
           <input v-model="unitQuantity" type="text" class="form-control" placeholder="Enter subitem's unit frequency" required>
              <span class="form-text text-muted">Please enter subitem's unit frequency</span>
            </div>
             <div class="col-lg-6">
              <label>status:<span class="text-danger">*</span></label></label>
            <select class="form-control" aria-label="Default select example" v-model="isActive">
                <option value="1" selected>Active</option>
                <option value="0">In Active</option>
            </select>
              <span class="form-text text-muted">Please enter subitem's status</span>
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
<script src="{{ asset('js/pages/crud/forms/widgets/select2.js') }}"></script>
@endsection

@section('pagescript')
<script type="text/x-template" id="select2-template">
  <select>
        <slot></slot>
    </select>
</script>
<script>



  let app = new Vue({
    el: '#app',
    data: {
      name: '',
      uniQuantity: '',
      unitFrequency: '',
      isStock:'',
      isActive:1,
    
    
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
        axios.post('/quotation-item/{{$item->id}}/subitem', {
            name: vm.name,
            unit_quantity: vm.unitQuantity,
            unit_frequency:vm.unitFrequency,
            status:vm.isActive,
            is_stock:0,
            product_id:0,
            item_id:'{{$item->id}}',
            is_active:vm.isActive

        
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
                window.location.href = '/quotation-item/{{$item->id}}/subitem';
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