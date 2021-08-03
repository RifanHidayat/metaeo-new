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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Manage Customers</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Customers</a>
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
            <h3 class="card-label">List All Estimations
                <!-- <span class="d-block text-muted pt-2 font-size-sm">sorting &amp; pagination remote datasource</span> -->
            </h3>
        </div>
        <div class="card-toolbar">
            <!--begin::Dropdown-->

            <!--end::Dropdown-->
            <!--begin::Button-->
            <a href="/quotation/create" class="btn btn-primary font-weight-bolder">
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
                </span>New Record</a>
            <!--end::Button-->
        </div>
    </div>
    <div class="card-body">
        <!--begin: Datatable-->
        <table class="table datatable datatable-bordered datatable-head-custom" id="quotation-table">
            <thead>
                <tr class="text-center">
                    <th>Number</th>
                    <th>Tanggal</th>
                    <th>UP</th>
                    <th>Title</th>
                    <th>Estimasi</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <!--end: Datatable-->
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
    $(function() {
        const quotationsTable = $('#quotation-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/datatables/quotations',
            columns: [{
                    data: 'number',
                    render: function(data, type, row) {
                        return `<div class="text-dark-75 font-weight-bolder font-size-lg mb-0">${data}</div><span  class="text-muted font-weight-bold text-hover-primary">${row.title}</span>`;
                    }
                },
                {
                    data: 'date',
                    render: function(data, type) {
                        return `<span class="text-primary font-weight-bolder font-size-lg">${data}</span>`;
                    }
                },
                {
                    data: 'pic_po.name',
                    name: 'up',
                    render: function(data, type) {
                        return `<div class="text-dark-75 font-weight-bolder font-size-lg mb-0">${data}</div>`;
                    }
                },
                {
                    data: 'title',
                    name: 'title',
                    render: function(data, type) {
                        return `<div class="text-dark-75 font-weight-bolder font-size-lg mb-0">${data}</div>`;
                    },
                    visible: false,
                },
                {
                    data: 'estimations',
                    name: 'title',
                    render: function(data, type) {
                        return `<div class="text-dark-75 font-weight-bolder font-size-lg mb-0">${data.length > 0 && data.map(item => `<span class="label label-light-info label-pill label-inline text-capitalize">${item.number}</span>`).join('')}</div>`;
                    },
                },
                {
                    data: 'quantity',
                    className: 'text-right',
                    render: function(data, type) {
                        return `<div class="text-muted font-weight-bolder font-size-lg mb-0">${Intl.NumberFormat('de-DE').format(data)}</div>`;
                    }
                },
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
                    return axios.delete('/quotation/' + id)
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
    })
</script>
@endsection