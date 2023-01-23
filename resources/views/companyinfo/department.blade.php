@extends('layouts.admin')
@section('content')

<div class="row">
  <div class="col-12">
      <form method="post" action="{{route(isset($edit->id)?'update.department':'insert.department')}}" enctype="multipart/form-data">
        @csrf
        
        <input type="hidden" name="id" value="{{ isset($edit->id)?$edit->id:'' }}">  
        <div class="card">
          <div class="card-header card_header">
            <div class="row">
              <div class="col-md-8 tbl_text">
                <i class=" uil-user-exclamation "></i> Department
              </div>
            </div>
          </div>
          <div class="col-3"></div>          
          <div class="card-body card_body">
              <div class="row">
                {{-- <div class="col-md-6">
                  <label  class="col-form-label col_form_label">Company  <span class="req_star">*</span>:</label>
                  <div class=" "{{$errors->has('parent') ? ' has-error' : ''}}>
                      <select class="form-select" aria-label="Default select example"  name="company_id" required>
                          @php 
                            $company = App\Models\Companyinfo::where('status',1)->get();                           
                          @endphp
                          @foreach($company as $row)                            
                            <option name="company_id" value="{{ isset($edit->company_id)?$edit->company_id:$row->id }}" > {{ $row->name }} </option>
                            <option value="{{$row->id}}" {{isset($edit->company_id)?$row->id == $edit->company_id?'selected':'':''}}>{{$row->name}}</option>
                          @endforeach
                      </select>
                      @if ($errors->has('company_id'))
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('company_id') }}</strong>
                      </span>
                      @endif
                  </div>
                </div>
                <div class="col-md-6">
                  <label  class="col-form-label col_form_label ">Branch  <span class="req_star">*</span>:</label>
                  <div {{$errors->has('branch_id') ? ' has-error' : ''}}>
                    <select class="form-select" aria-label="Default select example"  name="branch_id" required>
                      @php 
                        $branch = App\Models\Branch::where('status',1)->get();
                        // print_r($company); 
                      @endphp
                      @foreach($branch as $branch)                        
                        <option value="{{$branch->id}}" {{isset($edit->branch_id)?$branch->id==$edit->branch_id?'selected':'':''}}>{{$branch->name}}</option>
                      @endforeach
                    </select>
                    @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                </div> --}}
                  <div class="col-md-6">
                    <label class="col-form-label col_form_label">Department  <span class="req_star">*</span>:</label>
                    <div class="{{$errors->has('name') ? ' has-error' : ''}}">
                        <input type="text" class="form-control"  name="name" value="{{isset($edit->name)? $edit->name:''}}">
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
          </div>    
          <div class="card-footer card_footer center">
              <button  type="submit" class="btn btn-md btn-dark"> Submit </button>
          </div>

          </div><!-- end card body-->
          
        </div> <!-- end card -->
      </form>
       </div>
  </div><!-- end col-->
</div>
@endsection
