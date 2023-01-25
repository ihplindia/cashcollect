@extends('layouts.admin')
@section('content')

<div class="row">
  <div class="col-12">
      <form method="post" action="{{url('dashboard/currency/update')}}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $currency->id }}">
        <div class="card">
          <div class="card-header card_header">
            <div class="row">
              <div class="col-md-8 tbl_text">
                <i class="uil-user-exclamation"></i> Edit
              </div>
            </div>
          </div>

          <div class="card-body card_body">
              <div class="row">

                  <div class="row mb-3">
                        <label  class="col-3 col-form-label col_form_label "> Currency Name <span class="req_star">*</span> :</label>
                        <div class="col-6 {{$errors->has('title') ? ' has-error' : ''}}">
                            <input type="text" class="form-control"  name="title" value="{{$currency->title}}" required>
                            @if ($errors->has('title'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('title') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    @if(isset($currency->rate))

                    <div class="row mb-3">
                        <label  class="col-3 col-form-label col_form_label "> Currency Rate <span class="req_star">*</span> :</label>
                        <div class="col-6 {{$errors->has('code') ? ' has-error' : ''}}">
                            <input type="text" class="form-control"  name="code" value="{{$currency->rate}}" placeholder=" Name" required>
                            @if ($errors->has('code'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('code') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    @endif
                    <div class="row mb-3">
                        <label  class="col-3 col-form-label col_form_label "> Currency Code <span class="req_star">*</span> :</label>
                        <div class="col-6 {{$errors->has('code') ? ' has-error' : ''}}">
                            <input type="text" class="form-control"  name="code" value="{{$currency->code}}" placeholder=" Currency Code" required>
                            @if ($errors->has('code'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('code') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    {{-- <div class="row mb-3">
                        <label  class="col-3 col-form-label col_form_label "> Currency Icon :</label>
                        <div class="col-6 {{$errors->has('icon') ? ' has-error' : ''}}">
                            <input type="text" class="form-control"  name="icon" value="{{$currency->icon}}" placeholder=" fa-code" required>
                            @if ($errors->has('icon'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('icon') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div> --}}
                    <div class="row mb-3">
                        <label  class="col-3 col-form-label col_form_label "> Status <span class="req_star">*</span> :</label>
                        <div class="mt-1 col-6 {{$errors->has('icon') ? ' has-error' : ''}}">
                        <input type="radio" name="status" value="1" {{$currency->status == 1 ? 'checked':''}}> Active &nbsp; &nbsp; &nbsp;
                          <input type="radio" name="status" value="0" {{$currency->status != 1 ? 'checked':''}}> Inactive
                        </div>
                    </div>
              </div>
          </div>
          <div class="card-footer card_footer center">
              <button type="submit" class="btn btn-md btn-dark">Update</button>
          </div>

          </div><!-- end card body-->

        </div> <!-- end card -->
      </div>

      </form>
  </div><!-- end col-->
</div>
@endsection
