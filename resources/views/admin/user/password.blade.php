@extends('layouts.admin')
@section('content')

<div class="row">
<div class="col-12">
    <form method="post" action="{{url('dashboard/user/updatePassword')}}" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="user_id" value="{{ $data->id }}">
      <div class="card">
        <div class="card-header card_header">
            <div class="row">
                <div class="col-md-8 tbl_text">
                   <i class=" uil-user-exclamation "></i> Update Password
                </div>
                <div class="col-md-4 card_butt_part">
                    <a class="btn btn-sm btn-dark" href="{{url('dashboard/user')}}"><i class=" uil-users-alt "></i>  All User</a>
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
            <label  class="col-3 col-form-label col_form_label ">User Name:</label>
                <div class="col-6">
                  {{$data->name}}
               </div>
             </div>
        <div class="row mb-3">
            <label  class="col-3 col-form-label col_form_label ">Password<span class="req_star">*</span>:</label>
                <div class="col-6 {{$errors->has('password') ? ' has-error' : ''}}">
                  <input type="password" class="form-control" id="" name="password" value="">
                  @if ($errors->has('password'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                  </span>
                  @endif
               </div>
             </div>
        <div class="row mb-3">
            <label  class="col-3 col-form-label col_form_label ">Confirm Password<span class="req_star">*</span>:</label>
                <div class="col-6">
                  <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="">
               </div>
             </div>
    </div>
        <!-- end card body-->
        <div class="card-footer card_footer center">
            <button  type="submit" class="btn btn-md btn-dark">Update Password</button>
        </div>
    </div> <!-- end card -->
    </form>
</div><!-- end col-->
</div>
@endsection
