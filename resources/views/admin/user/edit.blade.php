@extends('layouts.admin')
@section('content')

<div class="row">
<div class="col-12">
    <form method="post" action="{{url('dashboard/user/update')}}" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="user_id" value="{{ $data->id }}">  
      <div class="card">
        <div class="card-header card_header">
            <div class="row">
                <div class="col-md-8 tbl_text">
                   <i class=" uil-user-exclamation "></i> Edit User
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
            <label  class="col-3 col-form-label col_form_label ">Name<span class="req_star">*</span>:</label>
                <div class="col-6 {{$errors->has('name') ? ' has-error' : ''}}">
                  <input type="text" class="form-control" id="" name="name" value="{{$data->name}}">
                  @if ($errors->has('name'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                  </span>
                  @endif
               </div>
             </div>
        <div class="row mb-3">
            <label  class="col-3 col-form-label col_form_label ">Phone :</label>
                <div class="col-6 {{$errors->has('phone') ? ' has-error' : ''}}">
                  <input type="text" class="form-control" id="" name="phone" value="{{$data->phone}}">
                  @if ($errors->has('phone'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('phone') }}</strong>
                  </span>
                  @endif
               </div>
             </div>
        <div class="row mb-3">
            <label  class="col-3 col-form-label col_form_label ">Email<span class="req_star">*</span>:</label>
                <div class="col-6 {{$errors->has('email') ? ' has-error' : ''}}">
                  <input type="email" class="form-control" id="" name="email" value="{{$data->email}}">
                  @if ($errors->has('email'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                  </span>
                  @endif
               </div>
             </div>
        <div class="row mb-3">
           <label  class="col-3 col-form-label col_form_label ">User Role<span class="req_star">*</span>:</label>
                <div class="col-6 {{$errors->has('role') ? ' has-error' : ''}}">
                  @php
                    $Allrole=App\models\role::where('role_status',1)->orderBy('role_id','ASC')->get();
                  @endphp
                   <select class="form-select" aria-label="Default select example" id="" name="role">
                        <option value="">Select Role</option>
                         @foreach($Allrole as $urole)
                        <option value="{{$urole->role_id}}" {{$data->role == $urole->role_id  ? 'selected' : ''}} >{{$urole->role_name}}</option>
                        @endforeach
                   </select>
                   @if ($errors->has('role'))
                   <span class="invalid-feedback" role="alert">
                     <strong>{{ $errors->first('role') }}</strong>
                   </span>
                   @endif
                </div>
             </div>
          <div class="row mb-3">
            <label  class="col-3 col-form-label col_form_label ">Photo :</label>
                <div class="col-6">
                  <input type="file" id="" name="pic">
                  @if($data->photo!='')
                  <img class="img-thumbail" height="100" src="{{asset('uploads/users/'.$data->photo)}}"/>
                  @else
                  <img class="img-thumbail" height="100" src="{{asset('uploads/avatar.png')}}"/>
                  @endif
               </div>
          </div>
          <div class="row mb-3">
            <label  class="col-3 col-form-label col_form_label ">Status<span class="req_star">*</span>:</label>
                <div class="col-6 {{$errors->has('status') ? ' has-error' : ''}}">
                  <input type="radio" name="status" value="1" {{$data->status == 1 ? 'checked':''}}> Active &nbsp; &nbsp; &nbsp; 
                  <input type="radio" name="status" value="0" {{$data->status != 1 ? 'checked':''}}> Inactive
                  @if ($errors->has('status'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('status') }}</strong>
                  </span>
                  @endif
               </div>
          </div>
    </div>
        <!-- end card body-->
        <div class="card-footer card_footer center">
            <button  type="submit" class="btn btn-md btn-dark">Update User</button>
        </div>
    </div> <!-- end card -->
    </form>
</div><!-- end col-->
</div>
@endsection
