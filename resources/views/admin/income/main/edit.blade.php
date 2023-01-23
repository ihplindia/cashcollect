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
                            <i class="  uil-analytics  "></i> Update Payment Information
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
                        <label class="col-3 col-form-label col_form_label ">File Ref no<span class="req_star">*</span>:</label>
                        <div class="col-6 {{$errors->has('file_ref_no') ? ' has-error' : ''}}">                							
                            <input type="text" class="form-control" id="" name="file_ref_no" value="{{$edit->file_ref_no}}">
                             @if ($errors->has('file_ref_no'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('file_ref_no') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-3 col-form-label col_form_label ">Amount  :</label>
                        <div class="col-4">
                            <input type="text" class="form-control" id="" name="amount" value="{{$edit->income_amount}}">
                            @if ($errors->has('amount'))
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('amount') }}</strong>
                          </span>
                          @endif
                        </div>
                        <div class="col-2 {{$errors->has('currency') ? ' has-error' : ''}}">
							@php
							$allCurrency = \App\Models\Currency::orderBy('title','ASC')->get();
							@endphp
							<select class="form-select" id="" name="currency" required>
								<option value="">Currency</option>
								@foreach($allCurrency as $curr)
								<option value="{{$curr->id}}" {{$curr->id==$edit->income_currency?'selected':''}}>{{$curr->title}}</option>
								@endforeach
							</select>
							@if ($errors->has('currency'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('currency') }}</strong>
							</span>
							@endif
						</div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-3 col-form-label col_form_label">Guest name<span class="req_star">*</span>:</label>
                        <div class="col-6 {{$errors->has('guest_name') ? ' has-error' : ''}}">                							
                            <input type="text" class="form-control" id="" name="guest_name" value="{{$edit->guest_name}}">
                            @if ($errors->has('guest_name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('guest_name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-3 col-form-label col_form_label ">Guest phone no<span class="req_star">*</span>:</label>
                        <div class="col-6 {{$errors->has('guest_phone') ? ' has-error' : ''}}">                							
                            <input type="text" class="form-control" id="" name="guest_phone" value="{{$edit->guest_phone}}">
                            @if ($errors->has('guest_phone'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('guest_phone') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-3 col-form-label col_form_label ">Guest email<span class="req_star">*</span>:</label>
                        <div class="col-6 {{$errors->has('guest_email') ? ' has-error' : ''}}">                							
                            <input type="text" class="form-control" id="" name="guest_email" value="{{$edit->guest_email}}">
                            @if ($errors->has('guest_email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('guest_email') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-3 col-form-label col_form_label ">Income Collector<span class="req_star">*</span>:</label>
                        <div class="col-6 {{$errors->has('income_collector') ? ' has-error' : ''}}">                							
							@php
							$alluser=\App\Models\User::where('status',1)->orderBy('name','ASC')->get();
							@endphp
							<select class="form-select" id="" name="income_collector" required>
								<option value="">Select User</option>
								@foreach($alluser as $user)
								<option value="{{$user->id}}" {{$user->id==$edit->income_collector?'selected':''}}>{{$user->name}}</option>
								@endforeach
							</select>
							@if ($errors->has('income_collector'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('income_collector') }}</strong>
							</span>
							@endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-3 col-form-label col_form_label ">Income Receiver<span class="req_star">*</span>:</label>
                        <div class="col-6 {{$errors->has('income_receiver') ? ' has-error' : ''}}">
                            @php
							$alluser=\App\Models\User::where('status',1)->orderBy('name','ASC')->get();
							@endphp
							<select class="form-select" id="" name="income_receiver" required>
								<option value="">Select User</option>
								@foreach($alluser as $user)
								<option value="{{$user->id}}" {{$user->id==$edit->income_receiver?'selected':''}}>{{$user->name}}</option>
								@endforeach
							</select>
                            @if ($errors->has('income_receiver'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('income_receiver') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    {{-- <div class="row mb-3">
                        <label class="col-3 col-form-label col_form_label ">Income Status<span class="req_star">*</span>:</label>
                        <div class="col-6 {{$errors->has('income_status') ? ' has-error' : ''}}">                							
                            <input type="text" class="form-control" id="" name="income_status" value="{{$edit->income_status}}">
                            @if ($errors->has('income_status'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('income_status') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div> --}}
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
