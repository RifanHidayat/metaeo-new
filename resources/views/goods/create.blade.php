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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Tambah Barang</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Barang</a>
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


<div class="modal fade" id="pphModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form"  @submit.prevent="addPphRate">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Nama PPh:</label>
            <input v-model="pphName" type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Tarif PPh:</label>

               <div class="input-group">
                <input type="text" v-model="pphAmount" class="form-control text-right" placeholder="Tarif PPh">
                <div class="input-group-append">
                <span class="input-group-text"><strong class="text-dark-50">%</strong></span>
                        </div>
                                                    </div>
       
            <!-- <input v-model="pphAmount" type="text" class="form-control" id="recipient-name">
          -->
        
        
        </div>
          
           <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" :class="loading && 'spinner spinner-white spinner-right'" :disabled="loading">
                Save
              </button>
      </div>
        </form>
      </div>
     
    </div>
  </div>
</div>
    <div class="col-lg-12">
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <h3 class="card-title">Form Barang</h3>
            </div>
            <!--begin::Form-->
            <form class="form" autocomplete="off" @submit.prevent="submitForm">
                <div class="card-body">
                    <div class="row">
                              <div class="form-row col-12">
                        <div class="form-group col-lg-4">
                         <label>Kategori Barang:</label>
                                 <select v-model="category" class="form-control goods-category">
                                    <option value="">Pilih Kategori</option>
                                    <option v-for="(ctg, index) in categories" :value="ctg.id">@{{ ctg.name }}</option>
                                </select>
                        </div>
                          <div class="form-group col-lg-4">
                         <label>Sub  Kategori Barang:</label>
                                 <select v-model="subcategory" class="form-control goods-subcategory">
                                    <option value="">Pilih Sub Kategori</option>
                                    <option v-for="(ctg, index) in subCategories" :value="ctg.id">@{{ ctg.name }}</option>
                                </select>
                        </div>

                         <div  class="form-group col-lg-4" v-if="type=='jasa'" >
                     
                            <label>PPh:</label>
                                 <select  v-model="pphrate" class="form-control pph-rate">
                                    <option value="">Pilih PPh</option>
                                    <option v-for="(ctg, index) in pphRates" :value="ctg.id">@{{ ctg.name }} - @{{ctg.amount}}% </option>
                                </select>
                    
                            </div>
                        
                        </div>


                        <div class="form-row col-12">
                        <div class="form-group col-lg-4">
                        <label>Kode. Barang:</label>
                        <input v-model="number" type="text" class="form-control"  maxlength="15">
                        <small class='text-muted'>
                            Kode produk terdiri dari 15 karakter
                        </small>

                        </div>
                   
                        <div class="form-group col-lg-4">
                              <label>Nama Barang:</label>
                            <input v-model="name" type="text" class="form-control">
                            </div>
                        </div>
                         <div class="form-row col-8" >
                        <div class="form-group col-lg-6">
                           <label>Jenis Barang:</label>
                             <select v-model="type" class="form-control type">
                                    <option value="persedian">Persedian</option>
                                     <option value="jasa">Jasa</option>
                                    
                                </select>
                        </div>
                         <div class="form-group col-lg-6">
                            <label>Satuan</label>
                             <select v-model="unit" class="form-control unit">
                                    <option value="">Pilih Satuan</option>
                                    <option v-for="(unit, index) in units" :value="unit.name">@{{ unit.name }}</option>
                                </select>
                        
                               
                      <!-- <span class="form-text text-muted">Please enter supplier's name</span> -->
                            </div>
                       
                        </div>

                        <div class="form-row col-8" >
                            

                        <div class="form-group col-lg-6">
                           <label>Harga Satuan:</label>
                            <input  v-model="purchasePrice" type="text" class="form-control text-right">
                        </div>
                      
                        </div>

                        
                        <!-- <div class="col-lg-6 col-md-12">
                            
                           
                            <div class="form-group">
                                <label>Kode Barang:</label>
                                <input type="text" v-model="number" class="form-control"> -->
                                <!-- <span class="form-text text-muted">23Please enter customer's NPWP (Optional)</span> -->
                            <!-- </div>
                            <div class="form-group">
                                <label>Nama Barang:</label>
                                <input type="text" v-model="name" class="form-control"> -->
                                <!-- <span class="form-text text-muted">23Please enter customer's NPWP (Optional)</span> -->
                            <!-- </div>
                            <div class="form-group">
                                <label>Satuan:</label>
                                <input type="text" v-model="unit" class="form-control"> -->
                                <!-- <span class="form-text text-muted">23Please enter customer's NPWP (Optional)</span> -->
                            <!-- </div>
                            <div class="form-group">
                                <label>Harga Beli:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" v-model="purchasePrice" class="form-control text-right">
                                </div> -->

                                <!-- <span class="form-text text-muted">23Please enter customer's NPWP (Optional)</span> -->
                            <!-- </div>
                            <div class="form-group">
                                <label>Stok:</label>
                                <input type="text" v-model="stock" class="form-control text-right"> -->
                                <!-- <span class="form-text text-muted">23Please enter customer's NPWP (Optional)</span> -->
                            <!-- </div>
                        </div>
                    </div> -->
                    <!-- begin: Example Code-->

                    <!-- end: Example Code-->
                </div>

              <hr>

              <div class="section-block m-0 mb-4">
                  <h3 class="section-title">Akun</h3>
                  
                </div>

                  <div class="form-group col-lg-8">
                      <label>Beban</label>
                      <select class="form-control" v-model="expenseAccount" >
                        <option v-for="(account,index) in accounts" :value="account.id">
                           @{{account.number}} -  @{{account.name}}
                       
                        </option>
                      </select>
                      <!-- <span class="form-text text-muted">Please enter supplier's name</span> -->
                   </div>
                   <div class="form-group col-lg-8">
                      <label>Penjualan:</label>
                      <select class="form-control" v-model="salesAccount">
                        <option v-for="(account,index) in accounts" :value="account.id">
                           @{{account.number}} -  @{{account.name}}
                       
                        </option>
                      </select>
                      <!-- <span class="form-text text-muted">Please enter supplier's name</span> -->
                   </div>
                   <div class="form-group col-lg-8">
                      <label>Diskon Penjualan:</label>
                      <select class="form-control" v-model="discountSalesAccount">
                        <option v-for="(account,index) in accounts" :value="account.id">
                           @{{account.number}} -  @{{account.name}}
                       
                        </option>
                      </select>
                      <!-- <span class="form-text text-muted">Please enter supplier's name</span> -->
                   </div>

                     <div class="form-group col-lg-8">
                      <label>Pembelian Belum tertagih:</label>
                      <select class="form-control" v-model="purchasesUnbilledAccount">
                        <option v-for="(account,index) in accounts" :value="account.id">
                           @{{account.number}} -  @{{account.name}}
                       
                        </option>
                      </select>
                      <!-- <span class="form-text text-muted">Please enter supplier's name</span> -->
                   </div>

                          <div class="form-group col-lg-8">
                      <label>Asset :</label>
                      <select class="form-control" v-model="assetAccount">
                        <option v-for="(account,index) in accounts" :value="account.id">
                        @{{account.number}} -  @{{account.name}}
                       
                        </option>
                      </select>
                      <!-- <span class="form-text text-muted">Please enter supplier's name</span> -->
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
@endsection

@section('script')
<script src="{{ asset('js/pages/features/miscellaneous/sweetalert2.js') }}"></script>
@endsection

@section('pagescript')
<script>
    let app = new Vue({
        el: '#app',
        data: {
            categories: JSON.parse(String.raw `{!! $categories !!}`),
            subCategories: JSON.parse(String.raw `{!! $sub_categories !!}`),
            units: JSON.parse(String.raw `{!! $units !!}`),
            pphRates:JSON.parse(String.raw `{!! $pph_rate !!}`),
            accounts:JSON.parse('{!!$accounts!!}'),

            salesAccount:'',
            expenseAccount:'',
            discountSalesAccount:'',
            purchasesUnbilledAccount:'',
            assetAccount:'',
            pphrate:'',
            subcategory:'',
            category: '',
            pphAmount:'',
            pphName:'',
            amount:'',
            number: '',
            name: '',
            unit: '',
            purchasePrice: '',
            stock: '',
            
            loading: false,
            type:'',
            pphValue:'',
        },
        methods: {
            submitForm: function() {
                this.sendData();
            },
            sendData: function() {
               
                let vm = this;
                vm.loading = true;
                axios.post('/goods', {
                        category: vm.category,
                        number: vm.number,
                        name: vm.name,
                        unit: vm.unit,
                        purchase_price: vm.purchasePrice,
                        stock: vm.stock,
                        type:vm.type,
                        pph:vm.pphValue,
                        pph_rate_id:vm.pphrate,
                        goods_sub_category_id:vm.subcategory,
                        sales_account:vm.salesAccount,
                        discount_sales_account:vm.discountSalesAccount,
                        expense_account:vm.expenseAccount,
                        purchases_unbilled_account:vm.purchasesUnbilledAccount
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
                            window.location.href = '/goods';
                            }
                        })
                        // console.log(response);
                    })
                    .catch(function(error) {
                        vm.loading = false;
                        console.log(error);
                        Swal.fire(
                            'Oops!',
                            `${error.response.data.message}`,
                            'error'
                        )
                    });
            },
            addPphRate:function(){
             
          
            axios.post('/pph-rates', {
                'name':this.pphName,
                'amount':this.pphAmount
            })
                .then(function(response) {
                    const {
                        data
                    } = response.data;
                    app.$data.pphRates.push(data);
                    app.$data.pphrate = data.id;
                    $('.pph-rate').val(data.id);
                    $('.pph-rate').select2('close');
                    $('#pphModal').modal('hide');
                    hideElement('#loadingCategory');
                })
                .catch(function(error) {
                    // vm.loading = false;
                    $('.pph-rate').select2('close');
                    hideElement('#loadingCategory');
                    console.log(error);
                    Swal.fire(
                        'Terjadi Kesalahan',
                        'Gagal menambahkan kategori barang',
                        'error'
                    )
                });
        
            }
        }
    })
</script>
<script>
    $(function() {
        $(".goods-category").select2({
            language: {
                noResults: function() {
                    const searchText = $(".goods-category").data("select2").dropdown.$search.val();
                    if (!searchText) {
                        return "No Result Found";
                    }
                    return `
                        <a href="#" class="d-block" id="btn-add-category"><i class="fas fa-plus fa-sm"></i> Tambah ${searchText} </a>
                        <div class="progress mt-2" id="loadingCategory" style="display: none">
                            <div class="progress-bar bg-primary w-100 progress-bar-striped progress-bar-animated" data-progress="100"></div>
                        </div>
                        `;
                },
            },
            escapeMarkup: function(markup) {
                return markup;
            },
        });
        $(".goods-category").on('change', function() {
            console.log('clicked');
            app.$data.category = $(this).val();
            // console.log(searchText);
        });
         $(".type").on('change', function() {
            // console.log('clicked');

             $(".pph-rate").select2({
            language: {
                noResults: function() {
                    const searchText = $(".pph-rate").data("select2").dropdown.$search.val();

                    if (!searchText) {
                        return "No Result Found";
                    }

                    return `
                        <a href="#" class="d-block" id="btn-add-pph-rate"><i class="fas fa-plus fa-sm"></i> Tambah </a>
                        <div class="progress mt-2" id="loadingCategory" style="display: none">
                            <div class="progress-bar bg-primary w-100 progress-bar-striped progress-bar-animated" data-progress="100"></div>
                        </div>
                        `;
                },
            },
            escapeMarkup: function(markup) {
                return markup;
            },
        });
        $(".pph-rate").on('change', function() {
            console.log('clicked');
            app.$data.pphrate = $(this).val();
            // console.log(searchText);
        });


            
        });

         $(".goods-subcategory").select2({
            language: {
                noResults: function() {
                    const searchText = $(".goods-subcategory").data("select2").dropdown.$search.val();
                    if (!searchText) {
                        return "No Result Found";
                    }
                    return `
                        <a href="#" class="d-block" id="btn-add-subcategory"><i class="fas fa-plus fa-sm"></i> Tambah ${searchText} </a>
                        <div class="progress mt-2" id="loadingCategory" style="display: none">
                            <div class="progress-bar bg-primary w-100 progress-bar-striped progress-bar-animated" data-progress="100"></div>
                        </div>
                        `;
                },
            },
            escapeMarkup: function(markup) {
                return markup;
            },
        });
        $(".goods-subcategory").on('change', function() {
            console.log('clicked');
            app.$data.subcategory = $(this).val();
            // console.log(searchText);
        });


        
           



         $(".unit").select2({
            language: {
                noResults: function() {
                    const searchText = $(".unit").data("select2").dropdown.$search.val();
                    if (!searchText) {
                        return "No Result Found";
                    }
                    return `
                        <a href="#" class="d-block" id="btn-add-unit"><i class="fas fa-plus fa-sm"></i> Tambah ${searchText} </a>
                        <div class="progress mt-2" id="loadingCategory" style="display: none">
                            <div class="progress-bar bg-primary w-100 progress-bar-striped progress-bar-animated" data-progress="100"></div>
                        </div>
                        `;
                },
            },
            escapeMarkup: function(markup) {
                return markup;
            },
        });
        $(".unit").on('change', function() {
            console.log('clicked');
            app.$data.unit = $(this).val();
            console.log(app.$data.unit);
            // console.log(searchText);
        });


        $(document).on('click', '#btn-add-category', function(e) {
            e.preventDefault();
            const searchText = $(".goods-category").data("select2").dropdown.$search.val();
            const data = {
                name: searchText,
                status: 1,
            }

            addCategory(data);
            // console.log('clicked');
        })

           $(document).on('click', '#btn-add-subcategory', function(e) {
            e.preventDefault();
            const searchText = $(".goods-subcategory").data("select2").dropdown.$search.val();
            const data = {
                name: searchText,
                status: 1,
            }

            addSubCategory(data);
            // console.log('clicked');
        })

          $(document).on('click', '#btn-add-unit', function(e) {
            e.preventDefault();
            const searchText = $(".unit").data("select2").dropdown.$search.val();
            const data = {
                name: searchText,
                status: 1,
            }
            addUnit(data)
       
        
            // console.log('clicked');
        })
           $(document).on('click', '#btn-add-pph-rate', function(e) {
            e.preventDefault();
            const searchText = $(".unit").data("select2").dropdown.$search.val();
            const data = {
                name: searchText,
                status: 1,
            }
             $('#pphModal').modal('show');
          //  addUnit(data)

        
       
        
            // console.log('clicked');
        })

        function hideElement(el) {
            $(el).hide();
        }

        function showElement(el) {
            $(el).show();
        }

        function addSubCategory(data) {
            showElement('#loadingCategory');
            axios.post('/goods-subcategory', data)
                .then(function(response) {
                    const {
                        data
                    } = response.data;
                    app.$data.subCategories.push(data);
                    app.$data.category = data.id;
                    $('.goods-category').val(data.id);
                    $('.goods-category').select2('close');
                    hideElement('#loadingCategory');
                })
                .catch(function(error) {
                    // vm.loading = false;
                    $('.goods-category').select2('close');
                    hideElement('#loadingCategory');
                    console.log(error);
                    Swal.fire(
                        'Terjadi Kesalahan',
                        'Gagal menambahkan kategori barang',
                        'error'
                    )
                });
        }

            function addCategory(data) {
            showElement('#loadingCategory');
            axios.post('/goods-category', data)
                .then(function(response) {
                    const {
                        data
                    } = response.data;
                    app.$data.categories.push(data);
                    app.$data.category = data.id;
                    $('.goods-subcategory').val(data.id);
                    $('.goods-subcategory').select2('close');
                    hideElement('#loadingCategory');
                })
                .catch(function(error) {
                    // vm.loading = false;
                    $('.goods-category').select2('close');
                    hideElement('#loadingCategory');
                    console.log(error);
                    Swal.fire(
                        'Terjadi Kesalahan',
                        'Gagal menambahkan kategori barang',
                        'error'
                    )
                });
        }

             function addUnit(data) {
            showElement('#loadingCategory');
            axios.post('/unit', data)
                .then(function(response) {
                    const {
                        data
                    } = response.data;
                    console.log(response.data);
                    app.$data.units.push(data);
                    app.$data.unit = data.id;
                    $('.unit').val(data.id);
                    $('.unit').select2('close');
                  showElement('#loadingCategory');
                })
                .catch(function(error) {
                    // vm.loading = false;
                    $('.unit').select2('close');
                    hideElement('#units');
                    console.log(error);
                    Swal.fire(
                        'Terjadi Kesalahan',
                        'Gagal menambahkan kategori barang',
                        'error'
                    )
                });
        }
    })
</script>
@endsection