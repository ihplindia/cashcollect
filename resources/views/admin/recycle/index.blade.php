@extends('layouts.admin')
@section('content')

<div class="row">
	<div class="col-xl-12 col-lg-12">

		<div class="row">
			<div class="col-lg-4">
				<a href="#">
					<div class="card widget-flat">
						<div class="card-body">
							@php
							$totalUser=App\Models\User::count();
							@endphp

							<div class="float-end">
								<i class="mdi mdi-account-multiple widget-icon"></i>
							</div>
							<h5 class="text-muted fw-normal mt-0" title="Number of Customers">Customers</h5>
							<h3 class="mt-3 mb-3">
								@if($totalUser < 10 ) 0{{$totalUser}} @else {{$totalUser}} @endif </h3>
						</div>
					</div>
				</a>
			</div>


			<div class="col-lg-4">
				<a href="{{url('dashboard/recycle/income')}}">
					<div class="card widget-flat">
						<div class="card-body">
							@php
							$totalIncome=App\Models\Income::where('income_status',0)->count();
							@endphp

							<div class="float-end">
								<i class=" dripicons-trash "></i>
							</div>
							<h5 class="text-muted fw-normal mt-0" title="Number of Customers">Income Trash</h5>
							<h3 class="mt-3 mb-3">
								@if($totalIncome < 10 ) 0{{$totalIncome}} @else {{$totalIncome}} @endif </h3>
						</div>
					</div>
				</a>
			</div>

			<div class="col-lg-4">
				<a href="dashboard/recycle/expense">
					<div class="card widget-flat">
						<div class="card-body">
							@php
							$totalExpense=App\Models\Expense::where('expense_status',0)->count();
							@endphp

							<div class="float-end">
								<i class=" dripicons-trash "></i>
							</div>
							<h5 class="text-muted fw-normal mt-0" title="Number of Customers">Expense Trash</h5>
							<h3 class="mt-3 mb-3">
								@if($totalExpense < 10 ) 0{{$totalExpense}} @else {{$totalExpense}} @endif </h3>
						</div>
					</div>
				</a>
			</div>
		</div>
	</div>
</div>


@endsection
