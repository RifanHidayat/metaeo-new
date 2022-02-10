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
        <h5 class="text-dark font-weight-bold my-1 mr-5">Tambah PIC Event</h5>
        <!--end::Page Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
          <li class="breadcrumb-item">
            <a href="" class="text-muted">Dashboard</a>
          </li>
          <li class="breadcrumb-item">
            <a href="" class="text-muted">PIC Event</a>
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
        <h3 class="card-title">Form PIC Event</h3>

      </div>
      <!--begin::Form-->
      <form class="form" autocomplete="off" @submit.prevent="submitForm">
        <div class="card-body">
          <div class="form-group row">
            <div class="col-lg-6">
              <label>Nama:<span class="text-danger">*</span></label>
              <input v-model="name" type="text" class="form-control" placeholder="Enter pic's name" required>
              <span class="form-text text-muted">Please enter pic's name</span>
            </div>
            <div class="col-lg-6">
              <label>Jabatan:</label>
              <input v-model="position" type="text" class="form-control" placeholder="Enter pic's position">
              <span class="form-text text-muted">Please enter pic's position (Optional)</span>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-lg-6">
              <label>Telepon:<span class="text-danger">*</span></label>
              <input v-model="phone" type="text" class="form-control" placeholder="Enter pic's contact number">
              <span class="form-text text-muted">Please enter pic's contact number (Optional)</span>
            </div>
            <div class="col-lg-6">
              <label>Email:</label>
              <input v-model="email" type="email" class="form-control" placeholder="Enter pic's email">
              <span class="form-text text-muted">Please enter pic's email (Optional)</span>
            </div>
          </div>
          <div class="form-group">
            <label>Customer:<span class="text-danger">*</span></label>
            <select2 v-model="customerId" :options="customers" class="form-control" required>
            </select2>
            <span class="form-text text-muted">Please enter customer</span>
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
  Vue.component("select2", {
    props: ["options", "value"],
    template: "#select2-template",
    mounted: function() {
      var vm = this;
      $(this.$el)
        // init select2
        .select2({
          data: this.options
        })
        .val(this.value)
        .trigger("change")
        // emit event on change.
        .on("change", function() {
          vm.$emit("input", this.value);
        });
    },
    watch: {
      value: function(value) {
        // update value
        $(this.$el)
          .val(value)
          .trigger("change");
      },
      options: function(options) {
        // update options
        $(this.$el)
          .empty()
          .select2({
            data: options
          });
      }
    },
    destroyed: function() {
      $(this.$el)
        .off()
        .select2("destroy");
    }
  });


  let app = new Vue({
    el: '#app',
    data: {
      name: '',
      phone: '',
      position: '',
      email: '',
      customerId: '',
      customers: JSON.parse('{!! $customers !!}'),
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
        axios.post('/pic-event', {
            name: this.name,
            phone: this.phone,
            email: this.email,
            position: this.position,
            customer_id: this.customerId,
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
                window.location.href = '/pic-event';
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