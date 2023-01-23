@extends('layouts.admin')
@section('content')

<div class="row">
<div class="col-12">
    <form method="post" action="{{url('dashboard/user/updatePassword')}}" enctype="multipart/form-data">
      @csrf
      
      <div class="card">
        <div class="card-header card_header">
            <div class="row">
                <div class="col-md-8 tbl_text">
                   <i class=" uil-user-exclamation "></i> Update Password
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
          <div class="row">
             <div class="col-md-12">
                <label class="col-form-label col_form_label">User Name:</label>
                <span>  {{$user->name}}</span>
             </div>             
             <div class="col-md-6">
                <label class="col-form-label col_form_label ">Password<span class="req_star">*</span>:</label>
                <div class="{{$errors->has('password') ? ' has-error' : ''}}">
                  <input type="hidden" name="id" value="{{$user->id}}">
                  <input type="password" class="form-control" id="" name="password" value="">
                  @if ($errors->has('password'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                  </span>
                  @endif
               </div>
             </div>

             <div class="col-md-6">
                <label class="col-form-label col_form_label">Confirm Password<span class="req_star">*</span>:</label>
                <div class="">
                  <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="">
                </div>
             </div>

          </div>
        <!-- end card body-->
        
    </div> <!-- end card -->
    <div class="card-footer card_footer center">
        <button  type="submit" class="btn btn-md btn-dark">Update Password</button>
    </div>
    </form>
</div><!-- end col-->
</div>
@endsection
