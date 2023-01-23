@extends('layouts.admin')
@section('content')

<div class="row">
<div class="col-12">
    <form method="post" action="{{url('dashboard/role/update')}}" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="role_id" value="{{ $role->role_id }}">  
      <div class="card">
        <div class="card-header card_header">
            <div class="row">
                <div class="col-md-8 tbl_text">
                   <i class=" uil-user-exclamation "></i> Edit Role
                </div>
                <div class="col-md-4 card_butt_part">
                    <a class="btn btn-sm btn-dark" href="{{url('dashboard/role')}}"><i class=" uil-users-alt "></i> All Role</a>
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
              <input type="text" class="form-control" id="" name="role_name" value="{{$role->role_name}}">
              @if ($errors->has('role_name'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('role_name') }}</strong>
              </span>
              @endif
            </div>
          </div>
          <div class="row mb-3">
            <label  class="col-3 col-form-label col_form_label ">Status<span class="req_star">*</span>:</label>
            <div class="col-6 {{$errors->has('role_status') ? ' has-error' : ''}}">
              <input type="radio" name="role_status" value="1" {{$role->role_status == 1 ? 'checked':''}}> Active &nbsp; &nbsp; &nbsp; 
              <input type="radio" name="role_status" value="0" {{$role->role_status != 1 ? 'checked':''}}> Inactive
              @if ($errors->has('role_status'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('role_status') }}</strong>
              </span>
              @endif
            </div>
            <div class="col-12 mr-5">
              <div class="form-group">
                <label for="name">Permissions</label>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="checkPermissionAll" value="1">
                    <label class="form-check-label" for="checkPermissionAll">All</label>
                </div>
                <hr>
                @php
                //Get role permission list
                  $rolelist = App\Models\Role::where('role_id',$role->role_id)->firstOrFail('permission_list');
                  $userlist = json_decode($rolelist->permission_list);                  
                  $i = 1; 
                @endphp
                  @foreach ($permission_groups as $group)
                  @php 
                    $permissionslist = App\Models\PermissionGroup::where('id',$group->name)->get();
                    $permissions = App\User::getpermissionsByGroupName($group->name);
                    // $all_permissions  = App\Models\Permission::pluck('id')->toArray();
                  $j = 1;
                  
                @endphp
                @foreach($permissionslist as $list)
                <div class="row">
                  <div class="col-3">
                      <div class="form-check">
                          <input type="checkbox" class="form-check-input" id="{{ $i }}Management" value="{{ $group->name }} " onclick="selectGroup({{$group->name}})">
                          <label class="form-check-label" for="checkPermission">{{ $list->group_name}}</label>
                      </div>
                  </div>
                  <div class="col-9 role-{{ $i }}-management-checkbox">
                      @foreach ($permissions as $permission)  
                        <div class="form-check">
                              <input type="checkbox" class="check_group_{{$list->id}}" name="permissions[]" value="{{ $permission->id }}" {{in_array($permission->id,$userlist)?'checked':''}} >
                              <label class="form-check-label" for="checkPermission{{ $permission->id }}">{{ $permission->name }}</label>
                          </div>
                          @php  $j++; @endphp
                      @endforeach
                      <br>
                  </div>
                </div>
                @endforeach    
                  @php  $i++; @endphp
                @endforeach
            </div>
          </div>
          </div>
            <!-- end card body-->
            <div class="card-footer card_footer center">
                <button  type="submit" class="btn btn-md btn-dark">Update Role</button>
            </div>
        </div> <!-- end card -->
      </form>
    </div><!-- end col-->
  </div>
@endsection
