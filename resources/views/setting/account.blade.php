@extends('layouts.app')

@section('title', 'Metaprint')

@section('head')
<link href="{{ asset('css/pages/wizard/wizard-2.css') }}" rel="stylesheet" type="text/css" />
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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Pengaturan</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Setting</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Account</a>
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
<div class="card card-custom" id="app">
    <div class="card-body p-0">
        <!--begin: Wizard-->
        <div class="wizard wizard-2" id="kt_wizard" data-wizard-state="first" data-wizard-clickable="false">
            <!--begin: Wizard Nav-->
            <div class="wizard-nav border-right py-8 px-8 py-lg-20 px-lg-10">
                <!--begin::Wizard Step 1 Nav-->
                @include('setting.menu')
                <!--end: Wizard Nav-->
                <!--begin: Wizard Body-->
                <div class="wizard-body py-8 px-8 py-lg-20 px-lg-10">
                    <!--begin: Wizard Form-->
                    <h3>Mapping Akun</h3>
                    
                <!-- collapse -->
                <!-- <div class="ml-5 mt-10">
                   <div class="p-3 mb-2 bg-light text-white row">
                   <label class="text-secondary">
                    Sales Order
                   </label>
                   <div data-toggle="collapse" data-target="#sales-order" class="text-right" aria-controls="demo" style="width: 90%;" >
                <a href="#"><i class="flaticon2-up text-right"></i></a>
                  
                </div>
                
                   </div>


                   <div class="row collapse" id="sales-order" aria-expanded="false" >
                    <div class="col-lg-8 col-md-12">
                    
                     <div class="form-group row">
                    
                        <div class="col-lg-6">
                            <label>Debit</label>         
                          <select v-model="accountId" class="form-control accounts" style="width: 100%;">
                           
                              <option value="">Pilih Akun</option>
                              <template>
                                 <optgroup v-for="(category,index) in accounts" :label="category.name" v-if="category.accounts.length>0">
                                    <template class="ml-10">
                                    <option v-for="(account,index) in category.accounts" :value="account.id" ><span class="mt-10">
                                    &nbsp;&nbsp;&nbsp;&nbsp;@{{account.name}}</span></option>                              
                                    </template>
                                </optgroup>
                                 </template>

                                
                            
                            
                            </select>   
                        </div>

                         <div class="col-lg-6">
                            <label>Credit</label>         
                          <select v-model="coaId" class="form-control coa" style="width: 100%;">
                           <option value="">Pilih Akun</option>
                                <template>
                                 <optgroup v-for="(category,index) in accounts" :label="category.name" v-if="category.accounts.length>0">
                                    <template class="ml-10">
                                    <option v-for="(account,index) in category.accounts" :value="account.id"><span class="mt-10">
                                    &nbsp;&nbsp;&nbsp;&nbsp;@{{account.number}}-@{{account.name}}</span></option>
                                    
                                    </template>
                                    
                                </optgroup>
                                 </template>
                            </select>
                        </div>

   
       
                        </div>

                         <div class="col-lg-12 text-lg-right">
                            <button type="submit" class="btn btn-primary" :class="loading && 'spinner spinner-white spinner-right'" :disabled="loading" @click="sendData('sales-order')">
                                Save
                            </button>
                           
                        </div>
                        <span class="form-text text-muted mt-10">Berikut ini akun sales order</span>

                     
                    </div>
                       <table class="table table-bordered" >
                        <thead >
                        <tr >
                            <td style="width: 40%;">
                                Debit
                            </td>
                            <td style="width: 25%;">
                                Credit
                            </td>
                            <td style="width: 10%;">
                                Action
                            </td>
                        </tr>

                        <thead>
                        <tbody>
                        <tr v-for="(account,index) in salesOrderAccounts">
                            <td v-if="account.account_id!=0 && account.account_id!=null">
                            @{{account.account.number}} - @{{account.account.name}}
                            </td>
                            <td v-else></td>
                             
                            <td v-if="account.coa!=0 && account.coa!=null">
                            @{{account.chart_of_account.number}} - @{{account.chart_of_account.name}}
                            </td>
                            <td v-else></td>
                             
                    
                                  <td class="text-center">
                

                                   <a @click="deleteRecord(account.id,account.name,index)" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
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
                      

                </div>
                     <div class="p-3 mb-2 bg-light text-white row mt-10">
                   <label class="text-secondary">
                    Quotation Event
                   </label>
                   <div data-toggle="collapse" data-target="#event-quotation" class="text-right" aria-controls="demo" style="width: 87%;" >
                <a href="#"><i class="flaticon2-up text-right"></i></a>
                </div>
                   </div> -->

                   <!-- begin content event quotation -->

                    <!-- <div class="row collapse" id="event-quotation" aria-expanded="false" >
                    <div class="col-lg-8 col-md-12">
                    
                     <div class="form-group row">
                    
                        <div class="col-lg-6">
                            <label>Debit</label>   
                                  
                          <select v-model="accountId" class="form-control accounts" style="width: 100%;">
                          <option value="">Pilih Akun</option>
                             <template>
                                 <optgroup v-for="(category,index) in accounts" :label="category.name" v-if="category.accounts.length>0">
                                    <template class="ml-10">
                                    <option v-for="(account,index) in category.accounts"  :value="account.id"><span class="mt-10">
                                    &nbsp;&nbsp;&nbsp;&nbsp;@{{account.name}}</span></option>
                                    
                                    </template>
                                    
                                </optgroup>
                                 </template>
                                 
                            </select>
                            
                            
                            
                        </div>

                          <div class="col-lg-6">
                            <label>Credit</label>         
                          <select v-model="coaId" class="form-control coa" style="width: 100%;">
                           <option value="">Pilih Akun</option>
                                    <template>
                                 <optgroup v-for="(category,index) in accounts" :label="category.name" v-if="category.accounts.length>0">
                                    <template class="ml-10">
                                    <option v-for="(account,index) in category.accounts" :value="account.id" ><span class="mt-10">
                                    &nbsp;&nbsp;&nbsp;&nbsp;@{{account.name}}</span></option>
                                    
                                    </template>
                                    
                                </optgroup>
                                 </template>
                            </select>
                        </div>

   
       
                        </div>

                         <div class="col-lg-12 text-lg-right">
                            <button type="submit" class="btn btn-primary" :class="loading && 'spinner spinner-white spinner-right'" :disabled="loading" @click="sendData('event-quotation')">
                                Save
                            </button>
                           
                        </div>
                        <span class="form-text text-muted mt-10">Berikut ini akun Quotation Event</span>

                     
                    </div>
                       <table class="table table-bordered" >
                        <thead >
                        <tr >
                            <td style="width: 40%;">
                                Debit
                            </td>
                            <td style="width: 25%;">
                                Credit
                            </td>
                            <td style="width: 10%;">
                                Action
                            </td>
                        </tr>

                        <thead>
                        <tbody>
                        
                        <tr v-for="(account,index) in eventQuotationAccounts">
                             <td v-if="account.account_id!=0 && account.account_id!=null">
                            @{{account.account.number}} - @{{account.account.name}}
                            </td>
                            <td v-else></td>
                             
                            <td v-if="account.coa!=0 && account.coa!=null">
                            @{{account.chart_of_account.number}} - @{{account.chart_of_account.name}}
                            </td>
                            <td v-else></td>
                           
                                  <td class="text-center">
                      

                                   <a @click="deleteRecord(account.id,account.name,index)" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
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
                      

                </div> -->





                      <!-- <div class="p-3 mb-2 bg-light text-white row mt-10">
                   <label class="text-secondary">
                    Quotation Other
                   </label>
                   <div data-toggle="collapse" data-target="#other-quotation" class="text-right" aria-controls="demo" style="width: 87%;" >
                <a href="#"><i class="flaticon2-up text-right"></i></a>
                </div>
                   
                   </div> -->


                          <!-- begin content other quotation -->
<!-- 
                    <div class="row collapse" id="other-quotation" aria-expanded="false" >
                    <div class="col-lg-8 col-md-12">
                    
                     <div class="form-group row">
                    
                        <div class="col-lg-6">
                            <label>Debit</label>         
                          <select v-model="accountId" class="form-control accounts" style="width: 100%;">
                           <option value="">Pilih Akun</option>
                                   <template>
                                 <optgroup v-for="(category,index) in accounts" :label="category.name" v-if="category.accounts.length>0">
                                    <template class="ml-10">
                                    <option v-for="(account,index) in category.accounts" :value="account.id" ><span class="mt-10">
                                    &nbsp;&nbsp;&nbsp;&nbsp;@{{account.name}}</span></option>
                                    
                                    </template>
                                    
                                </optgroup>
                                 </template>
                            </select>
                        </div>
                          

                            <div class="col-lg-6">
                            <label>Credit</label>         
                          <select v-model="coaId" class="form-control coa" style="width: 100%;">
                           <option value="">Pilih Akun</option>
                                   <template>
                                 <optgroup v-for="(category,index) in accounts" :label="category.name" v-if="category.accounts.length>0">
                                    <template class="ml-10">
                                    <option v-for="(account,index) in category.accounts" :value="account.id" ><span class="mt-10">
                                    &nbsp;&nbsp;&nbsp;&nbsp;@{{account.name}}</span></option>
                                    
                                    </template>
                                    
                                </optgroup>
                                 </template>

                            </select>
                        </div>

   
       
                        </div>

                         <div class="col-lg-12 text-lg-right">
                            <button type="submit" class="btn btn-primary" :class="loading && 'spinner spinner-white spinner-right'" :disabled="loading" @click="sendData('other-quotation')">
                                Save
                            </button>
                           
                        </div>
                        <span class="form-text text-muted mt-10">Berikut ini akun quotation other</span>

                     
                    </div>
                       <table class="table table-bordered" >
                        <thead >
                        <tr >
                            <td style="width: 40%;">
                                Debit
                            </td>
                            <td style="width: 25%;">
                                Credit
                            </td>
                            <td style="width: 10%;">
                                Action
                            </td>
                        </tr>

                        <thead>
                        <tbody>
                        
                        <tr v-for="(account,index) in otherQuotationAccounts">
                             <td v-if="account.account_id!=0 && account.account_id!=null">
                            @{{account.account.number}} - @{{account.account.name}}
                            </td>
                            <td v-else></td>
                             
                            <td v-if="account.coa!=0 && account.coa!=null">
                            @{{account.chart_of_account.number}} - @{{account.chart_of_account.name}}
                            </td>
                            <td v-else></td>
                                  <td class="text-center">
                      

                                   <a @click="deleteRecord(account.id,account.name,index)" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
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
                      

                </div> -->
                                   <!-- end content event-quotation-->


                     <div class="p-3 mb-2 bg-light text-white row mt-10 d-flex justify-content-between">
                   <label class="text-secondary">
                   Project
                   </label>
                   <div  data-toggle="collapse" data-target="#project" class="text-right" aria-controls="demo" >
                <a href="#"><i class="flaticon2-up text-right"></i></a>
                </div>
                   </div>

                   <!-- begin content event quotation -->

                    <div class="row collapse" id="project" aria-expanded="false" >
                    <div class="col-lg-8 col-md-12">
                    
                     <div class="form-group row">
                    
                        <div class="col-lg-6">
                            <label>Debit</label>   
                                  
                          <select v-model="accountId" class="form-control accounts" style="width: 100%;">
                           <option value="">Pilih Akun</option>
                                   <template>
                                 <optgroup v-for="(category,index) in accounts" :label="category.name" v-if="category.accounts.length>0">
                                    <template class="ml-10">
                                    <option v-for="(account,index) in category.accounts" :value="account.id"><span class="mt-10">
                                    &nbsp;&nbsp;&nbsp;&nbsp;@{{account.name}}</span></option>
                                    
                                    </template>
                                    
                                </optgroup>
                                 </template>
                            </select>
                            
                        </div>

                          <div class="col-lg-6">
                            <label>Credit</label>         
                          <select v-model="coaId" class="form-control coa" style="width: 100%;">
                           <option value="">Pilih Akun</option>
                                   <template>
                                 <optgroup v-for="(category,index) in accounts" :label="category.name" v-if="category.accounts.length>0">
                                    <template class="ml-10">
                                    <option v-for="(account,index) in category.accounts" :value="account.id" ><span class="mt-10">
                                    &nbsp;&nbsp;&nbsp;&nbsp;@{{account.name}}</span></option>
                                    
                                    </template>
                                    
                                </optgroup>
                                 </template>
                            </select>
                        </div>

   
       
                        </div>

                         <div class="col-lg-12 text-lg-right">
                            <button type="submit" class="btn btn-primary" :class="loading && 'spinner spinner-white spinner-right'" :disabled="loading" @click="sendData('project')">
                                Save
                            </button>
                            <!-- <button type="reset" class="btn btn-secondary">Cancel</button> -->
                        </div>
                        <span class="form-text text-muted mt-10">Berikut ini akun Project</span>

                     
                    </div>
                       <table class="table table-bordered" >
                        <thead >
                        <tr >
                            <td style="width: 40%;">
                                Debit
                            </td>
                            <td style="width: 25%;">
                            Credit
                            </td>
                            <td style="width: 10%;">
                                Action
                            </td>
                        </tr>

                        <thead>
                        <tbody>
                        
                        <tr v-for="(account,index) in projectAccounts">
                              <td v-if="account.account_id!=0 && account.account_id!=null">
                            @{{account.account.number}} - @{{account.account.name}}
                            </td>
                            <td v-else></td>
                             
                            <td v-if="account.coa!=0 && account.coa!=null">
                            @{{account.chart_of_account.number}} - @{{account.chart_of_account.name}}
                            </td>
                            <td v-else></td>
                           
                                  <td class="text-center">
                      

                                   <a @click="deleteRecord(account.id,account.name,index)" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
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
                      

                </div>

                   <!-- end content project-->

                   
                   <!-- end content event-quotation-->

             
                   <!-- <div class="p-3 mb-2 bg-light text-white row mt-10">
                   <label class="text-secondary">
                    Hutang Sales Order
                   </label>
                   <div data-toggle="collapse" data-target="#hutang-sales-order" class="text-right" aria-controls="demo" style="width: 83%;" >
                <a href="#"><i class="flaticon2-up text-right"></i></a>
                </div>
                </div> -->

                   <!-- begin content hutang -->

                    <!-- <div class="row collapse" id="hutang-sales-order" aria-expanded="false" >
                    <div class="col-lg-8 col-md-12">
                    
                     <div class="form-group row">
                    
                        <div class="col-lg-6">
                            <label>Debit</label>         
                          <select v-model="accountId" class="form-control accounts" style="width: 100%;">
                          <option value="">Pilih Akun</option>
                                  <template>
                                 <optgroup v-for="(category,index) in accounts" :label="category.name" v-if="category.accounts.length>0">
                                    <template class="ml-10">
                                    <option v-for="(account,index) in category.accounts" :value="account.id" ><span class="mt-10">
                                    &nbsp;&nbsp;&nbsp;&nbsp;@{{account.name}}</span></option>
                                    
                                    </template>
                                    
                                </optgroup>
                                 </template>
                            </select>
                        </div>


                          <div class="col-lg-6">
                            <label>Credit</label>         
                          <select v-model="coaId" class="form-control coa" style="width: 100%;">
                           <option value="">Pilih Akun</option>
                             
                                   <template>
                                 <optgroup v-for="(category,index) in accounts" :label="category.name" v-if="category.accounts.length>0">
                                    <template class="ml-10">
                                    <option v-for="(account,index) in category.accounts" :value="account.id" ><span class="mt-10">
                                    &nbsp;&nbsp;&nbsp;&nbsp;@{{account.name}}</span></option>
                                    
                                    </template>
                                    
                                </optgroup>
                                 </template>
                            </select>
                        </div>

   
       
                        </div>

                         <div class="col-lg-12 text-lg-right">
                            <button type="submit" class="btn btn-primary" :class="loading && 'spinner spinner-white spinner-right'" :disabled="loading" @click="sendData('hutang-sales-order')">
                                Save
                            </button>
                          
                        </div>
                          <span class="form-text text-muted mt-10">Berikut ini akun hutang (hanya punya 1 akun)</span>
                     
                    </div>
                       <table class="table table-bordered" >
                        <thead >
                        <tr >
                            <td style="width: 40%;">
                                Debit
                            </td>
                            <td style="width: 25%;">
                                Credit
                            </td>
                            <td style="width: 10%;">
                                Action
                            </td>
                        </tr>

                        <thead>
                        <tbody>
                        
                        <tr v-for="(account,index) in hutangSalesOrderAccounts">
                             <td v-if="account.account_id!=0 && account.account_id!=null">
                            @{{account.account.number}} - @{{account.account.name}}
                            </td>
                            <td v-else></td>
                             
                            <td v-if="account.coa!=0 && account.coa!=null">
                            @{{account.chart_of_account.number}} - @{{account.chart_of_account.name}}
                            </td>
                            <td v-else></td>
                           
                                  <td class="text-center">
                      

                                   <a @click="deleteRecord(account.id,account.name,index)" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
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
                      

                </div> -->

                   <!-- end content hutang-->

                   <!-- end content event-quotation-->

             
                   <div class="p-3 mb-2 bg-light text-white row mt-10 d-flex justify-content-between ">
                   <label class="text-secondary">
                    Hutang Invoice Event
                   </label>
                   <div  data-toggle="collapse" data-target="#hutang-quotation-event"  aria-controls="demo"  >
                <a href="#"><i class="flaticon2-up text-right"></i></a>
                </div>
                </div>

                   <!-- begin content hutang -->

                    <div class="row collapse" id="hutang-quotation-event" aria-expanded="false" >
                    <div class="col-lg-8 col-md-12">
                    
                     <div class="form-group row">
                    
                        <div class="col-lg-6">
                            <label>Debit</label>         
                          <select v-model="accountId" class="form-control accounts" style="width: 100%;">
                          <option value="">Pilih Akun</option>
                                  <template>
                                 <optgroup v-for="(category,index) in accounts" :label="category.name" v-if="category.accounts.length>0">
                                    <template class="ml-10">
                                    <option v-for="(account,index) in category.accounts" :value="account.id" ><span class="mt-10">
                                    &nbsp;&nbsp;&nbsp;&nbsp;@{{account.name}}</span></option>
                                    
                                    </template>
                                    
                                </optgroup>
                                 </template>
                            </select>
                        </div>


                          <div class="col-lg-6">
                            <label>Credit</label>         
                          <select v-model="coaId" class="form-control coa" style="width: 100%;">
                           <option value="">Pilih Akun</option>
                             
                                   <template>
                                 <optgroup v-for="(category,index) in accounts" :label="category.name" v-if="category.accounts.length>0">
                                    <template class="ml-10">
                                    <option v-for="(account,index) in category.accounts" :value="account.id" ><span class="mt-10">
                                    &nbsp;&nbsp;&nbsp;&nbsp;@{{account.name}}</span></option>
                                    
                                    </template>
                                    
                                </optgroup>
                                 </template>
                            </select>
                        </div>

   
       
                        </div>

                         <div class="col-lg-12 text-lg-right">
                            <button type="submit" class="btn btn-primary" :class="loading && 'spinner spinner-white spinner-right'" :disabled="loading" @click="sendData('hutang-quotation-event')">
                                Save
                            </button>
                            <!-- <button type="reset" class="btn btn-secondary">Cancel</button> -->
                        </div>
                          <span class="form-text text-muted mt-10">Berikut ini akun hutang (hanya punya 1 akun)</span>
                     
                    </div>
                       <table class="table table-bordered" >
                        <thead >
                        <tr >
                            <td style="width: 40%;">
                                Debit
                            </td>
                            <td style="width: 25%;">
                                Credit
                            </td>
                            <td style="width: 10%;">
                                Action
                            </td>
                        </tr>

                        <thead>
                        <tbody>
                        
                        <tr v-for="(account,index) in hutangQuotationEventAccounts">
                             <td v-if="account.account_id!=0 && account.account_id!=null">
                            @{{account.account.number}} - @{{account.account.name}}
                            </td>
                            <td v-else></td>
                             
                            <td v-if="account.coa!=0 && account.coa!=null">
                            @{{account.chart_of_account.number}} - @{{account.chart_of_account.name}}
                            </td>
                            <td v-else></td>
                           
                                  <td class="text-center">
                      

                                   <a @click="deleteRecord(account.id,account.name,index)" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
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
                      

                </div>

                   <!-- end content hutang-->


                   <!-- end content event-quotation-->

             
                   <div class="p-3 mb-2 bg-light text-white row mt-10 d-flex justify-content-between">
                   <label class="text-secondary">
                    Hutang Invoice Other
                   </label>
                   <div data-toggle="collapse" data-target="#hutang-quotation-other" class="text-right" aria-controls="demo" >
                <a href="#"><i class="flaticon2-up text-right"></i></a>
                </div>
                </div>

                   <!-- begin content hutang -->

                    <div class="row collapse" id="hutang-quotation-other" aria-expanded="false" >
                    <div class="col-lg-8 col-md-12">
                    
                     <div class="form-group row">
                    
                        <div class="col-lg-6">
                            <label>Debit</label>         
                          <select v-model="accountId" class="form-control accounts" style="width: 100%;">
                          <option value="">Pilih Akun</option>
                                  <template>
                                 <optgroup v-for="(category,index) in accounts" :label="category.name" v-if="category.accounts.length>0">
                                    <template class="ml-10">
                                    <option v-for="(account,index) in category.accounts" :value="account.id" ><span class="mt-10">
                                    &nbsp;&nbsp;&nbsp;&nbsp;@{{account.name}}</span></option>
                                    
                                    </template>
                                    
                                </optgroup>
                                 </template>
                            </select>
                        </div>


                          <div class="col-lg-6">
                            <label>Credit</label>         
                          <select v-model="coaId" class="form-control coa" style="width: 100%;">
                           <option value="">Pilih Akun</option>
                             
                                   <template>
                                 <optgroup v-for="(category,index) in accounts" :label="category.name" v-if="category.accounts.length>0">
                                    <template class="ml-10">
                                    <option v-for="(account,index) in category.accounts" :value="account.id" ><span class="mt-10">
                                    &nbsp;&nbsp;&nbsp;&nbsp;@{{account.name}}</span></option>
                                    
                                    </template>
                                    
                                </optgroup>
                                 </template>
                            </select>
                        </div>

   
       
                        </div>

                         <div class="col-lg-12 text-lg-right">
                            <button type="submit" class="btn btn-primary" :class="loading && 'spinner spinner-white spinner-right'" :disabled="loading" @click="sendData('hutang-quotation-other')">
                                Save
                            </button>
                            <!-- <button type="reset" class="btn btn-secondary">Cancel</button> -->
                        </div>
                          <span class="form-text text-muted mt-10">Berikut ini akun hutang (hanya punya 1 akun)</span>
                     
                    </div>
                       <table class="table table-bordered" >
                        <thead >
                        <tr >
                            <td style="width: 40%;">
                                Debit
                            </td>
                            <td style="width: 25%;">
                                Credit
                            </td>
                            <td style="width: 10%;">
                                Action
                            </td>
                        </tr>

                        <thead>
                        <tbody>
                        
                        <tr v-for="(account,index) in hutangQuotationOtherAccounts">
                             <td v-if="account.account_id!=0 && account.account_id!=null">
                            @{{account.account.number}} - @{{account.account.name}}
                            </td>
                            <td v-else></td>
                             
                            <td v-if="account.coa!=0 && account.coa!=null">
                            @{{account.chart_of_account.number}} - @{{account.chart_of_account.name}}
                            </td>
                            <td v-else></td>
                           
                                  <td class="text-center">
                      

                                   <a @click="deleteRecord(account.id,account.name,index)" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
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
                      

                </div>

                   <!-- end content hutang-->


                    <!-- <div class="p-3 mb-2 bg-light text-white row mt-10">
                   <label class="text-secondary">
                    Piutang Sales Order
                   </label>
                   <div data-toggle="collapse" data-target="#piutang-sales-order" class="text-right" aria-controls="demo" style="width: 83%;" >
                <a href="#"><i class="flaticon2-up text-right"></i></a>
                </div>
                   
                   </div> -->

                               <!-- begin content hutang -->

                    <!-- <div class="row collapse" id="piutang-sales-order" aria-expanded="false" >
                    <div class="col-lg-8 col-md-12">
                    
                     <div class="form-group row">
                    
                        <div class="col-lg-6">
                            <label>Debit</label>         
                          <select v-model="accountId" class="form-control accounts" style="width: 100%;">
                                   <option value="">Pilih Akun</option>
                                  <template>
                                 <optgroup v-for="(category,index) in accounts" :label="category.name" v-if="category.accounts.length>0">
                                    <template class="ml-10">
                                    <option v-for="(account,index) in category.accounts" :value="account.id" ><span class="mt-10">
                                    &nbsp;&nbsp;&nbsp;&nbsp;@{{account.name}}</span></option>
                                    
                                    </template>
                                    
                                </optgroup>
                                 </template>
                            </select>
                        </div>

                          <div class="col-lg-6">
                            <label>Credit</label>         
                          <select v-model="coaId" class="form-control coa" style="width: 100%;">
                             <option value="">Pilih Credit</option>
                                   <template>
                                 <optgroup v-for="(category,index) in accounts" :label="category.name" v-if="category.accounts.length>0">
                                    <template class="ml-10">
                                    <option v-for="(account,index) in category.accounts" :value="account.id" ><span class="mt-10">
                                    &nbsp;&nbsp;&nbsp;&nbsp;@{{account.name}}</span></option>
                                    
                                    </template>
                                    
                                </optgroup>
                                 </template>
                            </select>
                        </div>
                        

   
       
                        </div>

                         <div class="col-lg-12 text-lg-right">
                            <button type="submit" class="btn btn-primary" :class="loading && 'spinner spinner-white spinner-right'" :disabled="loading" @click="sendData('piutang-sales-order')">
                                Save
                            </button>
                          
                        </div>
                          <span class="form-text text-muted mt-10">Berikut ini akun Piutang (hanya punya 1 akun)</span>
                     
                    </div>
                       <table class="table table-bordered" >
                        <thead >
                        <tr >
                            <td style="width: 40%;">
                                Credit
                            </td>
                            <td style="width: 25%;">
                            Debit
                            </td>
                            <td style="width: 10%;">
                                Action
                            </td>
                        </tr>

                        <thead>
                        <tbody>
                        
                        <tr v-for="(account,index) in piutangSalesOrderAccounts">
                             <td v-if="account.account_id!=0 && account.account_id!=null">
                            @{{account.account.number}} - @{{account.account.name}}
                            </td>
                            <td v-else></td>
                             
                            <td v-if="account.coa!=0 && account.coa!=null">
                            @{{account.chart_of_account.number}} - @{{account.chart_of_account.name}}
                            </td>
                            <td v-else></td>
                           
                                  <td class="text-center">
                      

                                   <a @click="deleteRecord(account.id,account.name,index)" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
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
                      

                </div> -->


                    <div class="p-3 mb-2 bg-light text-white row mt-10 d-flex justify-content-between">
                   <label class="text-secondary">
                    Piutang Invoice Event
                   </label>
                   <div data-toggle="collapse" data-target="#piutang-quotation-event" class="text-right" aria-controls="demo" >
                <a href="#"><i class="flaticon2-up text-right"></i></a>
                </div>
                   
                   </div>

                               <!-- begin content hutang -->

                    <div class="row collapse" id="piutang-quotation-event" aria-expanded="false" >
                    <div class="col-lg-8 col-md-12">
                    
                     <div class="form-group row">
                    
                        <div class="col-lg-6">
                            <label>Debit</label>         
                          <select v-model="accountId" class="form-control accounts" style="width: 100%;">
                                   <option value="">Pilih Akun</option>
                                  <template>
                                 <optgroup v-for="(category,index) in accounts" :label="category.name" v-if="category.accounts.length>0">
                                    <template class="ml-10">
                                    <option v-for="(account,index) in category.accounts" :value="account.id" ><span class="mt-10">
                                    &nbsp;&nbsp;&nbsp;&nbsp;@{{account.name}}</span></option>
                                    
                                    </template>
                                    
                                </optgroup>
                                 </template>
                            </select>
                        </div>

                          <div class="col-lg-6">
                            <label>Credit</label>         
                          <select v-model="coaId" class="form-control coa" style="width: 100%;">
                             <option value="">Pilih Credit</option>
                                   <template>
                                 <optgroup v-for="(category,index) in accounts" :label="category.name" v-if="category.accounts.length>0">
                                    <template class="ml-10">
                                    <option v-for="(account,index) in category.accounts" :value="account.id" ><span class="mt-10">
                                    &nbsp;&nbsp;&nbsp;&nbsp;@{{account.name}}</span></option>
                                    
                                    </template>
                                    
                                </optgroup>
                                 </template>
                            </select>
                        </div>
                        

   
       
                        </div>

                         <div class="col-lg-12 text-lg-right">
                            <button type="submit" class="btn btn-primary" :class="loading && 'spinner spinner-white spinner-right'" :disabled="loading" @click="sendData('piutang-quotation-event')">
                                Save
                            </button>
                            <!-- <button type="reset" class="btn btn-secondary">Cancel</button> -->
                        </div>
                          <span class="form-text text-muted mt-10">Berikut ini akun Piutang (hanya punya 1 akun)</span>
                     
                    </div>
                       <table class="table table-bordered" >
                        <thead >
                        <tr >
                            <td style="width: 40%;">
                                Credit
                            </td>
                            <td style="width: 25%;">
                            Debit
                            </td>
                            <td style="width: 10%;">
                                Action
                            </td>
                        </tr>

                        <thead>
                        <tbody>
                        
                        <tr v-for="(account,index) in piutangQuotationEventAccounts">
                             <td v-if="account.account_id!=0 && account.account_id!=null">
                            @{{account.account.number}} - @{{account.account.name}}
                            </td>
                            <td v-else></td>
                             
                            <td v-if="account.coa!=0 && account.coa!=null">
                            @{{account.chart_of_account.number}} - @{{account.chart_of_account.name}}
                            </td>
                            <td v-else></td>
                           
                                  <td class="text-center">
                      

                                   <a @click="deleteRecord(account.id,account.name,index)" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
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
                      

                </div>

                      <div class="p-3 mb-2 bg-light text-white row mt-10 d-flex justify-content-between">
                   <label class="text-secondary">
                    Piutang Inovoice Other
                   </label>
                   <div data-toggle="collapse" data-target="#piutang-quotation-other" class="text-right" aria-controls="demo" >
                <a href="#"><i class="flaticon2-up text-right"></i></a>
                </div>
                   
                   </div>

                               <!-- begin content hutang -->

                    <div class="row collapse" id="piutang-quotation-other" aria-expanded="false" >
                    <div class="col-lg-8 col-md-12">
                    
                     <div class="form-group row">
                    
                        <div class="col-lg-6">
                            <label>Debit</label>         
                          <select v-model="accountId" class="form-control accounts" style="width: 100%;">
                                   <option value="">Pilih Akun</option>
                                  <template>
                                 <optgroup v-for="(category,index) in accounts" :label="category.name" v-if="category.accounts.length>0">
                                    <template class="ml-10">
                                    <option v-for="(account,index) in category.accounts" :value="account.id" ><span class="mt-10">
                                    &nbsp;&nbsp;&nbsp;&nbsp;@{{account.name}}</span></option>
                                    
                                    </template>
                                    
                                </optgroup>
                                 </template>
                            </select>
                        </div>

                          <div class="col-lg-6">
                            <label>Credit</label>         
                          <select v-model="coaId" class="form-control coa" style="width: 100%;">
                             <option value="">Pilih Credit</option>
                                   <template>
                                 <optgroup v-for="(category,index) in accounts" :label="category.name" v-if="category.accounts.length>0">
                                    <template class="ml-10">
                                    <option v-for="(account,index) in category.accounts" :value="account.id" ><span class="mt-10">
                                    &nbsp;&nbsp;&nbsp;&nbsp;@{{account.name}}</span></option>
                                    
                                    </template>
                                    
                                </optgroup>
                                 </template>
                            </select>
                        </div>
                        

   
       
                        </div>

                         <div class="col-lg-12 text-lg-right">
                            <button type="submit" class="btn btn-primary" :class="loading && 'spinner spinner-white spinner-right'" :disabled="loading" @click="sendData('piutang-quotation-other')">
                                Save
                            </button>
                            <!-- <button type="reset" class="btn btn-secondary">Cancel</button> -->
                        </div>
                          <span class="form-text text-muted mt-10">Berikut ini akun Piutang (hanya punya 1 akun)</span>
                     
                    </div>
                       <table class="table table-bordered" >
                        <thead >
                        <tr >
                            <td style="width: 40%;">
                                Credit
                            </td>
                            <td style="width: 25%;">
                            Debit
                            </td>
                            <td style="width: 10%;">
                                Action
                            </td>
                        </tr>

                        <thead>
                        <tbody>
                        
                        <tr v-for="(account,index) in piutangQuotationOtherAccounts">
                             <td v-if="account.account_id!=0 && account.account_id!=null">
                            @{{account.account.number}} - @{{account.account.name}}
                            </td>
                            <td v-else></td>
                             
                            <td v-if="account.coa!=0 && account.coa!=null">
                            @{{account.chart_of_account.number}} - @{{account.chart_of_account.name}}
                            </td>
                            <td v-else></td>
                           
                                  <td class="text-center">
                      

                                   <a @click="deleteRecord(account.id,account.name,index)" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
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
                      

                </div>


                </div>

                   <!-- end content hutang-->
                  
                    <!--end: Wizard Form-->
                <!-- body sales order -->
               
                </div>
                <!--end: Wizard Body-->
            </div>
            <!--end: Wizard-->
        </div>
    </div>
    @endsection

    @section('script')
    <script src="{{ asset('js/pages/features/miscellaneous/sweetalert2.js') }}"></script>
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    @endsection

    @section('pagescript')
    <script>
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        let app = new Vue({
            el: '#app',
            data: {
                name: '{{ $user->name }}',
                position: '{{ $user->position }}',
                gender: '{{ $user->gender }}',
                phone: '{{ $user->phone }}',
                email: '{{ $user->email }}',
                username: '{{ $user->username }}',
                password: '',
                confirmPassword: '',
                currentPassword: '',
                accounts:[],
                salesOrderAccounts:[],
                eventQuotationAccounts:[],
                otherQuotationAccounts:[],

                hutangQuotationOtherAccounts:[],
                hutangQuotationEventAccounts:[],
                hutangSalesOrderAccounts:[],
                piutangQuotationEventAccounts:[],
                piutangQuotationOtherAccounts:[],
                piutangSalesOrderAccounts:[],
                projectAccounts:[],
                coaId:'',
                accountId:'',
                loading: false,
            },
            methods: {
                // submitForm: function() {
                //     this.sendData();
                // },
            
                sendData: function(name) {
                    // console.log('submitted');
                    let vm = this;
                    vm.loading = true;
                    console.log(this.accountId)
                      console.log(this.coaId)

                   

                    axios.post('{{ env("MAGENTA_FINANCE_URL") }}/api/v1/account-mapping', {
                        name:name,
                        account_id:vm.accountId,
                        coa:vm.coaId,

                    })
                        .then(function(response) {
                            vm.loading = false;
                            toastr.success("Akun Berhasil disimpan");
                            vm.accountId="0";
                              
                                if (name=="sales-order"){
                             vm.getSalesOrderAccounts();

                            }

                        if (name=="event-quotation"){
                            vm.getEventQuotationAccounts();

                        }
                        if (name=="other-quotation"){
                            vm.getOtherQuotationAccounts();

                        }

                        if (name=="hutang-quotation-event"){
                            vm.getHutangQuotationEventAccounts();

                        }
                        if (name=="hutang-quotation-other"){
                            vm.getHutangQuotationOtherAccounts();

                        }
                        if (name=="hutang-sales-order"){
                            vm.getHutangSalesOrderAccounts();

                        }

                        
                        if (name=="piutang-sales-order"){
                            vm.getPiutangSalesOrderAccounts(); 

                        }
                        if (name=="piutang-quotation-event"){
                            vm.getPiutangQuotationEventAccounts(); 

                        }
                        if (name=="piutang-quotation-other"){
                            vm.getPiutangQuotationOtherAccounts(); 

                        }
                        if (name=="project"){
                            vm.getProjects(); 

                        }
                            // Swal.fire({
                            //     title: 'Success',
                            //     text: 'Data has been saved',
                            //     icon: 'success',
                            //     allowOutsideClick: false,
                            // }).then((result) => {
                            //     if (result.isConfirmed) {
                            //         // window.location.href = '/sales-order';
                            //     }
                            // })
                            // console.log(response);
                        })
                        .catch(function(error) {
                            vm.loading = false;
                            console.log(error);
                            toastr.error("Perubahan gagal disimpan");
                            // Swal.fire(
                            //     'Oops!',
                            //     'Something wrong',
                            //     'error'
                            // )
                        });
                },
                  deleteRecord: function(id,name,index) {
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
                        return axios.delete('{{ env("MAGENTA_FINANCE_URL") }}/api/v1/account-mapping/' + id)
                            .then(function(response) {
                                console.log(response.data);
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
                    if (result.isConfirmed) {
                         toastr.success("Akun Berhasil dihapus");
                        if (name=="sales-order"){
                             this.salesOrderAccounts.splice(index, 1);

                        }

                        if (name=="event-quotation"){
                            this.eventQuotationAccounts.splice(index, 1);

                        }
                        if (name=="other-quotation"){
                            this.otherQuotationAccounts.splice(index, 1);

                        }
                        if (name=="hutang"){
                            this.hutangAccounts.splice(index, 1);

                        }
                        if (name=="piutang"){
                            this.piutangAccounts.splice(index, 1);

                        }
                        if (name=="project"){
                            this.projectAccounts.splice(index, 1);

                        }
                        
                        
                        
                        
                       // if ()
                        // Swal.fire({
                        //     icon: 'success',
                        //     title: 'Success',
                        //     text: 'Data has been deleted',
                        // }).then((result) => {
                        //     if (result.isConfirmed) {
                        //         window.location.reload();
                        //     }
                        // })
                    }
                })
            },

                updateAccount: function() {
                    let vm = this;
                    if ((vm.password !== '' && vm.password !== null) || (vm.confirmPassword !== '' && vm.confirmPassword !== null)) {
                        if (vm.password !== vm.confirmPassword) {
                            toastr.warning("Konfirmasi password tidak sesuai");
                            return;
                        }
                    }

                    vm.loading = true;

                    const data = {
                        username: vm.username,
                        password: vm.password,
                        current_password: vm.currentPassword,
                    };

                    axios.post('/user/action/update-account/{{ $user->id }}', data)
                        .then(function(response) {
                            vm.loading = false;
                            toastr.success("Perubahan telah disimpan");
                            setTimeout(() => {
                                window.location.reload();
                            }, 500)
                            // Swal.fire({
                            //     title: 'Success',
                            //     text: 'Data has been saved',
                            //     icon: 'success',
                            //     allowOutsideClick: false,
                            // }).then((result) => {
                            //     if (result.isConfirmed) {
                            //         // window.location.href = '/sales-order';
                            //     }
                            // })
                            // console.log(response);
                        })
                        .catch(function(error) {
                            vm.loading = false;
                            console.log(error);
                            const {
                                data
                            } = error.response;
                            toastr.error(data.message);
                        });
                },
            getSalesOrderAccounts: function(){
                  //get all sales order accounts
             axios.get('{{ env("MAGENTA_FINANCE_URL") }}/api/v1/account-mapping?name=sales-order').then(response=>{
                    this.salesOrderAccounts=response.data.data;
                    

                }).catch(e=>{

                })

            },
            getEventQuotationAccounts: async function() {
               //get all event quotation accounts
                await axios.get('{{ env("MAGENTA_FINANCE_URL") }}/api/v1/account-mapping?name=event-quotation').then(response=>{
                    this.eventQuotationAccounts=response.data.data;
                  

                }).catch(e=>{

                })

            },
            getOtherQuotationAccounts: async function(){
                       //get all other quotation accounts
                await axios.get('{{ env("MAGENTA_FINANCE_URL") }}/api/v1/account-mapping?name=other-quotation').then(response=>{
                    this.otherQuotationAccounts=response.data.data;
                }).catch(e=>{
                })
            },
            getPiutangSalesOrderAccounts: async function(){
                //get all other piutang accounts
                await axios.get('{{ env("MAGENTA_FINANCE_URL") }}/api/v1/account-mapping?name=piutang-sales-Order').then(response=>{
                    this.piutangSalesOrderAccounts=response.data.data;
                   

                }).catch(e=>{

                })

            },
            getPiutangQuotationEventAccounts: async function(){
                //get all other piutang accounts
                await axios.get('{{ env("MAGENTA_FINANCE_URL") }}/api/v1/account-mapping?name=piutang-quotation-event').then(response=>{
                    this.piutangQuotationEventAccounts=response.data.data;
                   
                }).catch(e=>{

                })

            },
            getPiutangQuotationOtherccounts: async function(){
                //get all other piutang accounts
                await axios.get('{{ env("MAGENTA_FINANCE_URL") }}/api/v1/account-mapping?name=piutang-quotation-other').then(response=>{
                    this.piutangQuotationOtherAccounts=response.data.data;
                   

                }).catch(e=>{

                })

            },
            getHutangSalesOrderAccounts: async function(){
                  //get all hutang  accounts
                await axios.get('{{ env("MAGENTA_FINANCE_URL") }}/api/v1/account-mapping?name=hutang-sales-order').then(response=>{
                    this.hutangSalesOrderAccounts=response.data.data;
                   

                }).catch(e=>{

                })
            },
            getHutangQuotationEventAccounts: async function(){
                  //get all hutang  accounts
                await axios.get('{{ env("MAGENTA_FINANCE_URL") }}/api/v1/account-mapping?name=hutang-quotation-event').then(response=>{
                    this.hutangQuotationEventAccounts=response.data.data;
                   

                }).catch(e=>{

                })
            },
       
            getHutangQuotationOtherAccounts: async function(){
                  //get all hutang  accounts
                await axios.get('{{ env("MAGENTA_FINANCE_URL") }}/api/v1/account-mapping?name=hutang-quotation-other').then(response=>{
                    this.hutangQuotationOtherAccounts=response.data.data;
                   

                }).catch(e=>{

                })
            },


             getProjects: async function(){
                //get all hutang  accounts
                await axios.get('{{ env("MAGENTA_FINANCE_URL") }}/api/v1/account-mapping?name=project').then(response=>{
                    this.projectAccounts=response.data.data;
                   

                }).catch(e=>{

                })

            }

            },
            
            async mounted(){
                //get all account
                await axios.get('{{ env("MAGENTA_FINANCE_URL") }}/api/v1/account/category').then(response=>{
                    this.accounts=response.data.data;
                   

                }).catch(e=>{

                })

                this.getSalesOrderAccounts();
                this.getEventQuotationAccounts();
                this.getOtherQuotationAccounts();
               
                this.getHutangSalesOrderAccounts();
                this.getHutangQuotationEventAccounts();
                this.getPiutangSalesOrderAccounts();
                this.getPiutangQuotationEventAccounts();
                this.getPiutangQuotationOtherccounts();
              
                this.getProjects();
            }
        })
    </script>
    <script>
        $(function() {

            $('#company-logo').dropzone({
                url: "https://keenthemes.com/scripts/void.php", // Set the url for your upload script location
                paramName: "file", // The name that will be used to transfer the file
                maxFiles: 1,
                maxFilesize: 5, // MB
                addRemoveLinks: true,
                accept: function(file, done) {
                    if (file.name == "justinbieber.jpg") {
                        done("Naha, you don't.");
                    } else {
                        done();
                    }
                }
            });
        })
    </script>

    <script>
    $(function(){
            $(".accounts").select2({
        });
             $(".accounts").on('change', function() {
            
            app.$data.accountId = $(this).val();
            // console.log(searchText);
        });

                   $(".coa").select2({
        });
           $(".coa").on('change', function() {
            
            app.$data.coaId = $(this).val();
            // console.log(searchText);
        });
    })


    

    </script>

    

    @endsection