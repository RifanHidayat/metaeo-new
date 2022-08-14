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
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Tanggal:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="flaticon2-calendar-9"></i></span>
                                        </div>
                                        <input type="text" v-model="date" id="date" class="form-control">
                                    </div>
                                </div>
                                  <div class="form-group col-lg-6 col-md-12">
                                    <label>Tanggal Event:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                       
                                        <input type="text" v-model="eventDate" id="eventDate" class="form-control">
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
                                         <input  type="text" v-model="customerName" id="customer" class="form-control" readOnly>
                                       
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
                                    <label>Title:</label>
                                    <input type="text" v-model="title" class="form-control">
                                </div>
                                 <div class="form-group col-lg-6 col-md-12">
                                    <label>Venue:</label>
                                    <input type="text" v-model="venue" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                          <div class="mt-20">
                                            <div class="row justify-content-end">
                                                <!-- <div class="col-lg-4 col-md-12">
                                                    <div class="border">
                                                        <div class="bg-success w-100" style="height: 5px;"></div>
                                                        <div class="p-3">
                                                            <h4>Commssionable Cost</h4>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <span>Subtotal</span>
                                                                </div>
                                                               
                                                            </div>
                                                           
                                                           
                                                           
                                                            <p class="text-right font-size-h4">Rp @{{ currencyFormat(commissionableCost) }}</p>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                 <div class="col-lg-4 col-md-12">
                                                    <!-- <div class="border">
                                                        <div class="bg-success w-100" style="height: 5px;"></div>
                                                        <div class="p-3">
                                                            <h4>Nonfee Cost</h4>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <span>Subtotal</span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    
                                                                </div>
                                                            </div>
                                                           
                                                            
                                                          
                                                             <p class="text-right font-size-h4">Rp @{{ currencyFormat(nonFeeCost) }}</p>
                                                        </div>
                                                    </div> -->
                                                </div>
                                                 <div class="col-lg-4 col-md-12">
                                                 <div class="border">
                                                        <div class="bg-success w-100" style="height: 5px;"></div>
                                                        <div class="p-3">
                                                            <h4>Summary</h4>
                                                            <!-- <div v-if='commissionableCost!=0' class="row">
                                                                <div class="col-sm-6">
                                                                    <span>Comssionable Cost</span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span>@{{ currencyFormat(commissionableCost) }}</span>
                                                                </div>
                                                            </div>
                                                            <div v-if='nonFeeCost!=0'  class="row">
                                                                <div class="col-sm-6">
                                                                    <span>Nonfee</span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span>@{{ currencyFormat(nonFeeCost) }}</span>
                                                                </div>
                                                            </div> -->

                                                            <div  class="row">
                                                                <div class="col-sm-6">
                                                                    <span>Netto</span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span>@{{ currencyFormat(subtotalItem) }}</span>
                                                                </div>
                                                            </div>
                                                            
                                                              <div v-if='normalAsf>0'  class="row">
                                                                <div class="col-sm-6">
                                                                    <span>ASF @{{percentAsf}} %</span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span>@{{ currencyFormat(normalAsf) }}</span>
                                                                </div>
                                                            </div> 
                                                            <!-- <div v-if="(normalAsf+subtotalItem)>0" class="row">
                                                                <div class="col-sm-6">
                                                                    <span>Total</span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span>@{{ currencyFormat(normalAsf+subtotalItem) }}</span>
                                                                </div>
                                                            </div>   -->
                                                            <div v-if='normalDiscount>0' class="row">
                                                                <div class="col-sm-6">
                                                                    <span>Diskon @{{percentDiscount}} %</span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span>@{{ currencyFormat(normalDiscount) }}</span>
                                                                </div>
                                                            </div> 
                                                             
                                                             <div v-if='commissionableCost!=0 || nonFeeCost!=0' class="row">
                                                                <div class="col-sm-6">
                                                                    <span><strong>Subtotal</strong></span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span><strong>@{{ currencyFormat(netto) }}</strong></span>
                                                                </div>
                                                            </div>  
                                                            
                                                            <div v-if="ppnAmount>0"  class="row">
                                                                <div class="col-sm-6">
                                                                    <span>PPN @{{percentPpn}}%</span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span>@{{ currencyFormat(ppnAmount) }}</span>
                                                                </div>
                                                            </div>
                                                            <div v-if="pph23Amount>0" class="row">
                                                                <div class="col-sm-6">
                                                                    <span>PPh23 @{{ percentPph23 }}%</span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span>(@{{ currencyFormat(pph23Amount) }})</span>
                                                                </div>
                                                            </div>
                                                            <div v-if="pphfinalAmount>0" class="row">
                                                                <div class="col-sm-6">
                                                                    <span>PPh Pasal 4 @{{ percentPphfinal }}%</span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span>(@{{ currencyFormat(pphfinalAmount) }})</span>
                                                                </div>
                                                            </div>
                                                            <div v-if="otherCost > 0" class="row">
                                                                <div class="col-sm-6">
                                                                    <span>Biaya Lain (@{{ otherCostDescription }})</span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span>@{{ currencyFormat(otherCost) }}</span>
                                                                </div>
                                                            </div>
                                                            <p class="text-right font-size-h4">Rp @{{ currencyFormat(grandTotal) }}</p>
                                                        </div>
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
                                    
                                    <div class="row">
                                      
                                            
                                    <template  v-for="(item,index) in itemMenu" >
                                    <button v-if="item.status==1" type="button" class="btn btn-success mr-2" data-toggle="modal"  data-whatever="@mdo">@{{item.name}}</button>
                                    <button v-if="item.status==0" type="button" class="btn btn-secondary mr-2" data-toggle="modal" @click="changeStatus(item.id,index)"    data-whatever="@mdo">@{{item.name}}</button>
                                  
                                    </template>
                                   
                                    </div>
                                    <div class="my-3 text-right">
                            
                                    </div>
                                    <div>
                                        <table class="table table-bordered">
                                            <tbody>
                                            
                                                <tr v-if="!showSubitem.length && !isLoadingItem">
                                                    <td colspan="7">
                                                        <p class="text-center">
                                                            <i class="flaticon2-open-box font-size-h1"></i>
                                                        </p>
                                                        <p class="text-center text-dark-50" ><strong>Belum ada item</strong></p>

                                                    </td>
                                                </tr>
                                               
                                                
                                                
                                                
                                                <template  v-if="showSubitem.length>0">
                                                <tr>
                                                    <td colspan="10"><div class="p-3 mb-2 bg-light text-dark">Object pph yang digunakan @{{objectPph}}</div></td>    
                                                 <tr>
                                                
                                            
                                                   <tr >
                                                        <th>#</th>

                                                             <th style="width: 20%;">Nama Subitems</th>
                                                            
                                                            <th style="width: 10%;">Quantity</th>
                                                            <!-- <th>Deskripsi</th> -->
                                                            <th style="width: 10%;" >Duration</th>
                                                            <th style="width: 10%;">Frequency</th>
                                                            <th>Rate</th>
                                                            <th style="width:15%" >Subtotal</th>
                                                            <th colspan="1"> ASF</th>
                                                            <th colspan="1"> PPh23</th>
                                                            <th colspan="1"> PPh Final</th>
                                                        </tr>
                                                   
                                                    <template  > 
                                                        <tr v-for="(subitem, index) in showSubitem">    
                                                    
                                                    <th class="align-middle text-center">@{{ index + 1 }}</th>
                                                    
                                         
                                                            <td>
                                                                <div class="input-group">
                                                                     
                                                                    <input type="text"  @input="calculateSubitemAmount(index)" disabled class="form-control form-control-sm disabled" :value="subitem.name">
                                                                  
                                                                </div>
                                                                <div v-if="subitem.goods!=null">
                                                                   <span class="text-muted"> Stock : @{{subitem.goods.stock}}<span>
                                                                    <br><span class="text-muted"> Price  : @{{subitem.goods.purchase_price}}<span>
                                                                   </div>
                                                            </td>   
                                                            <td>
                                                                <div class="inp ut-group">
                                                                    
                                                                    <input type="text" @input="calculateSubitemAmount(index)"   class="form-control form-control-sm text-right" v-model='subitem.quantity'  >
                                                                </div>
                                                            </td>   
                                                            <td>
                                                                <div class="input-group">
                                                                    
                                                                    <input type="text" @input="calculateSubitemAmount(index)" :disabled="subitem.disabled"  class="form-control form-control-sm text-right"   v-model='subitem.duration' >
                                                                </div>
                                                            </td>   
                                                            <td>
                                                                <div class="input-group">
                                                                    
                                                                    <input type="text" @input="calculateSubitemAmount(index)"  :disabled="subitem.disabled" class="form-control form-control-sm text-right"   v-model='subitem.frequency'  >
                                                                </div>
                                                            </td>   
                                                            <td>
                                                                <div class="input-group">
                                                                    
                                                                    <input type="text" @input="calculateSubitemAmount(index)" :disabled="subitem.disabled"  class="form-control form-control-sm text-right"  v-model='subitem.rate'  >
                                                                </div>
                                                            </td>   
                                                            <td>
                                                                <div class="input-group text-right" align="right" valign="right">
                                                                    <span class="text-right">@{{currencyFormat(subitem.subtotal)}}</span>
                                                                    
                                                                 <!-- //   <input type="text" :value="currencyFormat(subitem.subtota)" @input="calculateSubitemAmount(index)" :disabled="subitem.disabled"  class="form-control form-control-sm text-right"  v-model='subitem.subtotal'  > -->
                                                                </div>
                                                            </td>   
                                                            <td>
                                                                <label class="checkbox">
                                                                 <input v-model="subitem.is_asf" @input="calculateSubitemAmount(index)" class="btn-choose" type="checkbox" @change="changedAsf()" >   

                                                           
                                                                 <span></span>&nbsp;  </label>
                                                            </td>  
                                                                    
                                                            <td>
                                                                <label class="checkbox">
                                                                 <input v-model="subitem.is_pph23" @input="calculateSubitemAmount(index)" class="btn-choose" type="checkbox" @change="changedPph23(index)" >   

                                                           
                                                                 <span></span>&nbsp;  </label>
                                                            </td>  
                                                                    
                                                            <td>
                                                                <label class="checkbox">
                                                                 <input v-model="subitem.is_pphfinal" @input="calculateSubitemAmount(index)" class="btn-choose" type="checkbox"  @change="changedPphfinal(index)">   

                                                           
                                                                 <span></span>&nbsp;  </label>
                                                            </td>  
                                                                    
                                                    
                                                    </template>
                                                   

                                                </template>
                                                <!-- end non fee -->
                                           
                                            </tbody>
                                        </table>
                                        <div class="mt-20">
                                            <div class="row justify-content-end">
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="border">
                                                        <div class="bg-success w-100" style="height: 5px;"></div>
                                                        <div class="p-3">
                                                        <div class="row">
                                                                <div class="col-sm-6">
                                                                    <span>Total</span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span>@{{ currencyFormat(subtotalSubitems) }}</span>
                                                                </div>
                                                            </div>
                                                            <!-- <div class="row">
                                                                <div class="col-sm-6">
                                                                    <span>Total ASF</span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span>@{{ currencyFormat(asfSubitems) }}</span>
                                                                </div>
                                                            </div> -->
                                                            <!-- <div class="row">
                                                                <div class="col-sm-6">
                                                                    <span>PPh23</span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span>@{{ currencyFormat(pph23Subitems) }}</span>
                                                                </div>
                                                            </div> -->
                                                            <!-- <div class="row">
                                                                <div class="col-sm-6">
                                                                    <span>PPh Final</span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span>@{{ currencyFormat(pphfinalSubitems) }}</span>
                                                                </div>
                                                            </div> -->
                                                            <!-- <h4>Total</h4>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <span></span>
                                                                </div>
                                                                
                                                            </div>
                                                           
                                                             
                                                        
                                                            <p class="text-right font-size-h4">Rp @{{ currencyFormat(subtotalSubitems) }}</p> -->
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

                                            <div class="form-row align-items-center">
                                                <div class="form-group col-md-4">
                                                    <label >
                                                      
                                                        <span></span>&nbsp;PPN
                                                    </label>
                                                </div>
                                                <div class="form-group row col-md-8">
                                                    <div class="input-group col-md-5">
                                                        <input type="text" v-model="percentPpn" class="form-control text-right" placeholder="0" @input="calculateDiscount" >
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><strong class="text-dark-50">%</strong></span>
                                                        </div>
                                                      
                                                       
                                                    </div>
                                                     
                                             
                                                </div>
                                            </div>
                                            <div class="form-row align-items-center">
                                                <div class="form-group col-md-4">
                                                    <label >
                                                      
                                                        <span></span>&nbsp;PPh23
                                                    </label>
                                                </div>
                                                <div class="form-group row col-md-8">
                                                    <div class="input-group col-md-5">
                                                        <input type="text" v-model="percentPph23" class="form-control text-right" placeholder="0" @input="calculateDiscount" >
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><strong class="text-dark-50">%</strong></span>
                                                        </div>
                                                      
                                                       
                                                    </div>
                                                    
                                             
                                                </div>
                                            </div>
                                            <div class="form-row align-items-center">
                                                <div class="form-group col-md-4">
                                                    <label >
                                                      
                                                        <span></span>&nbsp;PPh Pasal 4
                                                    </label>
                                                </div>
                                                <div class="form-group row col-md-8">
                                                    <div class="input-group col-md-5">
                                                        <input type="text" v-model="percentPphfinal" class="form-control text-right" placeholder="0" @input="calculateDiscount" >
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><strong class="text-dark-50">%</strong></span>
                                                        </div>
                                                      
                                                       
                                                    </div>
                                                    
                                             
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="other" role="tabpanel" aria-labelledby="other-tab">
                                <div class="pt-5 pb-3">
                                    
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                              <div class="form-group">
                                                <label>Note:</label>
                                                <textarea v-model="note" class="form-control"></textarea>
                                            </div>
                                            <!-- <h4>Tampil Diskon<h4> -->
                                        <div class="form-group col-md-4">
                                            
                                                    <label class="checkbox">
                                                        <input v-model="isShowDiscount" type="checkbox">
                                                        <span></span>&nbsp;Tampil Diskon
                                                    </label>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class="checkbox">
                                                        <input v-model="isShowPpn" type="checkbox">
                                                        <span></span>&nbsp;Tampil PPN
                                                    </label>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class="checkbox">
                                                        <input v-model="isShowPph" type="checkbox">
                                                        <span></span>&nbsp;Tampil PPh23
                                                    </label>
                                                </div>
                                            
                                                <div class="form-group col-md-4">
                                                    <label class="checkbox">
                                                        <input v-model="isShowPphfinal" type="checkbox">
                                                        <span></span>&nbsp;Tampil PPh Pasal 4
                                                    </label>
                                                </div>
                                            
                                            <!-- <div class="form-group">
                                                <label>File (Max. 2MB)</label>
                                                <div class="custom-file">
                                                    <input type="file" id="customFile" accept=".jpg, .jpeg, .png, .pdf, .doc, .xls, .xlsx" class="custom-file-input" disabled>
                                                    <label id="file-upload-label" for="customFile" class="custom-file-label">Choose file</label>
                                                </div>
                                           
                                            </div> -->
                                           
                                            
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

<!-- Modal-->
<div class="modal fade" id="eventQuotationModal" tabindex="-1" role="dialog" aria-labelledby="quotationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quotationModalLabel">Item Quotation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                   
                </div>
                <table class="table" id="event-quotation-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                                         
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/pages/features/miscellaneous/sweetalert2.js') }}"></script>
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/collect.js/4.18.3/collect.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/collect.js/4.18.3/collect.js"></script>



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
$(function(){
                quotationsTable = $('#event-quotation-table').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: '/datatables/event-quotation/item',
                columns: [{
                        data: 'name',
                        name: 'name',
                        render: function(data, type) {
                            return `<a href="#">${data}</a>`;
                        }
                    },
                    {
                        data: 'type',
                        name: 'type', 
                        render:function(data,type){
                            return data=="cost"?"Commissionable Cost":"Non-fee Cost"
                        }
                    },      
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },

                ]
            });



        $('#event-quotation-table tbody').on('click', '.btn-choose', function() {
            const data = quotationsTable.row($(this).parents('tr')).data();
            let selectedItems= app.$data.selectedItems;
            let selectedSubItems=app.$data.selectedSubItems;
            let item;
            const selectedItem={
                    ...data
             }
            const itemId = selectedItems.map(item => item.id);
            
            if ((itemId.indexOf(selectedItem.id) < 0) ){
              item=[{
                "subItemId":0,
                "quantity":0,
                "frequency":0,
                "rate":0,
                "subtotal":0,
                "isStock":0,
                "stock":0,
                'purchasePrice':0,
                'goodsName':""
                }]
        
            selectedItem['subtotal']=0;

            selectedItem['items']=item;
            selectedItems.push(selectedItem)
            //console.log(selectedItems)

            }

        });
})
</script>
<script>
    let app = new Vue({
        el: '#app',
        data: {
            itemMenu:JSON.parse('{!! $items !!}'),
            type:'',
            showSubitem:[],
            isLoadingItem:false,
            isShowPpn:0,
            isShowDiscount:0,
            isShowPph:0,
            isShowPphfinal:0,
            up: '',
            title: '',
            venue:'',
            note: '',
            customer: '',
            customerId:'',
            customerName:'',
            number: '',
            date: '',
            eventDate:'',
            description: '',
            loading: false,
            items: [],
            ppn: false,
            percentPpn: 11,
            pph23: false,
            percentPph23: 2,
            percentPphfinal:10,
            percentAsf:0,
            normalAsf:0,
            percentDiscount:0,
            normalDiscount:0,
            shippingCost: 0,
            otherCost: 0,
            otherCostDescription: '',
            customerId:'',
            selectedItems:[],
            selectedSubItems:[],
            eventPicId:'',
            poPicId:'',
            costItems:[],
            lengthItems:[],
            goods: JSON.parse('{!! $goods !!}'),
            // eventPic:JSON.parse('{!! $eventPic !!}'),
            // customers: JSON.parse('{!! $customers !!}'),
            eventPics: JSON.parse('{!! $eventPics !!}'),
            eventPic: JSON.parse('{!! $eventPic !!}'),
            poPics: JSON.parse('{!! $poPics !!}'),
            createdBy:'{{ Auth::user()->id }}',
            objectPph:"",
            
            
            // isShowPPh:false,
            // isShowDiscount:true
        },
        methods: {
            submitForm: function() {
                const filtered=this.selectedSubItems.filter(function(item){
                    return item.is_checked==true;
                }).filter(function(item){
                    const isPph23=item.item.pph_object=="pph23"?true:false;
                    const isCurrentPPh23=item.is_pph23
                    const isCurrentPPhfinal=item.is_pphfinal
                    
                    if (isPph23==true){
                        if (isCurrentPPhfinal==true){
                            return item;
                        }

                    }else{
                        if (isCurrentPPh23==true){
                            return item;
                        }
                        

                    }
                   
                })
                if (filtered.length>0){
                    Swal.fire({
                    title: 'Are you sure?',
                    text: `Object PPh Item ${filtered[0].item.name}  Tidak sesuai`,
                    icon: 'warning',
                    reverseButtons: true,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Save',
                    cancelButtonText: 'Cancel',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        return this.sendData();
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Data has been deleted',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        })
                    }
                })
                

                }else{
                    this.sendData();
                }
                 // 
            
            },
            changeStatus:function(id,index){
               
                this.objectPph=this.itemMenu[index].pph_object=="pph23"?"PPh23":"PPh Pasal 4"
                var filtered=this.itemMenu.filter(function(item){
                  return id==item.id;

                });
                if (filtered.length>0){
                    this.type=filtered[0].type=="cost"?"Commissionbale Cost":"Non fee Cost"
                }

               
                this.itemMenu.filter(function(item){
                    item.status= item.id==id?1:0;

                });
                this.fetchSubitem(id);

            },
            disabledRow:function(index,currentValue){
                let vm=this;
                const id=this.showSubitem[index].id
                this.showSubitem[index].disabled=!currentValue;
                if (vm)
                var filtered=vm.selectedSubItems.filter(function(item){
                    return item.id==id;
                });
                if (filtered.length>0){
                    filtered[0].disabled=!currentValue;
                    console.log(filtered[0]);
                    console.log(this.showSubitem[index]);
                   
                   

                }else{
                    vm.selectedSubItems.push(this.showSubitem[index]);
          

                }
               

               
    
            },
            fetchSubitem:function(id){
                let vm = this;
                vm.showSubitem=[];
                vm.isLoadingItem=true;
                axios.get(`/quotation-item/${id}/subitem/detail`).then(function(response){
                    response.data.data.filter(function(item){
                        var filtered=vm.selectedSubItems.filter(function(subitem){
                            return item.id==subitem.id;
                        })
                        if (filtered.length>0){
                            vm.showSubitem.push(filtered[0]);
                            

                        }else{
                            vm.showSubitem.push(item);
                            
                        }
                       

                    });
                    vm.isLoadingItem=false;
                    

                    
                }).catch(function(err){
                    console.log(err);
                    vm.showSubitem=[];
                    vm.isLoadingItem=false;

                })

            },
            sendData: function() {
                // console.log('submitted');
                let vm = this;
                vm.loading = true;
                axios.post('/event-quotation', {
                        number:vm.number,
                        customer_id: vm.customerId,
                        event_pic_id:vm.eventPicId,
                        event_po_id:vm.eventPicPo,
                        date: vm.date,
                        event_date: vm.eventDate,
                        venue: vm.venue,
                        note: vm.note,
                        title: vm.title,
                        ppn: vm.ppn ? 1 : 0,
                        ppn_amount: vm.ppnAmount,
                        pph23: vm.pph23 ? 1 : 0,
                        pph23_amount: vm.pph23Amount,
                        pphfinal_amount:vm.pphfinalAmount,
                        percent_asf:vm.percentAsf,
                        asf_amount:vm.normalAsf,
                        percent_discount:vm.percentDiscount,
                        discount_amount:vm.normalDiscount,
                        selected_items:vm.selectedItems,
                        event_pic_id:vm.eventPicId,
                        po_pic_id:vm.poPicId,
                        commissionable_cost :vm.commissionableCost,
                        subtotal:vm.subtotal,
                        netto:vm.netto,
                        nonfee_cost:vm.nonFeeCost,
                        total:vm.grandTotal,
                        is_show_ppn:this.isShowPpn,
                        is_show_pph:this.isShowPph,
                        is_show_discount:this.isShowDiscount,
                        created_by:this.createdBy,
                        selected_subitems:this.selectedSubItems,
                        is_show_pphfinal:this.isShowPphfinal,
                        ppn_percent:this.percentPpn,
                        pph23_percent:this.percentPph23,
                        pphfinal_percent:this.percentPphfinal,
                        

                        
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
                              //   window.location.href = '/event-quotation';
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
            addSubItem: function(item) {
               
               let vm = this;
               let filltereditem=vm.selectedItems.filter((value,key)=>value.id==item.id);
               let i={
                "subItemId":0,
                "quantity":0,
                "frequency":0,
                "rate":0,
                "subtotal":0,
                "isStock":0,
               "stock":0,
                'purchasePrice':0,
                'goodsName':""
                }
                console.log(i);
               filltereditem[0]['items'].push(i)     
              // console.log(vm.selectedItems)          
            },
            removeSubItem: function(item,index) {
                let vm = this;
                console.log(item);
                let filltereditem=vm.selectedItems.filter((value,key)=>value.id==item.id);
                console.log(filltereditem[0]['items'].length)
                if (filltereditem[0]['items'].length>1){
                      filltereditem[0]['items'].splice(index, 1);
                }
              
            },
             removeItem: function(index) {
               let vm = this;
               // console.log()    
               vm.selectedItems.splice(index, 1);
            },
            currencyFormat: function(number) {
                return Intl.NumberFormat('de-DE').format(number);
            },
            clearCurrencyFormat: function(number) {
                if (!number) {
                    return 0;
                }
                return number.replaceAll(".", "");
            },
            calculateSubitemAmount:function(index){
                let vm=this;
                const id=this.showSubitem[index].id

                const quantity=this.showSubitem[index].quantity;
                const currentValue=this.showSubitem[index].disabled
                if (quantity>0){
                    this.showSubitem[index].disabled=false
                    this.showSubitem[index].is_checked=true
                      
                var filtered=vm.selectedSubItems.filter(function(item){
                    return item.id==id;
                });
                if (filtered.length>0){
                    //filtered[0].disabled=!currentValue;
                    console.log(filtered[0]);
                    console.log(this.showSubitem[index]);
                   
                   

                }else{
                    vm.selectedSubItems.push(this.showSubitem[index]);
          

                }
               

                }else{
                    this.showSubitem[index].is_checked=false
                    this.showSubitem[index].disabled=true
                }

             
               
               
              
                this.showSubitem[index].subtotal=this.showSubitem[index].quantity*this.showSubitem[index].frequency*this.showSubitem[index].duration*this.showSubitem[index].rate
                this.calculateASF();

                // if (subitem.isStock==1){
                //     if (subitem.quantity>subitem.stock){
                //         subitem.quantity=subitem.stock
                //     }
                //      subitem.subtotal=Number(subitem.quantity)* Number(subitem.rate);

                // }else{
                //      subitem.subtotal=Number(subitem.quantity)* Number(subitem.frequency) * Number(subitem.rate);
                // }
           
               

                // this.calculateSubitem(item)

            },
            // calculateSubitem:function(item){
            //     return this.showSubitem.map((subitem)=>{

            //         const amount=Number(subitem.subtotal)
            //         return amount;
            //     }).reduce((acc,cur)=>{
            //         return acc+cur;
            //     },0)

            // },
            
            calculateASF:function(){
                 const grandTotal=this.selectedSubItems.filter((item)=>item.is_asf==true && item.is_checked==true).map((item)=>item.subtotal).reduce((acc,cur)=>{
                    return acc+cur;
                },0)
                this.normalAsf=((this.percentAsf/100) * Number(grandTotal)).toFixed(2) ;


            },
            
             calculateDiscount:function(){
                this.normalDiscount=((this.percentDiscount/100) * (this.commissionableCost + this.nonFeeCost)).toFixed(2);
            },
            isChecked:function(item,subitem){
                //subitem['isStock']=subitem['isStock']==0?1:0
                if (subitem['isStock']==0){
                    subitem['isStock']=1
                    subitem['quantity']=0;
                    subitem['subItemId']=0;
                    subitem['purchasePrice']=0;
                    subitem['frequency']=0;
                    subitem['stock']=0;
                    subitem['rate']=0;
                    subitem['goodsName']=""
                    subitem['subtotal']=0;
                
                }else{
                    
                    subitem['isStock']=0;
                    subitem['quantity']=0;
                    subitem['subItemId']=0;
                    subitem['purchasePrice']=0;
                    subitem['frequency']=0;
                    subitem['stock']=0;
                    subitem['rate']=0;
                    subitem['goodsName']=""
                    subitem['subtotal']=0;
                }
                this.calculateSubitem(item)
                console.log(subitem['isStock'])
                
            },
            isSelected:function(subitem){
                const goods=this.goods.filter((item)=>item.id==subitem.subItemId);
            
                    subitem.goodsName= ` ${goods[0]['number']} - ${goods[0]['name']}`;
                    subitem.purchasePrice=goods[0]['purchase_price']
                    subitem.rate=goods[0]['purchase_price']
                    subitem.stock=goods[0]['stock']
                       

              
                
            },
            changedAsf:function(){
                this.calculateASF();
            },
            changedPph23:function(index){
              this.showSubitem[index].is_pphfinal=false;
               // this.calculateASF();


            },
            changedPphfinal:function(index){
                this.showSubitem[index].is_pph23=false;
             //   this.calculateASF();
            }
            
           

        },
        computed: {
            subtotalSubitems:function(item){
                return this.showSubitem.map((subitem)=>{

                    const amount=Number(subitem.is_checked==true?subitem.subtotal:0)
                    return amount;
                }).reduce((acc,cur)=>{
                    return acc+cur;
                },0)


            },
            pph23Subitems:function(item){
                const tempPph23=this.showSubitem.filter(function(subitem){
                    return subitem.is_pph23==true
                }).map((subitem)=>{

                    const amount=Number(subitem.is_checked==true?subitem.subtotal:0)
                    return amount;
                }).reduce((acc,cur)=>{
                    return acc+cur;
                },0)

                return tempPph23 * 0.2


            },
            pphfinalSubitems:function(item){
                const tempPphfinal=this.showSubitem.filter(function(subitem){
                    return subitem.is_pphfinal==true
                    }).map((subitem)=>{

                    const amount=Number(subitem.is_checked==true?subitem.subtotal:0)
                    return amount;
                    }).reduce((acc,cur)=>{
                    return acc+cur;
                    },0)

        return tempPphfinal * 0.2

            },
            asfSubitems:function(item){
             //  const asf=pph23Subitems *

            const asf=this.showSubitem.filter(function(subitem){
            return subitem.is_asf==true
            }).map((subitem)=>{

            const amount=Number(subitem.is_checked==true?subitem.subtotal:0)
            return amount;
            }).reduce((acc,cur)=>{
            return acc+cur;     
                },0)

        return asf


            },
            subtotal: function() {
                
                const grandTotal = this.items.map(item => Number(item.amount)).reduce((acc, cur) => {
                    return acc + cur;
                }, 0);

                return  grandTotal.toFixed(2);
            },
            subtotalItem: function() {
                const grandTotal=this.selectedSubItems.filter((subitem)=> subitem.is_checked==true).map((item)=>item.subtotal).reduce((acc,cur)=>{
                    return acc+cur;
                },0)
                return grandTotal.toFixed(2);
                // const grandTotal = this.items.map(item => Number(item.amount)).reduce((acc, cur) => {
                //     return acc + cur;
                // }, 0);

                // return Math.round(grandTotal);
            },
         
            ppnAmount: function() {
                const grandTotal=this.selectedSubItems.filter((item)=>item.is_asf==false && item.is_checked==true).map((item)=>item.subtotal).reduce((acc,cur)=>{
                    return acc+cur;
                },0)
                let vm = this;
                // if (!vm.ppn) {
                //     return 0;
                // }

                
                //const ppn = (Number(grandTotal)) * (Number(vm.percentPpn) / 100);
                const ppn = (Number(vm.netto)) * (Number(vm.percentPpn) / 100);
                return ppn.toFixed(2);
            },
            pph23Amount: function() {
                let vm = this;
                // if (!vm.pph23) {
                //     return 0;
                // }

                const grandTotal=this.selectedSubItems.filter((item)=>item.is_pph23==true && item.is_checked==true).map((item)=>item.subtotal).reduce((acc,cur)=>{
                    return acc+cur;
                },0)

             
                const pph23 = (((this.percentPph23/100) * Number(grandTotal)  ) );
                return (Number(pph23)+(Number(this.normalAsf) *(this.percentPph23/100))).toFixed(2)
            },
            pphfinalAmount: function() {
                let vm = this;
                // if (!vm.pph23) {
                //     return 0;
                // }

                const grandTotal=this.selectedSubItems.filter((item)=>item.is_pphfinal==true && item.is_checked==true).map((item)=>item.subtotal).reduce((acc,cur)=>{
                    return acc+cur;
                },0)

             
                const pph23 = ((this.percentPphfinal/100) * Number(grandTotal));
                return pph23.toFixed(2);
            },
            grandTotal: function() {
                // const grandTotal = this.items.map(item => Number(item.amount)).reduce((acc, cur) => {
                //     return acc + cur;
                // }, 0);
                let vm=this
                const grandTotal =Number(vm.netto)+Number(vm.ppnAmount)-Number(vm.pph23Amount)-Number(vm.pphfinalAmount);


                return grandTotal.toFixed(2);
            },
            //commssionableCos
            commissionableCost:function(){
                const grandTotal=this.selectedSubItems.filter((subitem)=>subitem.item.type=="cost" && subitem.is_checked==true).map((item)=>item.subtotal).reduce((acc,cur)=>{
                    return acc+cur;
                },0)
                return grandTotal;
            },
            nonFeeCost:function(){
                const grandTotal=this.selectedSubItems.filter((subitem)=>subitem.item.type=="non" && subitem.is_checked==true).map((item)=>item.subtotal).reduce((acc,cur)=>{
                    return acc+cur;
                },0)
                return grandTotal;

            },
            netto:function(){
                return ((Number(this.subtotalItem)+ Number(this.normalAsf)- Number(this.normalDiscount)) ).toFixed(2)
               
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