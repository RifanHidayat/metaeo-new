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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Tambah Faktur</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Faktur</a>
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
                <h3 class="card-title">Form BAST</h3>
            </div>

            <!--begin::Form-->
            <form class="form" autocomplete="off" @submit.prevent="submitForm">
                <div class="card-body">
                    <div class="my-3 text-right">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#salesOrderModal"><i class="flaticon2-plus"></i> Pilih Delivery Order</button>
                         
                    </div>
                    <div v-if="!selectedData">
                        <p class="text-center">
                            <i class="flaticon2-open-box font-size-h1"></i>
                        </p>
                        <p class="text-center text-dark-50"><strong>Pilih sales order</strong></p>
                    </div>
                    <div v-if="selectedData">
                    <!-- begin sales order -->
                    <!-- fix -->
                    <div v-if="selectedData.source=='other'">
                        <div>
                            <div class="row">
                                <div class="col-md-12 col-lg-6">
                                    <div class="px-3 py-4 mb-3 rounded">
                                        <h3 class="mb-0"><i class="flaticon2-correct text-success icon-lg mr-2"></i> Sales Order  <a href="#">#@{{ selectedData.data.number }}</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-4">
                                    <table class="table">
                                        <tr>
                                            <td>Nomor DO</td>
                                            <td><strong>@{{ selectedData.data.number }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal DO</td>
                                            <td><strong>@{{ selectedData.data.date }}</strong></td>
                                        </tr>
                                         <tr>
                                            <td>Total</td>
                                            <td><strong>@{{ toCurrencyFormat(deliveryOrderTotal) }}</strong></td>
                                        </tr>
                                          
                                    </table>
                                </div>
                            
                                <div class="col-md-12 col-lg-4">
                                    <table class="table">
                                        <tr>
                                            <td>Nomor SO</td>
                                            <td><strong>@{{ selectedData.data.number }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal SO</td>
                                            <td><strong>@{{ selectedData.data.date }}</strong></td>
                                        </tr>
                                          
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                         
                                 <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <div class="form-row">
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Nomor:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">#</span>
                                        </div>
                                        <input type="text" v-model="bast_number" class="form-control number" id="number">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>PIC Event:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        
                                        <input type="text" v-model="bast_pic_event" id="eventPicName" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="bg-gray-100 p-3 rounded"> -->
                            <div class="form-row">
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Nomor GR:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">#</span>
                                        </div>
                                        <input type="text" v-model="bast_gr_number" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Jabatan:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        
                                        <input type="text" v-model="bast_pic_event_position" id="eventPicPosition" class="form-control">
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
                                        <input type="date" v-model="bast_date" class="form-control bast-date" id="date">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>PIC Magenta:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        
                                        <input type="text" v-model="bast_pic_magenta" id="magentaPicName" class="form-control">
                                    </div>
                                </div>
                            </div>

                              <div class="form-row">
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Customer:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        
                                        <input type="text" v-model="bast_customer" class="form-control" >
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>jabatan:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        
                                        <input type="text" v-model="bast_pic_magenta_position" id="po-date" class="form-control">
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
                                        <input readonly disabled type="text" v-model="bast_amount" id="amount" class="form-control text-right" ><br>
                                        
                                    </div>
                                    <!-- <div  v-if="selectedData">
                                    <span class="text-danger">Sisa BAST @{{toCurrencyFormat(bast_remaining)}}</span>
                                    </div> -->
                                        
                                </div>
                            </div>
                            <!-- </div> -->
                        </div>
                    </div>
                           
                        </div>
                        </div>
                        <!-- end fix -->

                             <div v-if="selectedData.source=='event'">
                        <div>
                            <div class="row">
                                <div class="col-md-12 col-lg-6">
                                    <div class="px-3 py-4 mb-3 rounded">
                                        <h3 class="mb-0"><i class="flaticon2-correct text-success icon-lg mr-2"></i> Sales Order  <a href="#">#@{{ selectedData.data.number }}</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-4">
                                    <table class="table">
                                        <tr>
                                            <td>Nomor DO</td>
                                            <td><strong>@{{ selectedData.data.number }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal DO</td>
                                            <td><strong>@{{ selectedData.data.date }}</strong></td>
                                        </tr>
                                         <tr>
                                            <td>Total</td>
                                            <td><strong>@{{ toCurrencyFormat(deliveryOrderTotal) }}</strong></td>
                                        </tr>
                                          
                                    </table>
                                </div>
                            
                                <div class="col-md-12 col-lg-4">
                                    <table class="table">
                                        <tr>
                                            <td>Nomor SO</td>
                                            <td><strong>@{{ selectedData.data.number }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal SO</td>
                                            <td><strong>@{{ selectedData.data.date }}</strong></td>
                                        </tr>
                                          
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                         
                                 <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <div class="form-row">
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Nomor:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">#</span>
                                        </div>
                                        <input type="text" v-model="bast_number" class="form-control number" id="number">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>PIC Event:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        
                                        <input type="text" v-model="bast_pic_event" id="eventPicName" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="bg-gray-100 p-3 rounded"> -->
                            <div class="form-row">
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Nomor GR:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">#</span>
                                        </div>
                                        <input type="text" v-model="bast_gr_number" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Jabatan:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        
                                        <input type="text" v-model="bast_pic_event_position" id="eventPicPosition" class="form-control">
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
                                        <input type="date" v-model="bast_date" class="form-control bast-date" id="date">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>PIC Magenta:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        
                                        <input type="text" v-model="bast_pic_magenta" id="magentaPicName" class="form-control">
                                    </div>
                                </div>
                            </div>

                              <div class="form-row">
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Customer:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        
                                        <input type="text" v-model="bast_customer" class="form-control" >
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>jabatan:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        
                                        <input type="text" v-model="bast_pic_magenta_position" id="po-date" class="form-control">
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
                                        <input @input="validateAmount()" type="text" v-model="bast_amount" id="amount" class="form-control text-right" ><br>
                                        
                                    </div>
                                    <div  v-if="selectedData">
                                    <span class="text-danger">Sisa BAST @{{toCurrencyFormat(bast_remaining)}}</span>
                                    </div>
                                        
                                </div>
                            </div>
                            
                            <!-- </div> -->
                        </div>
                    </div>
                           
                        </div>
                        </div>
                                           
                    </div>


       
                    
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-6">

                        </div>
                        <div class="col-lg-6 text-lg-right">
                            <button type="submit" class="btn btn-primary" :class="loading && 'spinner spinner-white spinner-right'" :disabled="loading || !isDueDateValid">
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
    <div class="modal fade" id="salesOrderModal" tabindex="-1" aria-labelledby="salesOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="salesOrderModalLabel">Pilih Sales Orderr</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                   
                </div>
                <div class="modal-body">
                    <table class="table" id="sales-order-table">
                        <thead>
                            <th>Nomor SO</th>
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
                            <th>Nomor SO   </th>
                            <th>Tanggal</th>
                             <th>Nomor PO</th>
                              <th>Sisa BAST</th>
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
<script src="{{ asset('js/terbilang.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
@endsection

@section('pagescript')
<script>
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

    let app = new Vue({
        el: '#app',
        data: {
            quotations: [],
            bast_number:'',
            source:'',
            checkedQuotationsIds: [],
            invoiceItems:[],
            number: '{{ $number }}',
            date: '',
            dueDate: '',
            dueDateTerm: 'custom',
            customer: 1,
            taxInvoiceSeries: '',
            termsOfPayment: '',
            grNumber: '',
            discount: 0,
            picPo: '',
            picPoPosition: '',
            note: '',
            salesOrderId: '',
            bastId:'',
            loading: false,
            netto:'',
            ppn:'',
            pph23:'',
            discount:'',
            material:'',
            asf:'',
            subtotal:'',
            total:'',
            bast_amount:'',
            bast_pic_magenta:'Myrawati Setiawan',
            bast_pic_magenta_position:'Project Magenta',
            bast_customer:'',
            bast_pic_event:'',
            bast_pic_event:'',
            bast_pic_event_position:'',
            bast_remaining:'',
            bast_amount:'',
            id:'', 
            bast_date:'',
            bast_gr_number:'',
            deliveryOrderTotal:'',
            cleaveCurrency: {
                delimiter: '.',
                numeralDecimalMark: ',',
                numeral: true,
                numeralThousandsGroupStyle: 'thousand'
            },
            source:'',
            selectedData: null,
            selectedDeliveryOrders: [],
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
                    //selected_data: vm.selectedData,
                    bast_amount:vm.bast_amount,
                    bast_pic_magenta:vm.bast_pic_magenta,
                    bast_pic_magenta_position:vm.bast_pic_magenta_position,
                    bast_customer:vm.bast_customer,
                    bast_pic_event:vm.bast_pic_event,
                    bast_pic_event:vm.bast_pic_event,
                    bast_pic_event_position:vm.bast_pic_event_position,
                    bast_remaining:vm.bast_remaining,
                    bast_amount:vm.bast_amount,
                    id:vm.id, 
                    sales_order_id:vm.selectedData.data.v2_sales_order.id,
                    bast_date:vm.bast_date,
                    number:vm.bast_number,
                    bast_gr_number:vm.bast_gr_number,
                    source:vm.source

                }

                axios.post('/bast', data)
                    .then(function(response) {
                        vm.loading = false;
                        Swal.fire({
                            title: 'Success',
                            text: 'Data has been saved',
                            icon: 'success',
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                               //  window.location.href = '/invoice';
                            }
                        })
                        // console.log(response);
                    })
                    .catch(function(error) {
                        vm.loading = false;
                        console.log(error);
                        if (error.response.data.error_type == 'exist_number') {
                            const {
                                title,
                                text,
                                icon
                            } = error.response.data.data.swal;
                            Swal.fire({
                                title: title,
                                text: text,
                                icon: icon,
                                allowOutsideClick: false,
                            })
                        } else {
                            Swal.fire(
                                'Oops!',
                                'Something wrong',
                                'error'
                            )
                        }
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
            clearCurrencyMask: function(masked) {
                if (masked == '' || masked == 0 || typeof(masked) == 'undefined') {
                    return 0;
                }
                return masked.toString().replaceAll('.', '');
            },
            onChangeDueDateSelect: function(event) {
                const invoiceDate = new Date(this.date);
                const dueDate = new Date();
                const dueDateTerm = event.target.value;
                console.log(invoiceDate, dueDate);
                if (dueDateTerm !== 'custom') {
                    const numDays = Number(dueDateTerm);
                    dueDate.setDate(invoiceDate.getDate() + numDays);
                    this.dueDate = `${dueDate.getFullYear()}-${this.pad(dueDate.getMonth() + 1, 2)}-${this.pad(dueDate.getDate() + 1, 2)}`;
                    $('.due-date').datepicker('setDate', this.dueDate);
                }
                this.dueDateTerm = dueDateTerm;
            },
            pad: function(num, size) {
                num = num.toString();
                while (num.length < size) num = "0" + num;
                return num;
            },
            getDeliveryOrderTotal(deliveryOrder, source = '') {

                function getTotal(items) {
                    if (typeof items == "undefined") {
                        return 0;
                    } else {
                        if (Array.isArray(items)) {
                            return items.map(item => Number(item.pivot.amount)).reduce((acc, cur) => {
                                return acc + cur;
                            }, 0);
                        } else {
                            return 0;
                        }
                    }
                }

                if (source == 'quotation') {
                    return getTotal(deliveryOrder.v2_quotation_items);
                } else if (source == 'purchase_order') {
                    return getTotal(deliveryOrder.cpo_items);
                } else {
                    return 0;
                }
            },
           
               toCurrencyFormat: function(number) {
                if (!number) {
                    number = 0;
                }
                return new Intl.NumberFormat('De-de').format(number);
            },
             validateAmount:function(){
            var bastRemaining=this.bast_remaining;
            var bastAmount=this.bast_amount;
            if (Number(this.bast_amount)>Number(this.bast_remaining)){
                this.bast_amount=this.bast_remaining;
                  
            }

                    

                 
                 
                //  var bastRemaining=this.selectedData.data.v2_sales_order_items[index].bast_remaining;
                //  var bastAmount=this.selectedData.data.v2_sales_order_items[index].bast_amount;
                //  if (bastAmount>bastRemaining){
                //      this.selectedData.data.v2_sales_order_items[index].bast_amount=bastRemaining;
                //  }

                //  return bastAmount;
                
            }
            // dateDiffInDays: function(a, b) {
            //     const _MS_PER_DAY = 1000 * 60 * 60 * 24;
            //     // Discard the time and time-zone information.
            //     const utc1 = Date.UTC(a.getFullYear(), a.getMonth(), a.getDate());
            //     const utc2 = Date.UTC(b.getFullYear(), b.getMonth(), b.getDate());

            //     return Math.floor((utc2 - utc1) / _MS_PER_DAY);
            // },
            // addDays: function(date, days) {
            //     var result = new Date(date);
            //     result.setDate(result.getDate() + days);
            //     return result;
            // },
            // onInputDueDayAmount: function(event) {
            //     console.log(event.target.value);
            //     if (this.date == '') {
            //         return;
            //     }
            //     const days = event.target.value;
            //     const newDate = this.addDays(this.date, days);
            //     this.dueDate = newDate.getFullYear() + '-' + (newDate.getMonth() + 1) + '-' + newDate.getDate();
            // }
            // validateProducedQuantity: function(quotation) {
            //     const remainingQuantity = this.remainingQuantity(quotation.quantity, quotation.produced, quotation.production);
            //     if (remainingQuantity < 0) {
            //         quotation.production = quotation.quantity - quotation.produced;
            //     }
            // },
            // remainingQuantity: function(quantity, produced, production) {
            //     const newProduction = isNaN(production) ? 0 : production;
            //     return Number(quantity) - Number(produced) - Number(newProduction);
            // }
           
        },
        computed: {
            checkedQuotations: function() {
                return this.quotations.filter(quotation => this.checkedQuotationsIds.indexOf(quotation.id) > -1);
            },
            // netto: function() {
            //     let vm = this;
            //     return this.checkedQuotations.map(quotation => {
            //         if (quotation.pivot.estimation == null || typeof quotation.pivot.estimation == 'undefined') {
            //             return 0;
            //         }

            //         const netto = (Number(quotation.pivot.estimation.quantity) * Number(quotation.pivot.estimation.price_per_unit));

            //         return netto;
            //     }).reduce((acc, cur) => {
            //         return acc + cur;
            //     }, 0);
            // },
            netto: () => 0,
            subtotal: function() {
                let vm = this;

                function getTotal(items) {
                    if (typeof items == "undefined") {
                        return 0;
                    } else {
                        if (Array.isArray(items)) {
                            return items.map(item => Number(item.pivot.amount) * Number(item.price)).reduce((acc, cur) => {
                                return acc + cur;
                            }, 0);
                        } else {
                            return 0;
                        }
                    }
                }

                const subtotal = vm.selectedDeliveryOrders.map(order => {
                    if (order.source == 'quotation') {
                        return getTotal(order.v2_quotation_items);
                    } else if (order.source == 'purchase_order') {
                        return getTotal(order.cpo_items);
                    } else {
                        return 0;
                    }
                }).reduce((acc, cur) => {
                    return acc + cur;
                }, 0)

                return subtotal;
            },
            ppn: function() {
                const PERCENTAGE = 10;
                const subtotal = isNaN(this.subtotal) ? 0 : (this.subtotal - Number(this.clearCurrencyMask(this.discount)));
                const ppn = subtotal * (PERCENTAGE / 100);
                return ppn;
            },
            pph: function() {
                const PERCENTAGE = 2;
                const subtotal = isNaN(this.subtotal) ? 0 : (this.subtotal - Number(this.clearCurrencyMask(this.discount)));
                const pph = subtotal * (PERCENTAGE / 100);
                return pph;
            },
            total: function() {
                const total = (this.subtotal - Number(this.clearCurrencyMask(this.discount))) + this.ppn - this.pph;
                return total;
            },
            terbilang: function() {
                let newTerbilang = terbilang(this.total.toString());
                newTerbilang = newTerbilang.replaceAll(' ', '').split('').map((letter, index) => {
                    if (index > 0 && letter == letter.toUpperCase()) {
                        return ' ' + letter;
                    }
                    return letter;
                }).join('');
                return newTerbilang;
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
            },
            isDueDateValid: function() {
                let vm = this;
                const date = new Date(vm.date);
                const dueDate = new Date(vm.dueDate);

                if (vm.date && vm.dueDate) {
                    if (dueDate < date) {
                        return false;
                    }

                    return true;
                }

                return true;
            },
            filteredDeliveryOrders: function() {
                let vm = this;
                if (vm.selectedData.data !== null) {
                    let deliveryOrders = vm.selectedData.data.delivery_orders;
                    if (Array.isArray(deliveryOrders)) {
                        deliveryOrders = deliveryOrders.filter(order => order.invoices.length < 1);
                        if (typeof deliveryOrders !== "undefined") {
                            const selectedDeliveryOrdersIds = vm.selectedDeliveryOrders.map(order => order.id);
                            return deliveryOrders.filter(order => selectedDeliveryOrdersIds.indexOf(order.id) < 0);
                        } else {
                            return [];
                        }
                    } else {
                        return [];
                    }
                } else {
                    return [];
                }
            }
            // dueDayAmount: function() {
            //     if (this.date == '' || this.dueDate == '') {
            //         return 0;
            //     }
            //     const a = new Date(this.date)
            //     const b = new Date(this.dueDate);
            //     const difference = this.dateDiffInDays(a, b);
            //     return difference;
            // }
            // totalRemainingQuantity: function() {
            //     return this.totalQuantity - this.totalProduced;
            // },
        },
        
    })
</script>
<script>
    $(function() {
        salesOrdersTable = $('#sales-order-table').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: '/datatables/bast/delivery-orders',
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
                //    {
                //     data: 'bast_remaining',
                //     name: 'bast_remaining'
                // },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $('#sales-order-table tbody').on('click', '.btn-choose', function() {
            const data = salesOrdersTable.row($(this).parents('tr')).data();
            var source="";
            console.log(data.v2_sales_order)

           if (data.v2_sales_order.source=="quotation"){
            source=data.v2_sales_order.event_quotation.number.substring(0, 2);
             app.$data.id=data.id;
            app.$data.bast_number=number(data.v2_sales_order.event_quotation.title);
            app.$data.bast_customer=data.v2_sales_order.customer.name;

            app.$data.salesOrderId = data.id;
            app.$data.bastId=0
           // app.$data.source=data.source
             app.$data.bast_remaining=data.v2_sales_order.netto-data.v2_sales_order.total_bast;
            
            
            app.$data.deliveryOrderTotal=Number(data.delivery_order_other_quotation_items.reduce((partialSum, a) => partialSum + (a['frequency']*a['quantity']* a['other_quotation_item']['price']), 0))
            app.$data.bast_amount=app.$data.deliveryOrderTotal;
        //    app.$data.bast_amount=data.amount;
       
            app.$data.source= source=="QE"?"event":"other";
            app.$data.selectedData = {
                data,
                source: source=="QE"?"event":"other",
            };

           }else{
            app.$data.id=data.id;
            app.$data.bast_number=number(data.v2_sales_order.customer_purchase_order.title);
            app.$data.bast_customer=data.v2_sales_order.customer.name;

            app.$data.salesOrderId = data.id;
            app.$data.bastId=0
           // app.$data.source=data.source
             app.$data.bast_remaining=data.v2_sales_order.netto-data.v2_sales_order.total_bast;
            
            
            app.$data.deliveryOrderTotal=Number(data.delivery_order_other_quotation_items.reduce((partialSum, a) => partialSum + (a['frequency']*a['quantity']* a['other_quotation_item']['price']), 0))
            app.$data.bast_amount=app.$data.deliveryOrderTotal;
             app.$data.source= data.v2_sales_order.customer_purchase_order.source;
            app.$data.selectedData = {
                data,
                source: data.v2_sales_order.customer_purchase_order.source,
            };

           }
          
        //     $('.bast-date').datepicker({
        //     format: 'yyyy-mm-dd',
        //     todayBtn: false,
        //     clearBtn: true,
        //     todayHighlight: true,
        //     orientation: "bottom left",
        // }).on('changeDate', function(e) {
        //     app.$data.bast_date = e.format(0, 'yyyy-mm-dd');
        // });

            // data.v2_sales_order_items.map(function(item){
            //     item['bast_number']=number();

            // })
           
            
        $('.date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: false,
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
        });
            
            // app.$data.salesOrderNumber = app.$data.selectedData.data.number;
            // const newDate = app.$data.selectedData.data.date;
            // app.$data.salesOrderDate = newDate;
            // $('#salesOrder-date').datepicker('update', newDate);

            $('#salesOrderModal').modal('hide');
        });


        $('.bast-date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: false,
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
        }).on('changeDate', function(e) {
            app.$data.bast_date = e.format(0, 'yyyy-mm-dd');
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
</script>



<script>

  function number(title) {

    var date = new Date();
    var tahun = date.getFullYear();
    var t = tahun.toString()
    var bulan = date.getMonth();
    var tanggal = date.getDate();
    var hari = date.getDay();
    var angka;

    if (String(bulan + 1) == "1") {
      angka = "I";

    } else if (String(bulan + 1) == "2") {
      angka = "II";


    } else if (String(bulan + 1) == "3") {
      angka = "III";


    } else if (String(bulan + 1) == "4") {
      angka = "IV";


    } else if (String(bulan + 1) == "5") {
      angka = "V";


    } else if (String(bulan + 1) == "6") {
      angka = "VI";


    } else if (String(bulan + 1) == "7") {
      angka = "VII";



    } else if (String(bulan + 1) == "8") {
      angka = "VIII";


    } else if (String(bulan + 1) == "9") {
      angka = "IX";


    } else if (String(bulan + 1) == "10") {
      angka = "X";


    } else if (String(bulan + 1) == "11") {
      angka = "XI";


    } else if (String(bulan + 1) == "12") {
      angka = "XII";


    }

   
    let number="No. " + t.substring(2, 4) + (bulan + 1) + tanggal + "/" + title + "/" + angka + "/" + t
   

   
   return number;

  }

</script>
@endsection