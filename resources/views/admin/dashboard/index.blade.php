@extends('layouts.admin')
@section('content')
    @php
        $data = App\Helper::Dashboard(Auth::user()->admin_view,Auth::user()->id);
    @endphp
<div class="row">
	<div class="col-xl-12 col-lg-12">
		<div class="row" style="cursor: pointer;">
			<div class="col-lg-3">
				<a href="{{route('all.income')}}">
					<div class="card widget-flat">
						<div class="card-body">
							<div class="float-end">
								<i class="mdi mdi-currency-usd widget-icon"></i>
							</div>
							<h5 class="text-muted fw-normal mt-0 text-center" title="Average Revenue">  Total Payment</h5>
							<h3 class="mt-3 mb-3 text-center">{{$data['totalIncome']}} </h3>
						</div>
					</div>
				</a>
			</div>
			<div class="col-lg-3">
				<a href="{{route('status','1')}}">
					<div class="card widget-flat">
						<div class="card-body">
							<div class="float-end">
								<i class="mdi mdi-account-multiple widget-icon"></i>
							</div>
							<h5 class="text-muted fw-normal mt-0 text-center" title="Number of Customers">Pending Payment</h5>
							<h3 class="mt-3 mb-3 text-center">
								{{$data["pendingIncome"]}}  </h3>
						</div>
					</div>
				</a>
			</div>
			<div class="col-lg-3">
				<a href="{{route('status','2')}}">
					<div class="card widget-flat">
						<div class="card-body">
							<div class="float-end">
								<i class="mdi mdi-account-multiple widget-icon"></i>
							</div>
							<h5 class="text-muted fw-normal mt-0 text-center" title="Number of Customers">Collected Payment</h5>
							<h3 class="mt-3 mb-3 text-center">
								{{$data["collected"]}}  </h3>
						</div>
					</div>
				</a>
			</div>
			<div class="col-lg-3">
				<a href="{{route('status','3')}}">
				<div class="card widget-flat">
					<div class="card-body">
						<div class="float-end">
							<i class="mdi mdi-cart-plus widget-icon"></i>
						</div>
						<h5 class="text-muted fw-normal mt-0 text-center" title="Number of Orders"> Depositeded Payment</h5>
						<h3 class="mt-3 mb-3 text-center">{{$data["depositeIncome"]}} </h3>
					</div>
				</div>
			</a>
			</div>
			@if(Auth::user()->admin_view < 5)
			<div class="col-lg-3">
				<a href="{{route('status','4')}}">
				<div class="card widget-flat">
					<div class="card-body">
						<div class="float-end">
							<i class="mdi mdi-cart-plus widget-icon"></i>
						</div>
						<h5 class="text-muted fw-normal mt-0 text-center" title="Number of Orders"> Approved Payment</h5>
						<h3 class="mt-3 mb-3 text-center">{{($data["approved"])}} </h3>
					</div>
				</div>
			</a>
			</div>
			@endif
			@if (isset($data['completeIncome']))
			<div class="col-lg-3">
				<a href="{{route('status','5')}}">
					<div class="card widget-flat">
						<div class="card-body">
							<div class="float-end">
								<i class="mdi mdi-pulse widget-icon"></i>
							</div>
							<h5 class="text-muted fw-normal mt-0 text-center" title="Growth">Settled Payment</h5>
							<h3 class="mt-3 mb-3 text-center">{{$data["completeIncome"]}} </h3>
						</div>
					</div>
				</a>
			</div>
			@endif
			@if (isset($data['expired']))
			<div class="col-lg-3">
				<a href="{{route('status','0')}}">
					<div class="card widget-flat">
						<div class="card-body">
							<div class="float-end">
								<i class="mdi mdi-pulse widget-icon"></i>
							</div>
							<h5 class="text-muted fw-normal mt-0 text-center" title="Growth">Cancelled Payment</h5>
							<h3 class="mt-3 mb-3 text-center">{{$data["expired"]}} </h3>
						</div>
					</div>
				</a>
			</div>
			@endif
		</div>
	</div>
</div>

@endsection
