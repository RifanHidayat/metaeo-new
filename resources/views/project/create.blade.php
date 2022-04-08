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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Tambah Project</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Project</a>
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
                <h3 class="card-title">Form Project</h3>

            </div>
            <!--begin::Form-->
            <form class="form" autocomplete="off" @submit.prevent="submitForm" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <div class="form-row">
                                <!-- <div class="form-group col-lg-6 col-md-12">
                                    <label>Nomor:</label> -->
                                    <!-- <input type="text" class="form-control"> -->
                                    <!-- <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">#</span>
                                        </div>
                                        <input type="text" v-model="number" class="form-control" disabled>
                                    </div>
                                </div> -->
                                
                            </div>
                            <!-- <div class="bg-gray-100 p-3 rounded"> -->
                            <div class="form-row">
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Tanggal Mulai:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="flaticon2-calendar-9"></i></span>
                                        </div>
                                        <input type="text" v-model="startDate" class="form-control" id="start-date">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Tanggal Akhir:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="flaticon2-calendar-9"></i></span>
                                        </div>
                                        <input type="text" v-model="endDate" class="form-control" id="end-date">
                                    </div>
                                </div>
                               
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Customer:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        
                                        <input type="text" v-model="customer" class="form-control" >
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>PIC:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        
                                        <input type="text" v-model="pic" class="form-control" >
                                    </div>
                                </div>
                            </div>

                                <div class="form-row">
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Deskripsi:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        
                                        <textarea rowspan="5"  type="text" v-model="description" class="form-control" ></textarea>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Lokasi:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        
                                        <textarea rowspan="5" type="text" v-model="address" class="form-control" ></textarea>
                                    </div>
                                </div>
                            </div>


                          

                             <div class="form-row">
                                
                                <div class="form-group col-lg-12 col-md-12">
                                    <label>Nominal:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp </span>
                                        </div>
                                        <input type="text" v-model="grandTotal" id="grandTotal" class="form-control text-right" @input="validateAmount"><br>
                                        
                                    </div>
                                    <div  v-if="selectedData">
                                  
                                    </div>
                                        
                                </div>
                            </div>
                            <!-- </div> -->
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
                                <a class="nav-link" id="other-tab" data-toggle="tab" href="#other">
                                    <span class="nav-icon">
                                        <i class="flaticon-information"></i>
                                    </span>
                                    <span class="nav-text">Info Lainnya</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="goods" role="tabpanel" aria-labelledby="goods-tab">
                                <div class="mt-2">
                                    <div class="my-3 text-right">
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#salesOrdersModal"><i class="flaticon2-plus"></i> Pilih Sales Order</button>
                                        <!-- <button type="button"  class="btn btn-success" data-toggle="modal" data-target="#quotationModal"><i class="flaticon2-plus"></i> Pilih Quotation</button> -->
                                      
                                    </div>
                                    <div v-if="selectedData.length==0">
                                        <p class="text-center">
                                            <i class="flaticon2-open-box font-size-h1"></i>
                                        </p>
                                        <p class="text-center text-dark-50"><strong>Tidak ada data</strong></p>
                                    </div>
                                    <div v-if="selectedData.length>0">
                                        <!-- <div v-if="selectedData.source == 'purchase_order'">
                                            <div class="row">
                                                <div class="col-md-12 col-lg-12">
                                                    <div class="px-3 py-4 mb-3 rounded">
                                                        <h3 class="mb-0"><i class="flaticon2-correct text-success icon-lg mr-2"></i> Purchase Order <a href="#">#@{{ selectedData.data.number }}</a></h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-lg-6">
                                                    <table class="table">
                                                        <tr>
                                                            <td>Nomor PO</td>
                                                            <td><strong>@{{ selectedData.data.number }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tanggal PO</td>
                                                            <td><strong>@{{ selectedData.data.date }}</strong></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-12 col-lg-6">
                                                    <table class="table">
                                                        <tr>
                                                            <td>Customer</td>
                                                            <td><strong>@{{ selectedData.data.customer?.name }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Keterangan</td>
                                                            <td><strong>@{{ selectedData.data.description }}</strong></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="mt-5">
                                                <table class="table table-bordered">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th class="text-center">No</th>
                                                            <th>Kode</th>
                                                            <th class="text-center">Deskripsi</th>
                                                            <th class="text-center">Tanggal Kirim</th>
                                                            <th class="text-center">Kode Pajak</th>
                                                            <th class="text-right">Qty</th>
                                                            <th class="text-right">Price</th>
                                                            <th class="text-right">Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(item, index) in selectedData.data.items">
                                                            <td class="text-center">@{{ index + 1 }}</td>
                                                            <td>@{{ item.code }}</td>
                                                            <td><strong>@{{ item.name }}</strong> <br> <em class="text-dark-50">@{{ item.description }}</em></td>
                                                            <td class="text-center">@{{ item.delivery_date }}</td>
                                                            <td class="text-center text-capitalize">@{{ item.tax_code }}</td>
                                                            <td class="text-right">@{{ toCurrencyFormat(item.quantity) }}</td>
                                                            <td class="text-right">@{{ toCurrencyFormat(item.price) }}</td>
                                                            <td class="text-right">@{{ toCurrencyFormat(item.amount) }}</td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td class="text-right" colspan="7"><strong>TOTAL</strong></td>
                                                            <td class="text-right"><strong>@{{ toCurrencyFormat(selectedData.data.netto) }}</strong></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div> -->
                                        <div v-if="selectedData.length>0">
                                            <!-- <h1>Quotation <a href="#">#@{{ selectedData.data.number }}</a></h1> -->
                                           
                                            <div v-for="(item,index) in selectedData" >

                                            <!-- begin eo quotation -->
                                             <div v-if="item.source=='eo-quotation'">
                                                 <div class="row" >
                                                <div class="col-md-12 col-lg-12">
                                                    <div class="px-3 py-4 mb-3 rounded">
                                                        <h3 class="mb-0"><i class="flaticon2-correct text-success icon-lg mr-2"></i> Quotation <a href="#">#@{{ item.number }}</a></h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-lg-4">
                                                    <table class="table">
                                                        <tr>
                                                            <td>Nomor Quotation</td>
                                                            <td><strong>@{{ item.number }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tanggal Quotation</td>
                                                            <td><strong>@{{ item.date }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Customer</td>
                                                            <td><strong>@{{ item.customer?.name }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Netto</td>
                                                            <td><strong>@{{ toCurrencyFormat(item.netto) }}</strong></td>
                                                        </tr>
                                                       
                                                    </table>
                                                </div>
                                                <div class="col-md-12 col-lg-4">
                                                    <table class="table">
                                                        <tr>
                                                            <td>Title</td>
                                                            <td><strong>@{{ item.title }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>PIC Event</td>
                                                            <td><strong>@{{item.pic_event.name }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Keterangan</td>
                                                            <td><strong>@{{ item.description }}</strong></td>
                                                        </tr>
                                                    </table>
                                                </div>

                                                 <div class="col-md-12 col-lg-4">
                                                    <table class="table">
                                                        <tr>
                                                            <td>Nomor PO</td>
                                                            <td><strong>@{{ item.po_quotation.number }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tangagl PO</td>
                                                            <td><strong>@{{ item.po_quotation.date}}</strong></td>
                                                        </tr>
                                                        
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="mt-5">
                                            <!-- event quotation -->
                                                <!-- <table class="table table-bordered" v-if="selectedData.data.type=='event'">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th style="width: 50px;">No</th>
                                                            <th>Deskripsi</th>
                                                            <th  style="width: 20%;">Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(item, index) in selectedData.data.items">
                                                            <td>@{{ index + 1 }}</td>
                                                            <td>@{{ item.name }}</td>
                                                            <td class="text-right">@{{ toCurrencyFormat(item.subtotal) }} </td>
                                                       
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td class="text-right" colspan="2"><strong>Subtotal</strong></td>
                                                            <td class="text-right"><strong>@{{ toCurrencyFormat(selectedData.data.commissionable_cost+selectedData.data.nonfee_cost) }}</strong></td>
                                                        </tr>
                                                         <tr>
                                                            <td class="text-right" colspan="2"><strong>ASF @{{selectedData.data.asf_percent}}%</strong></td>
                                                            <td class="text-right"><strong>@{{ toCurrencyFormat(selectedData.data.asf) }}</strong></td>
                                                        </tr>
                                                           <tr>
                                                            <td class="text-right" colspan="2"><strong>Discount @{{selectedData.data.discount_percent}} %</strong></td>
                                                            <td class="text-right"><strong>@{{ toCurrencyFormat(selectedData.data.discount) }}</strong></td>
                                                        </tr>

                                                   
                                                    
                                                        <tr>
                                                            <td class="text-right" colspan="2"><strong>Netto</strong></td>
                                                            <td class="text-right"><strong>@{{ toCurrencyFormat(selectedData.data.netto) }}</strong></td>
                                                        </tr>
                                                    </tfoot>
                                                </table> -->
                                                <!-- event quotation -->

<!-- 
                                                    <table class="table table-bordered" v-if="selectedData.data.type=='other'">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th class="text-center">No</th>
                                                            <th class="text-center" style="width: 30%;">Nama</th>
                                                            <th class="text-center">Qty</th>
                                                            <th class="text-center">Frequency</th>
                                                            <th class="text-center">Unit Price</th>
                                                            <th class="text-center">Amount</th>
                                                         
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(item, index) in selectedData.data.other_quotation_items">
                                                            <td class="text-right">@{{ index + 1 }}</td>
                                                            <td>@{{ item.name }}</td>
                                                            <td class="text-right">@{{ item.quantity }}</td>
                                                            
                                                           
                                                            <td class="text-right">@{{ toCurrencyFormat(item.frequency) }}</td>
                                                            <td class="text-right">@{{ toCurrencyFormat(item.price) }}</td>
                                                            <td class="text-right">@{{ toCurrencyFormat(item.amount) }}</td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td class="text-right" colspan="5"><strong>Subtotal</strong></td>
                                                            <td class="text-right"><strong>@{{ toCurrencyFormat(selectedData.data.subtotal) }}</strong></td>
                                                        </tr>
                                                         <tr>
                                                            <td class="text-right" colspan="5"><strong>ASF @{{selectedData.data.asf_percent}}%</strong></td>
                                                            <td class="text-right"><strong>@{{ toCurrencyFormat(selectedData.data.asf) }}</strong></td>
                                                        </tr>
                                                         <tr>
                                                            <td class="text-right" colspan="5"><strong>Diskon @{{selectedData.data.discount_percent}}%</strong></td>
                                                            <td class="text-right"><strong>@{{ toCurrencyFormat(selectedData.data.discount) }}</strong></td>
                                                        </tr>
                                                     
                                                        <tr>
                                                            <td class="text-right" colspan="5"><strong>TOTAL</strong></td>
                                                            <td class="text-right"><strong>@{{ toCurrencyFormat(selectedData.data.netto) }}</strong></td>
                                                        </tr>
                                                    </tfoot>
                                                </table> -->
                                                   <div class="text-right">
                                                                <button type="button" class="btn btn-danger" @click="removeItem(index)">Hapus</button>
                                                    </div>
                                                 <div style="height: 5px;" class="w-100 bg-gray-200 mt-5"></div>
                                            </div>
                                            </div>
                                            <!-- end eo quotation -->

                                            <!-- begin sales purchase order -->
                                            <div v-if="item.source=='purchase_order'">
                                            <div class="row" >
                                                <div class="col-md-12 col-lg-12">
                                                    <div class="px-3 py-4 mb-3 rounded">
                                                        <h3 class="mb-0"><i class="flaticon2-correct text-success icon-lg mr-2"></i> Sales Order <a href="#">#@{{ item.number }}</a>
                                                        </h3><br>
                                                    </div>

                                                      
                                                </div>
                                            </div>
                                             
                                            <div class="row">
                                            
                                                <div class="col-md-12 col-lg-4">
                                                    <table class="table">
                                                        <tr>
                                                            <td>Nomor Sales order</td>
                                                            <td><strong>@{{ item.number }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tanggal Sales Order</td>
                                                            <td><strong>@{{ item.date  }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Customer</td>
                                                            <td><strong>@{{ item.customer!=null?item.customer.name:""}}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Netto</td>
                                                            <td><strong>@{{ item.customer_purchase_order.total }}</strong></td>
                                                        </tr>
                                                       
                                                    </table>
                                                </div>
                                                <div class="col-md-12 col-lg-4">
                                                    <table class="table">
                                                        <tr>
                                                            <td>No. Purchase Order</td>
                                                            <td><strong>@{{ item.customer_purchase_order.number }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tanggal</td>
                                                            <td><strong>@{{item.customer_purchase_order.date }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Deskripsi</td>
                                                            <td><strong>@{{ item.customer_purchase_order.description }}</strong></td>
                                                        </tr>
                                                    </table>
                                                </div>

                                                 <!-- <div class="col-md-12 col-lg-4">
                                                    <table class="table">
                                                        <tr>
                                                            <td>Nomor PO</td>
                                                            <td><strong>@{{ item.number }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tangagl PO</td>
                                                            <td><strong>@{{ item.number}}</strong></td>
                                                        </tr>
                                                        
                                                    </table>
                                                </div> -->
                                            </div>
                                            <div class="mt-5">
                                         
                                                   <div class="text-right">
                                                                <button type="button" class="btn btn-danger" @click="removeItem(index)">Hapus</button>
                                                            </div>
                                                 <div style="height: 5px;" class="w-100 bg-gray-200 mt-5"></div>
                                            </div>
                                            </div>
                                        <!-- end sales purchase order-->

                                         <!-- b xeging sales order quotations -->
                                             <div v-if="item.source=='quotation'">
                                              
                                            <div class="row" >
                                                <div class="col-md-12 col-lg-12">
                                                    <div class="px-3 py-4 mb-3 rounded">
                                                        <h3 class="mb-0"><i class="flaticon2-correct text-success icon-lg mr-2"></i> Sales Order <a href="#">#@{{ item.number }}</a></h3>
                                                    </div>
                                                </div>
                                            </div>
                                             <span class="form-text text-muted">
                                                        Source Quotation   
                                                        </span>
                                            <div class="row">
                                                <div class="col-md-12 col-lg-4">
                                                    <table class="table">
                                                        <tr>
                                                            <td>Nomor Sales Order</td>
                                                            <td><strong>@{{ item.number }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tanggal Sales Order</td>
                                                            <td><strong>@{{ item.date }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                           <td>Customer</td>
                                                            <td><strong>@{{ item.customer!=null?item.customer.name:""}}</strong></td>
                                                        </tr>
                                                       
                                                        <tr>
                                                            <td>Netto</td>
                                                            <td><strong>@{{ item.v2_quotation.total }}</strong></td>
                                                        </tr>
                                                       
                                                    </table>
                                                </div>
                                                       <div class="col-md-12 col-lg-4">
                                                    <table class="table">
                                                        <tr>
                                                            <td>No. Quotation</td>
                                                            <td><strong>@{{ item.v2_quotation.number }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tanggal</td>
                                                            <td><strong>@{{item.v2_quotation.date }}</strong></td>
                                                        </tr>
                                                         <tr>
                                                           <td>up</td>
                                                            <td><strong>@{{item.v2_quotation.up}}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Deskripsi</td>
                                                            <td><strong>@{{ item.v2_quotation.description }}</strong></td>
                                                        </tr>
                                                    </table>
                                                </div>

                                            
                                            </div>
                                            <div class="mt-5">
                                         
                                                   <div class="text-right">
                                                                <button type="button" class="btn btn-danger" @click="removeItem(index)">Hapus</button>
                                                            </div>
                                                 <div style="height: 5px;" class="w-100 bg-gray-200 mt-5"></div>
                                            </div>
                                            </div>
                                        <!-- begin sales order -->

                                        
                                        </div>
                                        <!-- end quotaiton -->

                                       
                                          
                                    
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="other" role="tabpanel" aria-labelledby="other-tab">
                                <div class="pt-5 pb-3">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-group">
                                                <label>File PO (Max. 2MB)</label>
                                                <div class="custom-file">
                                                    <input type="file" id="customFile" accept=".jpg, .jpeg, .png, .pdf, .doc, .xls, .xlsx" class="custom-file-input" disabled>
                                                    <label id="file-upload-label" for="customFile" class="custom-file-label">Choose file</label>
                                                </div>
                                                <!---->
                                            </div>
                                            <div class="form-group">
                                                <label>File GR (Max. 2MB)</label>
                                                <div class="custom-file">
                                                    <input type="file" id="customFile" accept=".jpg, .jpeg, .png, .pdf, .doc, .xls, .xlsx" class="custom-file-input" disabled>
                                                    <label id="file-upload-label" for="customFile" class="custom-file-label">Choose file</label>
                                                </div>
                                                <!---->
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

    <!-- Modal -->
    <div class="modal fade" id="quotationModal" tabindex="-1" aria-labelledby="quotationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quotationModalLabel">Pilih Quotation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table" id="quotation-table">
                        <thead>
                            <th>Nomor</th>
                            <th>Tanggal</th>
                            <th>Title</th>
                               <th>Netto</th>
                       
                            <th>Action</th>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="salesOrdersModal" tabindex="-1" aria-labelledby="salesOrdersModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quotationModalLabel">Pilih Quotation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table" id="sales-table">
                        <thead>
                            <th>Nomor</th>
                            <th>Tanggal</th>
                            <th>Title</th>
                               <th>Netto</th>
                       
                            <th>Action</th>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
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
<script>
    let app = new Vue({
        el: '#app',
        data: {
            number: '',
            date: '',
            startDate:'',
            endDate:'',
            grNumber:'',
            customer:'',
            pic:'',
            address:'',
            eventPicId:'',
            picId:0,
            customerId:'',
            eventPicName:'',
            eventPicPosition:'',
            magentaPicName:'Myrawati Setiawan',
            magentaPicPosition:'Project Magenta',
            commisinableCost:[],
            nonfeeCost:[],
            quotationId: '',
            quotationNumber: '',
            quotationDate: '',
            amount:'',
            poId: '',
            poNumber: '',
            poDate: '',
            termOfPayment: '',
            dueDate: '',
            description: '',
            bastRemaining:'',
            loading: false,
            selectedData: [],
            customerCode:'',
            source:'',
            poNumber:'',
        },
        methods: {
            submitForm: function() {
                this.sendData();
                // console.log(this.poNumber);
                // console.log(this.source);
            },
            sendData: function() {
                // console.log('submitted');
                let vm = this;
                vm.loading = true;
                const data = {
                    start_date: vm.startDate,
                    end_date: vm.endDate,
                    customer_id: vm.customerId || '0',
                    pic_id: vm.picId || '0',
                    pic:vm.pic,
                    customer:vm.customer,
                    description:vm.description,
                    address:vm.address,
                    amount:vm.grandTotal,
                    items:vm.selectedData,
                    source:vm.source,
                    po_number:vm.poNumber
    
                };

               

                axios.post('/project', data)
                    .then(function(response) {
                        vm.loading = false;
                        Swal.fire({
                            title: 'Success',
                            text: 'Data has been saved',
                            icon: 'success',
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '/project';
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
            validateAmount:function(){
                if (this.amount>this.bastRemaining){
                    this.amount=this.bastRemaining
                }

            },
            removeItem: function(index) {
                let vm = this;
                vm.selectedData.splice(index, 1);
            },
            toCurrencyFormat: function(number) {
                if (!number) {
                    number = 0;
                }
                return new Intl.NumberFormat('De-de').format(number);
            }
        },
        computed: {
            grandTotal: function() {
                const grandTotal = this.selectedData.map(item => Number(item.netto)).reduce((acc, cur) => {
                    return acc + cur;
                }, 0);

                return grandTotal;
            }
        },
    })
</script>
<script>
    $(function() {
        quotationsTable = $('#quotation-table').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: '/datatables/projects/quotations',
            columns: [{
                    data: 'number',
                    name: 'number',
                    render: function(data, type) {
                        return `<a href="#">${data}</a>`;
                    }
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                 {
                    data: 'netto',
                    name: 'netto',
                    render:function(data,type){
                        return Intl.NumberFormat('De-de').format(data)
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

        $('#quotation-table tbody').on('click', '.btn-choose', function() {
            const data = quotationsTable.row($(this).parents('tr')).data();
            const selected = {
                ...data,
            };
            console.log("data ",data);
             selected['source']='eo-quotation';
          
         
         
              const dataIds = app.$data.selectedData.map(product => product.id);
             if (dataIds.indexOf(selected.id) < 0) {
                   
                    app.$data.selectedData.push(selected);
                    app.$data.pic=app.$data.selectedData[0].pic_event.name
                    app.$data.picId=app.$data.selectedData[0].pic_event.id
                    app.$data.customer=app.$data.selectedData[0].customer.name
                    app.$data.customeId=app.$data.selectedData[0].customer.id
                     app.$data.poNumber=app.$data.selectedData[0].po_quotation.number
                    app.$data.number=""
                     app.$data.source="quotation"
                 
               

             }

            //$('#quotation-date').datepicker('update', newDate);
            //$('#quotationModal').modal('hide');
        });

 
  
    })



</script>
<script>

        $(function() {

        salesOrderTable = $('#sales-table').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: '/datatables/projects/sales-orders',
            columns: [{
                    data: 'number',
                    name: 'number',
                    render: function(data, type) {
                        return `<a href="#">${data}</a>`;
                    }
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'source',
                    name: 'source',
                    render:function(data,type){
                        return data=="quotation"?"Quotation":"Purchase Order"
                    }
                },

                 {
                    data: 'netto',
                    name: 'netto',
                    render:function(data,type){
                        return Intl.NumberFormat('De-de').format(data)
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

        $('#sales-table tbody').on('click', '.btn-choose', function() {
            const data =  salesOrderTable.row($(this).parents('tr')).data();
            const selected = {
                ...data,    
            };
            console.log(data)
            
         
              const dataIds = app.$data.selectedData.map(product => product.id);
             if (dataIds.indexOf(selected.id) < 0) {
                    app.$data.selectedData.push(selected);
                    app.$data.customer=app.$data.selectedData[0].customer===""?"":app.$data.selectedData[0].customer.name;
                    app.$data.customerId=app.$data.selectedData[0].customer===""?"":app.$data.selectedData[0].customer.id;
                    app.$data.poNumber="0"
                    app.$data.picId="0";
                    app.$data.source="sales-order"

                

             }

            //$('#quotation-date').datepicker('update', newDate);
            //$('#quotationModal').modal('hide');
        });
         })
</script>

<script>

  function number() {

   

    let title=app.$data.title;
    let number="" + t.substring(2, 4) + (bulan + 1) + tanggal + "/" + title + "/" + angka + "/" + t
    app.$data.number=number;


  }

  
        $('#start-date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: false,
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
        }).on('changeDate', function(e) {
            app.$data.startDate = e.format(0, 'yyyy-mm-dd');
        });
         $('#end-date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: false,
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
        }).on('changeDate', function(e) {
            app.$data.endDate = e.format(0, 'yyyy-mm-dd');
        });

</script>
@endsection