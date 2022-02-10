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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Tambah Akun</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Finance</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Akun</a>
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
                <h3 class="card-title">Form Akun</h3>

            </div>
            <!--begin::Form-->
            <form class="form" autocomplete="off" @submit.prevent="submitForm">
                <div class="card-body">
                 <div class="form-group row">
                    
                        <div class="col-lg-6">
                            <label>Nomor Akun:</label>
                            <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">@{{categoryId}} -</span>
                                        </div>
                                        <input type="text" v-model="number" id="number" class="form-control">
                                    </div>
                        </div>
                        <div class="col-lg-6">
                            <label>Nama:<span class="text-danger">*</span></label>
                            <input v-model="name" type="text" class="form-control" placeholder="Enter account's name" required>
                            <!-- <span class="form-text text-muted">Please enter account's name</span> -->
                        </div>
                    </div>
                    <div class="form-group row">
                    
                        <div class="col-lg-6">
                            <label>Category:</label>         
                            <select v-model="categoryId" class="form-control" @change="onChanged($event)">
                                <option value="1"  selected>Asset</option>
                                <option value="2">Liability</option>
                                <option value="3">Equity</option>
                                <option value="4">Income</option>
                                <option value="5">Cost of Sales</option>
                                <option value="6">Expense</option>
                                <option value="8">Other Income</option>
                                <option value="9">Other Expense</option>
                            </select>
                        </div>

                            <div class="col-lg-6">
                            <label>Type:</label>         
                            <select v-model="type" class="form-control" @hanged="onChanged($event)" >
                                <option value="header"  selected>Header</option>
                                <option value="detail" v-if="account.length>0" >Detail</option>
                              
                              
                            </select>
                        </div>
                         
                            <!-- <span class="form-text text-muted">Please enter account's number (Optional)</span> -->
                        </div>
                         <div class="form-group row">
                        <div class="col-lg-6">
                        <label>Level:<span class="text-danger">*</span></label>
                         <select v-model="level" class="form-control" @change="onChangeLevel($event)">
                                <option v-if="type=='header' || account.length<=0"  value="1">Level 1</option>
                                <option v-if="account.length >  0" value="2">Level 2</option>
                                <option v-if="account.length >0"  value="3">Level 3</option>
                                <option  v-if="account.length >0"  value="4">level 4</option>
                             
                            </select>
                        </div>

                        <div class="col-lg-6">
                            <label>Tanggal:</label>
                                   <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="flaticon2-calendar-9"></i></span>
                                        </div>
                                        <input type="text" v-model="date" id="date" class="form-control">
                                    </div>
                        </div>
                    </div>
                      <div class="form-group row">
                    
                        <div class="col-lg-6">
                            <label>Saldo Awal:</label>
                            <input v-model="initBalance" type="text"class="form-control" >
                            <!-- <span class="form-text text-muted">Please enter account's number (Optional)</span> -->
                        </div>
                        <div class="col-lg-6">
                            <label>Saldo Sekarang:<span class="text-danger">*</span></label>
                            <input v-model="balance" type="text" class="form-control">
                            <!-- <span class="form-text text-muted">Please enter account's name</span> -->
                        </div>
                    </div>
                        <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Parent:<span class="text-danger">*</span></label>
                             <select v-model="parentId" class="form-control">
                                 <option v-for="account in accountLevels" :value="account.id">@{{account.name}}</option>
                            </select>


                        </div>

                    
                    </div>

                      <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Status:<span class="text-danger">*</span></label>
                             <select v-model="status" class="form-control">
                                <option value="1" selected>Active</option>
                                <option value="0">In Active</option>
                            </select>


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
                            <button type="submit" @click="sendData" class="btn btn-primary" :class="loading && 'spinner spinner-white spinner-right'" :disabled="loading">
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
@endsection

@section('script')
<script src="{{ asset('js/pages/features/miscellaneous/sweetalert2.js') }}"></script>
<script src="{{ asset('js/pages/crud/forms/widgets/select2.js') }}"></script>
@endsection

@section('pagescript')
<script type="text/x-template" id="select2-template">
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
                    vm.$emit("input", this.value);
                });
        },
        watch: {
            value: function(value) {
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


    let app = new Vue({
        el: '#app',
        data: {
            name: '',
            number: '',
            balance: '0',
            accountNumber:'0',
            type:'',
            level:'',
            initBalance:'0',
            category:'',
            date:'',
            parentId:'',
            isActive:'1',
            loading: false,
            account:[],
            accounts:[],
            accountLevels:[],
            categories:[],
            categoryId:'',
            status:1
        },
        methods: {
            submitForm: function() {
                this.sendData();
            },
            sendData: function() {
                // console.log('submitted');
                //this.loading==false
               
                let vm = this;
                vm.loading = true;
                
                axios.post('{{ env("MAGENTA_FINANCE_URL") }}/api/v1/account', {    
                        number: `${this.categoryId}-${this.number}`,
                        name: this.name,
                        date:this.date,
                        type:this.type,
                        level:this.level,
                        init_balace:0,
                        balance:0,
                        parent_id:this.level==1?0:this.parentId,
                        category_id:this.categoryId,
                        is_active:this.isActive,
                        account_number:"0",
                        init_balance: 0,
                        type: this.type,
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
                                window.location.href = '/finance/account';
                            }
                        })
                 
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
            onChanged:function(event){
                this.categoryId=event.target.value;
                this.getAccounts(this.categoryId)
                this.onChangeAccountLevels();
           
            },
            
            onChangeLevel:function(event){
                let level=event.target.value;
                this.onChangeAccountLevels();

             
            

            },
            onChangeAccountLevels:function(){
                let level=this.level;
                   if (level==1){
                
                    this.accountLevels=[];
                }
                if (level==2){
                    this.accountLevels=this.accounts.filter((item)=>{
                    return item.level==1 &&  item.category_id==this.categoryId
                })

                }
                if (level==3){
                    this.accountLevels=this.accounts.filter((item)=>{
                    return item.level==2 && item.category_id==this.categoryId
                })

                }
                if (level==4){
                    this.accountLevels=this.accounts.filter((item)=>{
                    return item.level==3 && item.category_id==this.categoryId
                })

                }
            },
             getAccounts: async function(id) {
                 await axios.get('{{ env("MAGENTA_FINANCE_URL") }}/api/v1/account?category_id='+id)
                 .then(response=>{
                    this.account=response.data.data;
                
                 })
                 .catch(e=>{

                 })
         
            }
        },
     async mounted(){
         await axios.get('{{ env("MAGENTA_FINANCE_URL") }}/api/v1/account')
         .then((response)=>{
             this.accounts=response.data.data;      
         }).catch(e=>{

         });
       
         //get clasification

         //get account

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