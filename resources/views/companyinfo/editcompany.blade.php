@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-12">
        <form method="post" action="{{url('dashboard/companyinfo/updatempany')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{$companyid->id}}">
            <input type="hidden" name="parent" value="{{$companyid->parent}}">
            <input type="hidden" name="status" value="{{$companyid->status}}">
            <div class="card">
                <div class="card-header card_header">
                    <div class="row">
                        <div class="col-md-8 tbl_text">
                            <i class=" uil-user-exclamation "></i>  Add Company Details
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
                        <label  class="col-3 col-form-label col_form_label ">Add New Company  <span class="req_star">*</span>:</label>
                        <div class="col-6 {{$errors->has('key') ? ' has-error' : ''}}">
                            <input type="text" class="form-control" name="name"value="{{$companyid->name}}">
                            @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    {{-- <div class="row mb-3">
                        <label  class="col-3 col-form-label col_form_label ">Status<span class="req_star">*</span>:</label>
                        <div class="col-6 {{$errors->has('status') ? ' has-error' : ''}} mt-1">
                            <input type="radio" name="status" value="1" {{$companyid->status == 1 ? 'checked':''}}> Active &nbsp; &nbsp; &nbsp; 
                            <input type="radio" name="status" value="0" {{$companyid->status != 1 ? 'checked':''}}> Inactive
                            @if ($errors->has('status'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('status') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div> --}}
                </div><!-- end card body-->
                <div class="card-footer card_footer center">
                    <button  type="submit" class="btn btn-md btn-dark"> Submit </button>
                </div>
            </div> <!-- end card -->
        </form>
    </div><!-- end col-->
</div>
@endsection
