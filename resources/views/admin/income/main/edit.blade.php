@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-12">
        <form class="form-horizontal" method="get" action="{{url('dashboard/income/update')}}" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-header card_header">
                    <div class="row">
                        <div class="col-md-8 tbl_text">
                            <i class="  uil-analytics  "></i> Update income Information
                        </div>
                        <div class="col-md-4 card_butt_part">
                            <a class="btn btn-sm btn-dark" href="{{url('dashboard/income')}}"><i class="  uil-dollar-alt  "></i> All Income</a>
                        </div>
                    </div>
                </div>
                <div class="card-body card_body">
                  <div class="row mb-3">
                      <label class="col-3 col-form-label col_form_label ">Date :</label>
                      <div class="col-6">
                          <input type="text" class="form-control" id="" name="date" value="{{$edit->income_date}}">
                          @if ($errors->has('date'))
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('date') }}</strong>
                        </span>
                        @endif
                      </div>
                  </div>
                    <div class="row mb-3">
                        <label class="col-3 col-form-label col_form_label ">Income Title<span class="req_star">*</span>:</label>
                        <div class="col-6 {{$errors->has('title') ? ' has-error' : ''}}">
                							<input type="hidden" name="id" value="{{$edit->income_id}}"/>
                							<input type="hidden" name="slug" value="{{$edit->income_slug}}"/>
                            <input type="text" class="form-control" id="" name="title" value="{{$edit->income_title}}">
              								@if ($errors->has('title'))
              							<span class="invalid-feedback" role="alert">
              								<strong>{{ $errors->first('title') }}</strong>
              							</span>
              							@endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-3 col-form-label col_form_label ">Amount :</label>
                        <div class="col-6">
                            <input type="text" class="form-control" id="" name="amount" value="{{$edit->income_amount}}">
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
                    <button type="submit" class="btn btn-md btn-dark">UPDATE</button>
                </div>
            </div> <!-- end card -->
        </form>
    </div><!-- end col-->
</div>
@endsection
