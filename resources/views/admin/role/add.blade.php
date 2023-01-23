@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-12">
        <form method="post" action="{{ url('dashboard/role/stored') }}" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-header card_header">
                    <div class="row">
                        <div class="col-md-8 tbl_text">
                        <i class=" uil-user-exclamation "></i>  Add Role
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
                        <label  class="col-3 col-form-label col_form_label ">Role Name<span class="req_star"> * </span>:</label>
                        <div class="col-6 {{$errors->has('role_name') ? ' has-error' : ''}}">
                            <input type="text" class="form-control"  name="role_name" value="{{old('role_name')}}">
                            @if ($errors->has('role_name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('role_name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-3 col-form-label col_form_label ">Status<span class="req_star"> * </span>:</label>
                        <div class="col-6 mt-2">
                            <input type="radio" name="status" value="1" checked> Active &nbsp; &nbsp; &nbsp; 
                            <input type="radio" name="status" value="0"> Inactive
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">Permissions</label>

                        <div class="form-check mt-1">
                            <input type="checkbox" class="form-check-input" id="checkPermissionAll" value="1">
                            <label class="form-check-label" for="checkPermissionAll">All</label>
                        </div>
                        <hr>
                        @php $i = 1; @endphp
                        @foreach ($permission_groups as $group)
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="{{ $i }}Management" value="{{ $group->name }}" onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)">
                                        @php
                                            $name_id = $group->name;
                                            $gname = App\User::GroupName($name_id);
                                                                                      
                                        @endphp
                                        @foreach ($gname as $key)
                                        
                                        <label class="form-check-label" for="checkPermission">{{ $key->group_name }}</label>
                                    </div>
                                </div>

                                <div class="col-9 role-{{ $i }}-management-checkbox">
                                    @php
                                        $permissions = App\User::getpermissionsByGroupName($group->name);
                                        $j = 1;
                                    @endphp
                                    @foreach ($permissions as $permission)
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="permissions[]" id="checkPermission{{ $permission->id }}" value="{{ $permission->id }}">
                                            <label class="form-check-label" for="checkPermission{{ $permission->id }}">{{ $permission->name }}</label>
                                        </div>
                                        @php  $j++; @endphp
                                    @endforeach
                                    @endforeach
                                    <br>
                                </div>
                            </div>
                            @php  $i++; @endphp
                        @endforeach
                    </div>
                </div>
                <!-- end card body-->
                <div class="card-footer card_footer center">
                    <button  type="submit" class="btn btn-md btn-dark">Create Role</button>
                </div>
            </div> <!-- end card -->
        </form>
    </div><!-- end col-->
</div>
@endsection
