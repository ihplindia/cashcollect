@extends('layouts.admin')
@section('content')

<div class="row">
  <div class="col-12">
      <form method="post" action="{{url('dashboard/setting/update')}}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $settingId->id }}">  
        <div class="card">
          <div class="card-header card_header">
            <div class="row">
              <div class="col-md-8 tbl_text">
                <i class=" uil-user-exclamation "></i> Edit 
              </div>
            </div>
          </div>
          
          <div class="card-body card_body">
              <div class="row">

                  <div class="col-md-6">
                      <label class="col-form-label col_form_label"> Key Name <span class="req_star">*</span>:</label>
                      <div class="{{$errors->has('key') ? ' has-error' : ''}}">
                          <input type="text" class="form-control"  name="key" value="{{$settingId->key}}">
                          @if ($errors->has('key'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('key') }}</strong>
                          </span>
                          @endif
                      </div>
                  </div>
                  
                  <div class="col-md-6">
                      <label class="col-form-label col_form_label"> Value Name <span class="req_star">*</span>:</label>
                      <div class="{{$errors->has('value') ? ' has-error' : ''}}">
                          <input type="text" class="form-control"  name="value" value="{{$settingId->value}}">
                          @if ($errors->has('value'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('value') }}</strong>
                          </span>
                          @endif
                      </div>
                  </div>
              </div>
          </div>    
          
          </div><!-- end card body-->
          <div class="card-footer card_footer center">
              <button  type="submit" class="btn btn-md btn-dark"> Update </button>
          </div>
        </div> <!-- end card -->
      </form>
  </div><!-- end col-->
</div>
@endsection