@extends('layouts.admin')
@section('content')

<div class="row">
	<div class="col-12">
		<form class="form-horizontal" method="get" action="{{url('dashboard/expense/submit')}}" enctype="multipart/form-data">
			@csrf
			<div class="card">
				<div class="card-header card_header">
					<div class="row">
						<div class="col-md-8 tbl_text">
							<i class="  uil-analytics  "></i> Add Expense Information
						</div>
						<div class="col-md-4 card_butt_part">
							<a class="btn btn-sm btn-dark" href="{{url('dashboard/expense')}}"><i class="  uil-dollar-alt  "></i> All Expense</a>
						</div>
					</div>
				</div>
				<div class="card-body card_body">
					<div class="row">
						<div class="col-3"></div>
						<div class="col-6">
							@if(Session::has('success'))
							<div class="alert alert-success" role="alert">
								{{session::get('success')}}
							</div>
							@endif
							@if(Session::has('error'))
							<div class="alert alert-danger" role="alert">
								{{session::get('error')}}
							</div>
							@endif
						</div>
						<div class="col-3"></div>
					</div>
					<div class="row mb-3">
						<label class="col-3 col-form-label col_form_label ">Expense Title<span class="req_star">*</span>:</label>
						<div class="col-6 {{$errors->has('title') ? ' has-error' : ''}}">
							<input type="text" class="form-control" id="" name="title" value="">
							@if ($errors->has('title'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('title') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="row mb-3">
						<label class="col-3 col-form-label col_form_label ">Expense Category<span class="req_star">*</span>:</label>
						<div class="col-6 {{$errors->has('category') ? ' has-error' : ''}}">
							@php
							$allCate=App\Models\ExpenseCategory::where('expcate_status',1)->orderBy('expcate_name','ASC')->get();
							@endphp
							<select class="form-control" id="" name="category">
								<option value="">Chose Cstegory</option>
								@foreach($allCate as $cate)
								<option value="{{$cate->expcate_id}}">{{$cate->expcate_name}}</option>
								@endforeach
							</select>
							@if ($errors->has('category'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('category') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="row mb-3">
						<label class="col-3 col-form-label col_form_label ">Expcate Date :</label>
						<div class="col-6  {{ $errors->has('date') ? ' has-error' : '' }}">
							<input type="date" class="form-control" id="" name="date" value="{{old('date')}}">
							@if ($errors->has('date'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('date') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="row mb-3">
						<label class="col-3 col-form-label col_form_label ">Expcate Amount :</label>
						<div class="col-6  {{ $errors->has('amount') ? ' has-error' : '' }}">
							<input type="text" class="form-control" id="" name="amount" value="{{old('amount')}}">
							@if ($errors->has('amount'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('amount') }}</strong>
							</span>
							@endif
						</div>
					</div>
				</div>
				<!-- end card body-->
				<div class="card-footer card_footer center">
					<button type="submit" class="btn btn-md btn-dark">SUBMIT</button>
				</div>
			</div> <!-- end card -->
		</form>
	</div><!-- end col-->
</div>
@endsection
