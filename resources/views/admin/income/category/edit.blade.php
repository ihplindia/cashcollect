@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-12">
        <form class="form-horizontal" method="POST" action="{{url('dashboard/income/category/update')}}" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-header card_header">
                    <div class="row">
                        <div class="col-md-8 tbl_text">
                            <i class="  uil-analytics  "></i> Update income category Information
                        </div>
                        <div class="col-md-4 card_butt_part">
                            <a class="btn btn-sm btn-dark" href="{{url('dashboard/income/category')}}"><i class="  uil-dollar-alt  "></i> All Category</a>
                        </div>
                    </div>
                </div>
                <div class="card-body card_body">
                    <div class="row mb-3">
                        <label class="col-3 col-form-label col_form_label ">Category Name<span class="req_star">*</span>:</label>
                        <div class="col-6 {{$errors->has('name') ? ' has-error' : ''}}">
							<input type="hidden" name="id" value="{{$data->incate_id}}"/>
							<input type="hidden" name="slug" value="{{$data->incate_slug}}"/>
                            <input type="text" class="form-control" id="" name="name" value="{{$data->incate_name}}">
								@if ($errors->has('name'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('name') }}</strong>
							</span>
							@endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-3 col-form-label col_form_label ">Remarks :</label>
                        <div class="col-6">
                            <input type="text" class="form-control" id="" name="remarks" value="{{$data->incate_remarks}}">
                        </div>
                    </div>
                </div>
                <!-- end card body-->
                <div class="card-footer card_footer center">
                    <button type="submit" class="btn btn-md btn-dark">UPDATE</button>
                </div>
            </div> <!-- end card -->
        </form>
    </div><!-- end col-->
</div>
@endsection
