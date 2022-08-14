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
                    <div class="row justify-content-between">
                        <div class="col-lg-6 col-sm-12">
                            <!-- <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-lg-right">Nomor Delivery Order:</label>
                                <div class="col-lg-8">
                                    <span class="label label-xl label-info label-inline ">@{{ number }}</span>
                                </div>
                            </div> -->
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-lg-right">Tanggal Pengiriman:</label>
                                <div class="col-lg-8">
                                    <input type="text" v-model="date" class="form-control delivery-order-date" placeholder="Masukkan tanggal pengiriman" />
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
                        <div class="col-lg-5 col-sm-12">
                            <div class="alert alert-light mb-10">
                                <!--begin: Item-->
                                <div class="d-flex align-items-center flex-lg-fill mb-4">
                                    <span class="mr-4">
                                        <i class="flaticon2-correct icon-2x text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-50">
                                        <span class="font-weight-bolder font-size-sm">Sales Order Number</span>
                                        <span class="font-weight-bolder font-size-h5">
                                            {{ $sales_order->number }}
                                        </span>
                                        <!-- <span class="text-dark-50 font-weight-bold">Pcs</span></span> -->
                                    </div>
                                </div>
                                <!--end: Item-->
                                <hr>
                                <!--begin: Item-->
                                <div class="d-flex align-items-center flex-lg-fill mb-4">
                                    <span class="mr-4">
                                        <i class="flaticon2-calendar-9 icon-2x text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-50">
                                        <span class="font-weight-bolder font-size-sm">Tanggal Sales Order</span>
                                        <span class="font-weight-bolder font-size-h5">
                                            {{ $sales_order->date }}
                                        </span>
                                    </div>
                                </div>
                                <!--end: Item-->
                                <hr>
                                <!--begin: Item-->
                                <div class="d-flex align-items-center flex-lg-fill mb-4">
                                    <span class="mr-4">
                                        <i class="flaticon2-correct icon-2x text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-50">
                                        <span class="font-weight-bolder font-size-sm">Purchase Order Number</span>
                                        <span class="font-weight-bolder font-size-h5">
                                            {{ $sales_order->po_number }}
                                        </span>
                                        <!-- <span class="text-dark-50 font-weight-bold">Pcs</span></span> -->
                                    </div>
                                </div>
                                <!--end: Item-->
                                <hr>
                                <!--begin: Item-->
                                <div class="d-flex align-items-center flex-lg-fill mb-4">
                                    <span class="mr-4">
                                        <i class="flaticon2-calendar-9 icon-2x text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-50">
                                        <span class="font-weight-bolder font-size-sm">Tanggal Purchase Order</span>
                                        <span class="font-weight-bolder font-size-h5">
                                            {{ $sales_order->po_date }}
                                        </span>
                                    </div>
                                </div>
                                <!--end: Item-->
                                <hr>
                                <!--begin: Item-->
                                <div class="d-flex align-items-center flex-lg-fill mb-4">
                                    <span class="mr-4">
                                        <i class="flaticon2-user-outline-symbol icon-2x text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-50">
                                        <span class="font-weight-bolder font-size-sm">Customer</span>
                                        <span class="font-weight-bolder font-size-h5">
                                            @if($sales_order->customer !== null)
                                            {{ $sales_order->customer->name }}
                                            @else
                                            -
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <!--end: Item-->
                                <hr>
                                <!--begin: Item-->
                                <div class="d-flex align-items-center flex-lg-fill mb-4">
                                    <span class="mr-4">
                                        <i class="flaticon2-position icon-2x text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-50">
                                        <span class="font-weight-bolder font-size-sm">Alamat Customer</span>
                                        <span class="font-weight-bolder font-size-h5">
                                            @if($sales_order->customer !== null)
                                            {{ $sales_order->customer->address }}
                                            @else
                                            -
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <!--end: Item-->
                            </div>
                        </div>
                    </div>


                    <!-- begin::Estimations List -->
                    <div class="card card-custom card-border">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">
                                    List Quotation
                                </h3>
                            </div>
                            <!-- <div class="card-toolbar">
                                <a href="#" class="btn btn-light-success">
                                    <i class="flaticon2-add-1"></i> Tambah
                                </a>
                            </div> -->
                        </div>
                        <div class="card-body">
                            <div v-if="quotations.length < 1" class="text-center">
                                <i class="flaticon2-open-box icon-4x"></i>
                                <p class="text-muted">Belum ada quotation terpilih</p>
                            </div>
                            <div>
                                <div class="row align-items-center" v-for="(quotation, index) in quotations" :key="quotation.id" :quotation="quotation">
                                    <div class="col-md-1">
                                        <div v-if="isCompleted(quotation)">
                                            <i class="flaticon2-correct text-success icon-2x"></i>
                                        </div>
                                        <label v-else class="checkbox checkbox-lg">
                                            <input type="checkbox" v-model="checkedQuotationsIds" :value="quotation.id" />
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="col-md-11 card card-custom gutter-b card-stretch card-border ribbon ribbon-top">
                                        <!-- <div :class="'ribbon-target bg-primary text-capitalize'" style="top: -2px; left: 20px;">Closed</div> -->
                                        <!--begin::Body-->
                                        <div class="card-body pt-4">
                                            <!--begin::User-->
                                            <div class="d-flex align-items-center my-7">
                                                <!--begin::Title-->
                                                <div class="d-flex flex-column">
                                                    <a href="#" class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-0">@{{ quotation.number }} - @{{ quotation.title }}</a>
                                                    <span class="text-muted font-weight-bold">@{{ quotation.customer.name }} | @{{ quotation.date }}</span>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                            <!--end::User-->
                                            <!--begin::Desc-->
                                            <!-- <p class="mb-7">I distinguish three main text objectives. First, your objective
                        <a href="#" class="text-primary pr-1">#xrs-54pq</a>
                    </p> -->
                                            <!--end::Desc-->
                                            <!--begin::Info-->
                                            <div class="mb-7">
                                                <div class="d-flex justify-content-between align-items-center my-1">
                                                    <span class="text-dark-75 font-weight-bolder mr-2">Quantity:</span>
                                                    <a href="#" class="text-muted text-hover-primary">@{{ Intl.NumberFormat('de-DE').format(quotation.selected_estimation.quantity) }}</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center my-1">
                                                    <span class="text-dark-75 font-weight-bolder mr-2">Quantity Sudah Diproduksi:</span>
                                                    <a href="#" class="text-muted text-hover-primary">@{{ Intl.NumberFormat('de-DE').format(quotation.produced) }}</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center my-1">
                                                    <span class="text-dark-75 font-weight-bolder mr-2">Quantity Sudah Dikirim:</span>
                                                    <a href="#" class="text-muted text-hover-primary">@{{ Intl.NumberFormat('de-DE').format(quotation.shipped) }}</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center my-1">
                                                    <span class="text-dark-75 font-weight-bolder mr-2">Quantity Belum Dikirim:</span>
                                                    <a href="#" class="text-muted text-hover-primary">@{{ Intl.NumberFormat('de-DE').format(quotation.selected_estimation.quantity - quotation.shipped) }}</a>
                                                </div>
                                                <!-- <div class="d-flex justify-content-between align-items-cente my-1">
                                                    <span class="text-dark-75 font-weight-bolder mr-2">Unit Price:</span>
                                                    <a href="#" class="text-muted text-hover-primary">Rp @{{ Intl.NumberFormat('de-DE').format(quotation.price_per_unit) }}</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center my-1">
                                                    <span class="text-dark-75 font-weight-bolder mr-2">Total Piutang:</span>
                                                    <span class="text-muted font-weight-bold">Rp @{{ Intl.NumberFormat('de-DE').format(quotation.total_bill) }}</span>
                                                </div> -->
                                                <!-- <div class="d-flex justify-content-between align-items-center mt-5">
                                                    <span class="text-dark-75 font-weight-bolder mr-2">Quantity Akan Diproduksi:</span>
                                                    <div>
                                                        <input type="number" v-model="quotation['production']" @input="validateProducedQuantity(quotation)" class="form-control">
                                                    </div>
                                                </div> -->
                                                <!-- <div class="d-flex justify-content-between align-items-center mt-5">
                                                    <span class="text-dark-75 font-weight-bolder mr-2">Quantity Sisa:</span>
                                                    <span class="text-muted font-weight-bold">@{{ Intl.NumberFormat('de-DE').format(remainingQuantity(quotation.quantity, quotation.produced, quotation.production)) }}</span>
                                                </div> -->
                                                <div v-if="!isCompleted(quotation)" class="d-flex justify-content-between align-items-center mt-3">
                                                    <span class="text-dark-75 font-weight-bolder mr-2">Detail Barang Yang Akan Dikirim:</span>
                                                    <div>
                                                        <button type="button" class="btn btn-light-primary btn-sm" data-toggle="collapse" :data-target="`.collapseShipping${quotation.id}`" aria-expanded="false" :aria-controls="`.collapseShipping${quotation.id}`"><i class="flaticon-edit icon-md"></i> Edit</button>
                                                    </div>
                                                </div>
                                                <div v-if="!isCompleted(quotation)" class="mt-5">
                                                    <div :class="`collapse show collapseShipping${quotation.id}`">
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
                                                                    <td>@{{ quotation.shipping_code }}</td>
                                                                    <td>@{{ quotation.shipping_description }}</td>
                                                                    <td>@{{ quotation.shipping_information }}</td>
                                                                    <td>@{{ Intl.NumberFormat('de-DE').format(quotation.shipping_amount) }}</td>
                                                                    <td>@{{ quotation.shipping_unit }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div :class="`collapse collapseShipping${quotation.id}`">
                                                    <div class="card card-body">
                                                        <div class="form-group row">
                                                            <div class="col-lg-6">
                                                                <label>Jumlah:</label>
                                                                <input type="number" v-model="quotation.shipping_amount" @input="validateShippingQuantity(quotation)" class="form-control" placeholder="Masukkan jumlah yang akan dikirim" />
                                                                <p class="mt-3"><em>Jumlah kirim tidak dapat melebihi quantity produksi</em></p>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label>Satuan:</label>
                                                                <input type="text" v-model="quotation.shipping_unit" class="form-control" placeholder="Masukkan nama satuan" />
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-lg-6">
                                                                <label>Deskripsi:</label>
                                                                <textarea class="form-control" placeholder="Masukkan deskripsi" v-model="quotation.shipping_description"></textarea>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label>Keterangan:</label>
                                                                <textarea class="form-control" placeholder="Masukkan keterangan" v-model="quotation.shipping_information"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-end">
                                                            <button type="button" class="btn btn-primary" data-toggle="collapse" :data-target="`.collapseShipping${quotation.id}`" aria-expanded="false" :aria-controls="`.collapseShipping${quotation.id}`">Simpan</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Info-->

                                        </div>
                                        <!--end::Body-->
                                    </div>
                                </div>
                                <!-- <selected-quotation v-for="(quotation, index) in quotations" :key="quotation.id" :quotation="quotation" :index="index">
                                </selected-quotation> -->
                            </div>
                        </div>
                        <div v-if="checkedQuotationsIds.length > 0" class="card-footer">
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

                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-6">

                        </div>
                        <div class="col-lg-6 text-lg-right">
                            <button type="submit" class="btn btn-primary" :class="loading && 'spinner spinner-white spinner-right'" :disabled="loading || checkedQuotationsIds.length < 1">
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
                                <span class="text-dark-50 font-weight-bold">{{ $sales_order->customer->address }}</span>
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
            quotations: JSON.parse(String.raw `{!! $sales_order->quotations !!}`),
            checkedQuotationsIds: [],
            number: '{{ $delivery_order_number }}',
            date: '',
            customer: '{{ $sales_order->customer->id }}',
            warehouse: '',
            shipper: '',
            numberOfVehicle: '',
            billingAddress: `{{ $sales_order->customer !== null ? $sales_order->customer->address : "" }}`,
            shippingAddress: '',
            salesOrderId: '{{ $sales_order->id }}',
            warehouses: JSON.parse(String.raw `{!! $sales_order->customer->warehouses !!}`),
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

                const data = {
                    number: vm.number,
                    date: vm.date,
                    customer_id: vm.customer,
                    warehouse: vm.warehouse,
                    shipper: vm.shipper,
                    number_of_vehicle: vm.numberOfVehicle,
                    billing_address: vm.billingAddress,
                    shipping_address: vm.shippingAddress,
                    sales_order_id: vm.salesOrderId,
                    selected_quotations: vm.checkedQuotations,
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
                const remainingQuantity = quotation.selected_estimation.quantity - quotation.shipped;
                if (remainingQuantity <= 0) {
                    return true;
                }

                return false;
            },
            selectCustomerAddress: function() {
                this.shippingAddress = this.billingAddress;
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
        },
        computed: {
            checkedQuotations: function() {
                return this.quotations.filter(quotation => this.checkedQuotationsIds.indexOf(quotation.id) > -1);
            },
            totalQuantity: function() {
                return this.checkedQuotations.map(quotation => quotation.selected_estimation.quantity).reduce((acc, cur) => {
                    return acc + cur;
                }, 0);
            },
            totalProduced: function() {
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
                return this.checkedQuotations.map(quotation => {
                    if (isNaN(quotation.shipping_amount)) {
                        return 0;
                    }
                    return Number(quotation.shipping_amount);
                }).reduce((acc, cur) => {
                    return acc + cur;
                }, 0);
            }
            // totalRemainingQuantity: function() {
            //     return this.totalQuantity - this.totalProduced;
            // },
        }
    })
</script>
<script>
    $(function() {
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
@endsection