@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-12">
        <form method="post" action="{{url('dashboard/permission/submit')}}" enctype="multipart/form-data">
        @csrf
            <div class="card">
                <div class="card-header card_header">
                    <div class="row">
                        <div class="col-md-8 tbl_text">
                        <i class="uil-user-exclamation"></i>  Add Permission
                        </div>
                    </div>
                </div>

            <div class="card-body card_body">
            <div class="row">

                <div class="col-lg-6">
                    <label  class="col-form-label col_form_label">Group Menu <span class="req_star">*</span>:</label>
                    <div class="{{$errors->has('group_name') ? ' has-error' : ''}}">
                        @php
                            $all=App\Models\PermissionGroup::where('status',1)->orderBy('id','ASC')->get();
                        @endphp
                        <select class="form-select" aria-label="Default select example"  name="group_name" required>
                                <option value="">Select Menu Group</option>
                                @foreach($all as $group)
                                    <option value="{{$group->id}}">{{$group->group_name}}</option>
                                @endforeach
                        </select>
                        @if ($errors->has('group_name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('role') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="col-lg-6">
                    <label  class="col-form-label col_form_label "> Group Child Name  <span class="req_star">*</span>:</label>
                    <div class="{{$errors->has('name') ? ' has-error' : ''}}">
                        <input type="text" class="form-control"  name="name" value="{{old('name')}}" placeholder="Menu Name " required>
                        @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="col-lg-6">
                    <label  class="col-form-label col_form_label "> URL Name<span class="req_star">*</span> :</label>
                    <div class="{{$errors->has('guard_name') ? ' has-error' : ''}}">
                        <input type="text" class="form-control" id="" name="guard_name" value="{{old('guard_name')}}" placeholder=" URL like {{Request::path()}}" required>
                        @if ($errors->has('guard_name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('guard_name') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>    

                <div class="col-lg-3">
                    <label  class="col-form-label col_form_label ">Details :</label>
                    <div class="{{$errors->has('pr_details') ? ' has-error' : ''}}">
                      <input type="text" class="form-control" id="" name="pr_details" value="{{old('pr_details')}}">
                      @if ($errors->has('pr_details'))
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('pr_details') }}</strong>
                      </span>
                      @endif
                    </div>
                </div>    
                <div class="col-lg-3">
                    <label  class="col-form-label col_form_label ">Status<span class="req_star">*</span>:</label>
                    <div class="mt-1">
                        <input type="radio" name="status" value="1" checked> Active &nbsp; &nbsp; &nbsp; 
                        <input type="radio" name="status" value="0"> Inactive
                    </div>
                </div>        
                
            </div>

            <div class="clear-both"></div> 
                <!-- end card body-->
                <div class="card-footer card_footer center mt-4">
                    <button  type="submit" class="btn btn-md btn-dark mt-2">Create Permission</button>
                </div>
            </div> <!-- end card -->
        </form>
    </div><!-- end col-->
</div>
@endsection
