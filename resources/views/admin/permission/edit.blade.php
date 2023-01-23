@extends('layouts.admin')
@section('content')
<div class="row">
   <div class="col-12">
      <form method="post" action="{{url('dashboard/permission/update')}}" enctype="multipart/form-data">
         @csrf
         <input type="hidden" name="user_id" value="{{ $data->id }}">  
         <div class="card">
            <div class="card-header card_header">
               <div class="row">
                  <div class="col-md-8 tbl_text">
                     <i class=" uil-user-exclamation "></i> Edit Permission
                  </div>
               </div>
            </div>
            <div class="card-body card_body">
               <div class="row">
                  <div class="col-3"></div>
                  <div class="col-3"></div>
               </div>
               <div class="row mb-3">
                  <label  class="col-3 col-form-label col_form_label "> Group <span class="req_star">*</span>:</label>
                  <div class="col-6 {{$errors->has('group_name') ? ' has-error' : ''}}">
                     @php
                     $all=App\Models\PermissionGroup::where('status',1)->orderBy('id','ASC')->get();
                     @endphp
                     <select class="form-select" aria-label="Default example"  name="group_name">
                     @foreach($all as $group)
                     <option value="{{$group->id}}" {{$data->group_name == $group->id ? 'selected' : ''}} >{{$group->group_name}}</option>
                     @endforeach
                     </select>
                     @if ($errors->has('group_name'))
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $errors->first('role') }}</strong>
                     </span>
                     @endif
                  </div>
               </div>
               <div class="row mb-3">
                  <label  class="col-3 col-form-label col_form_label "> Group chlid Name <span class="req_star">*</span>:</label>
                  <div class="col-6 {{$errors->has('name') ? ' has-error' : ''}}">
                     <input type="text" class="form-control" id="" name="name" value="{{$data->name}}" required>
                     @if ($errors->has('name'))
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $errors->first('name') }}</strong>
                     </span>
                     @endif
                  </div>
               </div>
               <div class="row mb-3">
                  <label  class="col-3 col-form-label col_form_label ">URL Name<span class="req_star">*</span> :</label>
                  <div class="col-6 {{$errors->has('guard_name') ? ' has-error' : ''}}">
                      <input type="text" class="form-control" id="" name="guard_name" value="{{$data->guard_name}}">
                      @if ($errors->has('guard_name'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('guard_name') }}</strong>
                      </span>
                      @endif
                  </div>
              </div>
               <div class="row mb-3">
                  <label  class="col-3 col-form-label col_form_label ">Details  :</label>
                  <div class="col-6 {{$errors->has('pr_details') ? ' has-error' : ''}}">
                     <input type="text" class="form-control" id="" name="pr_details" value="{{$data->pr_details}}">
                     @if ($errors->has('pr_details'))
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $errors->first('pr_details') }}</strong>
                     </span>
                     @endif
                  </div>
               </div>
               
               <div class="row mb-3">
                  <label  class="col-3 col-form-label col_form_label ">Status<span class="req_star">*</span>:</label>
                  <div class="col-6 {{$errors->has('status') ? ' has-error' : ''}} mt-1">
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
               <button  type="submit" class="btn btn-md btn-dark">Update Permission</button>
            </div>
         </div>
         <!-- end card -->
      </form>
   </div>
   <!-- end col-->
</div>
@endsection