@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-12">
        <form method="post" action="{{url('dashboard/setting/insert')}}" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-header card_header">
                    <div class="row">
                        <div class="col-md-8 tbl_text">
                            <i class=" uil-user-exclamation "></i>  Add Details
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
                        <label  class="col-3 col-form-label col_form_label "> Key  Name <span class="req_star">*</span>:</label>
                        <div class="col-6 {{$errors->has('key') ? ' has-error' : ''}}">
                            <input type="text" class="form-control"  name="key" value="{{old('key')}}">
                            @if ($errors->has('key'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('key') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-3 col-form-label col_form_label "> Value  Name <span class="req_star">*</span>:</label>
                        <div class="col-6 {{$errors->has('value') ? ' has-error' : ''}}">
                            <input type="text" class="form-control"  name="value" value="{{old('value')}}">
                            @if ($errors->has('value'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('value') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div><!-- end card body-->
                <div class="card-footer card_footer center">
                    <button  type="submit" class="btn btn-md btn-dark"> Submit </button>
                </div>
            </div> <!-- end card -->
        </form>
    </div><!-- end col-->
</div>
@endsection
