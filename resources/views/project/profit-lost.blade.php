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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Laba Rugi Project</h5>
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
                        <a href="" class="text-muted">Laba Rugi Project</a>
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
                <span class="card-title">Project <br>{{$project->number}}</span>
                <span class="card-title"></span>
                <div data-toggle="collapse" data-target="#demo" class="card-title" aria-controls="demo" >
                <a href="#"><i class="flaticon2-up"></i></a>
                </div>

            </div>
            <!--begin::Form-->
       
            <form class="form" autocomplete="off" @submit.prevent="submitForm" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row collapse" id="demo" aria-expanded="false" >
                        <div class="col-lg-8 col-md-12">
                            <div class="form-row">
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Nomor:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">#</span>
                                        </div>
                                        <input type="text" v-model="number" class="form-control" disabled>
                                    </div>
                                </div>
                                
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
                                        <input type="text" v-model="startDate" class="form-control" id="start-date" disabled>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Tanggal Akhir:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="flaticon2-calendar-9"></i></span>
                                        </div>
                                        <input type="text" v-model="endDate" class="form-control" id="end-date" disabled>
                                    </div>
                                </div>
                               
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Customer:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        
                                        <input type="text" v-model="customer" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>PIC:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        
                                        <input type="text" v-model="pic" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>

                                <div class="form-row">
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Deskripsi:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        
                                        <textarea rowspan="5"  type="text" v-model="outDescription" class="form-control" disabled ></textarea>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Lokasi:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        
                                        <textarea rowspan="5" type="text" v-model="address" class="form-control" disabled ></textarea>
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
                                        <input type="text" v-model="amount" id="grandTotal" class="form-control text-right" @input="validateAmount" disabled><br>
                                        
                                    </div>
                                    <div  v-if="selectedData">
                                  
                                    </div>
                                        
                                </div>
                            </div>
                            <!-- </div> -->
                        </div>
                    </div>
                    <div class="mt-5">
                    
              
                </div>
               
            </form>
            <!--end::Form-->
        </div>
    </div>


    <!-- begin out project -->
<div class="card card-custom gutter-b" id="app">
    <div class="card-header flex-wrap py-3">
        <div class="card-title">
            <h3 class="card-label">Out Project
                <!-- <span class="d-block text-muted pt-2 font-size-sm">sorting &amp; pagination remote datasource</span> -->
            </h3>
        </div>
 
    </div>
    <div class="card-body">
        <div v-if="loading" class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated " role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
                    <form class="form" autocomplete="off" @submit.prevent="submitForm" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                              <div class="form-row">
                                <div class="form-group col-lg-12 col-md-12">
                                    <label>Akun</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        
                                            <select v-model="account" class="form-control accounts" style="width: 100%;">
                                                            <option value="">Pilih Akun</option>
                                                            <option v-for="account in accounts" :value="account.id" >
                                                          @{{account.account.number}} - @{{account.account.name}}</option>
                                            </select>
                                    </div>
                                </div>
                            
                            </div>
                          
                            <!-- <div class="bg-gray-100 p-3 rounded"> -->
                            <div class="form-row">
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Tanggal :</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="flaticon2-calendar-9"></i></span>
                                        </div>
                                        <input type="text" v-model="outDate" class="form-control" id="out-date">
                                    </div>
                                </div>
                                        <div class="form-group col-lg-6 col-md-12">
                                    <label>Nominal:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        
                                     
                                          <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp </span>
                                        </div>
                                          <input type="text" v-model="outAmount" class="form-control text-right" >
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-12 col-md-12">
                                    <label>Note:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        
                                        <input type="text" v-model="outDescription" class="form-control" >
                                    </div>
                                </div>
                                
                            </div>

                           


                          

                            <!-- </div> -->
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


     
        <!--begin: Datatable-->
        <table class="table table-bordered" id="basic-table">
            <thead class="bg-light">
                <tr class="text-center">
                    <th>Tanggal</th>
                    <th>Note</th>
                    <th>Nominal</th>
                    
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="transaction in outProjectTransactions">
                    <td style="width: 200px;">@{{ transaction.date }}</td>
                    <td style="width: 40%;">@{{ transaction.note }}</td>
                    <td class="text-right" >@{{ currencyFormat(transaction.amount) }}</td>
                   
                    <td class="text-center  " style="width: 10%;">
                    <a href="#" @click="deleteRecord(transaction.id)" class="btn btn-sm btn-clean btn-icon btn-delete" title="Delete"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <rect x="0" y="0" width="24" height="24"></rect>
                  <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>
                  <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>
                </g>
              </svg> </span> </a>
                    
                    </td>
                </tr>
            </tbody>
        </table>
        <!--end: Datatable-->
    </div>
</div>
<!-- end out -->
 

<!-- begin list transaksi -->
<div class="card card-custom gutter-b" id="app">
    <div class="card-header flex-wrap py-3">
        <div class="card-title">
            <h3 class="card-label">List Transaksi
                <!-- <span class="d-block text-muted pt-2 font-size-sm">sorting &amp; pagination remote datasource</span> -->
            </h3>
        </div>
        <div class="card-toolbar">

        </div>
    </div>
    <div class="card-body">
        <div v-if="loading" class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated " role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="d-flex align-items-center flex-wrap alert alert-light mb-10">
            <!--begin: Item-->
            <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                <span class="mr-4">
                    <i class="flaticon2-arrow-down icon-2x text-success font-weight-bold"></i>
                </span>
                <div class="d-flex flex-column text-dark-50">
                    <span class="font-weight-bolder font-size-sm">Total In</span>
                    <span class="font-weight-bolder font-size-h5">
                        @{{ currencyFormat(inTotal) }}
                    </span>
                    <!-- <span class="text-dark-50 font-weight-bold">Pcs</span></span> -->
                </div>
            </div>
            <!--end: Item-->
            <!--begin: Item-->
            <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                <span class="mr-4">
                    <i class="flaticon2-arrow-up icon-2x text-danger font-weight-bold"></i>
                </span>
                <div class="d-flex flex-column text-dark-50">
                    <span class="font-weight-bolder font-size-sm">Total Out</span>
                    <span class="font-weight-bolder font-size-h5">
                        @{{ currencyFormat(outTotal) }}
                    </span>
                    <!-- <span class="text-dark-50 font-weight-bold">Pcs</span></span> -->
                </div>
            </div>
            <!--end: Item-->
            <!--begin: Item-->
            <div class="d-flex justify-content-center align-items-center flex-lg-fill mr-5 my-1">
                <span class="mr-4">
                    <i class="flaticon2-poll-symbol icon-2x text-primary font-weight-bold"></i>
                </span>
                <div class="d-flex flex-column text-dark-50">
                    <span class="font-weight-bolder font-size-sm">Saldo</span>
                    <span class="font-weight-bolder font-size-h5">
                        @{{ currencyFormat(inTotal - outTotal) }}
                    </span>
                    <!-- <span class="text-dark-50 font-weight-bold">Pcs</span></span> -->
                </div>
            </div>
            <!--end: Item-->
        </div>
        <!--begin: Datatable-->
         @{{balance=0}}
        <table class="table table-bordered" id="basic-table">
            <thead class="bg-light">
                <tr class="text-center">
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                    <th>Note</th>
                    <th>in</th>
                    <th>out</th>
                    <th>Saldo</th>
                </tr>
            </thead>
            <tbody>
           
                <tr v-for="transaction in projectProfitLostTransactions">
                    <td style="width: 200px;">@{{ transaction.date }}</td>
                    <td>@{{ transaction.description }}</td>
                     <td>@{{ transaction.note }}</td>
                    <td class="text-right">@{{ transaction.type == 'in' ? currencyFormat(transaction.amount) : '' }}</td>
                    <td class="text-right">@{{ transaction.type == 'out' ? currencyFormat(transaction.amount) : '' }}</td>
                    <td class="text-right">
                    @{{transaction.type == 'in'?balance=balance+transaction.amount:balance=balance-transaction.amount}}</td>
                </tr>
           
            </tbody>
            
        </table>
        <!--end: Datatable-->
    </div>
</div>
<!-- end list transaction -->
 
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
            number: '{!!$project->number!!}',
            date: '',
            startDate:'{!!$project->start_date!!}',
            endDate:'{!!$project->end_date!!}',
            grNumber:'',
            customer:'{!!$project->customer!!}',
            pic:'{!!$project->pic!!}',
            address:'{!!$project->address!!}',
            eventPicId:'',
            transactions: [],
            totalIn: 0,
            totalOut: 0,
            
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
            amount:'{!!$project->amount!!}',
            poId: '',
            poNumber: '',
            poDate: '',
            termOfPayment: '',
            dueDate: '',
            description: '{!!$project->description!!}',
            bastRemaining:'',
            loading: false,
            selectedData: [],
            customerCode:'',
            source:'',
            poNumber:'',
            members:[],
           
            projectId:'{{$project_id}}',
            
            accounts:[],
            account:'',

            accountId:'',
            accountName:'',
            accountNumber:'',
            outAmount:'',
            outDescription:'',
            outDate:'',
            outProjectTransactions:JSON.parse(String.raw`{!! $out_project_transactions !!}`),
            projectProfitLostTransactions:JSON.parse(String.raw `{!! $project_profit_lost_transactions !!}`),
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
                    date:vm.outDate,
                    description:vm.outDescription,
                    amount:vm.outAmount,
                    account:vm.account,
                    project_id:vm.projectId
                    
                
                };
                axios.post('/project/profit-lost', data)
                    .then(function(response) {
                        //vm.loading = false;
                        // Swal.fire({
                        //     title: 'Success',
                        //     text: 'Data has been saved',
                        //     icon: 'success',
                        //     allowOutsideClick: false,
                        // }).then((result) => {
                        //     if (result.isConfirmed) {
                        //         // window.location.href = '/goods';
                        //     }
                        // })

                        axios.post('{{ env("MAGENTA_FINANCE_URL") }}/api/v1/account-transaction',{
                            date:vm.outDate,
                            note:vm.outDescription,
                            account:vm.account,
                            amount:vm.outAmount,
                            data:response.data.data,
                            source:"out_budget_transaction"


                        })
                        .then(response=>{
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

                        }).catch(function(error){

                        })
                         
                            vm.outProjectTransactions.push(response.data.data)
                            vm.projectProfitLostTransactions.push(response.data.data)
                       
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
            
           
            toCurrencyFormat: function(number) {
                if (!number) {
                    number = 0;
                }
                return new Intl.NumberFormat('De-de').format(number);
            },

        
           
            getAccounts: async function(){
                 //get all event quotation accounts
                await axios.get('{{ env("MAGENTA_FINANCE_URL") }}/api/v1/account-mapping?name=project').then(response=>{
                    this.accounts=response.data.data;
                    console.log(response.data.data)
                
                }).catch(e=>{

                })
            }, currencyFormat: function(number) {
                return Intl.NumberFormat('de-DE').format(number);
            },
            deleteRecord:function(id){
                     let self=this;
                             
               
                    Swal.fire({
                    title: 'Are you sure?',
                    text: "The data will be deleted",
                    icon: 'warning',
                    reverseButtons: true,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        return axios.delete('/project/profit-lost/' + id)
                        .then(function(response) {
                            // let i= self.projectProfitLostTransactions.findIndex( x => x.id === id );
                            // let j= self.outProjectTransactions.findIndex( x => x.id === id );
                            // console.log(i)
                            //  self.outProjectTransactions.splice(j,1);
                            //   self.projectProfitLostTransactions.splice(i,1);

                             
                            Swal.fire({
                            title: 'Success',
                            text: 'Data has been saved',
                            icon: 'success',
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // window.location.href = '/goods';
                                  location.reload();
                            }

                        
                         
                          

                           
                            
                        })
                            })
                            .catch(function(error) {
                                console.log(error.data);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops',
                                    text: 'Something wrong',
                                })
                            });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    
                    
                })

            }
        },
    
        computed: {
            grandTotal: function() {
                const grandTotal = this.selectedData.map(item => Number(item.netto)).reduce((acc, cur) => {
                    return acc + cur;
                }, 0);

                return grandTotal;
            },
            subTotal:function(){
               const grandTotal = this.budgets.map(item => Number(item.amount)).reduce((acc, cur) => {  
                    return acc + cur;
                }, 0);

                return grandTotal;
            },
            inTotal:function(){
                const inTotal = this.projectProfitLostTransactions.filter(item=>item.type=="in").map(item => Number(item.amount)).reduce((acc, cur) => {
                
                    return acc + cur;
                }, 0);

                return inTotal;

            },
            outTotal:function(){
                const outTotal = this.projectProfitLostTransactions.filter(item=>item.type=="out").map(item => Number(item.amount)).reduce((acc, cur) => {
                    return acc + cur;
                }, 0);

                return outTotal;

            }

        },
    async mounted(){
            //   await axios.get('https://hrd.magentamediatama.net/api/employees').then((response)=>{
            //       var dataa=response.data.data.forEach((element) => {
            //           element['status']="member";
            //            element['number']=element['employee_id'];
            //           this.members.push(element);
            //            // 
            //         }); 
            //   }).catch(e=>{
            //       console.log(e)

            //   })
              this.getAccounts();

                

              await $('#members-table').DataTable({});
               
            
        }
    })
</script>

<script>

  function number() {
    let title=app.$data.title;
    let number="" + t.substring(2, 4) + (bulan + 1) + tanggal + "/" + title + "/" + angka + "/" + t
    app.$data.number=number;
  }

</script>

<script>
    $(function() {
       

        $('#out-date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: false,
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
        }).on('changeDate', function(e) {
            app.$data.outDate = e.format(0, 'yyyy-mm-dd');
        });
    })
</script>



<script>
        $(".accounts").select2({
        });
        $(".accounts").on('change', function() {
                 console.log($(this).val());
                app.$data.account=app.$data.accounts.filter((item)=>item.id==$(this).val())[0]
        });
</script>



@endsection