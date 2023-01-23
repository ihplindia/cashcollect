@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-12">
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
        <form method="post" action="{{route(isset($edit->id)?'update.branch':'addbranch')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ isset($edit->id)?$edit->id:'' }}">  
            <div class="card">
                <div class="card-header card_header">
                    <div class="row">
                        <div class="col-md-8 tbl_text">
                            <i class=" uil-user-exclamation "></i> Company Details
                        </div>
                    </div>
                </div>
                    @php
                    $company = App\Models\Companyinfo::where('status',1)
                            ->orderby('id','DESC')->get();  
                    @endphp
                    <br>
                    <div class="row mb-3">
                        <label  class="col-3 col-form-label col_form_label ">Company Name </label>
                        <div class="col-6 {{$errors->has('parent') ? ' has-error' : ''}}">
                            <select class="form-select" aria-label="Default select example"  name="company_id" required>
                                <option value="" >Select Group</option>
                                @foreach($company as $data)
                                    <option name="company_id" value="{{$data->id}}" {{isset($edit->company_id)?$data->id==$edit->company_id?' selected' : '':''}}>{{$data->name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('parent'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('parent') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-3 col-form-label col_form_label "> Branch  Name <span class="req_star">*</span>:</label>
                        <div class="col-6 {{$errors->has('name') ? ' has-error' : ''}}">
                            <input type="text" class="form-control"  name="name" value="{{isset($edit->name)?$edit->name:''}}" required>
                            @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-3 col-form-label col_form_label "> Email  :</label>
                        <div class="col-6 {{$errors->has('company_mail') ? ' has-error' : ''}}">
                            <input type="mail" class="form-control"  name="company_mail" value="{{isset($edit->company_mail)?$edit->company_mail:''}}">
                            @if ($errors->has('company_mail'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div> 
                    <div class="row mb-3">
                        <label  class="col-3 col-form-label col_form_label ">Status<span class="req_star">*</span>:</label>
                        <div class="col-6 {{$errors->has('status') ? ' has-error' : ''}} mt-1">
                           <input type="radio" name="status" value="1" {{isset($edit->status)?$edit->status ==1 ?'checked':'':''}}> Active &nbsp; &nbsp; &nbsp; 
                           <input type="radio" name="status" value="0" {{isset($edit->status)?$edit->status != 1 ? 'checked':'':''}}> Inactive
                           @if ($errors->has('status'))
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $errors->first('status') }}</strong>
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
