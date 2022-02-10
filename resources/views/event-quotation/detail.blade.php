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
                                                <div class="col-lg-4 col-md-12">
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
                                                </div>
                                                 <div class="col-lg-4 col-md-12">
                                                    <div class="border">
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
                                                    </div>
                                                </div>
                                                 <div class="col-lg-4 col-md-12">
                                                    <div class="border">
                                                        <div class="bg-success w-100" style="height: 5px;"></div>
                                                        <div class="p-3">
                                                            <h4>ASF</h4>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <span>Subtotal</span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                   
                                                                </div>
                                                            </div>
                                                           
                                                          
                                                           
                                                            <p class="text-right font-size-h4">Rp @{{ currencyFormat(normalAsf) }}</p>
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
                                    
                                    <div>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr v-if="!selectedItems.length">
                                                    <td colspan="7">
                                                        <p class="text-center">
                                                            <i class="flaticon2-open-box font-size-h1"></i>
                                                        </p>
                                                        <p class="text-center text-dark-50"><strong>Belum ada item</strong></p>

                                                    </td>
                                                </tr>
                                                <!-- begin commisionable cost -->
                                                  <tr  v-if="selectedItems.length>0">
                                                <td colspan="10"><a href="#">Commissionable Cost</a></td>
                                                </tr> 
                                                 
                                                <template v-for="(item, index) in selectedItems">
                                               
                                                <tr v-if="item.type=='cost'">
                                                <td colspan="7"><span >@{{item.name }}</a> </td>
                                                <td>
                                               <i class="fa fa-plus" aria-hidden="true" @click="addSubItem(item)"></i>
                                               
                                                </td>
                                                <td>
                                                 <i class="fa fa-trash" aria-hidden="true" @click="removeItem(index)"></i>
                                                </td>
                                                 
                                                </tr>
                                                   <tr v-if="item.type=='cost'">
                                                        <th>#</th>

                                                             <th style="width: 5%;">Stock</th>
                                                            
                                                            <th style="width: 25%;">Subitem</th>
                                                            <!-- <th>Deskripsi</th> -->
                                                            <th style="width: 10%;" >Quantity</th>
                                                            <th style="width: 10%;">Frequency</th>
                                                            <th>Rate</th>
                                                            <th>Subtotal</th>
                                                            <th colspan="2"> Action</th>
                                                        </tr>
                                                   
                                                    <template v-if="item.type=='cost'" v-for="(subitem, index) in item.items" >                 
                                                    
                                                        <tr>
                                                            <th class="align-middle text-center">@{{ index + 1 }}</th>

                                                              <td>
                                                                <label class="checkbox">
                                                                 <input v-model="subitem.isStock" class="btn-choose" type="checkbox"  v-if="subitem.isStock==1" checked v-on:click="isChecked(item,subitem)">   

                                                                  <input v-model="isStock" class="btn-choose" type="checkbox" v-if="subitem.isStock==0" v-on:click="isChecked(item,subitem)">   

                                                                 <span></span>&nbsp;  </label>
                                                            </td>
                                                        
                                                            <td class="w-10">
                                                                <div class="input-group">
                                                                   <select v-model="subitem.subItemId" class="form-control" id="subitemId" required v-if="subitem.isStock==0">
                                                                   <option selected >Choose name</option>
                                                                         <option v-for="(subitem,index) in item.subitems" v-bind:value="subitem.id">@{{subitem.name}}</option>
                                                                         
                                                                     </select>

                                                                      <select v-model="subitem.subItemId" class="form-control" id="subitemId"  @change="isSelected(subitem)" required v-if="subitem.isStock==1">
                                                                   <option selected >Choose Goods</option>
                                                                         <option v-for="(good,index) in goods" v-bind:value="good.id" >@{{good.number}}-@{{good.name}}</option>
                                                                         
                                                                     </select><br>
                                                                   
                                                                     
                                                            </div>
                                                         

                                                                       <div v-if="subitem.isStock==1" >
                                                                     <label>Stock : @{{subitem.stock}}</label><br>
                                                                      <label>Harga Jual : @{{subitem.purchasePrice}}</label>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <!-- <td>
                                                            <textarea class="form-control form-control-sm"></textarea>
                                                        </td> -->
                                                            <td>
                                                                <div class="input-group">
                                                                    
                                                                    <input type="number" v-model="subitem.quantity" class="form-control form-control-sm text-right" @input="calculateSubitemAmount(item,subitem)" >
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input v-if="subitem.isStock==0" type="number" v-model="subitem.frequency" class="form-control form-control-sm text-right" @input="calculateSubitemAmount(item,subitem)" >
                                                                
                                                                <input v-if="subitem.isStock==1" type="number" v-model="subitem.frequency" class="form-control form-control-sm text-right" @input="calculateSubitemAmount(item,subitem)" disabled >
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Rp</span>
                                                                    </div>
                                                                    <input type="text" v-model="subitem.rate" class="form-control form-control-sm text-right" @input="calculateSubitemAmount(item,subitem)" >
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Rp</span>
                                                                    </div>
                                                                    <input type="text" disabled v-model="subitem.subtotal" class="form-control form-control-sm text-right">
                                                                </div>
                                                            </td>
                                                            <td colspan="3">
                                                            <div class="text-right"  >
                                                                    <button type="button" class="btn btn-danger" @click="removeSubItem(item,index)">Hapus</button>
                                                                </div>
                                                            <td>
                                                        
                                                        
                                                   
                                                        </tr>
                                                        
                                                    
                                                    </template>
                                                   
                                                      <tr v-if="item.type=='cost'">
                                                        
                                                            
                                                            <th colspan="6">Total</th>
                                                           
                                                            
                                                          <td>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Rp</span>
                                                                    </div>
                                                                    <input type="text" disabled class="form-control form-control-sm text-right" v-model="item.subtotal">
                                                                </div>
                                                            </td>

                                                        </tr>
                                                        
                                                      

                                                </template>
                                                 <tr  v-if="selectedItems.length>0">
                                                <td colspan="10" style="border: none;"><br></td>
                                                </tr> 
                                                </tbody>
                                                </table>
                                                <table class="table table-bordered mt-15">
                                                  <tbody>
                                             
                                                <!-- end commsionable fee -->


                                                <tr>
                                                <td colspan="10"  v-if="selectedItems.length>0"><a href="#">Nonfee Cost</a></td>
                                                </tr>                                                <!-- begin nonfee -->
                                                     <template v-for="(item, index) in selectedItems">
                                                   
                                                <tr v-if="item.type=='non'">
                                                <td colspan="7"><span >@{{item.name }}</span> </td>
                                                <td>
                                               <i class="fa fa-plus" aria-hidden="true" @click="addSubItem(item)"></i>
                                               
                                                </td>
                                                <td>
                                                 <i class="fa fa-trash" aria-hidden="true" @click="removeItem(index)"></i>
                                                </td>
                                                 
                                                </tr>
                                                   <tr v-if="item.type=='non'">
                                                        <th>#</th>

                                                             <th style="width: 5%;">Stock</th>
                                                            
                                                            <th style="width: 25%;">Subitem</th>
                                                            <!-- <th>Deskripsi</th> -->
                                                            <th style="width: 10%;" >Quantity</th>
                                                            <th style="width: 10%;">Frequency</th>
                                                            <th>Rate</th>
                                                            <th>Subtotal</th>
                                                            <th colspan="2"> Action</th>
                                                        </tr>
                                                   
                                                    <template v-if="item.type=='non'" v-for="(subitem, index) in item.items" >                 
                                                    
                                                        <tr>
                                                            <th class="align-middle text-center">@{{ index + 1 }}</th>

                                                              <td>
                                                                <label class="checkbox">
                                                                 <input v-model="subitem.isStock" class="btn-choose" type="checkbox"  v-if="subitem.isStock==1" checked v-on:click="isChecked(item,subitem)">   

                                                                  <input v-model="isStock" class="btn-choose" type="checkbox" v-if="subitem.isStock==0" v-on:click="isChecked(item,subitem)">   

                                                                 <span></span>&nbsp;  </label>
                                                            </td>
                                                        
                                                            <td class="w-10">
                                                                <div class="input-group">
                                                                   <select v-model="subitem.subItemId" class="form-control" id="subitemId" required v-if="subitem.isStock==0">
                                                                   <option selected >Choose name</option>
                                                                         <option v-for="(subitem,index) in item.subitems" v-bind:value="subitem.id">@{{subitem.name}}</option>
                                                                         
                                                                     </select>

                                                                      <select v-model="subitem.subItemId" class="form-control" id="subitemId"  @change="isSelected(subitem)" required v-if="subitem.isStock==1">
                                                                   <option selected >Choose Goods</option>
                                                                         <option v-for="(good,index) in goods" v-bind:value="good.id" >@{{good.number}}-@{{good.name}}</option>
                                                                         
                                                                     </select><br>
                                                                   
                                                                     
                                                            </div>
                                                         

                                                                       <div v-if="subitem.isStock==1" >
                                                                     <label>Stock : @{{subitem.stock}}</label><br>
                                                                      <label>Harga Jual : @{{subitem.purchasePrice}}</label>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <!-- <td>
                                                            <textarea class="form-control form-control-sm"></textarea>
                                                        </td> -->
                                                            <td>
                                                                <div class="input-group">
                                                                    
                                                                    <input type="number" v-model="subitem.quantity" class="form-control form-control-sm text-right" @input="calculateSubitemAmount(item,subitem)" >
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input v-if="subitem.isStock==0" type="number" v-model="subitem.frequency" class="form-control form-control-sm text-right" @input="calculateSubitemAmount(item,subitem)" >
                                                                
                                                                <input v-if="subitem.isStock==1" type="number" v-model="subitem.frequency" class="form-control form-control-sm text-right" @input="calculateSubitemAmount(item,subitem)" disabled >
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Rp</span>
                                                                    </div>
                                                                    <input type="text" v-model="subitem.rate" class="form-control form-control-sm text-right" @input="calculateSubitemAmount(item,subitem)" >
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Rp</span>
                                                                    </div>
                                                                    <input type="text" disabled v-model="subitem.subtotal" class="form-control form-control-sm text-right">
                                                                </div>
                                                            </td>
                                                            <td colspan="3">
                                                            <div class="text-right"  >
                                                                    <button type="button" class="btn btn-danger" @click="removeSubItem(item,index)">Hapus</button>
                                                                </div>
                                                            <td>
                                                        
                                                        
                                                   
                                                        </tr>
                                                        
                                                     
                                                    </template>
                                                   
                                                      <tr v-if="item.type=='non'">
                                                        
                                                            
                                                            <th colspan="6">Total</th>
                                                           
                                                            
                                                          <td>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Rp</span>
                                                                    </div>
                                                                    <input type="text" disabled class="form-control form-control-sm text-right" v-model="item.subtotal">
                                                                </div>
                                                            </td>

                                                        </tr>
                                                      
                                             
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
                                                            <h4>Total</h4>
                                                            <div v-if='commissionableCost!=0' class="row">
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
                                                            </div>
                                                            
                                                              <div v-if='normalAsf!=0'  class="row">
                                                                <div class="col-sm-6">
                                                                    <span>ASF @{{percentAsf}} %</span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span>@{{ currencyFormat(normalAsf) }}</span>
                                                                </div>
                                                            </div>  
                                                             <div v-if='normalDiscount!=0' class="row">
                                                                <div class="col-sm-6">
                                                                    <span>Diskon @{{percentDiscount}} %</span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span>@{{ currencyFormat(normalDiscount) }}</span>
                                                                </div>
                                                            </div>  
                                                             <div v-if='commissionableCost!=0 || nonFeeCost!=0' class="row">
                                                                <div class="col-sm-6">
                                                                    <span><strong>Netto</strong></span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span>@{{ currencyFormat(netto) }}</span>
                                                                </div>
                                                            </div>  
                                                            <div v-if="ppn" class="row">
                                                                <div class="col-sm-6">
                                                                    <span>PPN @{{ percentPpn }}%</span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span>@{{ currencyFormat(ppnAmount) }}</span>
                                                                </div>
                                                            </div>
                                                            <div v-if="pph23" class="row">
                                                                <div class="col-sm-6">
                                                                    <span>PPh23 @{{ percentPph23 }}%</span>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <span>(@{{ currencyFormat(pph23Amount) }})</span>
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
            percentPpn: 10,
            pph23: false,
            percentPph23: 2,
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
           
        },
        methods: {
            submitForm: function() {
                   this.sendData();
                // console.log(this.eventPicId);
                // console.log(this.poPicId);
            
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
                        total:vm.grandTotal
                        
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
                                 window.location.href = '/event-quotation';
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
            calculateSubitemAmount:function(item,subitem){

                if (subitem.isStock==1){
                    if (subitem.quantity>subitem.stock){
                        subitem.quantity=subitem.stock
                    }
                     subitem.subtotal=Number(subitem.quantity)* Number(subitem.rate);

                }else{
                     subitem.subtotal=Number(subitem.quantity)* Number(subitem.frequency) * Number(subitem.rate);
                }
           
               

                this.calculateSubitem(item)

            },
            calculateSubitem:function(item){
                item.subtotal=item.items.map((subitem)=>{

                    const amount=Number(subitem.subtotal)
                    return amount;
                }).reduce((acc,cur)=>{
                    return acc+cur;
                },0)


            },
            calculateASF:function(){
                 const grandTotal=this.selectedItems.filter((item)=>item.type=="cost").map((item)=>item.subtotal).reduce((acc,cur)=>{
                    return acc+cur;
                },0)
                this.normalAsf=Math.round((this.percentAsf/100) * grandTotal);


            },
             calculateDiscount:function(){
                this.normalDiscount=Math.round((this.percentDiscount/100) * (this.commissionableCost + this.nonFeeCost));
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
                       

              
                
            }
           

        },
        computed: {
            subtotal: function() {
                const grandTotal = this.items.map(item => Number(item.amount)).reduce((acc, cur) => {
                    return acc + cur;
                }, 0);

                return Math.round(grandTotal);
            },
         
            ppnAmount: function() {
                let vm = this;
                if (!vm.ppn) {
                    return 0;
                }

                
                const ppn = (Number(this.commissionableCost)) * (Number(vm.percentPpn) / 100);
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
                const grandTotal = this.items.map(item => Number(item.amount)).reduce((acc, cur) => {
                    return acc + cur;
                }, 0);

                return Math.round(this.netto+this.ppnAmount-this.pph23Amount);
            },
            //commssionableCos
            commissionableCost:function(){
                const grandTotal=this.selectedItems.filter((item)=>item.type=="cost").map((item)=>item.subtotal).reduce((acc,cur)=>{
                    return acc+cur;
                },0)
                return grandTotal;
            },
            nonFeeCost:function(){
                const grandTotal=this.selectedItems.filter((item)=>item.type!="cost").map((item)=>item.subtotal).reduce((acc,cur)=>{
                    return acc+cur;
                },0)
                return grandTotal;

            },
            netto:function(){
                return Math.round(((this.commissionableCost + this.nonFeeCost + this.normalAsf) - this.normalDiscount))

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