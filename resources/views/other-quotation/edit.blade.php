@extends('layouts.app')

@section('title', 'Metaprint')

@section('head')
<link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('pagestyle')
<style>
    .input-group-text {
        padding: 0.45rem 1rem;
    }

    /* table tbody td {
        vertical-align: middle;
    } */
</style>
@endsection

@section('subheader')
<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Page Title-->
                <h5 class="text-dark font-weight-bold my-1 mr-5">Tambah Quotation</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Quotation</a>
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
                <h3 class="card-title">Form Quotation</h3>

            </div>
            <!--begin::Form-->
            <form class="form" autocomplete="off" @submit.prevent="submitForm" enctype="multipart/form-data">
                <div class="card-body">
                     <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <div class="form-row">
                                <div class="col-lg-6 col-md-12">
                                 
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-12 col-md-12">
                                    <label>Tanggal:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="flaticon2-calendar-9"></i></span>
                                        </div>
                                        <input type="text" v-model="date" id="date" class="form-control">
                                    </div>
                                </div>
                                
                                <!-- <div class="form-group col-lg-6 col-md-6">
                                    <label>Customer:</label>
                                     <select2 v-model="customerId" :options="customers" class="form-control" required>
                                    </select2>
                                </div> -->
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>PIC Event:</label>
                                     <select2 v-model="eventPicId" :options="eventPics" class="form-control" required>
                                    </select2>
                                </div>
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>PIC PO:</label>
                                 <select2po v-model="poPicId" :options="poPics" class="form-control" required>
                                    </select2po>
                                </div>
                                
                            </div>
                                <div class="form-row">
                                <div class="form-group col-lg-12 col-md-12">
                                    <label>Customer:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                         <input type="text" v-model="customerName" id="customer" class="form-control">
                                       
                                    </div>
                                </div>
                                <!-- <div class="form-group col-lg-6 col-md-6">
                                    <label>Customer:</label>
                                     <select2 v-model="customerId" :options="customers" class="form-control" required>
                                    </select2>
                                </div> -->
                            </div>
                            <div class="form-row">
                            <div class="form-group col-lg-12 col-md-12">
                                    <label>Title:</label>
                                    <input type="text" v-model="title" class="form-control">
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="mt-5">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="goods-tab" data-toggle="tab" href="#goods">
                                    <span class="nav-icon">
                                        <i class="flaticon-signs-1"></i>
                                    </span>
                                    <span class="nav-text">List Item</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="other-cost-tab" data-toggle="tab" href="#other-cost">
                                    <span class="nav-icon">
                                        <i class="flaticon-signs-1"></i>
                                    </span>
                                    <span class="nav-text">Biaya Lain</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="other-tab" data-toggle="tab" href="#other">
                                    <span class="nav-icon">
                                        <i class="flaticon-information"></i>
                                    </span>
                                    <span class="nav-text">info Lainnya</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="goods" role="tabpanel" aria-labelledby="goods-tab">
                                <div class="mt-2">
                                    <div class="my-3 text-right">
                                        <button type="button" class="btn btn-success" @click="addItem"><i class="flaticon2-plus"></i> Tambah</button>
                                    </div>
                                    <div>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr v-if="!items.length">
                                                    <td colspan="6">
                                                        <p class="text-center">
                                                            <i class="flaticon2-open-box font-size-h1"></i>
                                                        </p>
                                                        <p class="text-center text-dark-50"><strong>Belum ada item</strong></p>

                                                    </td>
                                                </tr>
                                                <template v-for="(item, index) in items">
                                                    <tr>
                                                    <th style="width: 30px;">#</th>
                                                        <th style="width: 50px;">Stock</th>
                                                        <th colspan="5">Nama Item</th>
                                                        <!-- <th>Quantity</th>
                                                        <th>Frequency</th>
                                                      
                                                        <th>Unit Price</th>
                                                        <th>Amount</th> -->
                                                       
                                                    </tr>
                                                    <tr>
                                                        <th rowspan="3" class="align-middle text-center">@{{ index + 1 }}</th>
                                                        <td class="text-right" rowspan="3" >
                                                               <label class="checkbox">
                                                                 <input v-model="item.isStock" class="btn-choose" type="checkbox"  v-if="item.isStock==1" checked v-on:click="isChecked(item)">   

                                                                  <input v-model="item.isStock" class="btn-choose" type="checkbox" v-if="item.isStock==0" v-on:click="isChecked(item)">   

                                                                 <span></span>&nbsp;  </label>
                                                        </td>
                                               
                                                         <td colspan="5" >

                                                            <!-- <div class="row">
                                                                <div class="col-md-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label><strong>Nama Item</strong></label>
                                                                        <input type="text" v-model="item.name" class="form-control form-control-sm">
                                                                    </div>
                                                                </div>
                                                            </div> -->
                                                            <div class="form-group">
                                                                
                                                                <textarea v-model="item.name" rows="5" class="form-control form-control-sm" v-if="item.isStock==0"></textarea>
                                                                  <select v-model="item.goodsId" class="form-control" id="goodsId"  @change="isSelected(item)" required v-else>
                                                                   <option selected >Choose Goods</option>
                                                                         <option v-for="(good,index) in goods" v-bind:value="good.id" >@{{good.number}}-@{{good.name}}</option>
                                                                         
                                                                     </select>
                                                                    <div v-if="item.isStock==1">
                                                                     <label>Stock : @{{item.stock}}</label><br>
                                                                      <label>Harga Jual : @{{toCurrencyFormat(item.purchasePrice)}}</label>
                                                                    </dvi>
                                                            </div>
                                                            
                                                           
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                   
                                                        
                                                        <th>Quantity</th>
                                                        <th>Frequency</th>
                                                         <th>Unit Price</th>
                                                          <th>Amount</th>
                                                      
                                                      
                                                       
                                                    </tr>
                                                    </tr>
                                                    <tr>
                                                          
                                                            
                                                    
                                                        <td>
                                                            <div class="input-group">
                                                               <input type="text" v-model="item.quantity" class="form-control form-control-sm text-right" @input="calculateSubitemAmount(item)" >
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input v-if="item.isStock==0"  type="text" v-model="item.frequency" class="form-control form-control-sm text-right" @input="calculateSubitemAmount(item)" >
                                                             <input v-if="item.isStock==1"  type="text" v-model="item.frequency" class="form-control form-control-sm text-right" @input="calculateSubitemAmount(item)"  disabled >
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">Rp</span>
                                                                </div>
                                                                <input type="text" v-model="item.price" class="form-control form-control-sm text-right"  @input="calculateSubitemAmount(item)">
                                                            </div>
                                                        </td>
                                                        <td class="text-right align-middle">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">Rp</span>
                                                                </div>
                                                                <input disabled type="text" v-model="item.amount" class="form-control form-control-sm text-right">
                                                            </div>
                                                            
                                                        </td>
                                                        <tr>
                                                        
                                                        
                                                        
                                                        <td  colspan="6">
                                                          <div class="row">
                                                                <div class="col-md-12 col-lg-6">
                                                                </div>
                                                            </div>
                                                            <div class="text-right">
                                                                <button type="button" class="btn btn-danger" @click="removeItem(index)">Hapus</button>
                                                            </div>
                                                        </td>
                                                        <tr>
                                                        <!-- <td colspan="6">
                                                        
                                                            <div class="form-group">
                                                                <label><strong>Name Item</strong></label>
                                                                <textarea v-model="item.name" rows="5" class="form-control form-control-sm" v-if="item.isStock==0"></textarea>
                                                                  <select v-model="item.goodsId" class="form-control" id="goodsId"  @change="isSelected(item)" required v-else>
                                                                   <option selected >Choose Goods</option>
                                                                         <option v-for="(good,index) in goods" v-bind:value="good.id" >@{{good.number}}-@{{good.name}}</option>
                                                                         
                                                                     </select>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12 col-lg-6">
                                                                </div>
                                                            </div>
                                                            <div class="text-right">
                                                                <button type="button" class="btn btn-danger" @click="removeItem(index)">Hapus</button>
                                                            </div>
                                                        </td> -->
                                                    </tr>
                                                    <tr>
                                                        <td colspan="7">
                                                            <div style="height: 5px;" class="w-100 bg-gray-200"></div>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                        <div class="mt-20">
                                            <div class="row justify-content-end">
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="border">
                                                        <div class="bg-success w-100" style="height: 5px;"></div>
                                                        <div class="p-3">
                                                            <h4>Total</h4>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <span>Subtotal</span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span>@{{ toCurrencyFormat(subtotal) }}</span>
                                                                </div>
                                                            </div>
                                                                 <div v-if='normalAsf!=0'  class="row">
                                                                <div class="col-sm-6">
                                                                    <span>ASF @{{percentAsf}} %</span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span>@{{ toCurrencyFormat(normalAsf) }}</span>
                                                                </div>
                                                            </div>  
                                                             <div v-if='normalDiscount!=0' class="row">
                                                                <div class="col-sm-6">
                                                                    <span>Diskon @{{percentDiscount}} %</span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span>@{{ toCurrencyFormat(normalDiscount) }}</span>
                                                                </div>
                                                            </div>  
                                                             <div class="row">
                                                                <div class="col-sm-6">
                                                                    <span><strong>Netto</strong></span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span>@{{ toCurrencyFormat(netto) }}</span>
                                                                </div>
                                                            </div>  
                                                            <div v-if="ppn" class="row">
                                                                <div class="col-sm-6">
                                                                    <span>PPN @{{ ppnValue }}%</span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span>@{{ toCurrencyFormat(ppnAmount) }}</span>
                                                                </div>
                                                            </div>
                                                            <div v-if="pph23" class="row">
                                                                <div class="col-sm-6">
                                                                    <span>PPh 23 @{{ pph23Value }}%</span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span>(@{{ toCurrencyFormat(pph23Amount) }})</span>
                                                                </div>
                                                            </div>
                                                            <div v-if="otherCost > 0" class="row">
                                                                <div class="col-sm-6">
                                                                    <span>Biaya Lain (@{{ otherCostDescription }})</span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span>@{{ toCurrencyFormat(otherCost) }}</span>
                                                                </div>
                                                            </div>
                                                            <p class="text-right font-size-h4">Rp @{{ toCurrencyFormat(grandTotal) }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="other-cost" role="tabpanel" aria-labelledby="other-cost-tab">
                                <div class="pt-5">
                                          <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                       

                                                  <div class="form-row align-items-center">
                                                <div class="form-group col-md-4">
                                                    <label >
                                                      
                                                        <span></span>&nbsp;ASF
                                                    </label>
                                                </div>
                                                <div class="form-group row col-md-8">
                                                    <div class="input-group col-md-5">
                                                        <input type="text" v-model="percentAsf" class="form-control text-right" placeholder="0" @input="calculateASF">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><strong class="text-dark-50">%</strong></span>
                                                        </div>
                                                      
                                                       
                                                    </div>
                                                    <div class="input-group col-md-7">
                                                    <div class="input-group-append">
                                                            <span class="input-group-text">Rp </span>
                                                        </div>
                                                        <input type="text" v-model="normalAsf" class="form-control text-right" placeholder="ASF" >
                                                        
                                                      
                                                       
                                                    </div>
                                                
                                                    
                                                </div>
                                            </div>
                                                <div class="form-row align-items-center">
                                                <div class="form-group col-md-4">
                                                    <label >
                                                      
                                                        <span></span>&nbsp;Diskon
                                                    </label>
                                                </div>
                                                <div class="form-group row col-md-8">
                                                    <div class="input-group col-md-5">
                                                        <input type="text" v-model="percentDiscount" class="form-control text-right" placeholder="0" @input="calculateDiscount" >
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><strong class="text-dark-50">%</strong></span>
                                                        </div>
                                                      
                                                       
                                                    </div>
                                                    <div class="input-group col-md-7">
                                                    <div class="input-group-append">
                                                            <span class="input-group-text">Rp </span>
                                                        </div>
                                                        <input type="text" v-model="normalDiscount" class="form-control text-right" placeholder="Diskon" >
                                                        
                                                      
                                                       
                                                    </div>
                                                
                                                    
                                                </div>
                                            </div>
                                            
                                            <!-- <div class="form-row align-items-center">
                                                <div class="form-group col-md-4">
                                                    <label>
                                                      
                                                        <span></span>&nbsp;PPN
                                                    </label>
                                                </div>
                                                <div class="form-group col-md-8">
                                                    <div class="input-group">
                                                        <input type="text" v-model="percentPpn" class="form-control text-right" placeholder="Tarif PPN" :readonly="!ppn">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><strong class="text-dark-50">%</strong></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- <div class="form-row align-items-center">
                                                <div class="form-group col-md-4">
                                                    <label >
                                                      
                                                        <span></span>&nbsp;PPh 23
                                                    </label>
                                                </div>
                                                <div class="form-group col-md-8">
                                                    <div class="input-group">
                                                        <input type="text" v-model="percentPph23" class="form-control text-right" placeholder="Tarif PPN" :readonly="!ppn">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><strong class="text-dark-50">%</strong></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                            

                                            <!-- <div class="form-group">
                                                <label>Biaya Lain:</label>
                                                <div class="form-row">
                                                    <div class="col-lg-6 col-md-12">
                                                        <input type="text" v-model="otherCostDescription" class="form-control" placeholder="Keterangan Biaya Lain">
                                                    </div>
                                                    <div class="col-lg-6 col-md-12">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><strong class="text-dark-50">Rp</strong></span>
                                                            </div>
                                                            <input type="text" v-model="otherCost" class="form-control text-right">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="other" role="tabpanel" aria-labelledby="other-tab">
                                <div class="pt-5 pb-3">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-group">
                                                <label>File (Max. 2MB)</label>
                                                <div class="custom-file">
                                                    <input type="file" id="customFile" accept=".jpg, .jpeg, .png, .pdf, .doc, .xls, .xlsx" class="custom-file-input" disabled>
                                                    <label id="file-upload-label" for="customFile" class="custom-file-label">Choose file</label>
                                                </div>
                                                <!---->
                                            </div>
                                            <div class="form-group">
                                                <label>Note:</label>
                                                <textarea v-model="note" class="form-control"></textarea>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
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
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
@endsection

@section('pagescript')
<script type="text/x-template" id="select2-template">
  <select>
        <slot></slot>
    </select>
</script>

<script type="text/x-template" id="select2-template-po">
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
           let customers=app.$data.eventPic;
           customer=customers.filter(($item)=>$item.id==this.value);
           if (customer!=null){
               app.$data.customerName=customer[0]['customer_name'];
               app.$data.customerId=customer[0]['customer_id'];
               app.$data.ppn=customer[0].ppn==1?true:false;
               app.$data.pph23=customer[0].pph23==1?true:false;
           }
          
          vm.$emit("input", this.value);
        });
    },
    watch: {
      value: function(value) {
          console.log(value)
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
    Vue.component("select2po", {
    props: ["options", "value"],
    template: "#select2-template-po",
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
          console.log(value)
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


</script>
<script>
    let app = new Vue({
        el: '#app',
        data: {
            id:'{{$event_quotation->id}}',
            up: '',
            title: '{{$event_quotation->title}}',
            venue:'{{$event_quotation->venue}}',
            note: '{{$event_quotation->note}}',
            customer: '',
            customerId:'{{$event_quotation->customer_id}}',
            customerName:'{{$event_quotation->customer->name}}',
            number: '',
            date: '{{$event_quotation->date}}',
            eventDate:'',
            description: '',
            loading: false,
            items: JSON.parse('{!!$other_quotation_items!!}'),
            ppn: '{!!$event_quotation->ppn=="1"?true:false!!}',
            percentPpn: 10,
            pph23: '{!!$event_quotation->pph=="1"?true:false!!}',
            percentPph23: 2,
            percentAsf:'{!!$event_quotation->asf_percent!!}',
            normalAsf:'{!!$event_quotation->asf!!}',
            percentDiscount:'{!!$event_quotation->discount_percent!!}',
            normalDiscount:'{!!$event_quotation->discount!!}',
            shippingCost: 0,
            otherCost: 0,
            otherCostDescription: '',
            customerId:'',
            selectedItems:[],
            eventPicId:'',
            poPicId:'',
            goods: JSON.parse('{!! $goods !!}'),
            // eventPic:JSON.parse('{!! $eventPic !!}'),
            // customers: JSON.parse('{!! $customers !!}'),
            eventPics: JSON.parse('{!! $eventPics !!}'),
            eventPic: JSON.parse('{!! $eventPic !!}'),
            poPics: JSON.parse('{!! $poPics !!}'),
        },
        methods: {
            submitForm: function() {
                this.sendData();
             

               ///console.log(this.selected_items);
            },
            sendData: function() {
                // console.log('submitted');
                let vm = this;
                vm.loading = true;
                axios.patch(`/other-quotation/`+this.id, {
                    date:vm.date,
                    event_pic_id:vm.eventPicId,
                    po_pic_id:vm.poPicId,
                    customer_id:vm.customerId,
                    title:vm.title,
                    selected_items:vm.items,
                    subtotal:vm.subtotal,
                    ppn: vm.ppn ? 1 : 0,
                    ppn_amount: vm.ppnAmount,
                    pph23: vm.pph23 ? 1 : 0,
                    pph23_amount: vm.pph23Amount,
                    percent_asf:vm.percentAsf,
                    asf_amount:vm.normalAsf,
                    percent_discount:vm.percentDiscount,
                    discount_amount:vm.normalDiscount,
                    note:vm.note,
                    total:vm.grandTotal,
                    netto:vm.netto,
                    image:null         
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
                                 window.location.href = '/other-quotation';
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
            calculateSubitemAmount:function(item){

                if (item.isStock==1){
                    if (item.quantity>item.stock){
                        item.quantity=item.stock
                    }
                     item.amount=Number(item.quantity)* Number(item.price);

                }else{
                     item.amount=Number(item.quantity)* Number(item.frequency) * Number(item.price);
                }
           
               

                //this.calculateSubitem(item)

            },
            addItem: function() {
                let vm = this;
                vm.items.push({
                    
                    name: '',
                    quantity: 1,
                    frequency:1,
                    price: 0,
                    amount: 0,
                    isStock:0,
                    goodsId:0,
                    stock:0,
                    purchasePrice:0,
                    goodsname:''

                   
                })
            },
            removeItem: function(index) {
                let vm = this;
                vm.items.splice(index, 1);
            },
            toCurrencyFormat: function(number) {
                return new Intl.NumberFormat('De-de').format(number);
            },
             isChecked:function(item){

  
                if (item['isStock']==0){
                    item['isStock']=1
                    item['quantity']=0;
                    item['goodsId']=0;
                    item['purchasePrice']=0;
                    item['frequency']=0;
                    item['stock']=0;
                    item['price']=0;
                    item['name']=""
                    item['amount']=0;
                
                }else{
                    
                   item['isStock']=0
                    item['quantity']=0;
                    item['goodsId']=0;
                    item['purchasePrice']=0;
                    item['frequency']=0;
                    item['stock']=0;
                    item['price']=0;
                    item['name']=""
                    item['amount']=0;
                }
               // this.calculateSubitem(item)
                //console.log(subitem['isStock'])
                
            },
            calculateASF:function(){
                 const grandTotal=this.items.map((item)=>item.subtotal).reduce((acc,cur)=>{
                    return acc+cur;
                },0)
                this.normalAsf=Math.round((this.percentAsf/100) * this.subtotal);


            },
             calculateDiscount:function(){
                this.normalDiscount=Math.round((this.percentDiscount/100) * (this.subtotal));
            },
            isSelected:function(item){
                console.log(item['goodsId']);
                console.log(this.goods)
                const goods=this.goods.filter((value)=>value.id==item['goodsId']);
                console.log(goods);
            
                    item.name= `${goods[0]['name']}`;
                    item.purchasePrice=goods[0]['purchase_price']
                    item.price=goods[0]['purchase_price']
                    item.stock=goods[0]['stock']
                       

              
                
            }

        },
        computed: {
            subtotal: function() {
                const grandTotal = this.items.map(item => Number(item.amount)).reduce((acc, cur) => {
                    return acc + cur;
                }, 0);

                return grandTotal;
            },
           ppnAmount: function() {
                let vm = this;
                if (!vm.ppn) {
                    return 0;
                }

                
                const ppn = (Number(this.subtotal)) * (Number(vm.percentPpn) / 100);
                return Math.round(ppn);
            },
            pph23Amount: function() {
                let vm = this;
                if (!vm.pph23) {
                    return 0;
                }

                const pph23 = this.normalAsf * (Number(this.percentPph23)/100);
                return Math.round(pph23);
            },
            grandTotal: function() {
                

                return Math.round(this.netto + this.ppnAmount - this.pph23Amount);
            },
               netto:function(){
                return ((this.subtotal + this.normalAsf) - this.normalDiscount)

            }
        },
        watch: {
            items: {
                handler: function(newval, oldval) {
                    this.items.forEach(item => {
                        item.amount = Number(item.price) * Number(item.quantity);
                    });
                },
                deep: true
            }
        }
    })
</script>
<script>
    $(function() {
        $('#po-date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: false,
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
        }).on('changeDate', function(e) {
            app.$data.date = e.format(0, 'yyyy-mm-dd');
        });

        $('#delivery-date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: false,
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
        }).on('changeDate', function(e) {
            app.$data.deliveryDate = e.format(0, 'yyyy-mm-dd');
        });
    })
</script>
<script>
    $(function() {
        $('#date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: false,
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
        }).on('changeDate', function(e) {
            app.$data.date = e.format(0, 'yyyy-mm-dd');
        });

        // $('#delivery-date').datepicker({
        //     format: 'yyyy-mm-dd',
        //     todayBtn: false,
        //     clearBtn: true,
        //     todayHighlight: true,
        //     orientation: "bottom left",
        // }).on('changeDate', function(e) {
        //     app.$data.deliveryDate = e.format(0, 'yyyy-mm-dd');
        // });
    })
</script>
@endsection