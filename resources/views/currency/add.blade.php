@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-12">
        <form method="post" action="{{url('dashboard/currency/insert')}}" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-header card_header">
                    <div class="row">
                        <div class="col-md-8 tbl_text">
                            <i class=" uil-user-exclamation "></i>  Add Currency
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
                        <label  class="col-3 col-form-label col_form_label "> Currency Name <span class="req_star">*</span>:</label>
                        <div class="col-6 {{$errors->has('title') ? ' has-error' : ''}}">
                            <input type="text" class="form-control"  name="title" value="{{old('title')}}" placeholder=" Name" required>
                            @if ($errors->has('title'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('title') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-3 col-form-label col_form_label "> Currency Code <span class="req_star">*</span>:</label>
                        <div class="col-6 {{$errors->has('code') ? ' has-error' : ''}}">
                            <input type="text" class="form-control"  name="code" value="{{old('code')}}" placeholder=" Currency Code" required>
                            @if ($errors->has('code'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('code') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    {{-- <div class="row mb-3">
                        <label  class="col-3 col-form-label col_form_label "> Currency Icon :</label>
                        <div class="col-6 {{$errors->has('icon') ? ' has-error' : ''}}">
                            <input type="text" class="form-control"  name="icon" value="{{old('icon')}}" placeholder=" fa-code">
                            @if ($errors->has('icon'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('icon') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div> --}}
                    <div class="row mb-3">
                        <label  class="col-3 col-form-label col_form_label ">Status<span class="req_star">*</span>:</label>
                        <div class="col-6 mt-1">
                            <input type="radio" name="status" value="1" checked> Active &nbsp; &nbsp; &nbsp;
                            <input type="radio" name="status" value="0"> Inactive
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
