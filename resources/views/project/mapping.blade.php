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
                                        
                                        <textarea rowspan="5"  type="text" v-model="description" class="form-control" disabled ></textarea>
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
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="members-tab" data-toggle="tab" href="#members">
                                    <span class="nav-icon">
                                        <i class="flaticon-users"></i>
                                    </span>
                                    <span class="nav-text">Member</span>
                                </a>
                            </li>
                          
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="tasks-tab" data-toggle="tab" href="#tasks">
                                    <span class="nav-icon">
                                        <i class="flaticon-signs-1"></i>
                                 </span>
                                    <span class="nav-text">Task</span>
                                </a>
                            </li>

                             <li class="nav-item" role="presentation">
                                <a class="nav-link" id="budget-tab" data-toggle="tab" href="#budget">
                                    <span class="nav-icon">
                                        <i class="flaticon-signs-1"></i>
                                 </span>
                                    <span class="nav-text">Budget</span>
                                </a>
                            </li>
                        </ul>


                        <div class="tab-content" id="myTabContent">
                        <!-- begin members -->
                            <div class="tab-pane fade show active" id="members" role="tabpanel" aria-labelledby="members-tab">
                                <div class="mt-2">
                                     <div class="my-3 text-right">
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#membersModal"><i class="flaticon2-plus"></i> Pilih Member</button>
                       
                                      
                                </div>
                         <table class="table" >
                            <tr v-if="selectedMembers.length<0">
                                                    <td colspan="7">
                                                        <p class="text-center">
                                                            <i class="flaticon2-open-box font-size-h1"></i>
                                                        </p>
                                                        <p class="text-center text-dark-50"><strong>Belum ada Anggota</strong></p>

                                                    </td>
                         </tr>
                         <thead v-if="selectedMembers.length>0">
                            <th align="left" style="width: 25%;">Pegawai</th>
                            <th align="left" style="width: 25%;">KTP/NPWP</th>
                            <th align="left"style="width: 15%;">Uang Harian</th>
                            <th align="left" style="width: 15%;">Status</th>
                            <td align="right"> Action<td>
                          
                        </thead>
                        <tbody v-if="selectedMembers.length>0">
                        <tr v-for="(member,index) in selectedMembers">
                            <td align="left">@{{member.first_name}}
                            <br>
                            <strong>
                            @{{member.number}}
                            </strong></td>
                            <td align="left">@{{member.identity_number}}</td>
                            <td align="left">
                                <input type="text" v-model="member.daily_money_regular" class="form-control form-control-sm text-right"  > 
                            </td>
                             <td align="left">
                            <select v-model="member.status" class="form-control" >
                             
                            <option value="member" >Anggota</option>
                                                                    
                            <option value="pic" >PIC</option>
                                                                     </select>
                             
                             </td>
                            <td >
                        <div class="text-right"  >
                                                                    <button type="button" class="btn btn-danger" @click="removeMember(index)">Hapus</button>
                                                                </div>
                            </td>
                          
                        </tr>
                        </tbody>
                    </table>
                      <div style="height: 5px;" class="w-100 bg-gray-200 mt-5"  v-if="selectedMembers.length>0"></div>

                       <div class="my-3 text-right mt-10" v-if="selectedMembers.length>0">
                                       <button type="submit" @click='sendData' class="btn btn-primary" :class="loading && 'spinner spinner-white spinner-right'" :disabled="loading">
                                Save
                            </button>
                                      
                                </div>


                    
                        
                        </div>
                        </div>
                            <!-- end members -->

                              <!-- begin members -->
                           
                            <!-- end members -->

                              <!-- begin members -->
                            <div class="tab-pane fade" id="tasks" role="tabpanel" aria-labelledby="tasks-tab">
                                <div class="mt-2">
                                    <div class="my-3 text-right">
                                        <button type="button" class="btn btn-info" ><i class="flaticon2-plus" @click="selectedTask"></i> Task</button>
                                      
                                </div>
                                           <table class="table table-bordered">
                                            <tbody>
                                                <tr v-if="!tasks.length">
                                                    <td colspan="3">
                                                        <p class="text-center">
                                                            <i class="flaticon2-open-box font-size-h1"></i>
                                                        </p>
                                                        <p class="text-center text-dark-50"><strong>Belum ada Task</strong></p>

                                                    </td>
                                                </tr>
                                                
                                                <template v-for="(item, index) in tasks">
                                                    <tr>
                                                    <th style="width: 30px;">#</th>
                                                       
                                                        <th style="width: 85%;">Nama Task</th>
                                                          <th style="width: 10%;" >Action</th>

                                                   
                                                       
                                                    </tr>
                                                  
                                                
                                                     
                                                        <tr>
                                                             <th class="align-middle text-center">@{{ index + 1 }}</th>
                                                        <td style="width: 85%;" >
                                                           <input type="text" v-model="item.name" class="form-control form-control-sm " @input="calculateSubitemAmount(item)" >
                                                             
                                                        </td>
                                                        
                                                        
                                                        
                                                        <td  style="width: 10%;">
                                                          <div class="row">
                                                                <div class="col-md-12 col-lg-6">
                                                                </div>
                                                            </div>
                                                            <div class="text-right">
                                                                <button type="button" class="btn btn-danger" @click="removeTask(index)">Hapus</button>
                                                            </div>
                                                        </td>


                                                        </tr>
                                                             <tr>
                                                        <td colspan="3">
                                                            <div style="height: 5px;" class="w-100 bg-gray-200"></div>
                                                        </td>
                                                    </tr>
                                                   
                                                   
                                                
                                                </template>
                                            </tbody>
                                        </table>
                                           <div class="my-3 text-right mt-10" v-if="tasks.length>0">
                                       <button type="submit" @click='sendDataTask' class="btn btn-primary" :class="loading && 'spinner spinner-white spinner-right'" :disabled="loading">
                                Save
                            </button>
                                      
                                </div>
                                </div>
                            </div>
                            <!-- end members -->
                            
                            <!-- begin budget -->

                                <div class="tab-pane fade" id="budget" role="tabpanel" aria-labelledby="budget-tab">
                                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <div class="form-row">
                                <div class="col-lg-6 col-md-12">
                                 
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Tanggal Awal Budget :</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="flaticon2-calendar-9"></i></span>
                                        </div>
                                        <input type="text" v-model="budgetStartDate" id="start-date-budget" class="form-control">
                                    </div>
                                </div>
                                   <div class="form-group col-lg-6 col-md-12">
                                    <label>Tanggal Akhir Budget:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="flaticon2-calendar-9"></i></span>
                                        </div>
                                        <input type="text" v-model="budgetEndDate" id="end-date-budget" class="form-control">
                                    </div>
                                </div>
                             
                            </div>

                                <div class="form-row">
                              
                                   <div class="form-group col-lg-12 col-md-12">
                                    <label>Subtotal:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp </span>
                                        </div>
                                        <input type="text" v-model="subTotal" id="end-date-budget" class="form-control text-right">
                                    </div>
                                </div>
                             
                            </div>
                        
                        
                          
                            
                        </div>
                    </div>
                                <div class="mt-2">
                                    <div class="my-3 text-right">
                                        <button  @click="selectedBudget" type="button" class="btn btn-info" ><i class="flaticon2-plus"></i> Budget</button>
                                      
                                </div>
                                           <table class="table table-bordered">
                                            <tbody>
                                                <tr v-if="!budgets.length">
                                                    <td colspan="3">
                                                        <p class="text-center">
                                                            <i class="flaticon2-open-box font-size-h1"></i>
                                                        </p>
                                                        <p class="text-center text-dark-50"><strong>Belum ada  Budget</strong></p>

                                                    </td>
                                                </tr>
                                                
                                                <template v-for="(item, index) in budgets">
                                                    <tr>
                                                    <th style="width: 30px;">#</th>
                                                       
                                                        <th style="width: 30%;">Akun</th>
                                                        <th style="width: 25%;" >Nominal</th>
                                                        <th style="width: 30%;" >Nama penerima</th>
                                                        <th  >Action</th>
     
                                                    </tr>
                                                  
                                                
                                                     
                                                        <tr>
                                                             <th class="align-middle text-center"  style="width: 30px;">@{{ index + 1 }}</th>
                                                        <td style="width: 25%;" >
                                                          <select v-model="item.account_id" class="form-control accounts" style="width: 100%;">
                                                            <option value="">Pilih Akun</option>
                                                            <option v-for="account in accounts" :value="account" >
                                                          @{{account.account.number}} - @{{account.account.name}}</option>
                                            </select>
                                                             
                                                        </td>
                                                         <td style="width: 25%;" >
                                                           <input type="text" v-model="item.amount" class="form-control form-control-sm text-right"  >
                                                             
                                                        </td>
                                                         <td style="width: 25%;" >
                                                           <input type="text" v-model="item.recipient_account" class="form-control form-control-sm "  >
                                                             
                                                        </td>

                                                        
                                                        
                                                        
                                                        <td  style="width: 10%;">
                                                          <div class="row">
                                                                <div class="col-md-12 col-lg-6">
                                                                </div>
                                                            </div>
                                                            <div class="text-right">
                                                                <button type="button" class="btn btn-danger" @click="removeBudget(index)">Hapus</button>
                                                            </div>
                                                        </td>


                                                        </tr>
                                                             <tr>
                                                        <td colspan="5">
                                                            <div style="height: 5px;" class="w-100 bg-gray-200"></div>
                                                        </td>
                                                    </tr>
                                                   
                                                   
                                                
                                                </template>
                                            </tbody>
                                        </table>
                                           <div class="my-3 text-right mt-10" v-if="budgets.length>0">
                                       <button type="submit" @click='sendDataBudget' class="btn btn-primary" :class="loading && 'spinner spinner-white spinner-right'" :disabled="loading">
                                Save
                            </button>
                                      
                                </div>
                                </div>
                            </div>

                            <!-- end budget -->
                    
                        </div>
                    </div>
                    <!-- begin: Example Code-->

                    <!-- end: Example Code-->
                </div>
                <!-- <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-6">

                        </div>
                        <div class="col-lg-6 text-lg-right">
                            <button type="submit" class="btn btn-primary" :class="loading && 'spinner spinner-white spinner-right'" :disabled="loading" @click="sendDataBudget">
                                Save
                            </button>
                            <!-- <button type="reset" class="btn btn-secondary">Cancel</button> -->
                        <!-- </div>
                    </div>
                </div> --> -->
            </form>
            <!--end::Form-->
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="membersModal" tabindex="-1" aria-labelledby="membersModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="membersModalLabel">Pilih Members</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table" id="members-table">
                         <thead>
                            <th align="left">Pegawai</th>
                            <th align="left">KTP/NPWP</th>
                            <th align="left">Uang Harian</th>
                            <th align="left">Action</th>
                        </thead>
                        <tbody>
                        <tr v-for="(member,index) in members">
                            <td align="left">@{{member.first_name}}
                            <br>
                            <strong>
                            @{{member.employee_id}}
                            </strong></td>
                            <td align="left">@{{member.identity_number}}</td>
                            <td align="left">@{{toCurrencyFormat(member.daily_money_regular)}}</td>
                            <td align="left">
                                 <div class="form-group col-md-4">
                                    <label class="checkbox">
                                        <input v-model="number.id" type="checkbox" v-on:click="isChecked(member)" >
                                    <span></span>
                                    </label>
                                    </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
 
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
            selectedMembers:JSON.parse('{!! $members!!}'),
            projectId:'{{$project_id}}',
            tasks:JSON.parse(`{!!$project->tasks!!}`),
            budgets:JSON.parse(`{!!$budgets!!}`),
            accounts:[],
            budgetStartDate:'{!!$project->budgets==null?"":$project->budgets->start_date!!}',
            budgetEndDate:'{!!$project->budgets==null?"":$project->budgets->start_date!!}',
             accountId:''
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
                selected_members:this.selectedMembers,
                project_id:this.projectId,
                };
                axios.post('/project/member', data)
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
                sendDataTask: function() {
                // console.log('submitted');
                let vm = this;
                vm.loading = true;
                const data = {
                selected_tasks:this.tasks,
                project_id:this.projectId,
                };
                axios.post('/project/task', data)
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
                sendDataBudget: function() {
                // console.log('submitted');
                let vm = this;
                vm.loading = true;
                const data = {
                selected_budgets:this.budgets,
                project_id:this.projectId,
                budget_start_date:vm.budgetStartDate,
                budget_end_date:vm.budgetEndDate,
                balance:vm.subTotal,
                };
                axios.post('/project/budget', data)
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
            },
            isChecked:function(member){
             const itemId = this.selectedMembers.map(item => member.id);
            
            if ((itemId.indexOf(this.selectedMembers.id) < 0) ){
                 this.selectedMembers.push(member)
            }

            },
            removeMember: function(index) {
                
                this.selectedMembers.splice(index, 1);
            },
            removeTask: function(index) {
                
                this.tasks.splice(index, 1);
            },
             removeBudget: function(index) {
                
                this.budgets.splice(index, 1);
            },
            selectedTask:function(){
                var data={
                    name:""
                }
               
                this.tasks.push(data)

            },
            
            selectedBudget:function(){
                var data={
                    account_name:"",
                    acccount_id:'',
                    account_number:'',
                    amount:'',
                    recipient_account:'',
                   

                }
               
                this.budgets.push(data)

            },
            getAccounts: async function(){
                 //get all event quotation accounts
                await axios.get('{{ env("MAGENTA_FINANCE_URL") }}/api/v1/account-mapping?name=project').then(response=>{
                    this.accounts=response.data.data;
                    console.log(response.data.data)
                
                }).catch(e=>{

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
            }
        },
    async mounted(){
              await axios.get('https://hrd.magentamediatama.net/api/employees').then((response)=>{
                  var dataa=response.data.data.forEach((element) => {
                      element['status']="member";
                       element['number']=element['employee_id'];
                      this.members.push(element);
                       // 
                    }); 
              }).catch(e=>{
                  console.log(e)

              })
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
        $('#start-date-budget').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: false,
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
        }).on('changeDate', function(e) {
            app.$data.budgetStartDate = e.format(0, 'yyyy-mm-dd');
        });

        $('#end-date-budget').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: false,
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
        }).on('changeDate', function(e) {
            app.$data.budgetEndDate = e.format(0, 'yyyy-mm-dd');
        });
    })
</script>

@endsection