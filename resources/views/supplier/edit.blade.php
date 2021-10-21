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
        <h3 class="card-title">Form Supplier</h3>

      </div>
      <!--begin::Form-->
      <form class="form" autocomplete="off" @submit.prevent="submitForm">
        <div class="card-body">
            <div class="form-group">
                <label>Number:</label>
                <input v-model="number" id="number" type="text" class="form-control" placeholder="Enter supplier's number">
                <span class="form-text text-muted">Please enter supplier's number</span>
              </div>
              <div class="form-group">
                <label>Name:</label>
                <input v-model="name" id="name" type="text" class="form-control" placeholder="Enter supplier's name">
                <span class="form-text text-muted">Please enter supplier's name</span>
              </div>

              <div class="form-group">
                <label>Address:<span class="text-danger">*</span></label>
                <textarea v-model="address" id="address" class="form-control" rows="3" required placeholder="Enter supplier's address"></textarea>
                <span class="form-text text-muted">Please enter supplier's address</span>
              </div>
          <div class="form-group row">
            <div class="col-lg-6">
              <label>Telephone:<span class="text-danger">*</span></label>
              <input v-model="telephone" id="telephone" type="text" class="form-control" placeholder="Enter supplier's telephone" required>
              <span class="form-text text-muted">Please enter supplier's telephone</span>
            </div>
            <div class="col-lg-6">
              <label>Handphone:</label>
              <input v-model="handphone" id="handphone" type="text" class="form-control" placeholder="Enter supplier's handphone">
              <span class="form-text text-muted">Please enter supplier's handphone</span>
            </div>
          </div>
          <div class="form-group">
            <label>Email:<span class="text-danger">*</span></label>
            <textarea v-model="email" id="email" class="form-control" rows="3" required placeholder="Enter supplier's email"></textarea>
            <span class="form-text text-muted">Please enter supplier's email</span>
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
      number: '{{ $supplier->number }}',
      name: '{{ $supplier->name }}',
      address: '{{ $supplier->address }}',
      telephone: '{{ $supplier->telephone }}',
      handphone: '{{ $supplier->handphone }}',
      email: '{{ $supplier->email }}',
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
        axios.patch('/supplier/{{ $supplier->id }}', {
            number: this.number,
            name: this.name,
            address: this.address,
            telephone: this.telephone,
            handphone: this.handphone,
            email: this.email,
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
@endsection