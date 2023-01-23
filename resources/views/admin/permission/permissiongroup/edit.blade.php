@extends('layouts.admin')
@section('content')

<div class="row">
  <div class="col-12">
      <form method="post" action="{{url('dashboard/permission/permissiongroup/update')}}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $data->id }}">  
        <div class="card">
          <div class="card-header card_header">
            <div class="row">
              <div class="col-md-8 tbl_text">
                <i class=" uil-user-exclamation "></i> Edit Permission Group
              </div>
            </div>
          </div>
          <div class="col-3"></div>
            </div>
            <div class="row mb-3">
              <label  class="col-3 col-form-label col_form_label ">Group<span class="req_star">*</span>:</label>
                  <div class="col-6 {{$errors->has('group_name') ? ' has-error' : ''}}">
                    <input type="text" class="form-control" id="" name="group_name" value="{{$data->group_name}}">
                    @if ($errors->has('group_name'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('group_name') }}</strong>
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
          </div><!-- end card body-->
          <div class="card-footer card_footer center">
              <button  type="submit" class="btn btn-md btn-dark">Update Group Permission</button>
          </div>
        </div> <!-- end card -->
      </form>
  </div><!-- end col-->
</div>
@endsection
