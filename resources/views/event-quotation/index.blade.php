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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Manage Quotation</h5>
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
                        <a href="" class="text-muted">Manage</a>
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
<div class="card card-custom gutter-b" id="app">
    <div class="card-header flex-wrap py-3">
        <div class="card-title">
            <h3 class="card-label">List Quotation
                <!-- <span class="d-block text-muted pt-2 font-size-sm">sorting &amp; pagination remote datasource</span> -->
            </h3>
        </div>
        <div class="card-toolbar">
            <!--begin::Dropdown-->

            <!--end::Dropdown-->
            <!--begin::Button-->
            <a href="/event-quotation/create" class="btn btn-primary font-weight-bolder">
                <span class="svg-icon svg-icon-md">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"></rect>
                            <circle fill="#000000" cx="9" cy="15" r="6"></circle>
                            <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3"></path>
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>Quotation Baru</a>
            <!--end::Button-->
        </div>
    </div>
    <div class="card-body">
        <!--begin: Datatable-->
        <table class="table datatable datatable-bordered datatable-head-custom" id="quotation-table">
            <thead>
                <tr >
                <th>Tanggal</th>
                    <th>Number</th>
                    <th>Title Event</th>
                    <th>Created By</th>
                    <th>Customer</th>
                    <th>Pic Event</th>
                    <th>Pic Po</th>
                    <th>Netto</th>
                    
                         
                   
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <!--end: Datatable-->
    </div>
    <div class="modal fade" id="poModal" tabindex="-1" role="dialog" aria-labelledby="quotationModalLabel" aria-hidden="true">
    <form class="form" autocomplete="off" @submit.prevent="submitForm" enctype="multipart/form-data">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quotationModalLabel">PO Quotation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                
                   <div class="form-group col-lg-6 col-md-12">
                                    <label>No. PO:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                       
                                        <input type="text" v-model="number" id="number" class="form-control" require>
                                    </div>
                                </div>
                                 <div class="form-group col-lg-6 col-md-12">
                                    <label>Tanggal:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="flaticon2-calendar-9"></i></span>
                                        </div>
                                        <input type="text" v-model="date" id="date" class="form-control" require>
                                    </div>
                                </div>
                                  <div class="form-group col-lg-6 col-md-12">
                                    <label>Title:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                      
                                        <input type="text" v-model="title" id="title" class="form-control" require>
                                    </div>
                                </div>
                                 <div class="form-group col-lg-6 col-md-12">
                                    <label>Nominal:</label>
                                    <!-- <input type="text" class="form-control"> -->
                                    <div class="input-group">
                                      
                                        <input type="text" v-model="amount" id="amount" class="form-control" require>
                                    </div>
                                </div>
                   
                </div>
                
            </div>
          
            <div class="modal-footer">
                <button type="submit" class="btn btn-light-primary font-weight-bold" >Save</button>
            </div>
        </div>
    </div>
    </form>
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
            date:'',
            number:'',
            title:'',
            amount:'',
            id:'',

        },
        methods: {
            submitForm: function() {
               // console.log("tes");
                   this.sendData();  

            },
            sendData: function() {
                // console.log('submitted');
                let vm = this;
                vm.loading = true;
                //let subject="Laporan Quotation Event"
                axios.post('/event-quotation/po/'+this.id, {
                     number:this.number,
                     date:this.date,
                     title:this.title,
                     amount:this.amount,
                                        
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
                                 window.location.href = '/event-quotation';
                                 // quotationsTable.ajax.reload();
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
             currencyFormat: function(number) {
                return Intl.NumberFormat('de-DE').format(number);
            },
           
    

        },
       
       
    })

</script>
<script>
    let app = new Vue({
        el: '#app',
        data: {

        },
        methods: {
            deleteRecord: function(id) {
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
                        return axios.delete('/customer/' + id)
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
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Data has been deleted',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        })
                    }
                })
            }
        }
    })
</script>
<script>
 function currencyFormat(number) {
                return Intl.NumberFormat('de-DE').format(number);
            }
    $(function() {
        const quotationsTable = $('#quotation-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/datatables/event-quotations',
            order: [
                [1, 'desc']
            ],
            columns: [  {
                    data: 'date',
                    name: 'date',
                    render: function(data, type) {
                        return `<span class="text-primary font-weight-bolder font-size-lg">${data}</span>`;
                    },
                    className: 'text-center',
                },{
                
                    data: 'number',
                    name: 'number',
                    render: function(data, type, row) {
                        return `<div class="text-dark-75 font-weight-bolder font-size-lg mb-0">${data}</div>`;
                    }
                },
                {
                
                data: 'title',
                name: 'title',
                render: function(data, type, row) {
                    return `<div class="text-dark-75 font-weight-bolder font-size-lg mb-0">${row.title}</div></span>`;
                }
            },
            {
                
                data: 'title',
                name: 'title',
                render: function(data, type, row) {
                    return `<div class="text-dark-75 font-weight-bolder font-size-lg mb-0">${row.user!=null?row.user.name:""}</div>`;
                }
            },
            
            {
                data: 'title',
                name: 'title',
                render: function(data, type, row) {
                    return `<div class="text-dark-75 font-weight-bolder font-size-lg mb-0">${row.customer!=null?row.customer.name:""}</div>`;
                }
            },
            
            {
                
                data: 'title',
                name: 'title',
                render: function(data, type, row) {
                    return `<div class="text-dark-75 font-weight-bolder font-size-lg mb-0">${row.pic_event!=null?row.pic_event.name:""}</div>`;
                }
            },
            
                
                
              
                 {
                    data: 'title',
                name: 'title',
                    render: function(data, type, row) {
                        return `<div class="text-dark-75 font-weight-bolder font-size-lg mb-0 text-left">${row.pic_po!=null?row.pic_po.name:""}</div>`;
                    }
                },
                {
                    data: 'netto',
                    name: 'netto',
                    render: function(data, type, row) {
                        return `<div class="text-dark-75 font-weight-bolder font-size-lg mb-0 text-right">${currencyFormat(data)}</div>`;
                    }
                },
                // {
                //     data: 'bast_remaining',
                //     name: 'bast_remaining',
                //     render: function(data, type, row) {
                //         return `<div class="text-dark-75 font-weight-bolder font-size-lg mb-0 text-right">${currencyFormat(data)}</div>`;
                //     }
                // },
                
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },

            ]
        });

        $('#quotation-table').on('click', 'tr .btn-delete', function(e) {
            e.preventDefault();
            // alert('click');
            const id = $(this).attr('data-id');
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
                    return axios.delete('/event-quotation/' + id)
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
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Data has been deleted',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // window.location.reload();
                            quotationsTable.ajax.reload();
                        }
                    })
                }
            })
        })

           $('#quotation-table').on('click', 'tr .btn-po', function(e) {
               
            e.preventDefault();
             const id = $(this).attr('data-id');
            app.$data.id=id;
             const data = quotationsTable.row($(this).parents('tr')).data();
             console.log(data.po_quotation);
             if (data.po_quotation!=null){
                 app.$data.date=data.po_quotation.date;
                 app.$data.number=data.po_quotation.number;
                 app.$data.title=data.po_quotation.title;
                 app.$data.amount=data.po_quotation.amount;
             }
         
          
          
        })
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