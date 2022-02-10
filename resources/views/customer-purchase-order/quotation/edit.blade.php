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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Tambah Purchase Order</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Purchase Order</a>
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
                <h3 class="card-title">Form Purchase Order</h3>

            </div>
            <!--begin::Form-->
            <form class="form" autocomplete="off" @submit.prevent="submitForm" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <div class="form-row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label>Nomor:</label>
                                        <!-- <input type="text" class="form-control"> -->
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">#</span>
                                            </div>
                                            <input type="text" v-model="number" class="form-control">
                                        </div>
                                    </div>
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
                                        <input type="text" v-model="date" id="po-date" class="form-control">
                                    </div>
                                </div>
                        
                            </div>

                            <div class="form-row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label>Title:</label>
                                        <!-- <input type="text" class="form-control"> -->
                                        <div class="input-group">
                                            
                                            <input type="text" v-model="title" class="form-control">
                                        </div>
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
                            <!-- <li class="nav-item" role="presentation">
                                <a class="nav-link" id="other-cost-tab" data-toggle="tab" href="#other-cost">
                                    <span class="nav-icon">
                                        <i class="flaticon-signs-1"></i>
                                    </span>
                                    <span class="nav-text">Biaya Lain</span>
                                </a>
                            </li> -->
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
                                        <button type="button" data-toggle="modal" data-target="#quotationModal"><i class="flaticon2-plus"></i> Quotation</button>
                                    </div>
                                    <div>
                                         <div v-for="(item,index) in selectedData" >

                                            <!-- begin eo quotation -->
                                            
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

                                              
                                            </div>
                                            <div class="mt-5">
                                           
                                                   <div class="text-right">
                                                                <button type="button" class="btn btn-danger" @click="removeItem(index)">Hapus</button>
                                                            </div>
                                                 <div style="height: 5px;" class="w-100 bg-gray-200 mt-5"></div>
                                            </div>
                                            </div>
                                            <!-- end eo quotation -->
                                    
                              
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
                                                    <label class="checkbox">
                                                        <input v-model="ppn" type="checkbox">
                                                        <span></span>&nbsp;PPN
                                                    </label>
                                                </div>
                                                <div class="form-group col-md-8">
                                                    <div class="input-group">
                                                        <input type="text" v-model="ppnValue" class="form-control text-right" placeholder="Tarif PPN" :readonly="!ppn">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><strong class="text-dark-50">%</strong></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row align-items-center">
                                                <div class="form-group col-md-4">
                                                    <label class="checkbox">
                                                        <input v-model="pph23" type="checkbox">
                                                        <span></span>&nbsp;PPh 23
                                                    </label>
                                                </div>
                                                <div class="form-group col-md-8">
                                                    <div class="input-group">
                                                        <input type="text" v-model="pph23Value" class="form-control text-right" placeholder="Tarif PPN" :readonly="!ppn">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><strong class="text-dark-50">%</strong></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
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
                                                <label>File (Max. 2MB)</label>
                                                <div class="custom-file">
                                                    <input type="file" id="customFile" accept=".jpg, .jpeg, .png, .pdf, .doc, .xls, .xlsx" class="custom-file-input" disabled>
                                                    <label id="file-upload-label" for="customFile" class="custom-file-label">Choose file</label>
                                                </div>
                                                <!---->
                                            </div>
                                            <div class="form-group">
                                                <label>Keterangan:</label>
                                                <textarea v-model="description" class="form-control"></textarea>
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

    <!-- Modal-->
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
            customer: '',
            number: '{!!$customer_purchase_order->number!!}',
            date: '{!!$customer_purchase_order->date!!}',
            description: '',
            loading: false,
            items: [],
            ppn: false,
            ppnValue: 10,
            pph23: false,
            pph23Value: 2,
            shippingCost: 0,
            otherCost: 0,
            otherCostDescription: '',
            selectedData: JSON.parse(String.raw`{!! $selected_data !!}`),
            id:'{!!$id!!}',
           
            title:''
        },
        methods: {
            submitForm: function() {
                this.sendData();
            },
            sendData: function() {
                // console.log('submitted');
                let vm = this;
                vm.loading = true;
                axios.patch(`/customer-purchase-order/quotation/${vm.id}`, {
                        customer_id: vm.customer,
                        number: vm.number,
                        date: vm.date,
                        description: vm.description,
                        subtotal: vm.subtotal,
                        ppn: vm.ppn ? 1 : 0,
                        ppn_value: vm.ppnValue,
                        ppn_amount: vm.ppnAmount,
                        pph23: vm.pph23 ? 1 : 0,
                        pph23_value: vm.pph23Value,
                        pph23_amount: vm.pph23Amount,
                        other_cost: vm.otherCost,
                        other_cost_description: vm.otherCostDescription,
                        total: vm.grandTotal,
                        items: vm.selectedData,
                        selectedQuotations:[],
                        title:vm.title
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
                                // window.location.href = '/goods';
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
            addItem: function() {
                let vm = this;
                vm.items.push({
                    code: '',
                    name: '',
                    description: '',
                    deliveryDate: '{{ date("Y-m-d") }}',
                    quantity: 1,
                    price: 0,
                    amount: 0,
                    taxCode: '',
                })
            },
            removeItem: function(index) {
                let vm = this;
                vm.selectedData.splice(index, 1);
            },
            toCurrencyFormat: function(number) {
                return new Intl.NumberFormat('De-de').format(number);
            }
        },
        computed: {
            subtotal: function() {
                const grandTotal = this.selectedData.map(item => Number(item.netto)).reduce((acc, cur) => {
                    return acc + cur;
                }, 0);

                return grandTotal;
            },
            ppnAmount: function() {
                let vm = this;
                if (!vm.ppn) {
                    return 0;
                }

                const ppn = this.subtotal * (Number(vm.ppnValue) / 100);
                return Math.round(ppn);
            },
            pph23Amount: function() {
                let vm = this;
                if (!vm.pph23) {
                    return 0;
                }

                const pph23 = this.subtotal * (Number(vm.pph23Value) / 100);
                return Math.round(pph23);
            },
            grandTotal: function() {
                const grandTotal = this.selectedData.map(item => Number(item.netto)).reduce((acc, cur) => {
                    return acc + cur;
                }, 0);

                return grandTotal + this.ppnAmount - this.pph23Amount + Number(this.otherCost);
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

        quotationsTable = $('#quotation-table').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: '/datatables/v2/customer-purchase-orders/quotation',
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
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render:function(data,type){
                        return `<div class="text-center">${data}</div>`                    }
                
                },
            ]
        });

             $('#quotation-table tbody').on('click', '.btn-choose', function() {
            const data = quotationsTable.row($(this).parents('tr')).data();
            const selected = {
                ...data,
            };
             selected['source']='eo-quotation';
          
    
         
              const dataIds = app.$data.selectedData.map(product => product.id);
             if (dataIds.indexOf(selected.id) < 0) {
                   
                    app.$data.selectedData.push(selected);
                   console.log(app.$data.selectedData)
                    app.$data.pic=app.$data.selectedData[0].pic_event.name
                    app.$data.picId=app.$data.selectedData[0].pic_event.id
                    app.$data.customer=app.$data.selectedData[0].customer.name
                    app.$data.customeId=app.$data.selectedData[0].customer.id
                     app.$data.poNumber=""
                    // app.$data.number=""
                     app.$data.source="quotation"
                    
                 
               

             }
             console.log(app.$data.selectedData);
            

            //$('#quotation-date').datepicker('update', newDate);
            //$('#quotationModal').modal('hide');
        });


        cpoTable = $('#cpo-table').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: '/datatables/v2/sales-orders/customer-purchase-orders',
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
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $('#cpo-table tbody').on('click', '.btn-choose', function() {
            const data = cpoTable.row($(this).parents('tr')).data();
            app.$data.selectedData = {
                data,
                source: 'purchase_order',
            };

            app.$data.poNumber = app.$data.selectedData.data.number;
            const newDate = app.$data.selectedData.data.date;
            app.$data.poDate = newDate;
            $('#po-date').datepicker('update', newDate);

            $('#poModal').modal('hide');
        });

        $('#date').datepicker({
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
@endsection