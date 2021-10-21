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
        <h5 class="text-dark font-weight-bold my-1 mr-5">Tambah Estimasi</h5>
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
    <div class="card card-custom card-sticky gutter-b">
      <div class="card-header ribbon ribbon-top">
        <div class="card-title">
          <h3 class="card-label">Form Estimasi</h3>
        </div>
        <div class="ribbon-target bg-warning" style="top: -2px; right: 20px;">Open</div>
        <!-- <div class="card-toolbar">
          <span class="label label-xl label-light-warning label-inline">Open</span>
        </div> -->
      </div>
      <!--begin::Form-->
      <form class="form" autocomplete="off" enctype="multipart/form-data" @submit.prevent="submitForm">
        <div class="card-body">
          <div class="form-group row">
            <div class="col-lg-6"></div>
            <div class="col-lg-6">
              <label>Status:<span class="text-danger">*</span></label>
              <select v-model="status" class="form-control">
                <option value="open">Open</option>
                <option value="closed">Closed</option>
                <option value="rejected">Rejected</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-lg-6">
              <!-- <label>Estimated Number:</label>
              <input v-model="number" type="text" class="form-control bg-light" required readonly> -->
            </div>
            <div class="col-lg-6">
              <label>Total Production (IDR):</label>
              <input v-model="totalProduction" type="text" class="form-control bg-light text-right" readonly required>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-lg-6">
              <label>Estimation Date:<span class="text-danger">*</span></label>
              <input v-model="date" type="text" class="form-control estimation-date" readonly>
            </div>
            <div class="col-lg-6">
              <label>HPP (IDR):</label>
              <input v-model="hpp" type="text" class="form-control bg-light text-right" readonly required>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-lg-6">
              <label>Customer:<span class="text-danger">*</span></label>
              <select2 v-model="customerId" :options="customers" class="form-control" @selected="onChangeCustomer" required>
              </select2>
            </div>
            <div class="col-lg-6">
              <label>HPP / Unit (IDR):</label>
              <input v-model="hppPerUnit" type="text" class="form-control bg-light text-right" readonly required>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-lg-6">
              <label>PIC PO:<span class="text-danger">*</span></label>
              <select2 v-model="picId" :options="picPosOptions" class="form-control" @selected="onChangePicPo" v-bind:disabled="picLoading" required>
              </select2>
            </div>
            <div class="col-lg-6">
              <label>Harga Jual / Unit (IDR):</label>
              <input v-model="sellPricePerUnit" v-cleave="cleaveCurrency" type="text" class="form-control text-right" required>
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
              <input v-model="totalSellPrice" type="text" class="form-control bg-light text-right" readonly required>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-lg-6">
              <label>Total Quantity:<span class="text-danger">*</span></label>
              <input v-model="totalQuantity" v-cleave="cleaveCurrency" type="text" class="form-control" placeholder="Enter Quantity" required>
            </div>
            <div class="col-lg-6">
              <label>PPN (IDR):</label>
              <input v-model="ppn" type="text" class="form-control bg-light text-right" readonly required>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-lg-6">
              <label>Delivery Date:<span class="text-danger">*</span></label>
              <input v-model="deliveryDate" type="text" class="form-control delivery-date" placeholder="Enter delivery date" readonly>
            </div>
            <div class="col-lg-6">
              <label>PPH (IDR):</label>
              <input v-model="pph" type="text" class="form-control bg-light text-right" readonly required>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-lg-6">

            </div>
            <div class="col-lg-6">
              <label>Total Piutang (IDR):</label>
              <input v-model="totalDebt" type="text" class="form-control bg-light text-right" readonly required>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-lg-6">
              <label>Note:</label>
              <textarea v-model="note" class="form-control" rows="3"></textarea>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label>File (Max. 2MB)</label>
                <div></div>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="customFile" ref="fileUpload" v-on:change="handleFileUpload" accept=".jpg, .jpeg, .png, .pdf, .doc, .xls, .xlsx">
                  <label ref="fileUploadLabel" id="file-upload-label" class="custom-file-label" for="customFile">Choose file</label>
                </div>
                <p v-if="previewFile.size !== '' && previewFile.size > (2048 * 1000)"><i class="flaticon-warning text-warning"></i> Ukuran file max. 2 MB. File tidak akan terkirim</p>
              </div>
              <div v-if="file">
                <div class="card card-custom gutter-b card-stretch">
                  <div class="card-body">
                    <div class="d-flex flex-column align-items-center">
                      <!--begin: Icon-->
                      <img alt="" class="max-h-100px" :src="fileTypeImage">
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
          </div>

          <div class="separator separator-dashed my-10"></div>
          <div class="d-flex justify-content-between mb-10">
            <div class="">
              <h3 class="text-dark font-weight-bold">Item Estimasi</h3>
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
          <offset :items="offsetItems" :onaddsubitem="addSubFinishingItem" :onremovesubitem="removeSubFinishingItem" :onremoveitem="removeOffsetItem" :calculate="calculateOffset" :calculatesubitem="calculateSubFinishingItem" :cleave="cleaveCurrency" :grandtotal="offsetGrandTotal"></offset>
          <!-- end::estimation-item -->

          <!-- begin::estimation-item-digital -->
          <digital :items="digitalItems" :onaddsubitem="addSubFinishingItem" :onremovesubitem="removeSubFinishingItem" :onremoveitem="removeDigitalItem" :calculate="calculateDigital" :calculatesubitem="calculateSubFinishingItem" :cleave="cleaveCurrency" :grandtotal="digitalGrandTotal"></digital>
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
<script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
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
          vm.$emit('selected', this.value);
          vm.$emit("input", this.value);
        });
    },
    watch: {
      value: function(value) {
        // update value
        $(this.$el)
          .val(value)
        // .trigger("change");
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

  Vue.directive('cleave', {
    inserted: (el, binding) => {
      el.cleave = new Cleave(el, binding.value || {})
    },
    update: (el) => {
      const event = new Event('input', {
        bubbles: true
      });
      setTimeout(function() {
        el.value = el.cleave.properties.result
        el.dispatchEvent(event)
      }, 100);
    }
  })

  Vue.component('offset', {
    props: ['items', 'onaddsubitem', 'onremovesubitem', 'onremoveitem', 'calculate', 'calculatesubitem', 'cleave', 'grandtotal'],
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
              <td><input v-model="item.item" type="text" class="form-control" style="width: 250px;" placeholder="Enter Item"></td>
              <td>
                <select v-model="item.machineType" class="form-control" style="width: 150px;">
                  @foreach($machines as $machine)
                  <option value="{{ $machine->id }}">{{ $machine->name }}</option>
                  @endforeach
                </select>
              </td>
              <!-- Size -->
              <td><input v-model="item.sizeOpenedP" @input="calculate(item)" type="number" step="any" class="form-control" style="width: 100px;"></td>
              <td><input v-model="item.sizeOpenedL" @input="calculate(item)" type="number" step="any" class="form-control" style="width: 100px;"></td>
              <td><input v-model="item.sizeClosedP" @input="calculate(item)" type="number" step="any" class="form-control" style="width: 100px;"></td>
              <td><input v-model="item.sizeClosedL" @input="calculate(item)" type="number" step="any" class="form-control" style="width: 100px;"></td>
              <!-- Color -->
              <td><input v-model="item.color1" @input="calculate(item)" type="number" step="any" class="form-control" style="width: 100px;"></td>
              <td><input v-model="item.color2" @input="calculate(item)" type="number" step="any" class="form-control" style="width: 100px;"></td>
              <!-- Paper -->
              <td>
                <!-- <select v-model="item.paperType" @input="calculate(item)" class="form-control" style="width: 150px;">
                  <option value="0">HVS</option> 
                </select> -->
                <input v-model="item.paperType" type="text" class="form-control" style="width: 250px;" placeholder="Enter Paper">
              </td>
              <td><input v-model="item.paperSizePlanoP" @input="calculate(item)" type="number" step="any" class="form-control" style="width: 100px;"></td>
              <td><input v-model="item.paperSizePlanoL" @input="calculate(item)" type="number" step="any" class="form-control" style="width: 100px;"></td>
              <td><input v-model="item.paperGramasi" @input="calculate(item)" type="number" step="any" class="form-control" style="width: 100px;"></td>
              <td><input v-model="item.paperPricePerKg" v-cleave="cleave" @input="calculate(item)" type="text" class="form-control text-right" style="width: 150px;" value="" required></td>
              <td><input v-model="item.paperQuantityPlano" v-cleave="cleave" @input="calculate(item)" type="text" class="form-control" style="width: 150px;" value="" required></td>
              <td><input v-model="item.paperCuttingSizeP" @input="calculate(item)" type="number" step="any" class="form-control" style="width: 100px;"></td>
              <td><input v-model="item.paperSizePlanoDivCuttingSizeP" type="number" step="any" class="form-control bg-light" style="width: 100px;" readonly></td>
              <td><input v-model="item.paperCuttingSizeL" @input="calculate(item)" type="number" step="any" class="form-control" style="width: 100px;"></td>
              <td><input v-model="item.paperSizePlanoDivCuttingSizeL" type="number" step="any" class="form-control bg-light" style="width: 100px;" readonly></td>
              <td><input v-model="item.paperQuantity" type="text" class="form-control bg-light" style="width: 150px;" value="" readonly required></td>
              <td>
                <div class="input-group" style="flex-wrap: nowrap;">
                  <div class="input-group-prepend">
                    <span class="input-group-text" data-toggle="tooltip" data-theme="dark" title="Custom Fill">
                      <label class="checkbox checkbox-inline checkbox-success">
                        <input type="checkbox" v-model="item.isPaperUnitPriceEditable" />
                        <span></span>
                      </label>
                    </span>
                  </div>
                  <input type="text" class="form-control text-right" v-model="item.paperUnitPrice" @input="calculate(item)" aria-label="Paper Unit Price" style="width: 150px;" :disabled="!item.isPaperUnitPriceEditable" />
                </div>  
              </td>
              <!-- <td><input type="text" v-model="item.paperUnitPrice" class="form-control text-right" style="width: 150px;" value="" required></td> -->
              <td><input v-model="item.paperTotal" type="text" class="form-control bg-light text-right" style="width: 150px;" value="" readonly required></td>
              <!-- Film -->
              <td><input v-model="item.filmQuantitySet" v-cleave="cleave" @input="calculate(item)" type="text" class="form-control" style="width: 150px;" value="" required></td>
              <td><input v-model="item.filmUnitPrice" v-cleave="cleave" @input="calculate(item)" type="text" class="form-control text-right" style="width: 150px;" value="" required></td>
              <td><input v-model="item.filmTotal" type="text" class="form-control bg-light text-right" style="width: 150px;" value="" readonly required></td>
              <!-- End::Film -->
              <td><input v-model="item.appSetDesign" v-cleave="cleave" @input="calculate(item)" type="text" class="form-control text-right" style="width: 150px;" value="" required></td>
              <!-- Printing -->
              <td>
                <select v-model="item.printingType" @change="calculate(item)" ref="asdasd" class="form-control" style="width: 150px;">
                @foreach($print_types as $print_type)
                  <option value="{{ $print_type->id }}">{{ $print_type->name }}</option>
                @endforeach
                  <!-- <option value="BBS">BBS</option>
                  <option value="BBL">BBL</option>
                  <option value="BB">BB</option>
                  <option value="1 Muka">1 Muka</option> -->
                </select>
              </td>
              <td><input v-model="item.printingQuantity" type="text" class="form-control bg-light" style="width: 150px;" value="" readonly required></td>
              <td><input v-model="item.printingMinPrice" v-cleave="cleave" @input="calculate(item)" type="text" class="form-control text-right " style="width: 150px;" value="" required></td>
              <td><input v-model="item.printingDrukPrice" v-cleave="cleave" @input="calculate(item)" type="text" class="form-control text-right " style="width: 150px;" value="" required></td>
              <td><input v-model="item.printingTotal" type="text" class="form-control bg-light text-right" style="width: 150px;" value="" readonly required></td>
              <!-- Finishing -->
              
              <td><input v-model="item.finishingItem" type="text" class="form-control" style="width: 250px;" placeholder="Enter Item"></td>
              <td><input v-model="item.finishingQuantity" type="text" class="form-control" style="width: 150px;" value="" required></td>
              <td><input v-model="item.finishingUnitPrice" type="text" class="form-control text-right" style="width: 150px;" value="" required></td>
              <td><input v-model="item.finishingTotal" type="text" class="form-control bg-light text-right" style="width: 150px;" value="" readonly required></td>
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
              <td><input v-model="subFinishingItem.item" type="text" class="form-control" style="width: 250px;" placeholder="Enter Item"></td>
              <td><input v-model="subFinishingItem.quantity" @input="calculatesubitem(subFinishingItem)" type="text" class="form-control" style="width: 150px;" value="" required></td>
              <td><input v-model="subFinishingItem.unitPrice" @input="calculatesubitem(subFinishingItem)" type="text" class="form-control text-right" style="width: 150px;" value="" required></td>
              <td><input v-model="subFinishingItem.total" type="text" class="form-control bg-light text-right" style="width: 150px;" value="" readonly required></td>
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
            <td class="text-right"><strong>IDR @{{ grandtotal.paper }}</strong></td>
            <td></td>
            <td></td>
            <td class="text-right"><strong>IDR @{{ grandtotal.film }}</strong></td>
            <td class="text-right"><strong>IDR @{{ grandtotal.appSetDesign }}</strong></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right"><strong>IDR @{{ grandtotal.printing }}</strong></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right"><strong>IDR @{{ grandtotal.finishing }}</strong></td>
            <td></td>
            <td></td>
          </tfoot>
        </table>
      </div>
    </div>
  `
  })
  Vue.component('digital', {
    props: ['items', 'onaddsubitem', 'onremovesubitem', 'onremoveitem', 'calculate', 'calculatesubitem', 'cleave', 'grandtotal'],
    template: `
    <div class="mt-10" v-if="items.length > 0">
      <h4 class="text-dark font-weight-bold mb-5">Digital</h4>
      <div class="table-responsive">
        <table class="table table-bordered w-100">
          <thead class="text-center bg-light">
            <tr>
              <td rowspan="2" class="align-middle">Item</td>
              <td rowspan="2" class="align-middle">Paper</td>
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
              <td><input v-model="item.item" type="text" class="form-control" style="width: 250px;" placeholder="Enter Item"></td>
              <td>
                <!-- <select v-model="item.paper" class="form-control" style="width: 150px;">
                  <option value="0">Fancy</option>
                  <option value="1">Biasa</option>
                  <option value="2">Sticker</option>
                </select> -->
                <input v-model="item.paper" type="text" class="form-control" style="width: 250px;" placeholder="Enter Paper">
              </td>
              <td>
                <select v-model="item.printingType" @change="calculate(item)" ref="asdasd" class="form-control" style="width: 150px;" disabled>
                @foreach($print_types as $print_type)
                  <option value="{{ $print_type->id }}">{{ $print_type->name }}</option>
                @endforeach
                  <!-- <option value="BBS">BBS</option>
                  <option value="BBL">BBL</option>
                  <option value="BB">BB</option>
                  <option value="1 Muka">1 Muka</option> -->
                </select>
              </td>
              <!-- <td><input v-model="item.printingType" type="text" class="form-control bg-light" style="width: 250px;" value="BBL"></td> -->
              <!-- Color -->
              <td><input v-model="item.color1" type="number" step="any" class="form-control" style="width: 100px;"></td>
              <td><input v-model="item.color2" type="number" step="any" class="form-control" style="width: 100px;"></td>
              <!-- End::Color -->
              <td><input v-model="item.price" v-cleave="cleave" @input="calculate(item)" type="text" class="form-control text-right" style="width: 150px;" value="" required></td>
              <td><input v-model="item.quantity" v-cleave="cleave" @input="calculate(item)" type="text" class="form-control" style="width: 150px;" value="" required></td>
              <td><input v-model="item.total" type="text" class="form-control bg-light text-right" style="width: 150px;" value="" readonly required></td>
              <!-- Finishing -->
              <td><input v-model="item.finishingItem" type="text" class="form-control" style="width: 250px;" placeholder="Enter Item"></td>
              <td><input v-model="item.finishingQuantity" @input="calculate(item)" type="text" class="form-control" style="width: 150px;" value="" required></td>
              <td><input v-model="item.finishingUnitPrice" @input="calculate(item)" type="text" class="form-control text-right" style="width: 150px;" value="" required></td>
              <td><input v-model="item.finishingTotal" type="text" class="form-control bg-light text-right" style="width: 150px;" value="" readonly required></td>
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
              <td colspan="8"></td>
              <td><input v-model="subFinishingItem.item" type="text" class="form-control" style="width: 250px;" placeholder="Enter Item"></td>
              <td><input v-model="subFinishingItem.quantity" @input="calculatesubitem(subFinishingItem)" type="text" class="form-control" style="width: 150px;" value="" required></td>
              <td><input v-model="subFinishingItem.unitPrice" @input="calculatesubitem(subFinishingItem)" type="text" class="form-control text-right" style="width: 150px;" value="" required></td>
              <td><input v-model="subFinishingItem.total" type="text" class="form-control bg-light text-right" style="width: 150px;" value="" readonly required></td>
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
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td class="text-right"><strong>IDR @{{ grandtotal.item }}</strong></td>
              <td></td>
              <td></td>
              <td></td>
              <td class="text-right"><strong>IDR @{{ grandtotal.finishing }}</strong></td>
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
      printTypes: JSON.parse(String.raw `{!! $print_types !!}`),
      offsetCounter: 1,
      digitalCounter: 1,
      cleaveCurrency: {
        delimiter: '.',
        numeralDecimalMark: ',',
        numeral: true,
        numeralThousandsGroupStyle: 'thousand'
      },
      status: '',
      number: '{{ $estimation_number }}',
      date: '',
      customerId: '',
      customerPpn: 0,
      customerPph: 0,
      picId: '',
      picEmail: '',
      work: '',
      totalQuantity: '',
      deliveryDate: '',
      sellPricePerUnit: '',
      // ppn: 0,
      // pph: 0,
      // totalDebt: 0,
      note: '',
      file: '',
      previewFile: {
        name: '',
        size: '',
        type: '',
      },
      // offsetItems: [],
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
        paperCuttingSizeP: 1,
        paperSizePlanoDivCuttingSizeP: '',
        paperCuttingSizeL: 1,
        paperSizePlanoDivCuttingSizeL: '',
        isPaperUnitPriceEditable: false,
        paperQuantity: '',
        paperUnitPrice: '',
        paperTotal: '',
        filmQuantitySet: '',
        filmUnitPrice: '',
        filmTotal: '',
        appSetDesign: 0,
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
      }, ],
      offsetGrandTotal: {
        paper: 0,
        film: 0,
        appSetDesign: 0,
        printing: 0,
        finishing: 0,
        total: 0,
      },
      digitalItems: [],
      // digitalItems: [{
      //   item: '',
      //   paper: '',
      //   printingType: 'BBL',
      //   color1: '',
      //   color2: '',
      //   price: '',
      //   quantity: '',
      //   total: '',
      //   finishingItem: '',
      //   finishingQuantity: '',
      //   finishingUnitPrice: '',
      //   finishingTotal: '',
      //   subFinishingItems: [],
      // }],
      digitalGrandTotal: {
        item: 0,
        finishing: 0,
        total: 0,
      },
      customers: JSON.parse(String.raw `{!! $customers !!}`),
      customersAll: JSON.parse(String.raw `{!! $customers_all !!}`),
      picPos: [],
      picPosOptions: [{
        id: '',
        text: 'Choose PIC PO'
      }],
      picLoading: false,
      loading: false,
    },
    computed: {
      totalProduction: function() {
        let digitalGrandTotal = this.digitalItems.length > 0 ? this.digitalGrandTotal.total : 0;
        let offsetGrandTotal = this.offsetItems.length > 0 ? this.offsetGrandTotal.total : 0;
        let totalProduction = digitalGrandTotal + offsetGrandTotal;
        return this.toThousandFormat(totalProduction);
      },
      hpp: function() {
        let totalProduction = parseInt(this.clearCurrencyMask(this.totalProduction));
        let offsetAppGrandTotal = this.offsetItems.length > 0 ? parseInt(this.clearCurrencyMask(this.offsetGrandTotal.appSetDesign)) : 0;
        return this.toThousandFormat(totalProduction + offsetAppGrandTotal);
      },
      hppPerUnit: function() {
        let hpp = parseInt(this.clearCurrencyMask(this.hpp));
        let totalQuantity = parseInt(this.clearCurrencyMask(this.totalQuantity));
        let hppPerUnit = this.toThousandFormat(Math.round(hpp / totalQuantity))
        return (isNaN(hppPerUnit)) ? 0 : hppPerUnit;
      },
      margin: function() {
        let sellPricePerUnit = parseInt(this.clearCurrencyMask(this.sellPricePerUnit));
        let hppPerUnit = parseInt(this.clearCurrencyMask(this.hppPerUnit));
        let margin = Math.round(((sellPricePerUnit - hppPerUnit) / sellPricePerUnit) * 100);
        // let margin = (Math.abs(sellPricePerUnit - hppPerUnit) / ((sellPricePerUnit + hppPerUnit) / 2)) * 100;
        // return margin;
        return (isNaN(margin)) ? 0 : margin;
      },
      totalSellPrice: function() {
        let sellPricePerUnit = parseInt(this.clearCurrencyMask(this.sellPricePerUnit));
        let totalQuantity = parseInt(this.clearCurrencyMask(this.totalQuantity));
        return this.toThousandFormat(sellPricePerUnit * totalQuantity);
      },
      ppn: function() {
        const PERCENTAGE = 0.10;
        if (this.customerPpn == 0) {
          return 0
        }

        let ppn = parseInt(this.clearCurrencyMask(this.totalSellPrice)) * PERCENTAGE;
        return this.toThousandFormat(ppn);
      },
      pph: function() {
        const PERCENTAGE = 0.02;
        if (this.customerPph == 0) {
          return 0
        }

        let pph = parseInt(this.clearCurrencyMask(this.totalSellPrice)) * PERCENTAGE;
        return this.toThousandFormat(pph);
      },
      totalDebt: function() {
        const totalDebt = Number(this.clearCurrencyMask(this.totalSellPrice)) + Number(this.clearCurrencyMask(this.ppn)) - Number(this.clearCurrencyMask(this.pph))
        return this.toThousandFormat(totalDebt);
      },
      fileTypeImage: function() {
        const path = '/media/svg/files/';
        switch (this.previewFile.type) {
          case 'pdf':
            return path + 'pdf.svg';
          case 'xls':
          case 'xlsx':
            return path + 'csv.svg';
          case 'jpg':
          case 'png':
          case 'jpeg':
            return path + 'jpg.svg';
          case 'doc':
          case 'docx':
            return path + 'doc.svg';
          default:
            return path + 'jpg.svg';
        }
      }
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
          number: this.number,
          date: this.date,
          customer_id: this.customerId,
          pic_po_id: this.picId,
          work: this.work,
          quantity: this.totalQuantity,
          production: this.totalProduction,
          hpp: this.hpp,
          hpp_per_unit: this.hppPerUnit,
          price_per_unit: this.sellPricePerUnit,
          margin: this.margin,
          total_price: this.totalSellPrice,
          ppn: this.ppn,
          pph: this.pph,
          total_bill: this.totalDebt,
          delivery_date: this.deliveryDate,
          status: this.status,
          note: this.note,
          file: this.file,
          offsetItems: JSON.stringify(this.offsetItems),
          digitalItems: JSON.stringify(this.digitalItems),
        }

        let formData = new FormData();
        for (var key in data) {
          formData.append(key, data[key]);
        }

        axios.post('/estimation', formData)
          .then(function(response) {
            vm.loading = false;
            Swal.fire({
              title: 'Success',
              text: 'Data has been saved',
              icon: 'success',
              allowOutsideClick: false,
            }).then((result) => {
              if (result.isConfirmed) {
                // window.location.href = '/pic-po';
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
          paperCuttingSizeP: 1,
          paperSizePlanoDivCuttingSizeP: '',
          paperCuttingSizeL: 1,
          paperSizePlanoDivCuttingSizeL: '',
          paperQuantity: '',
          isPaperUnitPriceEditable: false,
          paperUnitPrice: '',
          paperTotal: '',
          filmQuantitySet: '',
          filmUnitPrice: '',
          filmTotal: '',
          appSetDesign: 0,
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
        this.calculateOffsetGrandTotal();
      },
      addDigitalItem: function() {
        this.digitalItems.push({
          id: this.digitalCounter++,
          item: '',
          paper: '',
          printingType: `{{ collect($print_types)->where('initial', 'bbl')->first()->id }}`,
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
        this.calculateDigitalGrandTotal();
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
      },
      calculateOffset: function(item) {
        // console.log('triggered')
        // console.log(item.color1);

        let color1 = item.color1;
        let color2 = item.color2;

        let paperSizePlanoP = item.paperSizePlanoP;
        let paperSizePlanoL = item.paperSizePlanoL;
        let paperCuttingSizeP = item.paperCuttingSizeP;
        let paperCuttingSizeL = item.paperCuttingSizeL;
        // ------ Paper ------
        // Calculate Cutting Size
        let paperSizePlanoDivCuttingSizeP = paperSizePlanoP / paperCuttingSizeP;
        item.paperSizePlanoDivCuttingSizeP = this.round2Decimal(paperSizePlanoDivCuttingSizeP);
        let paperSizePlanoDivCuttingSizeL = paperSizePlanoL / paperCuttingSizeL;
        item.paperSizePlanoDivCuttingSizeL = this.round2Decimal(paperSizePlanoDivCuttingSizeL);
        // Calculate Paper Quantity
        let paperQuantityPlano = item.paperQuantityPlano;
        let paperQuantity = this.clearCurrencyMask(paperQuantityPlano) * paperCuttingSizeP * paperCuttingSizeL;
        item.paperQuantity = this.toThousandFormat(Math.round(paperQuantity));
        // Calculate Unit Price
        let paperGramasi = item.paperGramasi;
        let paperPricePerKg = item.paperPricePerKg;

        let paperUnitPrice = 0;
        if (item.isPaperUnitPriceEditable == false) {
          paperUnitPrice = ((paperSizePlanoP * paperSizePlanoL * paperGramasi * this.clearCurrencyMask(paperPricePerKg)) / 20000) / 500;
          item.paperUnitPrice = this.toThousandFormat(Math.round(paperUnitPrice));
          // item.paperUnitPrice = Math.round(paperUnitPrice);
        } else {
          item.paperUnitPrice = this.clearCurrencyMask(item.paperUnitPrice);
          paperUnitPrice = Number(item.paperUnitPrice);
        }

        // Calculate Total Paper
        let paperTotal = this.clearCurrencyMask(paperQuantityPlano) * paperUnitPrice;
        item.paperTotal = this.toThousandFormat(Math.round(paperTotal));

        // ------ Film -------
        // Calculate Total Film
        let filmQuantitySet = item.filmQuantitySet;
        let filmUnitPrice = item.filmUnitPrice;
        let filmTotal = this.clearCurrencyMask(filmQuantitySet) * paperSizePlanoDivCuttingSizeP * paperSizePlanoDivCuttingSizeL * color1 * this.clearCurrencyMask(filmUnitPrice);
        item.filmTotal = this.toThousandFormat(Math.round(filmTotal));

        // ------ App/Set/Design ------
        // Calculate
        let appSetDesign = item.appSetDesign;

        // ------ Printing ------
        // Calculate Total Quantity
        let filteredPrintingTypes = this.printTypes.filter(type => type.id == item.printingType);
        let printingType = filteredPrintingTypes.length ? filteredPrintingTypes[0].initial : '';

        let printingQuantity = 0;

        if (printingType == 'bbs') {
          printingQuantity = Number(this.clearCurrencyMask(paperQuantity)) * 2;
        } else if (printingType == 'none') {
          printingQuantity = 0;
        } else {
          printingQuantity = this.clearCurrencyMask(paperQuantity);
        }

        item.printingQuantity = this.toThousandFormat(printingQuantity);

        // let printingQuantity = (printingType == 'BBS') ? Number(this.clearCurrencyMask(paperQuantity)) * 2 : this.clearCurrencyMask(paperQuantity);
        // item.printingQuantity = this.toThousandFormat(printingQuantity);

        let printingMinPrice = item.printingMinPrice;
        let printingDrukPrice = item.printingDrukPrice;
        let printingTotal = 0;
        if (printingQuantity <= 3000) {
          printingTotal = this.clearCurrencyMask(printingMinPrice) * color1 * this.clearCurrencyMask(filmQuantitySet);
        } else {
          printingTotal = (this.clearCurrencyMask(printingMinPrice) * color1) + (printingQuantity - 3000) * color1 * this.clearCurrencyMask(printingDrukPrice) * this.clearCurrencyMask(filmQuantitySet);
        }

        // item.printingTotal = (printingTotal < 1) ? 1 : this.toThousandFormat(Math.round(printingTotal));
        item.printingTotal = this.toThousandFormat(Math.round(printingTotal));

        // ------ Finishing -------
        // Calculate Total
        let finishingQuantity = item.finishingQuantity;
        let finishingUnitPrice = item.finishingUnitPrice;

        let finishingTotal = finishingQuantity * finishingUnitPrice;

        item.finishingTotal = this.toThousandFormat(Math.round(finishingTotal));
        // ------ Sub Finishing ------


        // Calculate Grand Total
        this.calculateOffsetGrandTotal();

      },
      calculateOffsetGrandTotal: function() {
        let vm = this;

        let offsetPaperGrandTotal = this.offsetItems.map(item => parseInt(vm.clearCurrencyMask(item.paperTotal))).reduce((cur, acc) => {
          return cur + acc
        }, 0);
        this.offsetGrandTotal.paper = this.toThousandFormat(offsetPaperGrandTotal);

        let offsetFilmGrandTotal = this.offsetItems.map(item => parseInt(vm.clearCurrencyMask(item.filmTotal))).reduce((cur, acc) => {
          return cur + acc
        }, 0);
        this.offsetGrandTotal.film = this.toThousandFormat(offsetFilmGrandTotal);

        let offsetAppGrandTotal = this.offsetItems.map(item => parseInt(vm.clearCurrencyMask(item.appSetDesign))).reduce((cur, acc) => {
          return cur + acc
        }, 0);
        this.offsetGrandTotal.appSetDesign = this.toThousandFormat(offsetAppGrandTotal);

        let offsetPrintingGrandTotal = this.offsetItems.map(item => parseInt(vm.clearCurrencyMask(item.printingTotal))).reduce((cur, acc) => {
          return cur + acc
        }, 0);
        this.offsetGrandTotal.printing = this.toThousandFormat(offsetPrintingGrandTotal);

        let offsetFinishingGrandTotal = this.offsetItems.map(item => {
          // parseInt(vm.clearCurrencyMask(item.finishingTotal))
          let subItem = 0;
          if (item.subFinishingItems.length > 0) {
            subItem = item.subFinishingItems.map(sub => parseInt(vm.clearCurrencyMask(sub.total))).reduce((cur, acc) => {
              return cur + acc
            }, 0);
          }
          return parseInt(vm.clearCurrencyMask(item.finishingTotal)) + subItem;
        }).reduce((cur, acc) => {
          return cur + acc
        }, 0);
        this.offsetGrandTotal.finishing = this.toThousandFormat(offsetFinishingGrandTotal);

        this.offsetGrandTotal.total = offsetPaperGrandTotal + offsetFilmGrandTotal + offsetPrintingGrandTotal + offsetFinishingGrandTotal;

      },
      calculateDigital: function(item) {
        // item: '',
        //   printType: '',
        //   color1: '',
        //   color2: '',
        //   price: '',
        //   quantity: '',
        //   total: '',
        //   finishingItem: '',
        //   finishingQuantity: '',
        //   finishingUnitPrice: '',
        //   finishingTotal: '',
        //   subFinishingItems: [],
        let color1 = item.color1;
        let color2 = item.color2;
        let price = item.price;
        let quantity = item.quantity;

        total = this.clearCurrencyMask(price) * this.clearCurrencyMask(quantity);
        item.total = this.toThousandFormat(Math.round(total));
        // ------ Finishing -------
        // Calculate Total
        let finishingQuantity = item.finishingQuantity;
        let finishingUnitPrice = item.finishingUnitPrice;
        let finishingTotal = finishingQuantity * finishingUnitPrice;
        item.finishingTotal = this.toThousandFormat(Math.round(finishingTotal));

        // Calculate Grand Total
        this.calculateDigitalGrandTotal();

      },
      calculateDigitalGrandTotal: function() {
        let vm = this;
        let digitalItemGrandTotal = this.digitalItems.map(item => parseInt(vm.clearCurrencyMask(item.total))).reduce((cur, acc) => {
          return cur + acc
        }, 0);
        this.digitalGrandTotal.item = this.toThousandFormat(digitalItemGrandTotal);

        let digitalFinishingGrandTotal = this.digitalItems.map(item => {
          // parseInt(vm.clearCurrencyMask(item.finishingTotal))
          let subItem = 0;
          if (item.subFinishingItems.length > 0) {
            subItem = item.subFinishingItems.map(sub => parseInt(vm.clearCurrencyMask(sub.total))).reduce((cur, acc) => {
              return cur + acc
            }, 0);
          }
          return parseInt(vm.clearCurrencyMask(item.finishingTotal)) + subItem;
        }).reduce((cur, acc) => {
          return cur + acc
        }, 0);

        this.digitalGrandTotal.finishing = this.toThousandFormat(digitalFinishingGrandTotal);

        this.digitalGrandTotal.total = digitalItemGrandTotal + digitalFinishingGrandTotal;
      },
      calculateSubFinishingItem: function(item) {
        let finishingQuantity = item.quantity;
        let finishingUnitPrice = item.unitPrice;

        let finishingTotal = finishingQuantity * finishingUnitPrice;

        item.total = this.toThousandFormat(Math.round(finishingTotal));
      },
      round2Decimal: function(number) {
        return Math.round((number + Number.EPSILON) * 100) / 100
      },
      clearCurrencyMask: function(masked) {
        if (masked == '' || masked == 0 || typeof(masked) == 'undefined') {
          return 0;
        }
        return masked.toString().replaceAll('.', '');
      },
      toThousandFormat: function(number) {
        if (number !== '') {
          // return number.toString().replace(/\d(?=(\d{3})+\.)/g, '$&,');
          return new Intl.NumberFormat('de-DE').format(number)
        }
        return;
      },
      onChangeCustomer: function(id) {
        //   console.log('changed');
        //   console.log(event.target.value);
        this.customerPpn = 0;
        this.customerPph = 0;

        const customer = this.customersAll.filter(customer => customer.id == id)[0];
        if (customer !== undefined) {
          this.customerPpn = customer.with_ppn;
          this.customerPph = customer.with_pph;
        }

        this.picEmail = '';
        this.picLoading = true;
        this.picPosOptions = [{
          id: '',
          text: 'Choose PIC PO'
        }];
        let vm = this;
        // let id = event.target.value;
        if (this.customers.length > 0 && this.customers !== null && id !== '') {
          axios.get('/api/customers/' + id + '/pic-pos').then((res) => {
            // console.log(res);
            vm.picPos = res.data.data;
            res.data.data.forEach(pic => {
              vm.picPosOptions.push({
                id: pic.id,
                text: pic.name,
              })
            })
            vm.picLoading = false;
            // vm.companySelected = true;
          }).catch(err => {
            vm.picLoading = false;
            console.log(err);
          });
        }
      },
      onChangePicPo: function(id) {
        if (id !== '') {
          this.picEmail = this.picPos.filter(pic => pic.id == id)[0].email;
        }
      },
    }
  })
</script>
<script>
  $(function() {
    // $('.estimation-date, .delivery-date').datepicker({
    //   todayBtn: true,
    //   clearBtn: true,
    //   orientation: "bottom left"
    // });

    $('.estimation-date').datepicker({
      format: 'yyyy-mm-dd',
      todayBtn: false,
      clearBtn: true,
      todayHighlight: true,
      orientation: "bottom left",
    }).on('changeDate', function(e) {
      app.$data.date = e.format(0, 'yyyy-mm-dd');
    });

    $('.delivery-date').datepicker({
      format: 'yyyy-mm-dd',
      todayBtn: false,
      clearBtn: true,
      todayHighlight: true,
      orientation: "bottom left",
    }).on('changeDate', function(e) {
      app.$data.deliveryDate = e.format(0, 'yyyy-mm-dd');
    });



    $('.mask-number').mask('000.000.000.000.000', {
      reverse: true
    });
    // let maskNumbers = document.querySelectorAll('.mask-number');
    // $('.mask-number').toArray().forEach(function(input) {
    //   var cleave = new Cleave(input, {
    //     delimiter: '.',
    //     numeralDecimalMark: ',',
    //     numeral: true,
    //     numeralThousandsGroupStyle: 'thousand'
    //   });
    // })
  });
</script>
@endsection