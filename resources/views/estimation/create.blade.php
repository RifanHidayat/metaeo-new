@extends('layouts.app')

@section('title', 'Metaprint')

@section('head')
<link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css">
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
@endsection

@section('subheader')
<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
  <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
    <!--begin::Info-->
    <div class="d-flex align-items-center flex-wrap mr-1">
      <!--begin::Page Heading-->
      <div class="d-flex align-items-baseline flex-wrap mr-5">
        <!--begin::Page Title-->
        <h5 class="text-dark font-weight-bold my-1 mr-5">Add Estimation</h5>
        <!--end::Page Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
          <li class="breadcrumb-item">
            <a href="" class="text-muted">Dashboard</a>
          </li>
          <li class="breadcrumb-item">
            <a href="" class="text-muted">Estimation</a>
          </li>
          <li class="breadcrumb-item">
            <a href="" class="text-muted">Add</a>
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
    <div class="card card-custom card-sticky gutter-b">
      <div class="card-header ribbon ribbon-top">
        <div class="card-title">
          <h3 class="card-label">Estimation Form</h3>
        </div>
        <div class="ribbon-target bg-warning" style="top: -2px; right: 20px;">Open</div>
        <!-- <div class="card-toolbar">
          <span class="label label-xl label-light-warning label-inline">Open</span>
        </div> -->
      </div>
      <!--begin::Form-->
      <form class="form" autocomplete="off" @submit.prevent="submitForm">
        <div class="card-body">
          <div class="form-group row">
            <div class="col-lg-6"></div>
            <div class="col-lg-6">
              <label>Status:<span class="text-danger">*</span></label>
              <select v-model="status" class="form-control">
                <option value="">Open</option>
                <option value="">Closed</option>
                <option value="">Rejected</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-lg-6">
              <label>Estimated Number:</label>
              <input v-model="number" type="text" class="form-control bg-light" value="NT-786786867" required readonly>
            </div>
            <div class="col-lg-6">
              <label>Total Production (IDR):</label>
              <input v-model="totalProduction" type="text" class="form-control bg-light text-right mask-number" readonly required>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-lg-6">
              <label>Estimation Date:<span class="text-danger">*</span></label>
              <input v-model="date" type="date" class="form-control estimation-date" readonly>
            </div>
            <div class="col-lg-6">
              <label>HPP (IDR):</label>
              <input v-model="hpp" type="text" class="form-control bg-light text-right mask-number" readonly required>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-lg-6">
              <label>Customer:<span class="text-danger">*</span></label>
              <select2 v-model="customerId" :options="customers" class="form-control" required>
              </select2>
            </div>
            <div class="col-lg-6">
              <label>HPP / Unit (IDR):</label>
              <input v-model="hppPerUnit" type="text" class="form-control bg-light text-right mask-number" readonly required>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-lg-6">
              <label>PIC PO:<span class="text-danger">*</span></label>
              <select2 v-model="picId" :options="customers" class="form-control" disabled required>
              </select2>
            </div>
            <div class="col-lg-6">
              <label>Harga Jual / Unit (IDR):</label>
              <input v-model="sellPricePerUnit" type="text" class="form-control text-right mask-number" required>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-lg-6">
              <label>PIC PO Email:</label>
              <input v-model="picEmail" type="text" class="form-control bg-light" placeholder="Choose PIC PO" required readonly>
            </div>
            <div class="col-lg-6">
              <label>Margin (%):</label>
              <input v-model="margin" type="text" class="form-control bg-light text-right" value="65" readonly required>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-lg-6">
              <label>Pekerjaan:<span class="text-danger">*</span></label>
              <input v-model="work" type="text" class="form-control" placeholder="Enter Pekerjaan" required>
            </div>
            <div class="col-lg-6">
              <label>Total Harga Jual (IDR):</label>
              <input v-model="totalSellPrice" type="text" class="form-control bg-light text-right mask-number" readonly required>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-lg-6">
              <label>Total Quantity (IDR):<span class="text-danger">*</span></label>
              <input v-model="totalQuantity" type="text" class="form-control mask-number" placeholder="Enter Quantity" required>
            </div>
            <div class="col-lg-6">
              <label>PPN (IDR):</label>
              <input v-model="ppn" type="text" class="form-control bg-light text-right mask-number" readonly required>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-lg-6">
              <label>Delivery Date:<span class="text-danger">*</span></label>
              <input v-model="deliveryDate" type="date" class="form-control delivery-date" placeholder="Enter delivery date" readonly>
            </div>
            <div class="col-lg-6">
              <label>PPH (IDR):</label>
              <input v-model="pph" type="text" class="form-control bg-light text-right mask-number" readonly required>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-lg-6">

            </div>
            <div class="col-lg-6">
              <label>Total Piutang (IDR):</label>
              <input v-model="totalDebt" type="text" class="form-control bg-light text-right mask-number" readonly required>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-lg-6">
              <label>Note:</label>
              <textarea v-model="note" class="form-control" rows="3"></textarea>
            </div>
            <div class="col-lg-6">
              <label>Upload File:</label>
              <input type="file">
            </div>
          </div>

          <div class="separator separator-dashed my-10"></div>
          <div class="d-flex justify-content-between mb-10">
            <div class="">
              <h3 class="text-dark font-weight-bold">Estimation Items</h3>
            </div>
            <div class="">
              <div class="btn-group">
                <button type="button" @click="addOffsetItem" class="btn btn-primary font-weight-bolder">
                  <i class="ki ki-plus icon-xs"></i>Add Item (Offset)</button>
                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                  <ul class="nav nav-hover flex-column">
                    <li class="nav-item">
                      <a href="#" @click.prevent="addDigitalItem" class="nav-link">
                        <i class="nav-icon flaticon2-add-1"></i>
                        <span class="nav-text">Add Item (Digital)</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <!-- begin::estimation-item -->
          <offset :items="offsetItems" :onaddsubitem="addSubFinishingItem" :onremovesubitem="removeSubFinishingItem" :onremoveitem="removeOffsetItem"></offset>
          <!-- end::estimation-item -->

          <!-- begin::estimation-item-digital -->
          <digital :items="digitalItems" :onaddsubitem="addSubFinishingItem" :onremovesubitem="removeSubFinishingItem" :onremoveitem="removeDigitalItem"></digital>
          <!-- end::estimation-item-digital -->
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-lg-6">

            </div>
            <div class="col-lg-6 text-lg-right">
              <button type="submit" class="btn btn-primary" :class="loading && 'spinner spinner-white spinner-right'" :disabled="loading">
                Save
              </button>

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
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
@endsection

@section('pagescript')
<script>
  $(function() {
    $('.estimation-date, .delivery-date').datepicker({
      todayBtn: true,
      clearBtn: true,
      orientation: "bottom left"
    });
    $('.mask-number').mask('000.000.000.000.000', {
      reverse: true
    });

    FilePond.registerPlugin(FilePondPluginImagePreview);
    const inputElement = document.querySelector('input[type="file"]');
    const pond = FilePond.create(inputElement);
  });
</script>
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

  Vue.component('offset', {
    props: ['items', 'onaddsubitem', 'onremovesubitem', 'onremoveitem'],
    template: `

    <div  v-if="items.length > 0">
    <h4 class="text-dark font-weight-bold mb-5">Offset</h4>
      <div class="table-responsive">
        <table class="table table-bordered w-100">
          <thead class="text-center bg-light">
            <tr>
              <td rowspan="2" class="align-middle">Item</td>
              <td rowspan="2" class="align-middle">Machine Type</td>
              <td colspan="4">Size</td>
              <td colspan="2">Color</td>
              <td colspan="13">Paper</td>
              <td colspan="3">Film</td>
              <td rowspan="2" class="align-middle">App/Set/Design</td>
              <td colspan="5">Printing</td>
              <td colspan="5">Finishing</td>
              <td rowspan="2" class="align-middle">Action</td>
            </tr>
            <tr>
              <!-- Size -->
              <td>Opened (P)</td>
              <td>Opened (L)</td>
              <td>Closed (P)</td>
              <td>Closed (L)</td>
              <!-- Color -->
              <td>Color 1</td>
              <td>Color 2</td>
              <!-- Paper -->
              <td>Type</td>
              <td>Size Plano (P)</td>
              <td>Size Plano (L)</td>
              <td>Gramasi</td>
              <td>Price / Kg</td>
              <td>Qty Plano</td>
              <td>Cutting Size (P)</td>
              <td>Size Plano / Cutting Size (P)</td>
              <td>Cutting Size (L)</td>
              <td>Size Plano / Cutting Size (L)</td>
              <td>Quantity</td>
              <td>Unit Price</td>
              <td>Total</td>
              <!-- Film -->
              <td>Qty Set</td>
              <td>Unit Price</td>
              <td>Total</td>
              <!-- Printing -->
              <td>Type</td>
              <td>Total Qty</td>
              <td>Min Price</td>
              <td>Druk Price</td>
              <td>Total</td>
              <!-- Finishing -->
              <td>Item</td>
              <td>Qty</td>
              <td>Unit Price</td>
              <td>Total</td>
              <td></td>
            </tr>
          </thead>
          <tbody>
            <template v-for="(item, index) in items">
            <tr :key="item.id">
              <td><input type="text" class="form-control" style="width: 250px;" placeholder="Enter Item"></td>
              <td>
                <select class="form-control" style="width: 150px;">
                  <option value="GTO">GTO</option>
                  <option value="SM 74">GTO</option>
                  <option value="SM 102">SM102</option>
                </select>
              </td>
              <!-- Size -->
              <td><input type="number" class="form-control" style="width: 100px;"></td>
              <td><input type="number" class="form-control" style="width: 100px;"></td>
              <td><input type="number" class="form-control" style="width: 100px;"></td>
              <td><input type="number" class="form-control" style="width: 100px;"></td>
              <!-- Color -->
              <td><input type="number" class="form-control" style="width: 100px;"></td>
              <td><input type="number" class="form-control" style="width: 100px;"></td>
              <!-- Paper -->
              <td>
                <select class="form-control" style="width: 150px;">
                  <option value="HVS">HVS</option>
                </select>
              </td>
              <td><input type="number" class="form-control" style="width: 100px;"></td>
              <td><input type="number" class="form-control" style="width: 100px;"></td>
              <td><input type="number" class="form-control" style="width: 100px;"></td>
              <td><input type="text" class="form-control text-right mask-number" style="width: 150px;" value="" required></td>
              <td><input type="text" class="form-control mask-number" style="width: 150px;" value="" required></td>
              <td><input type="number" class="form-control" style="width: 100px;"></td>
              <td><input type="number" class="form-control bg-light" style="width: 100px;" readonly></td>
              <td><input type="number" class="form-control" style="width: 100px;"></td>
              <td><input type="number" class="form-control bg-light" style="width: 100px;" readonly></td>
              <td><input type="text" class="form-control mask-number" style="width: 150px;" value="" required></td>
              <td><input type="text" class="form-control text-right mask-number" style="width: 150px;" value="" required></td>
              <td><input type="text" class="form-control bg-light text-right mask-number" style="width: 150px;" value="" readonly required></td>
              <!-- Film -->
              <td><input type="text" class="form-control mask-number" style="width: 150px;" value="" required></td>
              <td><input type="text" class="form-control text-right mask-number" style="width: 150px;" value="" required></td>
              <td><input type="text" class="form-control bg-light text-right mask-number" style="width: 150px;" value="" readonly required></td>
              <!-- End::Film -->
              <td><input type="text" class="form-control text-right mask-number" style="width: 150px;" value="" required></td>
              <!-- Printing -->
              <td>
                <select class="form-control" style="width: 150px;">
                  <option value="BBS">BBS</option>
                  <option value="BBL">BBL</option>
                  <option value="BB">BB</option>
                  <option value="1 Muka">1 Muka</option>
                </select>
              </td>
              <td><input type="text" class="form-control bg-light mask-number" style="width: 150px;" value="" readonly required></td>
              <td><input type="text" class="form-control text-right mask-number" style="width: 150px;" value="" required></td>
              <td><input type="text" class="form-control text-right mask-number" style="width: 150px;" value="" required></td>
              <td><input type="text" class="form-control bg-light text-right mask-number" style="width: 150px;" value="" readonly required></td>
              <!-- Finishing -->
              
              <td><input type="text" class="form-control" style="width: 250px;" placeholder="Enter Item"></td>
              <td><input type="text" class="form-control mask-number" style="width: 150px;" value="" required></td>
              <td><input type="text" class="form-control text-right mask-number" style="width: 150px;" value="" required></td>
              <td><input type="text" class="form-control bg-light text-right mask-number" style="width: 150px;" value="" readonly required></td>
              <td>
                <a href="#" @click.prevent="onaddsubitem(item)" class="btn btn-icon btn-success">
                  <span class="svg-icon svg-icon-light svg-icon-2x">
                    <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Code\Plus.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                      <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24" />
                        <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10" />
                        <path d="M11,11 L11,7 C11,6.44771525 11.4477153,6 12,6 C12.5522847,6 13,6.44771525 13,7 L13,11 L17,11 C17.5522847,11 18,11.4477153 18,12 C18,12.5522847 17.5522847,13 17,13 L13,13 L13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 L11,13 L7,13 C6.44771525,13 6,12.5522847 6,12 C6,11.4477153 6.44771525,11 7,11 L11,11 Z" fill="#000000" />
                      </g>
                    </svg>
                    <!--end::Svg Icon-->
                  </span>
                </a>
              </td>
              <td>
                <a href="#" @click.prevent="onremoveitem(index)" class="btn btn-icon btn-danger">
                  <span class="svg-icon svg-icon-light svg-icon-2x">
                    <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Code\Error-circle.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                      <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24" />
                        <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10" />
                        <path d="M12.0355339,10.6213203 L14.863961,7.79289322 C15.2544853,7.40236893 15.8876503,7.40236893 16.2781746,7.79289322 C16.6686989,8.18341751 16.6686989,8.81658249 16.2781746,9.20710678 L13.4497475,12.0355339 L16.2781746,14.863961 C16.6686989,15.2544853 16.6686989,15.8876503 16.2781746,16.2781746 C15.8876503,16.6686989 15.2544853,16.6686989 14.863961,16.2781746 L12.0355339,13.4497475 L9.20710678,16.2781746 C8.81658249,16.6686989 8.18341751,16.6686989 7.79289322,16.2781746 C7.40236893,15.8876503 7.40236893,15.2544853 7.79289322,14.863961 L10.6213203,12.0355339 L7.79289322,9.20710678 C7.40236893,8.81658249 7.40236893,8.18341751 7.79289322,7.79289322 C8.18341751,7.40236893 8.81658249,7.40236893 9.20710678,7.79289322 L12.0355339,10.6213203 Z" fill="#000000" />
                      </g>
                    </svg>
                    <!--end::Svg Icon-->
                  </span>
                </a>
              </td>
              
            </tr>
            <tr v-for="(subFinishingItem, subIndex) in item.subFinishingItems" :key="subFinishingItem.id">
            <!-- Finishing -->
              <td colspan="30"></td>
              <td><input type="text" class="form-control" style="width: 250px;" placeholder="Enter Item"></td>
              <td><input type="text" class="form-control mask-number" style="width: 150px;" value="" required></td>
              <td><input type="text" class="form-control text-right mask-number" style="width: 150px;" value="" required></td>
              <td><input type="text" class="form-control bg-light text-right mask-number" style="width: 150px;" value="" readonly required></td>
              <td>
                <a href="#" @click.prevent="onremovesubitem(item, subIndex)" class="btn btn-icon btn-danger">
                  <span class="svg-icon svg-icon-light svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Code\Minus.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                      <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                          <rect x="0" y="0" width="24" height="24"/>
                          <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
                          <rect fill="#000000" x="6" y="11" width="12" height="2" rx="1"/>
                      </g>
                  </svg><!--end::Svg Icon--></span>
                </a>
              </td>
              <td></td>
            </tr>
            </template>
          </tbody>
          <tfoot>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right"><strong>Rp. 99.002.000</strong></td>
            <td></td>
            <td></td>
            <td class="text-right"><strong>Rp. 99.002.000</strong></td>
            <td class="text-right"><strong>Rp. 99.002.000</strong></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right"><strong>Rp. 99.002.000</strong></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right"><strong>Rp. 99.002.000</strong></td>
            <td></td>
            <td></td>
          </tfoot>
        </table>
      </div>
    </div>
  `
  })
  Vue.component('digital', {
    props: ['items', 'onaddsubitem', 'onremovesubitem', 'onremoveitem'],
    template: `
    <div class="mt-5" v-if="items.length > 0">
      <h4 class="text-dark font-weight-bold mb-5">Digital</h4>
      <div class="table-responsive">
        <table class="table table-bordered w-100">
          <thead class="text-center bg-light">
            <tr>
              <td rowspan="2" class="align-middle">Item</td>
              <td rowspan="2" class="align-middle">Print Type</td>
              <td colspan="2">Color</td>
              <td rowspan="2" class="align-middle">Price</td>
              <td rowspan="2" class="align-middle">Quantity</td>
              <td rowspan="2" class="align-middle">Total</td>
              <td colspan="5">Finishing</td>
              <td rowspan="2" class="align-middle">Action</td>
            </tr>
            <tr>
              <!-- Color -->
              <td>Color 1</td>
              <td>Color 2</td>
              <!-- Finishing -->
              <td>Item</td>
              <td>Qty</td>
              <td>Unit Price</td>
              <td>Total</td>
              <td></td>
            </tr>
          </thead>
          <tbody>
          <template v-for="(item, index) in items">
            <tr :key="item.id">
              <td><input type="text" class="form-control" style="width: 250px;" placeholder="Enter Item"></td>
              <td>
                <select class="form-control" style="width: 150px;">
                  <option value="Fancy">Fancy</option>
                  <option value="Biasa">Biasa</option>
                  <option value="Sticker">Sticker</option>
                </select>
              </td>
              <!-- Color -->
              <td><input type="number" class="form-control" style="width: 100px;"></td>
              <td><input type="number" class="form-control" style="width: 100px;"></td>
              <!-- End::Color -->
              <td><input type="text" class="form-control text-right mask-number" style="width: 150px;" value="" required></td>
              <td><input type="text" class="form-control mask-number" style="width: 150px;" value="" required></td>
              <td><input type="text" class="form-control bg-light text-right mask-number" style="width: 150px;" value="" readonly required></td>
              <!-- Finishing -->
              <td><input type="text" class="form-control" style="width: 250px;" placeholder="Enter Item"></td>
              <td><input type="text" class="form-control mask-number" style="width: 150px;" value="" required></td>
              <td><input type="text" class="form-control text-right mask-number" style="width: 150px;" value="" required></td>
              <td><input type="text" class="form-control bg-light text-right mask-number" style="width: 150px;" value="" readonly required></td>
              <td>
                <a href="#" @click.prevent="onaddsubitem(item)" class="btn btn-icon btn-success">
                  <span class="svg-icon svg-icon-light svg-icon-2x">
                    <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Code\Plus.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                      <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24" />
                        <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10" />
                        <path d="M11,11 L11,7 C11,6.44771525 11.4477153,6 12,6 C12.5522847,6 13,6.44771525 13,7 L13,11 L17,11 C17.5522847,11 18,11.4477153 18,12 C18,12.5522847 17.5522847,13 17,13 L13,13 L13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 L11,13 L7,13 C6.44771525,13 6,12.5522847 6,12 C6,11.4477153 6.44771525,11 7,11 L11,11 Z" fill="#000000" />
                      </g>
                    </svg>
                    <!--end::Svg Icon-->
                  </span>
                </a>
              </td>
              <td>
                <a href="#" @click.prevent="onremoveitem(index)" class="btn btn-icon btn-danger">
                  <span class="svg-icon svg-icon-light svg-icon-2x">
                    <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Code\Error-circle.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                      <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24" />
                        <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10" />
                        <path d="M12.0355339,10.6213203 L14.863961,7.79289322 C15.2544853,7.40236893 15.8876503,7.40236893 16.2781746,7.79289322 C16.6686989,8.18341751 16.6686989,8.81658249 16.2781746,9.20710678 L13.4497475,12.0355339 L16.2781746,14.863961 C16.6686989,15.2544853 16.6686989,15.8876503 16.2781746,16.2781746 C15.8876503,16.6686989 15.2544853,16.6686989 14.863961,16.2781746 L12.0355339,13.4497475 L9.20710678,16.2781746 C8.81658249,16.6686989 8.18341751,16.6686989 7.79289322,16.2781746 C7.40236893,15.8876503 7.40236893,15.2544853 7.79289322,14.863961 L10.6213203,12.0355339 L7.79289322,9.20710678 C7.40236893,8.81658249 7.40236893,8.18341751 7.79289322,7.79289322 C8.18341751,7.40236893 8.81658249,7.40236893 9.20710678,7.79289322 L12.0355339,10.6213203 Z" fill="#000000" />
                      </g>
                    </svg>
                    <!--end::Svg Icon-->
                  </span>
                </a>
              </td>
            </tr>
            <tr v-for="(subFinishingItem, subIndex) in item.subFinishingItems" :key="subFinishingItem.id">
            <!-- Finishing -->
              <td colspan="7"></td>
              <td><input type="text" class="form-control" style="width: 250px;" placeholder="Enter Item"></td>
              <td><input type="text" class="form-control mask-number" style="width: 150px;" value="" required></td>
              <td><input type="text" class="form-control text-right mask-number" style="width: 150px;" value="" required></td>
              <td><input type="text" class="form-control bg-light text-right mask-number" style="width: 150px;" value="" readonly required></td>
              <td>
                <a href="#" class="btn btn-icon btn-danger" @click.prevent="onremovesubitem(item, subIndex)" >
                    <span class="svg-icon svg-icon-light svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Code\Minus.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"/>
                            <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
                            <rect fill="#000000" x="6" y="11" width="12" height="2" rx="1"/>
                        </g>
                    </svg><!--end::Svg Icon--></span>
                  </a>
              </td>
              <td></td>
            </tr>
            </template>
          </tbody>
          <tfoot>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td class="text-right"><strong>Rp 12.000.000</strong></td>
              <td></td>
              <td></td>
              <td></td>
              <td class="text-right"><strong>Rp 12.000.000</strong></td>
              <td></td>
              <td></td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  `
  })


  let app = new Vue({
    el: '#app',
    data: {
      offsetCounter: 1,
      digitalCounter: 1,
      status: '',
      number: '',
      date: '',
      customerId: '',
      picId: '',
      picEmail: '',
      work: '',
      totalQuantity: '',
      deliveryDate: '',
      totalProduction: 0,
      hpp: 0,
      hppPerUnit: 0,
      sellPricePerUnit: '',
      margin: 0,
      totalSellPrice: 0,
      ppn: 0,
      pph: 0,
      totalDebt: 0,
      note: '',
      offsetItems: [{
        id: 0,
        item: '',
        machineType: '',
        sizeOpenedP: '',
        sizeOpenedL: '',
        sizeClosedP: '',
        sizeClosedL: '',
        color1: '',
        color2: '',
        paperType: '',
        paperSizePlanoP: '',
        paperSizePlanoL: '',
        paperGramasi: '',
        paperPricePerKg: '',
        paperQuantityPlano: '',
        paperCuttingSizeP: '',
        paperSizePlanoDivCuttingSizeP: '',
        paperCuttingSizeL: '',
        paperSizePlanoDivCuttingSizeL: '',
        paperQuantity: '',
        paperUnitPrice: '',
        paperTotal: '',
        filmQtySet: '',
        filmUnitPrice: '',
        filmTotal: '',
        appSetDesign: '',
        printingType: '',
        printingQuantity: '',
        printingMinPrice: '',
        printingDrukPrice: '',
        printingTotal: '',
        finishingItem: '',
        finishingQuantity: '',
        finishingUnitPrice: '',
        finishingTotal: '',
        subFinishingItems: [],
        // subFinishingItems: [{
        //   item: '',
        //   quantity: '',
        //   unitPrice: '',
        //   total: '',
        // }],

      }, ],
      digitalItems: [{
        item: '',
        printType: '',
        color1: '',
        color2: '',
        price: '',
        quantity: '',
        total: '',
        finishingItem: '',
        finishingQuantity: '',
        finishingUnitPrice: '',
        finishingTotal: '',
        subFinishingItems: [],
        // subFinishingItems: [{
        //   item: '',
        //   quantity: '',
        //   unitPrice: '',
        //   total: '',
        // }],
      }],
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
        axios.post('/estimation', {

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
                window.location.href = '/pic-po';
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
      },
      addOffsetItem: function() {
        this.offsetItems.push({
          id: this.offsetCounter++,
          item: '',
          machineType: '',
          sizeOpenedP: '',
          sizeOpenedL: '',
          sizeClosedP: '',
          sizeClosedL: '',
          color1: '',
          color2: '',
          paperType: '',
          paperSizePlanoP: '',
          paperSizePlanoL: '',
          paperGramasi: '',
          paperPricePerKg: '',
          paperQuantityPlano: '',
          paperCuttingSizeP: '',
          paperSizePlanoDivCuttingSizeP: '',
          paperCuttingSizeL: '',
          paperSizePlanoDivCuttingSizeL: '',
          paperQuantity: '',
          paperUnitPrice: '',
          paperTotal: '',
          filmQtySet: '',
          filmUnitPrice: '',
          filmTotal: '',
          appSetDesign: '',
          printingType: '',
          printingQuantity: '',
          printingMinPrice: '',
          printingDrukPrice: '',
          printingTotal: '',
          finishingItem: '',
          finishingQuantity: '',
          finishingUnitPrice: '',
          finishingTotal: '',
          subFinishingItems: [],
        })
      },
      addDigitalItem: function() {
        this.digitalItems.push({
          id: this.digitalCounter++,
          item: '',
          printType: '',
          color1: '',
          color2: '',
          price: '',
          quantity: '',
          total: '',
          finishingItem: '',
          finishingQuantity: '',
          finishingUnitPrice: '',
          finishingTotal: '',
          subFinishingItems: [],
          // subFinishingItems: [{
          //   item: '',
          //   quantity: '',
          //   unitPrice: '',
          //   total: '',
          // }],
        })
      },

      removeOffsetItem: function(index) {
        this.offsetItems.splice(index, 1);
        // console.log(index);
      },
      removeDigitalItem: function(index) {
        this.digitalItems.splice(index, 1);
        // console.log(index);
      },
      addSubFinishingItem: function(item) {
        item.subFinishingItems.push({
          id: Math.round(Math.random() * 9999),
          item: '',
          quantity: '',
          unitPrice: '',
          total: '',
        })
      },
      removeSubFinishingItem: function(item, index) {
        item.subFinishingItems.splice(index, 1);
      }
    }
  })
</script>
@endsection