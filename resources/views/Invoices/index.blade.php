@extends('layouts.master')
@section('title')
لوحة التحكم
@stop
@section('css')
	<!--  Owl-carousel css-->
	<link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />
	<!-- Maps css -->
	<link href="{{ URL::asset('assets/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
	<!-- breadcrumb -->
	<div class="breadcrumb-header justify-content-between">
		<div class="left-content">
			<div>
				<h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">مرحبا , {{ Auth::user()->name }}</h2>
				<p class="mg-b-0">مرحبا بك في لوحة التحكم.</p>
			</div>
		</div>
	</div>
	<!-- /breadcrumb -->
@endsection
@section('content')
	<!-- row -->
	<div class="row row-sm">
		<a href="{{ url('/' . ($page = 'invoices')) }}" class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
			<div class="card overflow-hidden sales-card bg-primary-gradient">
				<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
					<div class="">
						<h6 class="mb-3 tx-12 text-white">اجمالي الفواتير</h6>
					</div>
					<div class="pb-0 mt-0">
						<div class="d-flex">
							<div class="">
								<h4 class="tx-20 font-weight-bold mb-1 text-white">
									{{ number_format($invoices->sum('Total'), 2) }}
								</h4>
								<p class="mb-0 tx-12 text-white op-7">{{ $invoices->count() }}</p>
							</div>
							<span class="float-right my-auto mr-auto">
								<i class="fas fa-arrow-circle-up text-white"></i>
								<span class="text-white op-7">100%</span>
							</span>
						</div>
					</div>
				</div>
				<span id="compositeline" class="pt-1">
					@foreach ($invoices as $inv)
						{{$inv->Total}},
					@endforeach
				</span>
			</div>
		</a>
		<a href="{{ url('/' . ($page = 'unPaid_invoices')) }}" class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
			<div class="card overflow-hidden sales-card bg-danger-gradient">
				<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
					<div class="">
						<h6 class="mb-3 tx-12 text-white">الفواتير الغير مدفوعة</h6>
					</div>
					<div class="pb-0 mt-0">
						<div class="d-flex">
							<div class="">
								<h3 class="tx-20 font-weight-bold mb-1 text-white">

									{{ number_format($invoices->where('Value_Status', 2)->sum('Total'), 2) }}

								</h3>
								<p class="mb-0 tx-12 text-white op-7">{{ $invoices->where('Value_Status', 2)->count() }}
								</p>
							</div>
							<span class="float-right my-auto mr-auto">
								<i class="fas fa-arrow-circle-down text-white"></i>
								<span class="text-white op-7">
									{{ number_format($invoices->where('Value_Status', 2)->sum('Total') / $invoices->sum('Total') * 100, 2) }}%
								</span>
							</span>
						</div>
					</div>
				</div>
				<span id="compositeline2" class="pt-1">
					@foreach ($invoices->where('Value_Status', 2) as $inv)
						{{$inv->Total}},
					@endforeach
				</span>
			</div>
		</a>
		<a href="{{ url('/' . ($page = 'Paid_invoices')) }}" class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
			<div class="card overflow-hidden sales-card bg-success-gradient">
				<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
					<div class="">
						<h6 class="mb-3 tx-12 text-white">الفواتير المدفوعة</h6>
					</div>
					<div class="pb-0 mt-0">
						<div class="d-flex">
							<div class="">
								<h4 class="tx-20 font-weight-bold mb-1 text-white">

									{{ number_format($invoices->where('Value_Status', 1)->sum('Total'), 2) }}

								</h4>
								<p class="mb-0 tx-12 text-white op-7">
									{{ $invoices->where('Value_Status', 1)->count() }}
								</p>
							</div>
							<span class="float-right my-auto mr-auto">
								<i class="fas fa-arrow-circle-up text-white"></i>
								<span class="text-white op-7">
									{{ number_format($invoices->where('Value_Status', 1)->sum('Total') / $invoices->sum('Total') * 100, 2) }}%
								</span>
							</span>
						</div>
					</div>
				</div>
				<span id="compositeline3" class="pt-1">
					@foreach ($invoices->where('Value_Status', 1) as $inv)
						{{$inv->Total}},
					@endforeach
				</span>
			</div>
		</a>
		<a href="{{ url('/' . ($page = 'Partially_invoices')) }}" class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
			<div class="card overflow-hidden sales-card bg-warning-gradient">
				<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
					<div class="">
						<h6 class="mb-3 tx-12 text-white">الفواتير المدفوعة جزئيا</h6>
					</div>
					<div class="pb-0 mt-0">
						<div class="d-flex">
							<div class="">
								<h4 class="tx-20 font-weight-bold mb-1 text-white">
									{{ number_format($invoices->where('Value_Status', 3)->sum('Total'), 2) }}
								</h4>
								<p class="mb-0 tx-12 text-white op-7">
									{{ $invoices->where('Value_Status', 3)->count() }}
								</p>
							</div>
							<span class="float-right my-auto mr-auto">
								<i class="fas fa-arrow-circle-down text-white"></i>
								<span class="text-white op-7">
									{{ number_format($invoices->where('Value_Status', 3)->sum('Total') / $invoices->sum('Total') * 100, 2) }}%
								</span>
							</span>
						</div>
					</div>
				</div>
				<span id="compositeline4" class="pt-1">
					@foreach ($invoices->where('Value_Status', 3) as $inv)
						{{$inv->Total}},
					@endforeach
				</span>
			</div>
		</a>
	</div>
	<!-- row closed -->

	<!-- row opened -->
	<div class="row row-sm">
		<div class="col-md-12 col-lg-12 col-xl-7">
			<div class="card">
				<div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
					<div class="d-flex justify-content-between">
						<h4 class="card-title mb-0">نسبة احصائية الفواتير</h4>
						<i class="mdi mdi-dots-horizontal text-gray"></i>
					</div>
				</div>
				<canvas id="bar" style="width: 70%"></canvas>
			</div>
		</div>


		<div class="col-lg-12 col-xl-5">
			<div class="card card-dashboard-map-one">
				<label class="main-content-label">نسبة احصائية الفواتير</label>
				<div style="height:300px;">
					<canvas id="chart"></canvas>
				</div>
			</div>
		</div>
	</div>
	<!-- row closed -->

@endsection
@section('js')
	<!--Internal  Chart.bundle js -->
	<script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
	<!-- Moment js -->
	<script src="{{ URL::asset('assets/plugins/raphael/raphael.min.js') }}"></script>
	<script src="{{ URL::asset('assets/js/dashboard.sampledata.js') }}"></script>
	<script src="{{ URL::asset('assets/js/chart.flot.sampledata.js') }}"></script>
	<!--Internal Apexchart js-->
	<script src="{{ URL::asset('assets/js/apexcharts.js') }}"></script>
	<!-- Internal Map -->
	<script src="{{ URL::asset('assets/js/modal-popup.js') }}"></script>
	<!--Internal  index js -->
	<script src="{{ URL::asset('assets/js/index.js') }}"></script>
	{{--
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js" /> --}}
	<script>
		// Bar Chart
		const chartData = @json($dataChart);

		var barChart = document.getElementById('bar').getContext('2d');
		var bar = new Chart(barChart, {
			type: 'bar',
			data: {
				labels: ["المدفوعة جزئياً", "الغير مدفوعة", "المدفوعة"],
				datasets: [{
					label: "إحصائيات الفواتير",
					data: chartData,
					backgroundColor: [
						'#F38544',
						'#F86079',
						'#21B283',
					],
					borderWidth: 2,
					borderColor: '#777777',
					hoverBorderWidth: 1,
					hoverBorderColor: '#000000',
				}]
			},
			options: {
				responsive: true,

				// maintainAspectRatio: false,
				scales: {
					xAxes: [{
						barPercentage: 0.9,
						categoryPercentage: 0.5,
					}],
					yAxes: [{
						ticks: {
							beginAtZero: true
						}
					}]
				}
			}
		});

		// Pie Chart
		var pieChart = document.getElementById('chart').getContext('2d');
		var chart = new Chart(pieChart, {
			type: 'doughnut',
			data: {
				labels: ["المدفوعة جزئياً", "الغير مدفوعة", "المدفوعة"],
				datasets: [{
					label: "إحصائيات الفواتير",
					backgroundColor: [
						'#F38544',
						'#F86079',
						'#21B283',
					],
					borderColor: [
						'#F38544',
						'#F86079',
						'#21B283',
					],
					data: chartData,
					hoverBorderWidth: 1,
					hoverBorderColor: '#000000',
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,

				// ✅ التحكم بالمسافة من الأعلى
				layout: {
					padding: {
						top: 40,   // 👈 عدّل الرقم حسب رغبتك
						bottom: 10
					}
				},
			},
		});
	</script>

@endsection