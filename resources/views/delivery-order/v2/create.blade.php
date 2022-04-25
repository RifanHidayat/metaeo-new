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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Tambah Delivery Order</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Delivery Order</a>
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
                <h3 class="card-title">Form Delivery Order</h3>
            </div>

            <!--begin::Form-->
            <form class="form" autocomplete="off" @submit.prevent="submitForm">
                <div class="card-body">
                    <div class="my-3 text-right">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#salesOrderModal"><i class="flaticon2-plus"></i> Pilih Sales Order</button>
                        
                    </div>
                    <div v-if="!selectedData">
                        <p class="text-center">
                            <i class="flaticon2-open-box font-size-h1"></i>
                        </p>
                        <p class="text-center text-dark-50"><strong>Pilih sales order</strong></p>
                    </div>
                    <div v-if="selectedData">
                    <div >
                        <div>
                            <!-- <h1>Sales Order <a href="#">#@{{ selectedData.data.number }}</a></h1> -->
                            <div class="row">
                            <!-- sales order -->
                                <div class="col-md-12 col-lg-6">
                                    <div class="px-3 py-4 mb-3 rounded">
                                        <h3 class="mb-0"><i class="flaticon2-correct text-success icon-lg mr-2"></i> Sales Order <a href="#">#@{{ selectedData.data.number }}</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-4">

                                    
                                    <table class="table">
                                        <tr>
                                            <td>Nomor</td>
                                            <td><strong>@{{ selectedData.data.number }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal SO</td>
                                            <td><strong>@{{ selectedData.data.date }}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-12 col-lg-4">
                                    <table class="table">
                                        <tr>
                                            <td>Nomor Quotation</td>
                                            <td><strong>@{{ selectedData.data.quotation_number  }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Quotation</td>
                                            <td><strong>@{{ selectedData.data.quotation_date }}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-12 col-lg-4">
                                    <table class="table">
                                        <tr>
                                            <td>Nomor PO</td>
                                            <td><strong>@{{ selectedData.data.customer_purchase_order_number }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal PO</td>
                                            <td><strong>@{{ selectedData.data.customer_purchase_order_date }}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                     
                    </div>
                    <!-- begin sales order -->
                    <div v-if="selectedData" class="mt-20">

                     <!-- begin sales order -->
                     <div v-if="selectedData.source=='metaprint'"  class="mt-20">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="delivery-item-tab" data-toggle="tab" href="#delivery-item">
                                    <span class="nav-icon">
                                        <i class="flaticon-signs-1"></i>
                                    </span>
                                    <span class="nav-text">Item Pengiriman&nbsp;<span class="label label-primary mr-2">@{{ dataItems.length }}</span></span>

                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="goods-tab" data-toggle="tab" href="#goods">
                                    <span class="nav-icon">
                                        <i class="flaticon-signs-1"></i>
                                    </span>
                                    <span class="nav-text">Info Delivery Order</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="other-tab" data-toggle="tab" href="#other">
                                    <span class="nav-icon">
                                        <i class="flaticon-signs-1"></i>
                                    </span>
                                    <span class="nav-text">Info Lainnya</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="complete-tab" data-toggle="tab" href="#complete">
                                    <span class="nav-icon">
                                        <i class="flaticon-signs-1"></i>
                                    </span>
                                    <span class="nav-text">Riwayat Pengiriman&nbsp;<span class="label label-primary mr-2">@{{ deliveryHistoryItems.length }}</span></span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="delivery-item" role="tabpanel" aria-labelledby="delivery-item-tab">
                                <div class="mt-5">
                                    <!-- begin::Estimations List -->
                                    <div class="card card-custom card-border">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h3 class="card-label">
                                                    List Item
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div v-if="dataItems.length < 1" class="text-center">
                                                <i class="flaticon2-open-box icon-4x"></i>
                                                <p class="text-muted">Tidak ada item</p>
                                            </div>
                                            <div>
                                                <div class="row align-items-center" v-for="(item, index) in dataItems" :key="item.id">
                                                    <div class="col-md-1">
                                                        <!-- <div v-if="isCompleted(item)">
                                                            <i class="flaticon2-correct text-success icon-2x"></i>
                                                        </div> -->
                                                        <label class="checkbox checkbox-lg">
                                                            <input type="checkbox" v-model="checkedItemsIds" :value="item.id" />
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-11 card card-custom gutter-b card-stretch card-border ribbon ribbon-top">
                                                        <div class="card-body pt-4">
                                                            <!--begin::User-->
                                                            <div class="d-flex align-items-center my-7">
                                                                <!--begin::Title-->
                                                                <div class="d-flex flex-column">
                                                                    <a href="#" class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-0">@{{ item.code }} - @{{ item.name }}</a>
                                                                    <span class="text-muted font-weight-bold">Tanggal Kirim: @{{ item.delivery_date }}</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::User-->
                                                            <!--begin::Info-->
                                                            <div>
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <div class="bg-primary w-100" style="height: 5px;"></div>
                                                                        <div class="p-2 border">
                                                                            <strong>Qty</strong>
                                                                            <p class="text-right mb-0">@{{ item.quantity }}</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="bg-danger w-100" style="height: 5px;"></div>
                                                                        <div class="p-2 border">
                                                                            <strong>Diproduksi</strong>
                                                                            <p class="text-right mb-0">@{{ item.produced }}</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="bg-info w-100" style="height: 5px;"></div>
                                                                        <div class="p-2 border">
                                                                            <strong>Dikirim</strong>
                                                                            <p class="text-right mb-0">@{{ item.shipped }}</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="bg-success w-100" style="height: 5px;"></div>
                                                                        <div class="p-2 border">
                                                                            <strong>Belum Dikirim</strong>
                                                                            <p class="text-right mb-0">@{{ item.produced - item.shipped }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- <div>
                                                                <table class="table table-bordered">
                                                                    <thead class="bg-light">
                                                                        <tr class="text-center">
                                                                            <td class="font-weight-normal">Qty</td>
                                                                            <td class="font-weight-normal">Diproduksi</td>
                                                                            <td class="font-weight-normal">Dikirim</td>
                                                                            <td class="font-weight-normal">Belum Dikirim</td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr class="text-center">
                                                                            <td>@{{ toCurrencyFormat(item.amount) }}</td>
                                                                            <td>@{{ toCurrencyFormat(item.produced) }}</td>
                                                                            <td>@{{ toCurrencyFormat(item.shipped) }}</td>
                                                                            <td>@{{ toCurrencyFormat(item.produced - item.shipped) }}</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div> -->
                                                            <div class="mb-7">
                                                                <div v-if="!isCompleted(item)" class="d-flex justify-content-end align-items-center mt-3">
                                                                    <!-- <span class="text-dark-50 font-weight-bolder mr-2">Detail Barang Yang Akan Dikirim:</span> -->
                                                                    <!-- <div></div> -->
                                                                    <div>
                                                                        <button type="button" class="btn btn-light-primary btn-sm" data-toggle="collapse" :data-target="`.collapseShipping${item.id}`" aria-expanded="false" :aria-controls="`.collapseShipping${item.id}`"><i class="flaticon-edit icon-md"></i> Edit</button>
                                                                    </div>
                                                                </div>
                                                                <div v-if="!isCompleted(item)" class="mt-5">
                                                                    <div :class="`collapse show collapseShipping${item.id}`">
                                                                        <table class="table">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Kode</th>
                                                                                    <th>Deskripsi</th>
                                                                                    <th>Keterangan</th>
                                                                                    <th>Kts</th>
                                                                                    <th>Satuan</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>@{{ item.shipping_code }}</td>
                                                                                    <td>@{{ item.shipping_description }}</td>
                                                                                    <td>@{{ item.shipping_information }}</td>
                                                                                    <td>@{{ Intl.NumberFormat('de-DE').format(item.shipping_amount) }}</td>
                                                                                    <td>@{{ item.shipping_unit }}</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div :class="`collapse collapseShipping${item.id}`">
                                                                    <div class="card card-body">
                                                                        <div class="form-group row">
                                                                            <div class="col-lg-6">
                                                                                <label>Jumlah:</label>
                                                                                <input type="number" v-model="item.shipping_amount" @input="validateShippingQuantity(item)" class="form-control" placeholder="Masukkan jumlah yang akan dikirim" />
                                                                                <p class="mt-3"><em>Jumlah kirim tidak dapat melebihi quantity produksi</em></p>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <label>Satuan:</label>
                                                                                <input type="text" v-model="item.shipping_unit" class="form-control" placeholder="Masukkan nama satuan" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <div class="col-lg-6">
                                                                                <label>Deskripsi:</label>
                                                                                <textarea class="form-control" placeholder="Masukkan deskripsi" v-model="item.shipping_description"></textarea>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <label>Keterangan:</label>
                                                                                <textarea class="form-control" placeholder="Masukkan keterangan" v-model="item.shipping_information"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-flex justify-content-end">
                                                                            <button type="button" class="btn btn-primary" data-toggle="collapse" :data-target="`.collapseShipping${item.id}`" aria-expanded="false" :aria-controls="`.collapseShipping${item.id}`">Simpan</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--end::Info-->

                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="d-flex align-items-center flex-wrap">
                                                <!--begin: Item-->
                                                <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                                                    <span class="mr-4">
                                                        <i class="flaticon2-layers-1 icon-2x text-muted font-weight-bold"></i>
                                                    </span>
                                                    <div class="d-flex flex-column text-dark-75">
                                                        <span class="font-weight-bolder font-size-sm">Quantity</span>
                                                        <span class="font-weight-bolder font-size-h5">
                                                            @{{ Intl.NumberFormat('de-DE').format(totalQuantity) }}
                                                            <span class="text-dark-50 font-weight-bold">Pcs</span></span>
                                                    </div>
                                                </div>
                                                <!--end: Item-->
                                                <!--begin: Item-->
                                                <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                                                    <span class="mr-4">
                                                        <i class="flaticon2-reload icon-2x text-muted font-weight-bold"></i>
                                                    </span>
                                                    <div class="d-flex flex-column text-dark-75">
                                                        <span class="font-weight-bolder font-size-sm">Quantity Produksi</span>
                                                        <span class="font-weight-bolder font-size-h5">
                                                            @{{ Intl.NumberFormat('de-DE').format(totalProduced) }}
                                                            <span class="text-dark-50 font-weight-bold">Pcs</span></span>
                                                    </div>
                                                </div>
                                                <!--end: Item-->
                                                <!--begin: Item-->
                                                <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                                                    <span class="mr-4">
                                                        <i class="flaticon2-lorry icon-2x text-muted font-weight-bold"></i>
                                                    </span>
                                                    <div class="d-flex flex-column text-dark-75">
                                                        <span class="font-weight-bolder font-size-sm">Quantity Akan Dikirim</span>
                                                        <span class="font-weight-bolder font-size-h5">
                                                            @{{ Intl.NumberFormat('de-DE').format(totalShipping) }}
                                                            <span class="text-dark-50 font-weight-bold">Pcs</span></span>
                                                    </div>
                                                </div>
                                                <!--end: Item-->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end::Estimations List -->
                                </div>
                            </div>
                            <div class="tab-pane" id="goods" role="tabpanel" aria-labelledby="goods-tab">
                                <div class="row justify-content-between mt-5">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group row" hidden>
                                            <label class="col-lg-4 col-form-label text-lg-right">Nomor:</label>
                                            <div class="col-lg-8">
                                                <input type="text" v-model="number" class="form-control" placeholder="Masukkan nomor pengiriman" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label text-lg-right">Tanggal Pengiriman:</label>
                                            <div class="col-lg-8">
                                                <input type="date" v-model="date" class="form-control delivery-order-date" placeholder="Masukkan tanggal pengiriman" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label text-lg-right">Gudang:</label>
                                            <div class="col-lg-8">
                                                <input type="text" v-model="warehouse" class="form-control" placeholder="Masukkan nama gudang" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label text-lg-right">Pengirim:</label>
                                            <div class="col-lg-8">
                                                <input type="text" v-model="shipper" class="form-control" placeholder="Masukkan nama pengirim" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label text-lg-right">Nomor Kendaraan:</label>
                                            <div class="col-lg-8">
                                                <input type="text" v-model="numberOfVehicle" class="form-control" placeholder="Masukkan nomor kendaraan" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label text-lg-right">Tagihan Ke:</label>
                                            <div class="col-lg-8">
                                                <textarea rows="5" v-model="billingAddress" class="form-control" placeholder="Masukkan alamat tagihan"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label text-lg-right">Kirim Ke:</label>
                                            <div class="col-lg-8">
                                                <button type="button" class="btn btn-light-primary w-100 mb-3" data-toggle="modal" data-target="#modalWarehouse"><i class="flaticon2-pin-1"></i> Pilih Alamat</button>
                                                <textarea rows="5" v-model="shippingAddress" class="form-control" placeholder="Masukkan alamat pengiriman"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="other" role="tabpanel" aria-labelledby="other-tab">
                                <div class="mt-5">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-group">
                                                <label>Keterangan:</label>
                                                <textarea v-model="description" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="complete" role="tabpanel" aria-labelledby="complete-tab">
                                <div class="mt-5">
                                    <!-- begin::Estimations List -->
                                    <div class="card card-custom card-border">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h3 class="card-label">
                                                    Pengiriman Selesai
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div v-if="dataItems.length < 1" class="text-center">
                                                <i class="flaticon2-open-box icon-4x"></i>
                                                <p class="text-muted">Tidak ada item</p>
                                            </div>
                                            <div>
                                                <div class="row justify-content-between mb-10" v-for="(item, index) in deliveryHistoryItems" :key="item.id">
                                                    <div class="col-md-12 col-lg-6 card card-custom gutter-b card-stretch card-border">
                                                        <div class="card-body pt-4">
                                                            <!--begin::User-->
                                                            <div class="d-flex align-items-center my-7">
                                                                <!--begin::Title-->
                                                                <div class="d-flex flex-column">
                                                                    <a href="#" class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-0">@{{ item.code }} - @{{ item.name }}</a>
                                                                    <span class="text-muted font-weight-bold">Tanggal Kirim: @{{ item.delivery_date }}</span>
                                                                </div>
                                                                <!--end::Title-->

                                                            </div>
                                                            <!--end::User-->
                                                            <div>
                                                                <p>
                                                                    <i class="flaticon2-layers-2"></i>
                                                                    <strong class="text-muted">Quantity</strong>
                                                                    <span>&nbsp;:&nbsp;</span>
                                                                    <strong>@{{ item.quantity }}</strong>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <div class="col-md-12 col-lg-6">
                                                        <div class="timeline timeline-3">
                                                            <div class="timeline-items">
                                                                <div v-for="(deliveryOrder, index) in item.delivery_orders" class="timeline-item">
                                                                    <div class="timeline-media">
                                                                        <i class="flaticon2-box text-success"></i>
                                                                    </div>
                                                                    <div class="timeline-content">
                                                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                                                            <div class="mr-2">
                                                                                <a href="#" class="text-dark-75 text-hover-primary font-weight-bold">
                                                                                    Delivery Order <span class="text-primary">#@{{ deliveryOrder.number }}</span>
                                                                                </a>
                                                                                <span class="text-muted ml-2">
                                                                                    @{{ deliveryOrder.date }}
                                                                                </span>
                                                                                <span class="label label-light-success font-weight-bolder label-inline ml-2">Selesai</span>
                                                                            </div>
                                                                        </div>
                                                                        <!-- <p class="p-0"> -->
                                                                        <div class="row mb-3">
                                                                            <div class="col-lg-6 col-md-12">
                                                                                <span>Jumlah: </span>
                                                                                <strong>@{{ deliveryOrder.pivot.amount }}</strong>
                                                                            </div>
                                                                            <div class="col-lg-6 col-md-12">
                                                                                <span>Pengirim: </span>
                                                                                <strong>@{{ deliveryOrder.shipper }}</strong>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <span>Alamat:</span>
                                                                            <strong>@{{ deliveryOrder.shipping_address }}</strong>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <span>Catatan:</span>
                                                                            <strong>@{{ deliveryOrder.description }}</strong>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Here -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="d-flex align-items-center flex-wrap">
                                                <!--begin: Item-->
                                                <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                                                    <span class="mr-4">
                                                        <i class="flaticon2-layers-1 icon-2x text-muted font-weight-bold"></i>
                                                    </span>
                                                    <div class="d-flex flex-column text-dark-75">
                                                        <span class="font-weight-bolder font-size-sm">Quantity</span>
                                                        <span class="font-weight-bolder font-size-h5">
                                                            @{{ Intl.NumberFormat('de-DE').format(totalQuantity) }}
                                                            <span class="text-dark-50 font-weight-bold">Pcs</span></span>
                                                    </div>
                                                </div>
                                                <!--end: Item-->
                                                <!--begin: Item-->
                                                <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                                                    <span class="mr-4">
                                                        <i class="flaticon2-reload icon-2x text-muted font-weight-bold"></i>
                                                    </span>
                                                    <div class="d-flex flex-column text-dark-75">
                                                        <span class="font-weight-bolder font-size-sm">Quantity Produksi</span>
                                                        <span class="font-weight-bolder font-size-h5">
                                                            @{{ Intl.NumberFormat('de-DE').format(totalProduced) }}
                                                            <span class="text-dark-50 font-weight-bold">Pcs</span></span>
                                                    </div>
                                                </div>
                                                <!--end: Item-->
                                                <!--begin: Item-->
                                                <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                                                    <span class="mr-4">
                                                        <i class="flaticon2-lorry icon-2x text-muted font-weight-bold"></i>
                                                    </span>
                                                    <div class="d-flex flex-column text-dark-75">
                                                        <span class="font-weight-bolder font-size-sm">Quantity Akan Dikirim</span>
                                                        <span class="font-weight-bolder font-size-h5">
                                                            @{{ Intl.NumberFormat('de-DE').format(totalShipping) }}
                                                            <span class="text-dark-50 font-weight-bold">Pcs</span></span>
                                                    </div>
                                                </div>
                                                <!--end: Item-->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end::Estimations List -->
                                </div>
                            </div>
                        </div>
                    </div>
                     <!-- end sales order -->

                     <!-- begin event -->
                 
                     <!-- end event -->


                    <!-- begin bast -->
                    
                     <div v-if="selectedData.source=='event'" class="mt-20">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="delivery-item-tab" data-toggle="tab" href="#delivery-item">
                                    <span class="nav-icon">
                                        <i class="flaticon-signs-1"></i>
                                    </span>
                                    <span class="nav-text">Item Pengiriman&nbsp;<span class="label label-primary mr-2">@{{ dataItems.length }}</span></span>

                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="goods-tab" data-toggle="tab" href="#goods">
                                    <span class="nav-icon">
                                        <i class="flaticon-signs-1"></i>
                                    </span>
                                    <span class="nav-text">Info Delivery Order</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="other-tab" data-toggle="tab" href="#other">
                                    <span class="nav-icon">
                                        <i class="flaticon-signs-1"></i>
                                    </span>
                                    <span class="nav-text">Info Lainnya</span>
                                </a>
                            </li>
                            <!-- <li class="nav-item" role="presentation">
                                <a class="nav-link" id="complete-tab" data-toggle="tab" href="#complete">
                                    <span class="nav-icon">
                                        <i class="flaticon-signs-1"></i>
                                    </span>
                                    <span class="nav-text">Riwayat Pengiriman&nbsp;<span class="label label-primary mr-2">@{{ deliveryHistoryItems.length }}</span></span>
                                </a>
                            </li> -->
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="delivery-item" role="tabpanel" aria-labelledby="delivery-item-tab">
                                <div class="mt-5">
                                    <!-- begin::Estimations List -->
                                    <div class="card card-custom card-border">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h3 class="card-label">
                                                    List Item
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                                 <table class="table table-bordered">
                                                                        <thead  class="bg-light">
                                                                            <tr>
                                                                                <th class="text-right" style="width: 5%;" >No</th>
                                                                                <th style="width: 75%;">Description</th>
                                                                                <th>Amount</th>
                                                                                
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                      <tr>
                                                                        <td>
                                                                        1
                                                                        </td>
                                                                         <td>
                                                                        Material 
                                                                        </td>
                                                                          <td class="text-right">
                                                                        @{{Intl.NumberFormat('de-DE').format(eventQuotation.commissionableCost+eventQuotation.nonfeeCost) }}
                                                                        </td>
                                                                      </tr>

                                                                        <tr>
                                                                        <td>
                                                                        2
                                                                        </td>
                                                                         <td>
                                                                        Jasa - ASF
                                                                        </td>
                                                                          <td class="text-right">
                                                                       @{{Intl.NumberFormat('de-DE').format(eventQuotation.asf) }}
                                                                        </td>
                                                                      </tr>
                                                                           
                                                                           
                                                                        </tbody>
                                                                    </table>
                                            
                                            <!-- <div v-if="dataItems.length < 1" class="text-center">
                                                <i class="flaticon2-open-box icon-4x"></i>
                                                <p class="text-muted">Tidak ada item</p>
                                            </div> -->
                                            <div>
                                            
                                             <div class="card-footer">
                                        <div class="d-flex align-items-center flex-wrap">
                                            <!--begin: Item-->
                                            <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                                                <span class="mr-4">
                                                    <i class="flaticon2-layers-1 icon-2x text-muted font-weight-bold"></i>
                                                </span>
                                                <div class="d-flex flex-column text-dark-75">
                                                    <span class="font-weight-bolder font-size-sm">Netto</span>
                                                    <span class="font-weight-bolder font-size-h5">
                                                        <span class="text-dark-50 font-weight-bold">Rp </span>
                                                        @{{ Intl.NumberFormat('de-DE').format(eventQuotation.subtotal) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <!--end: Item-->
                                            <!--begin: Item-->
                                            <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                                                <span class="mr-4">
                                                    <i class="flaticon2-pie-chart-4 icon-2x text-muted font-weight-bold"></i>
                                                </span>
                                                <div class="d-flex flex-column text-dark-75">
                                                    <span class="font-weight-bolder font-size-sm">Diskon</span>
                                                    <span class="font-weight-bolder font-size-h5">
                                                        <span class="text-dark-50 font-weight-bold">Rp </span>
                                                        (@{{ Intl.NumberFormat('de-DE').format(clearCurrencyMask(eventQuotation.discount)) }})
                                                    </span>
                                                </div>
                                            </div>
                                               <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                                                <span class="mr-4">
                                                    <i class="flaticon2-pie-chart-4 icon-2x text-muted font-weight-bold"></i>
                                                </span>
                                                <div class="d-flex flex-column text-dark-75">
                                                    <span class="font-weight-bolder font-size-sm">Netto</span>
                                                    <span class="font-weight-bolder font-size-h5">
                                                        <span class="text-dark-50 font-weight-bold">Rp </span>
                                                        @{{ Intl.NumberFormat('de-DE').format(clearCurrencyMask(eventQuotation.netto)) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <!--end: Item-->
                                            <!--begin: Item-->
                                            <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                                                <span class="mr-4">
                                                    <i class="flaticon2-file-1 icon-2x text-muted font-weight-bold"></i>
                                                </span>
                                                <div class="d-flex flex-column text-dark-75">
                                                    <span class="font-weight-bolder font-size-sm">PPN</span>
                                                    <span class="font-weight-bolder font-size-h5">
                                                        <span class="text-dark-50 font-weight-bold">Rp </span>
                                                        @{{ Intl.NumberFormat('de-DE').format(eventQuotation.ppn) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <!--end: Item-->
                                            <!--begin: Item-->
                                            <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                                                <span class="mr-4">
                                                    <i class="flaticon2-file-1 icon-2x text-muted font-weight-bold"></i>
                                                </span>
                                                <div class="d-flex flex-column text-dark-75">
                                                    <span class="font-weight-bolder font-size-sm">PPH</span>
                                                    <span class="font-weight-bolder font-size-h5">
                                                        <span class="text-dark-50 font-weight-bold">Rp </span>
                                                        (@{{ Intl.NumberFormat('de-DE').format(eventQuotation.pph) }})
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                                                <span class="mr-4">
                                                    <i class="flaticon2-tag icon-2x text-muted font-weight-bold"></i>
                                                </span>
                                                <div class="d-flex flex-column text-dark-75">
                                                    <span class="font-weight-bolder font-size-sm">Total</span>
                                                    <span class="font-weight-bolder font-size-h5">
                                                        <span class="text-dark-50 font-weight-bold">Rp </span>
                                                        @{{ Intl.NumberFormat('de-DE').format(eventQuotation.total) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <!--end: Item-->
                                        </div>
                                        
                                    </div>
                                                
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                         
                                        </div>
                                    </div>
                                    <!-- end::Estimations List -->
                                </div>
                            </div>
                            
                            <div class="tab-pane" id="goods" role="tabpanel" aria-labelledby="goods-tab">
                                <div class="row justify-content-between mt-5">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label text-lg-right">Nomor:</label>
                                            <div class="col-lg-8">
                                                <input type="text" v-model="number" class="form-control" placeholder="Masukkan nomor pengiriman" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label text-lg-right">Tanggal Pengiriman:</label>
                                            <div class="col-lg-8">
                                                <input type="date" v-model="date" class="form-control delivery-order-date" placeholder="Masukkan tanggal pengiriman" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label text-lg-right">Gudang:</label>
                                            <div class="col-lg-8">
                                                <input type="text" v-model="warehouse" class="form-control" placeholder="Masukkan nama gudang" />
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label text-lg-right">Pengirim:</label>
                                            <div class="col-lg-8">
                                                <input type="text" v-model="shipper" class="form-control" placeholder="Masukkan nama pengirim" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label text-lg-right">Nominal:</label>
                                            <div class="col-lg-8">
                                                <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp </span>
                                        </div>
                                        <input  type="text" v-model="amount" id="amount" class="form-control text-right" ><br>
                                        
                                    </div>
                                            </div>
                                        </div>
                                     
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label text-lg-right">Nomor Kendaraan:</label>
                                            <div class="col-lg-8">
                                                <input type="text" v-model="numberOfVehicle" class="form-control" placeholder="Masukkan nomor kendaraan" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label text-lg-right">Tagihan Ke:</label>
                                            <div class="col-lg-8">
                                                <textarea rows="5" v-model="billingAddress" class="form-control" placeholder="Masukkan alamat tagihan"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label text-lg-right">Kirim Ke:</label>
                                            <div class="col-lg-8">
                                                <button type="button" class="btn btn-light-primary w-100 mb-3" data-toggle="modal" data-target="#modalWarehouse"><i class="flaticon2-pin-1"></i> Pilih Alamat</button>
                                                <textarea rows="5" v-model="shippingAddress" class="form-control" placeholder="Masukkan alamat pengiriman"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="other" role="tabpanel" aria-labelledby="other-tab">
                                <div class="mt-5">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-group">
                                                <label>Keterangan:</label>
                                                <textarea v-model="description" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="complete" role="tabpanel" aria-labelledby="complete-tab">
                                <div class="mt-5">
                                    <!-- begin::Estimations List -->
                                    <div class="card card-custom card-border">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h3 class="card-label">
                                                    Pengiriman Selesai
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div v-if="dataItems.length < 1" class="text-center">
                                                <i class="flaticon2-open-box icon-4x"></i>
                                                <p class="text-muted">Tidak ada item</p>
                                            </div>
                                            <div>
                                                <div class="row justify-content-between mb-10" v-for="(item, index) in deliveryHistoryItems" :key="item.id">
                                                    <div class="col-md-12 col-lg-6 card card-custom gutter-b card-stretch card-border">
                                                        <div class="card-body pt-4">
                                                            <!--begin::User-->
                                                            <div class="d-flex align-items-center my-7">
                                                                <!--begin::Title-->
                                                                <div class="d-flex flex-column">
                                                                    <a href="#" class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-0">@{{ item.code }} - @{{ item.name }}</a>
                                                                    <span class="text-muted font-weight-bold">Tanggal Kirim: @{{ item.delivery_date }}</span>
                                                                </div>
                                                                <!--end::Title-->

                                                            </div>
                                                            <!--end::User-->
                                                            <div>
                                                                <p>
                                                                    <i class="flaticon2-layers-2"></i>
                                                                    <strong class="text-muted">Quantity</strong>
                                                                    <span>&nbsp;:&nbsp;</span>
                                                                    <strong>@{{ item.quantity }}</strong>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <div class="col-md-12 col-lg-6">
                                                        <div class="timeline timeline-3">
                                                            <div class="timeline-items">
                                                                <div v-for="(deliveryOrder, index) in item.delivery_orders" class="timeline-item">
                                                                    <div class="timeline-media">
                                                                        <i class="flaticon2-box text-success"></i>
                                                                    </div>
                                                                    <div class="timeline-content">
                                                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                                                            <div class="mr-2">
                                                                                <a href="#" class="text-dark-75 text-hover-primary font-weight-bold">
                                                                                    Delivery Order <span class="text-primary">#@{{ deliveryOrder.number }}</span>
                                                                                </a>
                                                                                <span class="text-muted ml-2">
                                                                                    @{{ deliveryOrder.date }}
                                                                                </span>
                                                                                <span class="label label-light-success font-weight-bolder label-inline ml-2">Selesai</span>
                                                                            </div>
                                                                        </div>
                                                                        <!-- <p class="p-0"> -->
                                                                        <div class="row mb-3">
                                                                            <div class="col-lg-6 col-md-12">
                                                                                <span>Jumlah: </span>
                                                                                <strong>@{{ deliveryOrder.pivot.amount }}</strong>
                                                                            </div>
                                                                            <div class="col-lg-6 col-md-12">
                                                                                <span>Pengirim: </span>
                                                                                <strong>@{{ deliveryOrder.shipper }}</strong>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <span>Alamat:</span>
                                                                            <strong>@{{ deliveryOrder.shipping_address }}</strong>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <span>Catatan:</span>
                                                                            <strong>@{{ deliveryOrder.description }}</strong>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Here -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="d-flex align-items-center flex-wrap">
                                                <!--begin: Item-->
                                                <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                                                    <span class="mr-4">
                                                        <i class="flaticon2-layers-1 icon-2x text-muted font-weight-bold"></i>
                                                    </span>
                                                    <div class="d-flex flex-column text-dark-75">
                                                        <span class="font-weight-bolder font-size-sm">Quantity</span>
                                                        <span class="font-weight-bolder font-size-h5">
                                                            @{{ Intl.NumberFormat('de-DE').format(totalQuantity) }}
                                                            <span class="text-dark-50 font-weight-bold">Pcs</span></span>
                                                    </div>
                                                </div>
                                                <!--end: Item-->
                                                <!--begin: Item-->
                                                <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                                                    <span class="mr-4">
                                                        <i class="flaticon2-reload icon-2x text-muted font-weight-bold"></i>
                                                    </span>
                                                    <div class="d-flex flex-column text-dark-75">
                                                        <span class="font-weight-bolder font-size-sm">Quantity Produksi</span>
                                                        <span class="font-weight-bolder font-size-h5">
                                                            @{{ Intl.NumberFormat('de-DE').format(totalProduced) }}
                                                            <span class="text-dark-50 font-weight-bold">Pcs</span></span>
                                                    </div>
                                                </div>
                                                <!--end: Item-->
                                                <!--begin: Item-->
                                                <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                                                    <span class="mr-4">
                                                        <i class="flaticon2-lorry icon-2x text-muted font-weight-bold"></i>
                                                    </span>
                                                    <div class="d-flex flex-column text-dark-75">
                                                        <span class="font-weight-bolder font-size-sm">Quantity Akan Dikirim</span>
                                                        <span class="font-weight-bolder font-size-h5">
                                                            @{{ Intl.NumberFormat('de-DE').format(totalShipping) }}
                                                            <span class="text-dark-50 font-weight-bold">Pcs</span></span>
                                                    </div>
                                                </div>
                                                <!--end: Item-->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end::Estimations List -->
                                </div>
                            </div>
                        </div>
                    </div>
                     <!-- end event -->


                     <!-- begin other -->
                        <div v-if="selectedData.source=='other'" class="mt-20">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="delivery-item-tab" data-toggle="tab" href="#delivery-item">
                                    <span class="nav-icon">
                                        <i class="flaticon-signs-1"></i>
                                    </span>
                                    <span class="nav-text">Item Pengiriman&nbsp;<span class="label label-primary mr-2">@{{ dataItems.length }}</span></span>

                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="goods-tab" data-toggle="tab" href="#info-item-event">
                                    <span class="nav-icon">
                                        <i class="flaticon-signs-1"></i>
                                    </span>
                                    <span class="nav-text">Info Delivery Order</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="other-tab" data-toggle="tab" href="#info-other-other">
                                    <span class="nav-icon">
                                        <i class="flaticon-signs-1"></i>
                                    </span>
                                    <span class="nav-text">Info Lainnya</span>
                                </a>
                            </li>
                              <li class="nav-item" role="presentation">
                                <a class="nav-link" id="complete-tab" data-toggle="tab" href="#complete-other">
                                    <span class="nav-icon">
                                        <i class="flaticon-signs-1"></i>
                                    </span>
                                    <span class="nav-text">Riwayat Pengiriman&nbsp;
                                </a>
                            </li>
                            <!-- <li class="nav-item" role="presentation">
                                <a class="nav-link" id="complete-tab" data-toggle="tab" href="#complete">
                                    <span class="nav-icon">
                                        <i class="flaticon-signs-1"></i>
                                    </span>
                                    <span class="nav-text">Riwayat Pengiriman&nbsp;<span class="label label-primary mr-2">@{{ deliveryHistoryItems.length }}</span></span>
                                </a>
                            </li> -->
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="delivery-item" role="tabpanel" aria-labelledby="delivery-item-tab">
                                <div class="mt-5">
                                    <!-- begin::Estimations List -->
                                    <div class="card card-custom card-border">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h3 class="card-label">
                                                    List Item
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <!-- <div v-if="dataItems.length < 1" class="text-center">
                                                <i class="flaticon2-open-box icon-4x"></i>
                                                <p class="text-muted">Tidak ada item</p>
                                            </div> -->
                                            <div>
                                                <!-- begin quotation other -->
                                                                      <div >
                                                                    <table class="table table-bordered" style="width: 100%;">
                                                                       
                                                                             <template  v-for="(itemm ,index1) in eventQuotations" >
                                                                                <thead>
                                                                                <tr>
                                                                                <th  colspan="5" class="text-left"  ><a href="#">#@{{itemm.number}}</th>
                                                                                  <td class="text-center" style="width:20%;" align="center"> 
                                                                               <center> <div class="form-group  text-center"  >
                                                                                <label class="checkbox">
                                                                                    <input v-model="itemm.isShow" type="checkbox">
                                                                            <span></span>
                                                                           </label>
                                                                             </div></center>
                                                                        </td>
                                                                      </tr>
     </thead> 
                                                                
     <template  v-for="(item ,index2) in itemm. other_quotation_items" >
    <template v-if="itemm.isShow==1 ">
    <template v-if="Number(item.product_quantity-item.delivery_order_items.reduce((partialSum, a) => partialSum + a['quantity'], 0))>0 || Number(item.product_frequency-item.delivery_order_items.reduce((partialSum, a) => partialSum + a['frequency'], 0))>0">
    <thead  class="bg-light">

                                                                            <tr>
                                                                              <th class="text-left"  >#</th>
                                                                               <th class="text-left"  >Kirim</th>
                                                                                <th class="text-left"  >Kode</th>
                                                                             
                                                                                <th class="text-left" >Quantity</th>
                                                                                <th class="text-left" >KTS</th>
                                                                                  
                                                                                <th class="text-left" >Satuan</th>
                                                                                
                                                                                
                                                                            </tr>
                                                                        </thead>
                                                                         <tr>
                                                                            <td rowspan="6">@{{Number(index2)+1}}</td>
                                                                            <td class="align-middle text-right">
                                                                                <div class="form-group col-md-4"  >
                                                                                <label class="checkbox">
                                                                                    <input v-model="item.isSent" type="checkbox"  >
                                                                            <span></span>
                                                                           </label>
                                                                             </div>
                                                                      </td>
                                                                            <td><input class="form-control text-left" v-model="item.number"></td>
                                                                         
                                                                             
                                                                             <td><input class="form-control text-right" v-model="item.quantity" @input="validateQuantityItem(index1,index2)" >
                                                                            </td>


                                                                             <td><input class="form-control text-right"v-model="item.frequency" @input="validateFrequencyItem(index1,index2)">
                                                                             
                                                                            </td>

                                                                            
                                                                            <td><input class="form-control text-left"v-model="item.unit" >
                                                                            
                                                                        
                                                                        </td>
                                                                    
                                                                        </tr>
                                                                        <tr>
                                                                            

                                                                        <th class="text-left" ></th>
                                                                        <th class="text-left" ></th>
                                                                        <th class="text-left" >
                                                                            <span class="text-danger">Sisa :@{{Number(item.product_quantity-item.delivery_order_items.reduce((partialSum, a) => partialSum + a['quantity'], 0))}}</span>
                                                                        </th>
                                                                        <th class="text-left" >
                                                                            <span class="text-danger">Sisa :@{{Number(item.product_frequency-item.delivery_order_items.reduce((partialSum, a) => partialSum + a['frequency'], 0))}}</span>
                                                                        </th>
                                                                        <th class="text-left" ></th>
                                                                         
                                                                        </tr>
                                                                        <tr class="bg-light">
                                                                            

                                                                        <th class="text-left" colspan="5" >name</th>
                                                                         
                                                                        </tr>
                                                                        <tr>
                                                                        
                                                                           <td colspan="5">
                                                                            <textarea v-model="item.name" class="form-control" rows="4"></textarea>
                                                                           
                                                                           </td>
                                                                        </tr>
                                                                         <tr class="bg-light">

                                                                        <th class="text-left" colspan="5" >Deskripsi</th>
                                                                         
                                                                        </tr>
                                                                        <tr>
                                                                        
                                                                           <td colspan="5">
                                                                            <textarea v-model="item.description" class="form-control" rows="1"></textarea>
                                                                           
                                                                           </td>
                                                                        </tr>
                                                                         <tr>
                                                        <td colspan="6">
                                                            <div style="height: 5px;" class="w-100 bg-gray-200"></div>
                                                        </td>
                                                    </tr>
                                                                                </template>
                                                                          
                                                                            </template>  
                                                                       
                                                                           
                                                                        
                                                                        </template>
                                                                         </template>
                                                                     
                                                                           
                                                                        
                                                                    </table>
                                                                </div>
                                                                <!-- end quotation other -->
                                                
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                         
                                        </div>
                                    </div>
                                    <!-- end::Estimations List -->
                                </div>
                            </div>
                            <div class="tab-pane" id="info-item-event" role="tabpanel" aria-labelledby="goods-tab">
                                <div class="row justify-content-between mt-5">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label text-lg-right">Nomor:</label>
                                            <div class="col-lg-8">
                                                <input type="text" v-model="number" class="form-control" placeholder="Masukkan nomor pengiriman" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label text-lg-right">Tanggal Pengiriman:</label>
                                            <div class="col-lg-8">
                                                <input type="date" v-model="date" class="form-control delivery-order-date" placeholder="Masukkan tanggal pengiriman" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label text-lg-right">Gudang:</label>
                                            <div class="col-lg-8">
                                                <input type="text" v-model="warehouse" class="form-control" placeholder="Masukkan nama gudang" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label text-lg-right">Pengirim:</label>
                                            <div class="col-lg-8">
                                                <input type="text" v-model="shipper" class="form-control" placeholder="Masukkan nama pengirim" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label text-lg-right">Nomor Kendaraan:</label>
                                            <div class="col-lg-8">
                                                <input type="text" v-model="numberOfVehicle" class="form-control" placeholder="Masukkan nomor kendaraan" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label text-lg-right">Tagihan Ke:</label>
                                            <div class="col-lg-8">
                                                <textarea rows="5" v-model="billingAddress" class="form-control" placeholder="Masukkan alamat tagihan"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label text-lg-right">Kirim Ke:</label>
                                            <div class="col-lg-8">
                                                <button type="button" class="btn btn-light-primary w-100 mb-3" data-toggle="modal" data-target="#modalWarehouse"><i class="flaticon2-pin-1"></i> Pilih Alamat</button>
                                                <textarea rows="5" v-model="shippingAddress" class="form-control" placeholder="Masukkan alamat pengiriman"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="info-other-other" role="tabpanel" aria-labelledby="other-tab">
                                <div class="mt-5">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-group">
                                                <label>Keterangan:</label>
                                                <textarea v-model="description" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="complete-other" role="tabpanel" aria-labelledby="complete-tab">
                                      <div class="mt-5">
                                    <!-- begin::Estimations List -->
                                    <div class="card card-custom card-border">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h3 class="card-label">
                                                    Pengiriman selesai
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <!-- <div v-if="dataItems.length < 1" class="text-center">
                                                <i class="flaticon2-open-box icon-4x"></i>
                                                <p class="text-muted">Tidak ada item</p>
                                            </div> -->
                                            <div>
                                                <!-- begin quotation other -->
                                                                      <div >
                                                                    <table class="table table-bordered" style="width: 100%;">
                                                                       
                                                                       
                                                    
                                                                             <template  v-for="(itemm ,index) in completedDeliveryOrders" >
                                                                                      <thead>
                                                                                <tr>
                                                                                <th  colspan="6" class="text-left"  ><a href="#">#@{{itemm.number}}</th>
                                                                                
                                                                      </tr>
                                                                                    
                                                                           
                                                                            </thead> 
                                                                            <template  v-for="(item ,index) in  itemm.delivery_order_other_quotation_items" >
                                                                        
                                                                            <template >
                                                                                  <thead  class="bg-light">
                                                                            <tr>
                                                                              <th class="text-left"  >#</th>
                                                                               
                                                                                <th class="text-left"  >Kode</th>
                                                                             
                                                                                <th class="text-left" >Quantity</th>
                                                                                <th class="text-left" >KTS</th>
                                                                                  
                                                                                <th class="text-left" >Satuan</th>
                                                                                
                                                                                
                                                                            </tr>
                                                                        </thead>
                                                                         <tr>
                                                                            <td rowspan="5">@{{Number(index)+1}}</td>
                                                                          
                                                                            <td><input readonly class="form-control text-left" v-model="item.number" readonly></td>
                                                                         
                                                                             
                                                                             <td><input class="form-control text-right" v-model="item.quantity"  readonly disavled></td>


                                                                             <td><input class="form-control text-right"v-model="item.frequency"  readonly disavled></td>

                                                                            
                                                                            <td><input class="form-control text-left"v-model="item.unit"  readonly disavled></td>
                                                                    
                                                                        </tr>
                                                                        <tr class="bg-light">

                                                                        <th class="text-left" colspan="5" >name</th>
                                                                         
                                                                        </tr>
                                                                        <tr>
                                                                        
                                                                           <td colspan="5">
                                                                            <textarea v-model="item.name" class="form-control" rows="4" disavled></textarea>
                                                                           
                                                                           </td>
                                                                        </tr>
                                                                         <tr class="bg-light">

                                                                        <th class="text-left" colspan="5" >Deskripsi</th>
                                                                         
                                                                        </tr>
                                                                        <tr>
                                                                        
                                                                           <td colspan="5">
                                                                            <textarea disavled v-model="item.description" class="form-control" rows="1"></textarea>
                                                                           
                                                                           </td>
                                                                        </tr>
                                                                         <tr>
                                                        <td colspan="6">
                                                            <div style="height: 5px;" class="w-100 bg-gray-200"></div>
                                                        </td>
                                                    </tr>
                                                                            </template>  
                                                                       
                                                                           
                                                                        
                                                                        </template>
                                                                         </template>
                                                                     
                                                                           
                                                                        
                                                                    </table>
                                                                </div>
                                                                <!-- end quotation other -->
                                                
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                         
                                        </div>
                                    </div>
                                    <!-- end::Estimations List -->
                                </div>
                            </div>
                        </div>
                    </div>
                     <!-- end other -->



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
    <!-- Modal -->
    <div class="modal fade" id="modalWarehouse" tabindex="-1" role="dialog" aria-labelledby="modalWarehouseTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Pilih Alamat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <a href="#" @click.prevent="selectCustomerAddress">
                        <div class="d-flex align-items-center bg-light rounded p-5 mb-3">
                            <!--begin::Icon-->
                            <span class="svg-icon svg-icon-secondary mr-5">
                                <span class="svg-icon svg-icon-lg">
                                    <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/General/Attachment2.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <path d="M19,11 L21,11 C21.5522847,11 22,11.4477153 22,12 C22,12.5522847 21.5522847,13 21,13 L19,13 C18.4477153,13 18,12.5522847 18,12 C18,11.4477153 18.4477153,11 19,11 Z M3,11 L5,11 C5.55228475,11 6,11.4477153 6,12 C6,12.5522847 5.55228475,13 5,13 L3,13 C2.44771525,13 2,12.5522847 2,12 C2,11.4477153 2.44771525,11 3,11 Z M12,2 C12.5522847,2 13,2.44771525 13,3 L13,5 C13,5.55228475 12.5522847,6 12,6 C11.4477153,6 11,5.55228475 11,5 L11,3 C11,2.44771525 11.4477153,2 12,2 Z M12,18 C12.5522847,18 13,18.4477153 13,19 L13,21 C13,21.5522847 12.5522847,22 12,22 C11.4477153,22 11,21.5522847 11,21 L11,19 C11,18.4477153 11.4477153,18 12,18 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                            <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="2" />
                                            <path d="M12,17 C14.7614237,17 17,14.7614237 17,12 C17,9.23857625 14.7614237,7 12,7 C9.23857625,7 7,9.23857625 7,12 C7,14.7614237 9.23857625,17 12,17 Z M12,19 C8.13400675,19 5,15.8659932 5,12 C5,8.13400675 8.13400675,5 12,5 C15.8659932,5 19,8.13400675 19,12 C19,15.8659932 15.8659932,19 12,19 Z" fill="#000000" fill-rule="nonzero" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </span>
                            <!--end::Icon-->
                            <!--begin::Title-->
                            <div class="d-flex flex-column flex-grow-1 mr-2">
                                <span class="font-weight-bold text-dark-75 font-size-lg mb-1">Alamat Customer</span>
                                <span class="text-dark-50 font-weight-bold">@{{ customerAddress }}</span>
                            </div>
                            <!--end::Title-->
                            <!--begin::Lable-->
                            <!-- <span class="font-weight-bolder text-secondary py-1 font-size-lg">+8%</span> -->
                            <!--end::Lable-->
                        </div>
                    </a>
                    <a v-for="(warehouse, index) in warehouses" href="#" @click.prevent="selectWarehouseAddress(index)">
                        <div class="d-flex align-items-center bg-light rounded p-5 mb-3">
                            <!--begin::Icon-->
                            <span class="svg-icon svg-icon-secondary mr-5">
                                <span class="svg-icon svg-icon-lg">
                                    <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/General/Attachment2.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <path d="M20.4061385,6.73606154 C20.7672665,6.89656288 21,7.25468437 21,7.64987309 L21,16.4115967 C21,16.7747638 20.8031081,17.1093844 20.4856429,17.2857539 L12.4856429,21.7301984 C12.1836204,21.8979887 11.8163796,21.8979887 11.5143571,21.7301984 L3.51435707,17.2857539 C3.19689188,17.1093844 3,16.7747638 3,16.4115967 L3,7.64987309 C3,7.25468437 3.23273352,6.89656288 3.59386153,6.73606154 L11.5938615,3.18050598 C11.8524269,3.06558805 12.1475731,3.06558805 12.4061385,3.18050598 L20.4061385,6.73606154 Z" fill="#000000" opacity="0.3" />
                                            <polygon fill="#000000" points="14.9671522 4.22441676 7.5999999 8.31727912 7.5999999 12.9056825 9.5999999 13.9056825 9.5999999 9.49408582 17.25507 5.24126912" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </span>
                            <!--end::Icon-->
                            <!--begin::Title-->
                            <div class="d-flex flex-column flex-grow-1 mr-2">
                                <span class="font-weight-bold text-dark-75 font-size-lg mb-1">Alamat Gudang @{{ ' - ' + warehouse.name }}</span>
                                <span class="text-dark-50 font-weight-bold">@{{ warehouse.address }}</span>
                            </div>
                            <!--end::Title-->
                            <!--begin::Lable-->
                            <!-- <span class="font-weight-bolder text-secondary py-1 font-size-lg">+8%</span> -->
                            <!--end::Lable-->
                        </div>
                    </a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="salesOrderModal" tabindex="-1" aria-labelledby="salesOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="salesOrderModalLabel">Pilih Sales Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table" id="sales-order-table">
                        <thead>
                            <th>Nomor</th>
                            <th>Tanggal</th>
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
            <div class="modal fade" id="bastModal" tabindex="-1" aria-labelledby="salesOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="salesOrderModalLabel">Pilih  BAST</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                   
                </div>
                <div class="modal-body">
                    <table class="table" id="bast-table">
                        <thead>
                            <th>Nomor</th>
                            <th>Tanggal</th>
                             <th>Nomor Po</th>
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
            quotations: [],
            checkedQuotationsIds: [],
             invoiceItems:[],
            number: '',
            date: '',
            customer: '',
            warehouse: '',
            shipper: '',
            numberOfVehicle: '',
            billingAddress: ``,
            shippingAddress: '',
            salesOrderId: '',
            bastId:'',
            warehouses: [],
            customerAddress: '',
            loading: false,
            selectedData: null,
            checkedItemsIds: [],
            description: '',
            materia:'',
            eventQuotation:null,
            eventQuotations:[],
            completedDeliveryOrders:[],
            source:"",
            amount:""
            
        },
        methods: {
            submitForm: function() {
                this.sendData();
            },
            clearCurrencyMask: function(masked) {
                if (masked == '' || masked == 0 || typeof(masked) == 'undefined') {
                    return 0;
                }
                return masked.toString().replaceAll('.', '');
            },
            sendData: function() {
                // console.log('submitted');
                let vm = this;
                vm.loading = true;

                const data = {
                    number: vm.number,
                    date: vm.date,
                    customer_id: 1,
                    warehouse: vm.warehouse,
                    shipper: vm.shipper,
                    number_of_vehicle: vm.numberOfVehicle,
                    billing_address: vm.billingAddress,
                    shipping_address: vm.shippingAddress,
                    sales_order_id: vm.salesOrderId,
                    source: vm.selectedData.data.source,
                    description: vm.description,
                    // selected_quotations: vm.checkedQuotations,
                    selected_items: vm.checkedItems,
                    delivery_items:vm.invoiceItems,
                    bast_id:vm.bastId,
                    //event_quotations:vm.selectedData.event_quotations,
                    event_quotations:vm.eventQuotations,
                    source:vm.selectedData.source,
                    amount:vm.amount,
                    // source:vm.selectedData.data.customer_purchase_order!=null?vm.selectedData.data.customer_purchase_order.source:vm.source
                }

                axios.post('/delivery-order', data)
                    .then(function(response) {
                        vm.loading = false;
                        Swal.fire({
                            title: 'Success',
                            text: 'Data has been saved',
                            icon: 'success',
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // window.location.href = '/customer';
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
            showItem:function(index){


            },
            validateQuantityItem:function(quotationIndex,quotationItemIndex){
               
                var quantity=this.eventQuotations[quotationIndex].other_quotation_items[quotationItemIndex]['product_quantity']
                 var cureentQuantity=this.eventQuotations[quotationIndex].other_quotation_items[quotationItemIndex]['quantity'];
            
                var max=Number(quantity-this.eventQuotations[quotationIndex].other_quotation_items[quotationItemIndex]['delivery_order_items'].reduce((partialSum, a) => partialSum + a['quantity'], 0))
                console.log(max)
                
             
                if (cureentQuantity>max){
                    this.eventQuotations[quotationIndex].other_quotation_items[quotationItemIndex]['quantity']=max;
           
                }
                
               

            },
            validateFrequencyItem:function(quotationIndex,quotationItemIndex){
                 var quantity=this.eventQuotations[quotationIndex].other_quotation_items[quotationItemIndex]['product_frequency'];
                   var cureentFrequency=this.eventQuotations[quotationIndex].other_quotation_items[quotationItemIndex]['frequency'];
                
                var max=Number(quantity-this.eventQuotations[quotationIndex].other_quotation_items[quotationItemIndex]['delivery_order_items'].reduce((partialSum, a) => partialSum + a['frequency'], 0))
                
                
                if (cureentFrequency>max){
                    this.eventQuotations[quotationIndex].other_quotation_items[quotationItemIndex]['frequency']=max;
           
                }

            },
            validateShippingQuantity: function(quotation) {
                const remainingQuantity = this.remainingShippingQuantity(quotation.produced, quotation.shipped, quotation.shipping_amount);
                if (remainingQuantity < 0) {
                    quotation.shipping_amount = quotation.produced - quotation.shipped;
                }
            },
            remainingShippingQuantity: function(produced, shipped, ship) {
                // const newProduction = isNaN(production) ? 0 : production;
                // return Number(quantity) - Number(produced) - Number(newProduction);
                return Number(produced) - Number(shipped) - Number(ship);
            },
            // validateProducedQuantity: function(quotation) {
            //     const remainingQuantity = this.remainingQuantity(quotation.quantity, quotation.produced, quotation.production);
            //     if (remainingQuantity < 0) {
            //         quotation.production = quotation.quantity - quotation.produced;
            //     }
            // },
            // remainingQuantity: function(quantity, produced, production) {
            //     const newProduction = isNaN(production) ? 0 : production;
            //     return Number(quantity) - Number(produced) - Number(newProduction);
            // },
            isCompleted: function(quotation) {
                return false;
                const remainingQuantity = quotation.selected_estimation.quantity - quotation.shipped;
                if (remainingQuantity <= 0) {
                    return true;
                }

                return false;
            },
            selectCustomerAddress: function() {
                this.shippingAddress = this.customerAddress;
                this.closeWarehouseModal();
            },
            selectWarehouseAddress: function(index) {
                const warehouseAddress = this.warehouses[index].address;
                if (typeof warehouseAddress == "undefined") {
                    this.shippingAddress = this.billingAddress;
                } else {
                    this.shippingAddress = warehouseAddress;
                }
                
                this.closeWarehouseModal();
            },
            closeWarehouseModal: function() {
                $('#modalWarehouse').modal('hide');
            },
            toCurrencyFormat: function(number) {
                if (!number) {
                    number = 0;
                }
                return new Intl.NumberFormat('De-de').format(number);
            }
        },
        computed: {
            checkedItems: function() {
                return this.dataItems.filter(item => this.checkedItemsIds.indexOf(item.id) > -1);
            },
            totalQuantity: function() {
                return this.checkedItems.map(item => item.quantity).reduce((acc, cur) => {
                    return acc + cur;
                }, 0);
            },
            totalProduced: function() {
                return 0;
                return this.checkedQuotations.map(quotation => {
                    if (isNaN(quotation.produced)) {
                        return 0;
                    }
                    return Number(quotation.produced);
                }).reduce((acc, cur) => {
                    return acc + cur;
                }, 0);
            },
            totalShipping: function() {
                return this.checkedItems.map(item => {
                    if (isNaN(item.shipping_amount)) {
                        return 0;
                    }
                    return Number(item.shipping_amount);
                }).reduce((acc, cur) => {
                    return acc + cur;
                }, 0);
            },
            dataItems: function() {
                let vm = this;
                if (vm.selectedData) {
                    let items = [];
                    const {
                        source
                    } = vm.selectedData.data;
                    if (source == 'quotation') {
                         if (vm.selectedData.data.v2_quotation!=null){
                              items = vm.selectedData.data.v2_quotation.items.filter(item => Number(item.shipped) < Number(item.quantity)).map(item => {
                            item.source = 'quotation';
                            return item;
                        });
                       
                    }
                if (vm.selectedData.data.event_quotation!=null){
                      items = vm.selectedData.data.event_quotation.items.filter(item => Number(item.shipped) < Number(item.quantity)).map(item => {
                            item.source = 'quotation';
                            return item;
                        });
                   
                }
                    } else if (source == 'purchase_order') {
                        items = vm.selectedData.data.customer_purchase_order.items.filter(item => Number(item.shipped) < Number(item.quantity)).map(item => {
                            item.source = 'purchase_order';
                            return item;
                        });
                    }
                    return items;
                }

                return [];
            },
            deliveryHistoryItems: function() {
                let vm = this;
                if (vm.selectedData) {
                    let items = [];
                    const {
                        source
                    } = vm.selectedData.data;
                    if (source == 'quotation') {
                       
                    if (vm.selectedData.data.v2_quotation!=null){
                          items = vm.selectedData.data.v2_quotation.items.filter(item => item.delivery_orders.length > 0).map(item => {
                            item.source = 'quotation';
                            return item;
                        });

                       
                    }
                if (vm.selectedData.data.event_quotation!=null){
                      items = vm.selectedData.data.event_quotation.items.filter(item => Number(item.shipped) < Number(item.quantity)).map(item => {
                            item.source = 'quotation';
                            return item;
                        });
                   
                }
                  
                    } else if (source == 'purchase_order') {
                        items = vm.selectedData.data.customer_purchase_order.items.filter(item => item.delivery_orders.length > 0).map(item => {
                            item.source = 'purchase_order';
                            return item;
                        });
                    }
                    return items;
                }

                return [];
            }
        }
    })
</script>
<script>
    $(function() {
        salesOrdersTable = $('#sales-order-table').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: '/datatables/v2/delivery-orders/sales-orders',
            columns: [{
                    data: 'number',
                    name: 'v2_sales_orders.number',
                    render: function(data, type) {
                        return `<a href="#">${data}</a>`;
                    }
                },
                {
                    data: 'date',
                    name: 'v2_sales_orders.date'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render:function(data,type){
                        return `<div class="text-center">${data}</div>`                    }
                },
            ]
        });


        $('#sales-order-table tbody').on('click', '.btn-choose', function() {
            const data = salesOrdersTable.row($(this).parents('tr')).data();
            console.log('event quotation',data.event_quotation)
           
             app.$data.bastId=0
            app.$data.salesOrderId = data.id;

            let items = [];
            if (data.source == 'quotation') {
                 console.log("quotation")
                
                if (data.v2_quotation!=null){


                }
                if (data.event_quotation!=null){
                   var code =data.event_quotation.number.substring(0, 2)   
                   console.log('code',code);             

                   if (code=="QE"){



        

            const event_quotations=data.event_quotation;
            var comissionable_cost=data.event_quotation['commissionable_cost'];
            var netto=data.event_quotation['netto']
            var nonfee_cost=data.event_quotation['nonfee_cost'];
            var asf=data.event_quotation['asf'];
            var discount=data.event_quotation['discount'];
            var pph=data.event_quotation['pph23_amount'];

            

            var ppn=data.event_quotation['ppn_amount'];
            var total=data.event_quotation['total'];
            var subtotal=data.event_quotation['subtotal'];
            


            app.$data.eventQuotation={
                asf:asf,
                discount:discount,
                commissionableCost:comissionable_cost,
                nonfeeCost:nonfee_cost,
                netto:netto,
                pph:pph,
                ppn:ppn,
                total:total,
                subtotal:subtotal

            }
            
            app.$data.selectedData = {
                data,
                source: "event",
            };
                       
    

                    }else { 
                    app.$data.eventQuotations.push(data.event_quotation);
                    data.event_quotation.other_quotation_items.filter(function(otherItem){
                      var dd=[];
                       otherItem['delivery_order_items']=[];
                       otherItem['product_quantity']=otherItem['quantity']
                       otherItem['product_frequency']=otherItem['frequency']
                       otherItem['quantity']=0
                       otherItem['frequency']=0

                        
                     return otherItem.delivery_order.filter(function(item){
                         return item.delivery_order_other_quotation_items.filter(function(item){
                             if (item.other_quotation_item_id==otherItem.id){
                                 otherItem['delivery_order_items'].push(item)
                                 return item;
                             }

                         
                         });
                     })

                   //  otherItem['tes']="tes";

                  })
                    
            //          app.$data.eventQuotations=data.customer_purchase_order.event_quotations.filter(function(item) {
            //       return 


            //    });


app.$data.completedDeliveryOrders=data.delivery_orders;
                    app.$data.selectedData = {
                    data,
                     source: "other",
                    };               
                    }

                   

                    



                }
                
            //     app.$data.selectedData = {
                
            //     data,
                
            //     source: "metaprint",
             
            //   };
           
            
            } else if (data.source == 'purchase_order') {
                console.log("customer puchase order")
            if (data.customer_purchase_order.source=='other'){

              app.$data.eventQuotations=data.customer_purchase_order.event_quotations;
              app.$data.eventQuotations=data.customer_purchase_order.event_quotations.filter(function(item) {
                  return item.other_quotation_items.filter(function(otherItem){
                      var dd=[];
                       otherItem['delivery_order_items']=[];
                       otherItem['product_quantity']=otherItem['quantity']
                       otherItem['product_frequency']=otherItem['frequency']
                       otherItem['quantity']=0
                       otherItem['frequency']=0

                        
                     return otherItem.delivery_order.filter(function(item){
                         return item.delivery_order_other_quotation_items.filter(function(item){
                             if (item.other_quotation_item_id==otherItem.id){
                                 otherItem['delivery_order_items'].push(item)
                                 return item;
                             }

                         
                         });
                     })

                   //  otherItem['tes']="tes";

                  })


               });
               
               
               app.$data.completedDeliveryOrders=data.delivery_orders;
               
               app.$data.selectedData = {
               
                data,
               
                source: "other",
              
              };
              console.log("data, ",app.$data.selectedData)
            


            }else if (data.customer_purchase_order.source=='event'){

          
            const event_quotations=data.customer_purchase_order.event_quotations;
            var comissionable_cost=event_quotations.reduce((sum, a) => parseInt(sum) + parseInt(a['commissionable_cost']), 0)
            var netto=event_quotations.reduce((sum, a) => parseInt(sum) + parseInt(a['netto']), 0)
            var nonfee_cost=event_quotations.reduce((sum, a) => parseInt(sum) + parseInt(a['nonfee_cost']), 0)
            var asf=event_quotations.reduce((sum, a) => parseInt(sum) + parseInt(a['asf']), 0)
            var discount=event_quotations.reduce((sum, a) => parseInt(sum) + parseInt(a['discount']), 0)
            var pph=event_quotations.reduce((sum, a) => parseInt(sum) + parseInt(a['pph23_amount']), 0)

            

            var ppn=event_quotations.reduce((sum, a) => parseInt(sum) + parseInt(a['ppn_amount']), 0)
            var total=event_quotations.reduce((sum, a) => parseInt(sum) + parseInt(a['total']), 0)
            var subtotal=event_quotations.reduce((sum, a) => parseInt(sum) + parseInt(a['subtotal']), 0)
            


            app.$data.eventQuotation={
                asf:asf,
                discount:discount,
                commissionableCost:comissionable_cost,
                nonfeeCost:nonfee_cost,
                netto:netto,
                pph:pph,
                ppn:ppn,
                total:total,
                subtotal:subtotal

            }
            
            app.$data.selectedData = {
                data,
                source: "event",
            };

            }else{
                 items = data.customer_purchase_order.items;
                if (data.customer !== null && data.customer !== "undefined") {
                app.$data.customerAddress = data.customer.address;
                app.$data.billingAddress = data.customer.address;
                app.$data.warehouses = data.customer.warehouses;
                 app.$data.selectedData = {
                data,
                source: "metaprint",
            };
            }

            data.items = items.map(item => {
                item['shipping_code'] = item.code;
                item['shipping_description'] = item.name;
                item['shipping_information'] = item.description;
                item['shipping_amount'] = 0;
                item['shipping_unit'] = 'pcs';
                let produced = 0;
                let shipped = 0;

                if (item.job_orders.length) {
                    produced = item.job_orders.map(jo => Number(jo.order_amount)).reduce((acc, cur) => {
                        return acc + cur;
                    }, 0);
                }

                if (item.delivery_orders.length) {
                    shipped = item.delivery_orders.map(deliveryOrder => Number(deliveryOrder.pivot.amount)).reduce((acc, cur) => {
                        return acc + cur;
                    }, 0);
                }

                item['produced'] = produced;
                item['shipped'] = shipped;

                return item;
            })


            }}

            

          //  console.log(app.$data.selectedData);

            // app.$data.salesOrderNumber = app.$data.selectedData.data.number;
            // const newDate = app.$data.selectedData.data.date;
            // app.$data.salesOrderDate = newDate;
            // $('#salesOrder-date').datepicker('update', newDate);

            $('#salesOrderModal').modal('hide');
        });

        $('.delivery-order-date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: false,
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
        }).on('changeDate', function(e) {
            app.$data.date = e.format(0, 'yyyy-mm-dd');
        });
    })
</script>

<!-- <script>
    $(function() {
        bast = $('#bast-table').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: '/datatables/v2/delivery-orders/bast',
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
                    data:'po_quotation_number',
                    name:'po_quotation_number'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $('#bast-table tbody').on('click', '.btn-choose', function() {
            // const data = bast.row($(this).parents('tr')).data();
            //  app.$data.salesOrderId = 0;
            // let division=data.amount/Number(data.event_quotation.netto)
            // app.$data.grNumber=data.gr_number;
            // app.$data.bastId=data.id
            // app.$data.source="bast"
            // // app.$data.asf =division * data.event_quotation.asf;
            // // app.$data.netto=division *data.event_quotation.netto;
            // // app.$data.discount=division *data.event_quotation.discount;
            // // app.$data.ppn=division * data.event_quotation.ppn_amount;
            // // app.$data.pph23=division * data.event_quotation.pph23_amount
            // // app.$data.total=division * data.event_quotation.total;
            // app.$data.selectedData = {
            //     data,
            //     source: 'bast',
            // };
            //   app.$data.invoiceItems={
            //     ...data.other_quotation_items
            // }
            const data = bast.row($(this).parents('tr')).data();
 

            const event_quotations=data.v2_sales_order.customer_purchase_order.event_quotations;
           
            var comissionable_cost=event_quotations.reduce((sum, a) => parseInt(sum) + parseInt(a['commissionable_cost']), 0)
             var netto=event_quotations.reduce((sum, a) => parseInt(sum) + parseInt(a['netto']), 0)
            var nonfee_cost=event_quotations.reduce((sum, a) => parseInt(sum) + parseInt(a['nonfee_cost']), 0)
            var asf=event_quotations.reduce((sum, a) => parseInt(sum) + parseInt(a['asf']), 0)
            var discount=event_quotations.reduce((sum, a) => parseInt(sum) + parseInt(a['discount']), 0)
            var pph=event_quotations.reduce((sum, a) => parseInt(sum) + parseInt(a['pph23_amount']), 0)
            var ppn=event_quotations.reduce((sum, a) => parseInt(sum) + parseInt(a['ppn_amount']), 0)
            var total=event_quotations.reduce((sum, a) => parseInt(sum) + parseInt(a['total']), 0)
            var subtotal=event_quotations.reduce((sum, a) => parseInt(sum) + parseInt(a['subtotal']), 0)
            
             app.$data.salesOrderId = 0;
             
            let division=data.amount/Number(netto)
            app.$data.grNumber=data.gr_number;
            app.$data.bastId=data.id
            app.$data.source="bast"
           
            app.$data.asf =Math.round(division * asf);
            
            app.$data.netto=Math.round(division *netto);
            app.$data.discount=Math.round(division * discount);
            app.$data.ppn=Math.round(division *ppn);
            app.$data.pph23=Math.round(division *pph )
            app.$data.total=Math.round(division * total);
            app.$data.selectedData = {
                data,
                source: 'event',
                event_quotations
            };
               
            if (data.type=="event"){
             app.$data.material=Math.round(Number((division) * ((comissionable_cost)+ (nonfee_cost))))
             app.$data.subtotal=app.$data.asf+app.$data.material;

             app.$data.selectedData = {
                data,
                source: 'other',
                event_quotations
            };
           
            }else{
                app.$data.selectedData = {
                data,
                source: 'metaprint',
                event_quotations
            };
                        app.$data.subtotal=Number(division)*Number(subtotal);
               
            // app.$data.invoiceItems={
            //     ...event_quotations[0].other_quotation_items
            // }
            // app.$data.event_quotatis={
            //     ...event_quotations
            // }
           
          
            }
           
            $('#bastModal').modal('hide');

           
           
            
        });


        $('#invoice-date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: false,
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
        }).on('changeDate', function(e) {
            app.$data.date = e.format(0, 'yyyy-mm-dd');
        });

        $('.due-date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: false,
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
        }).on('changeDate', function(e) {
            app.$data.dueDateTerm = 'custom';
            app.$data.dueDate = e.format(0, 'yyyy-mm-dd');
        });
    })
</script> -->
@endsection