@extends('layouts.admin')
@section('content')

<div class="row">
	<div class="col-xl-12 col-lg-12">

		<div class="row">
			<div class="col-lg-3">
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
			</div>

			<div class="col-lg-3">
				<div class="card widget-flat">
					<div class="card-body">
						@php
						$totalIncome=App\Models\Income::where('income_status',1)->sum('income_amount');
						@endphp
						<div class="float-end">
							<i class="mdi mdi-cart-plus widget-icon"></i>
						</div>
						<h5 class="text-muted fw-normal mt-0" title="Number of Orders">Tottal Inocme</h5>
						<h3 class="mt-3 mb-3">{{number_format($totalIncome,2)}}Tk</h3>
					</div>
				</div>
			</div>



			<div class="col-lg-3">
				<div class="card widget-flat">
					<div class="card-body">
						@php
						$totalExpense=App\models\Expense::where('expense_status',1)->sum('Expense_amount');
						@endphp
						<div class="float-end">
							<i class="mdi mdi-currency-usd widget-icon"></i>
						</div>
						<h5 class="text-muted fw-normal mt-0" title="Average Revenue">Total Expense</h5>
						<h3 class="mt-3 mb-3">{{number_format($totalExpense,2)}}Tk</h3>
					</div>
				</div>
			</div>

			<div class="col-lg-3">
				<div class="card widget-flat">
					<div class="card-body">
						@php
						$totalSavings=($totalIncome-$totalExpense);
						@endphp
						<div class="float-end">
							<i class="mdi mdi-pulse widget-icon"></i>
						</div>
						<h5 class="text-muted fw-normal mt-0" title="Growth">Total Saving</h5>
						<h3 class="mt-3 mb-3">{{number_format($totalSavings,2)}}Tk</h3>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>


@endsection