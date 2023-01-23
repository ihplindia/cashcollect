@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-12">
        <form method="post" action="{{route(isset($edit->id)?'update.company':'insert.company')}}" enctype="multipart/form-data">
            <input type="hidden" name="id" value="{{isset($edit->id)?$edit->id:''}}">
            @csrf
            <div class="card">
                <div class="card-header card_header">
                    <div class="row">
                        <div class="col-md-8 tbl_text">
                            <i class=" uil-user-exclamation "></i>  Company Details
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
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-form-label col_form_label">Company<span class="req_star">*</span>:</label>
                            <div class="{{$errors->has('key') ? ' has-error' : ''}}">
                                <input type="text" class="form-control" name="name" value="{{isset($edit->name)?$edit->name:''}}">
                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="col-form-label col_form_label">Status<span class="req_star">*</span>:</label>
                            <div class="{{$errors->has('status') ? ' has-error' : ''}} mt-1">
                               <input type="radio" name="status" value="1" {{isset($edit->status)?$edit->status ==1 ?'checked':'':''}}> Active &nbsp; &nbsp; &nbsp; 
                               <input type="radio" name="status" value="0" {{isset($edit->status)?$edit->status != 1 ? 'checked':'':''}}> Inactive
                               @if ($errors->has('status'))
                               <span class="invalid-feedback" role="alert">
                               <strong>{{ $errors->first('status') }}</strong>
                               </span>
                               @endif
                            </div>
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
