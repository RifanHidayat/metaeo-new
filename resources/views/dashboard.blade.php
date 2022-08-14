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
<!--begin::Dashboard-->
<!--begin::Row-->
<div class="row">
	<div class="col-xl-12">
		<div class="row">
			<div class="col-xl-3">
				<!--begin::Tiles Widget 21-->
				<div class="card card-custom gutter-b" style="height: 200px">
					<!--begin::Body-->
					<div class="card-body d-flex flex-column p-0">
						<!--begin::Stats-->
						<div class="flex-grow-1 card-spacer pb-0">
							<span class="svg-icon svg-icon-5x svg-icon-info">
								<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group.svg-->
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<polygon points="0 0 24 0 24 24 0 24" />
										<path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
										<path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
									</g>
								</svg>
								<!--end::Svg Icon-->
							</span>
							<div class=" pt-2">
								<span class="font-weight-boldest font-size-h2">{{ $customers_count }}</span>
								@if($customers_gain_current_month > 0)
								<span class="ml-3 font-size-h4 text-success"><i class="flaticon2-plus icon-sm text-success align-middle"></i> {{ $customers_gain_current_month }} <span>Bulan Ini</span></span>
								@endif
							</div>
							<div class="text-muted font-weight-bold font-size-h4">Customer</div>
						</div>
						<!--end::Stats-->
						<!--begin::Chart-->
						<!-- <div id="kt_tiles_widget_21_chart" class="card-rounded-bottom" data-color="info" style="height: 100px"></div> -->
						<!--end::Chart-->
					</div>
					<!--end::Body-->
				</div>
				<!--end::Tiles Widget 21-->
			</div>
			<div class="col-xl-3">
				<!--begin::Tiles Widget 21-->
				<div class="card card-custom gutter-b" style="height: 200px">
					<!--begin::Body-->
					<div class="card-body d-flex flex-column p-0">
						<!--begin::Stats-->
						<div class="flex-grow-1 card-spacer pb-0">
							<span class="svg-icon svg-icon-5x svg-icon-danger">
								<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group.svg-->
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<polygon points="0 0 24 0 24 24 0 24" />
										<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
										<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
									</g>
								</svg>
								<!--end::Svg Icon-->
							</span>
							<div class="font-weight-boldest font-size-h2 pt-2 pl-2">{{ $users_count }}</div>
							<div class="text-muted font-weight-bold font-size-h4 pl-2">User</div>
						</div>
						<!--end::Stats-->
						<!--begin::Chart-->
						<!-- <div id="kt_tiles_widget_21_chart" class="card-rounded-bottom" data-color="info" style="height: 100px"></div> -->
						<!--end::Chart-->
					</div>
					<!--end::Body-->
				</div>
				<!--end::Tiles Widget 21-->
			</div>
			<div class="col-xl-6">
				<!--begin::Tiles Widget 25-->
				<div class="card card-custom bgi-no-repeat bgi-size-cover gutter-b bg-primary" id="with-bg-svg" style="height: 200px; background-image: url('/media/svg/patterns/taieri.svg')">
					<div class="card-body d-flex">
						<div class="d-flex py-5 flex-column align-items-start flex-grow-1">
							<div class="flex-grow-1">
								<a href="#" class="text-white font-weight-bolder font-size-h3">Dashboard Metaprint</a>
								<p class="text-white opacity-75 font-weight-bold mt-3">Welcome, {{ Auth::user()->name }}</p>
							</div>
						</div>
					</div>
				</div>
				<!--end::Tiles Widget 25-->
			</div>
		</div>
		<div class="row align-items-start">
			<div class="col-xl-6">
				<!--begin::List Widget 7-->
				<div class="card card-custom gutter-b card-stretch">
					<!--begin::Header-->
					<div class="card-header border-0">
						<h3 class="card-title font-weight-bolder text-dark">Transaksi Terakhir</h3>
					</div>
					<!--end::Header-->
					<!--begin::Body-->
					<div class="card-body px-0 pt-0 pb-10">
						@if(count($transactions) < 1) <div class="text-center">
							<i class="fas fa-exchange-alt icon-4x mb-5"></i>
							<p class="text-muted font-weight-bold">Belum Ada Transaksi</p>
					</div>
					@endif
					@foreach($transactions as $transaction)
					<!--begin::Item-->
					<a href="/transaction/detail/{{ $transaction->id }}">
						<div class="d-flex align-items-center flex-wrap bg-hover-light px-10 py-5">
							<!--begin::Symbol-->
							<!-- <div class="symbol symbol-50 symbol-light mr-5">
								<span class="symbol-label">
									<img src="https://images.unsplash.com/photo-1550136513-548af4445338?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1054&q=80" class="h-50 align-self-center" alt="">
								</span>
							</div> -->
							<!--end::Symbol-->
							<!--begin::Text-->
							<div class="d-flex flex-column flex-grow-1 mr-2">
								<p class="font-weight-bold text-dark-75 font-size-lg mb-1">{{ $transaction->customer->name }}</p>
								<span><span class="text-warning font-weight-bold">{{ $transaction->number }}</span><span class="text-muted font-weight-bold">&nbsp;({{ $transaction->date }})</span></span>
							</div>
							<!--end::Text-->
							<span class="label label-xl label-success label-inline my-lg-0 my-2 font-weight-bolder">Rp {{ number_format($transaction->total, 0, ",", ".") }}</span>
						</div>
					</a>
					<!--end::Item-->
					@endforeach
				</div>
				<!--end::Body-->
			</div>
			<!--end::List Widget 7-->
		</div>
		<div class="col-xl-6">
			<!--begin::List Widget 7-->
			<div class="card card-custom gutter-b card-stretch">
				<!--begin::Header-->
				<div class="card-header border-0">
					<h3 class="card-title font-weight-bolder text-dark">Faktur Overdue</h3>
				</div>
				<!--end::Header-->
				<!--begin::Body-->
				<div class="card-body px-0 pt-0 pb-10">
					@if(count($over_due_invoices) < 1) <div class="text-center">
						<i class="far fa-calendar-check icon-4x mb-5"></i>
						<p class="text-muted font-weight-bold">Tidak Ada Faktur Overdue</p>
				</div>
				@endif
				@foreach($over_due_invoices as $invoice)
				<!--begin::Item-->
				<a href="/invoice/detail/{{ $invoice->id }}">
					<div class="d-flex align-items-center flex-wrap bg-hover-light px-10 py-5">
						<!--begin::Symbol-->
						<!-- <div class="symbol symbol-50 symbol-light mr-5">
								<span class="symbol-label">
									<img src="https://images.unsplash.com/photo-1550136513-548af4445338?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1054&q=80" class="h-50 align-self-center" alt="">
								</span>
							</div> -->
						<!--end::Symbol-->
						<!--begin::Text-->
						<div class="d-flex flex-column flex-grow-1 mr-2">
							<p class="font-weight-bold text-dark-75 font-size-lg mb-1">{{ $invoice->customer->name }}</p>
							<span><span class="text-warning font-weight-bold">{{ $invoice->number }}</span><span class="text-muted font-weight-bold">&nbsp;(Piutang: Rp {{ number_format($invoice->unpaid, 0, ",", ".") }})</span></span>
						</div>
						<!--end::Text-->
						<span class="label label-xl label-danger label-inline my-lg-0 my-2 font-weight-bolder">
							{{ \Carbon\Carbon::create($invoice->due_date)->isoFormat('D MMMM Y') }}
						</span>
					</div>
				</a>
				<!--end::Item-->
				@endforeach
			</div>
			<!--end::Body-->
		</div>
		<!--end::List Widget 7-->
	</div>
</div>
</div>
</div>
<!--end::Row-->
<!--end::Dashboard-->
@endsection

@section('script')
<!--begin::Page Vendors(used by this page)-->
<script src="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
<script src="{{ asset('js/pages/widgets.js') }}"></script>
<!--end::Page Scripts-->
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
		$('#basic-table').DataTable();
	})
</script>
@endsection