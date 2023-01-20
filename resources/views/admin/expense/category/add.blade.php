@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-12">
        <form class="form-horizontal" method="get" action="{{url('dashboard/expense/category/submit')}}" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-header card_header">
                    <div class="row">
                        <div class="col-md-8 tbl_text">
                            <i class="  uil-analytics  "></i> Add Expense category Information
                        </div>
                        <div class="col-md-4 card_butt_part">
                            <a class="btn btn-sm btn-dark" href="{{url('dashboard/expense/category')}}"><i class="  uil-dollar-alt  "></i> All Expense Category</a>
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
                        <label class="col-3 col-form-label col_form_label ">Expense Category Name<span class="req_star">*</span>:</label>
                        <div class="col-6 {{$errors->has('name') ? ' has-error' : ''}}">
                            <input type="text" class="form-control" id="" name="name" value="{{old('name')}}">
							@if ($errors->has('name'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('name') }}</strong>
							</span>
							@endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-3 col-form-label col_form_label ">Expense Remarks :</label>
                        <div class="col-6">
                            <input type="text" class="form-control" id="" name="remarks" value="{{old('remarks')}}">
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
