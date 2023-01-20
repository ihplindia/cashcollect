@extends('layouts.admin')
@section('content')

<div class="row">
<div class="col-12">
    <form method="post" action="{{url('dashboard/role/update')}}" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="role_id" value="{{ $data->role_id }}">  
      <div class="card">
        <div class="card-header card_header">
            <div class="row">
                <div class="col-md-8 tbl_text">
                   <i class=" uil-user-exclamation "></i> Edit Role
                </div>
                <div class="col-md-4 card_butt_part">
                    <a class="btn btn-sm btn-dark" href="{{url('dashboard/role')}}"><i class=" uil-users-alt "></i> Update Role</a>
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
            <label  class="col-3 col-form-label col_form_label ">Role Name<span class="req_star">*</span>:</label>
                <div class="col-6 {{$errors->has('role_name') ? ' has-error' : ''}}">
                  <input type="text" class="form-control" id="" name="role_name" value="{{$data->role_name}}">
                  @if ($errors->has('role_name'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('role_name') }}</strong>
                  </span>
                  @endif
               </div>
             </div>
        <div class="row mb-3">
            <label  class="col-3 col-form-label col_form_label ">Slug Name :</label>
                <div class="col-6 {{$errors->has('role_slug') ? ' has-error' : ''}}">
                  <input type="text" class="form-control" id="" name="role_slug" value="{{$data->role_slug}}">
                  @if ($errors->has('role_slug'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('role_slug') }}</strong>
                  </span>
                  @endif
               </div>
             </div>
            <div class="row mb-3">
              <label  class="col-3 col-form-label col_form_label ">Status<span class="req_star">*</span>:</label>
                  <div class="col-6 {{$errors->has('role_status') ? ' has-error' : ''}}">
                    <input type="radio" name="role_status" value="1" {{$data->role_status == 1 ? 'checked':''}}> Active &nbsp; &nbsp; &nbsp; 
                    <input type="radio" name="role_status" value="0" {{$data->role_status != 1 ? 'checked':''}}> Inactive
                    @if ($errors->has('role_status'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('role_status') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
          </div>
            <!-- end card body-->
            <div class="card-footer card_footer center">
                <button  type="submit" class="btn btn-md btn-dark">Role User</button>
            </div>
        </div> <!-- end card -->
      </form>
    </div><!-- end col-->
  </div>
@endsection
