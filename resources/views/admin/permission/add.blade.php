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
                    <i class=" uil-user-exclamation "></i>  Add Permission
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
                    <input type="text" class="form-control"  name="name" value="{{old('name')}}">
                    @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                </div>
            <div class="row mb-3">
                <label  class="col-3 col-form-label col_form_label ">Guard Name <span class="req_star">*</span>:</label>
                    <div class="col-6 {{$errors->has('guard_name') ? ' has-error' : ''}}">
                    <input type="text" class="form-control"  name="guard_name" value="{{old('guard_name')}}">
                    @if ($errors->has('guard_name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('guard_name') }}</strong>
                    </span>
                    @endif
                </div>
                </div>
            <div class="row mb-3">
                <label  class="col-3 col-form-label col_form_label ">Group<span class="req_star">*</span>:</label>
                    <div class="col-6 {{$errors->has('group_name') ? ' has-error' : ''}}">
                    <input type="text" class="form-control"  name="group_name" value="{{old('group_name')}}">
                    @if ($errors->has('group_name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('group_name') }}</strong>
                    </span>
                    @endif
                </div>
                </div>
            <div class="row mb-3">
                <label  class="col-3 col-form-label col_form_label ">Status<span class="req_star">*</span>:</label>
                <div class="col-6">
                    <input type="radio" name="status" value="1" checked> Active &nbsp; &nbsp; &nbsp; 
                    <input type="radio" name="status" value="0"> Inactive
                </div>
            </div>
            </div>
                <!-- end card body-->
                <div class="card-footer card_footer center">
                    <button  type="submit" class="btn btn-md btn-dark">Create Permission</button>
                </div>
            </div> <!-- end card -->
        </form>
    </div><!-- end col-->
</div>
@endsection
