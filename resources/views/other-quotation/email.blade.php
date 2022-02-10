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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Kirim Quotation</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Quotation</a>
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
                <h3 class="card-title">Form Email</h3>

            </div>
            <!--begin::Form-->
            <form class="form" autocomplete="off" @submit.prevent="submitForm" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <div class="form-row">
                                <div class="col-lg-6 col-md-12">
                                 
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>PIC Event:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            
                                        </div>
                                        <input type="text" v-model="eventPicName" id="eventPicName" class="form-control">
                                    </div>
                                </div>
                                 <div class="form-group col-lg-6 col-md-12">
                                    <label>PIC PO:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        
                                        </div>
                                        <input type="text" v-model="poPicName" id="poPicPo" class="form-control">
                                    </div>
                                </div>
                                <!-- <div class="form-group col-lg-6 col-md-6">
                                    <label>Customer:</label>
                                     <select2 v-model="customerId" :options="customers" class="form-control" required>
                                    </select2>
                                </div> -->
                            </div>
                           <div class="form-row">
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Email PIC Event:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            
                                        </div>
                                        <input type="text" v-model="eventPicEmail" id="eventPicEmail" class="form-control">
                                    </div>
                                </div>
                                  <div class="form-group col-lg-6 col-md-12">
                                    <label>Email PIC PO</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                       
                                        <input type="text" v-model="poPicEmail" id="poPicEmail" class="form-control">
                                    </div>
                                </div>
                                <!-- <div class="form-group col-lg-6 col-md-6">
                                    <label>Customer:</label>
                                     <select2 v-model="customerId" :options="customers" class="form-control" required>
                                    </select2>
                                </div> -->
                            </div>
                                <div class="form-row">
                                <div class="form-group col-lg-12 col-md-12">
                                    <label>Subject:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                         <input type="text" v-model="subject" id="customerName" class="form-control"> 
                                    </div>
                                </div>
                            </div>

                               <div class="form-row">
                                <div class="form-group col-lg-16 col-md-12">
                                    <label>Message:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                  
                                       <textarea v-model="body"  id="basic-example">
                                       
                                    </textarea>     
                                  
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
</div>


@endsection

@section('script')
<script src="{{ asset('js/pages/features/miscellaneous/sweetalert2.js') }}"></script>
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
  <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>tinymce.init({selector:'textarea'});</script>
@endsection

@section('pagescript')
<script type="text/x-template" id="select2-template">
  <select>
        <slot></slot>
    </select>
</script>

<script type="text/x-template" id="select2-template-po">
  <select>
        <slot></slot>
    </select>
</script>


<script>
    let app = new Vue({
        el: '#app',
        data: {
            eventPicName:'{{$event_quotation->picEvent->name}}',
            eventPicEmail:'{{$event_quotation->picEvent->email}}',
            poPicName:'{{$event_quotation->picPo->name}}',
            poPicEmail:'{{$event_quotation->picPo->email}}',
            customerName:'{{$event_quotation->customer->name}}',
            id:'{{$id}}',
            subject:'',
            body:'',

          
            
        },
        methods: {
            submitForm: function() {
                //console.log(this.body)
                   this.sendData();
                // console.log(this.eventPicId);
                // console.log(this.poPicId);
               // console.log($('#basic-example').val());
            
            },
            sendData: function() {
                // console.log('submitted');
                let vm = this;
                vm.loading = true;
               // let subject="Laporan Quotation Event"
                axios.post('/other-quotation/email/'+this.id, {
                     event_pic_email:this.eventPicEmail,
                     po_pic_email:this.poPicEmail,
                     event_pic_name:this.eventPicEmail,
                     po_pic_name:this.poPicName,
                     customer_name:this.customerName,
                     subject:this.subject,
                     body:$('#basic-example').val()                    
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
           
    

        },
       
        watch: {
         
        }
    })
</script>
<script>
    $(function() {
    tinymce.init({
  selector: 'textarea#basic-example',
  height: 500,
  width:200,
  menubar: false,
  plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table paste code help wordcount'
  ],
  toolbar: 'undo redo | formatselect | ' +
  'bold italic backcolor | alignleft aligncenter ' +
  'alignright alignjustify | bullist numlist outdent indent | ' +
  'removeformat | help',
  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
});

    })
</script>
@endsection