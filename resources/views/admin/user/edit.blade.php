@extends('layouts.admin')
@section('content')

<div class="row">
<div class="col-12">
    <form method="post" action="{{route(isset($data->id)?'update.user':'create.newuser')}}" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="id" value="{{ isset($data->id)?$data->id:'' }}">

          <div class="card">
            <div class="card-header card_header">
                <div class="row">
                    <div class="col-md-8 tbl_text">
                       <i class=" uil-user-exclamation"></i>User
                    </div>
                    <div class="col-md-4 card_butt_part">
                        <a class="btn btn-sm btn-dark" href="{{route('users')}}"><i class=" uil-users-alt "></i>  All User</a>
                    </div>
                </div>
            </div>

            <div class="card-body card_body">
                <div class="row">
                    <div class="col-lg-6">
                        <label class="col-form-label col_form_label">Name<span class="req_star">*</span>:</label>
                        <div class="{{$errors->has('name') ? ' has-error' : ''}}">
                          <input type="text" class="form-control" id="" name="name" value="{{isset($data->name)?$data->name:''}}" required>
                          @if ($errors->has('name'))
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                          </span>
                          @endif
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <label class="col-form-label col_form_label ">Phone :</label>
                        <div class="{{$errors->has('phone') ? ' has-error' : ''}}">
                          <input type="text" class="form-control" id="" name="phone" value="{{isset($data->phone)?$data->phone:''}}" required>
                          @if ($errors->has('phone'))
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('phone') }}</strong>
                          </span>
                          @endif
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <label  class="col-form-label col_form_label ">Email<span class="req_star">*</span>:</label>
                        <div class="{{$errors->has('email') ? ' has-error' : ''}}">
                          <input type="email" class="form-control" id="" name="email" value="{{isset($data->email)?$data->email:''}}" required>
                          @if ($errors->has('email'))
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                          </span>
                          @endif
                        </div>
                    </div>

                    {{-- <div class="col-lg-4">
                        <label  class="col-form-label col_form_label ">User Role<span class="req_star">*</span>:</label>
                        <div class="{{$errors->has('role') ? ' has-error' : ''}}">
                          @php
                            $Allrole=App\Models\Role::where('role_status',1)->orderBy('role_id','ASC')->get();
                          @endphp
                           <select class="form-select" aria-label="Default select example" id="" name="role" required>
                                <option value="">Select Role</option>
                                 @foreach($Allrole as $urole)
                                <option value="{{$urole->role_id}}" {{isset($data->role)?$data->role == $urole->role_id  ? 'selected' : '':''}} >{{$urole->role_name}}</option>
                                @endforeach
                           </select>
                           @if ($errors->has('role'))
                           <span class="invalid-feedback" role="alert">
                             <strong>{{ $errors->first('role') }}</strong>
                           </span>
                           @endif
                        </div>
                    </div> --}}

                    <div class="col-lg-4">
                        <label  class="col-form-label col_form_label "> Company <span class="req_star">*</span>:</label>
                        <div class="{{$errors->has('company_id') ? ' has-error' : ''}}">
                          @php
                          $company=App\Models\Companyinfo::where('status',1)->orderBy('id','ASC')->get();
                          @endphp
                            <select id="company" class="form-select" aria-label="Default select example"  name="company_id" required>
                                <option value="">Select Branch</option>
                                  @foreach($company as $company)
                                <option value="{{$company->id}}" {{isset($data->company_id)?$data->company_id == $company->id  ? 'selected' : '':''}} {{$company->id}} >{{$company->name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('company_id'))
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('company_id') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <label  class="col-form-label col_form_label "> Branch <span class="req_star">*</span>: </label>
                        <div class="{{$errors->has('branch_id') ? ' has-error' : ''}}">
                          @php
                            if(isset($data->company_id))
                            {
                              $branch=App\Models\Branch::where('status',1)->where('company_id',$data->company_id)->orderBy('id','ASC')->get();
                            }
                            else
                            {
                              $branch=App\Models\Branch::where('status',1)->orderBy('id','ASC')->get();
                            }
                          @endphp
                            <select id="branch" class="form-select" aria-label="Default select example" name="branch_id" required>
                                <option value="">Select Branch</option>
                                  @foreach($branch as $branch)
                                <option value="{{$branch->id}}" {{isset($data->branch_id)?$data->branch_id == $branch->id  ? 'selected' : '':''}} {{$branch->id}} >{{$branch->name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('branch_id'))
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('branch_id') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <label  class="col-form-label col_form_label "> Department <span class="req_star">*</span> :</label>
                        <div class="{{$errors->has('company_id') ? ' has-error' : ''}}">
                            @php
                              $department=App\Models\Department::where('status',1)->orderBy('id','ASC')->get();
                            @endphp
                            <select class="form-select" aria-label="Default select example" value=""  name="department_id" required>
                                <option value="">Select Department</option>
                                  @foreach($department as $department)
                                <option value="{{$department->id}}" {{isset($data->department_id)?$data->department_id == $department->id  ? 'selected' : '':''}} {{$department->id}} >{{$department->name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('department_id'))
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('department_id') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    @if (!isset($data->password))
                    <div class="col-lg-4">
                        <label  class="col-form-label col_form_label ">Password<span class="req_star">*</span>:</label>
                        <div class="{{$errors->has('password') ? ' has-error' : ''}}">
                          <input type="password" class="form-control" value="" name="password" required>
                          @if ($errors->has('password'))
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                          </span>
                          @endif
                        </div>
                    </div>
                    @endif
                    <div class="col-lg-4">
                        <label  class="col-form-label col_form_label ">Status<span class="req_star">*</span>:</label>
                        <div class="{{$errors->has('status') ? ' has-error' : ''}} mt-2" >
                          {{-- <input type="radio" name="status" value="1" checked> Active &nbsp; &nbsp; &nbsp;
                          <input type="radio" name="status" value="0"> Inactive --}}

                          <input type="radio" name="status" value="1" {{isset($data->status)?$data->status == 1 ? 'checked':'':'checked'}}> Active &nbsp; &nbsp; &nbsp;
                          <input type="radio" name="status" value="0" {{isset($data->status)?$data->status != 1 ? 'checked':'':''}}> Inactive
                          @if ($errors->has('status'))
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('status') }}</strong>
                          </span>
                          @endif
                       </div>
                    </div>

                    <div class="col-lg-4">
                        <label  class="col-form-label col_form_label "> Photo :</label>
                        <div class="mb-1">
                           @if(isset($data->avatar))
                          <img class="img-thumbail rounded-circle" height="50" src="{{asset('uploads/users/'.$data->avatar)}}"/>
                          @else
                          <img class="img-thumbail rounded-circle" height="50" src="{{asset('uploads/avatar.png')}}"/>
                          @endif
                       </div>
                       <input type="file" id="" name="pic">
                    </div>
                    <br>
                    <div class="col-lg-12">
                        <label  class="col-form-label col_form_label ">User Type:</label>
                        <div class="mt-2">
                          <div class="mt-2">
                            <input type="radio" name="admin_view" value="0" {{isset($data->admin_view)?$data->admin_view == 0 ? 'checked':'':''}}> Web Admin &nbsp; &nbsp; &nbsp;
                            <input type="radio" name="admin_view" value="1" {{isset($data->admin_view)?$data->admin_view == 1 ? 'checked':'':''}}> Admin &nbsp; &nbsp; &nbsp;
                            <input type="radio" name="admin_view" value="2" {{isset($data->admin_view)?$data->admin_view == 2 ? 'checked':'':'checked'}} > Accountent &nbsp; &nbsp; &nbsp;
                            <input type="radio" name="admin_view" value="3" {{isset($data->admin_view)?$data->admin_view == 3 ? 'checked':'':'checked'}} > Sales &nbsp; &nbsp; &nbsp;
                            <input type="radio" name="admin_view" value="4" {{isset($data->admin_view)?$data->admin_view == 3 ? 'checked':'':'checked'}} > OPR &nbsp; &nbsp; &nbsp;
                            <input type="radio" name="admin_view" value="5" {{isset($data->admin_view)?$data->admin_view == 4 ? 'checked':'':'checked'}} > Other &nbsp; &nbsp; &nbsp;
                         </div>
                         <br>
                    </div>
                </div>
            </div>
            <!-- end card body-->
        <div class="card-footer card_footer center">
          <button  type="submit" class="btn btn-md btn-dark"> Submit </button>
      </div>
  </div> <!-- end card -->
  </form>
        </div>


</div><!-- end col-->
</div>

<script>
      $(document).ready(function() {
      $('#company').on('change', function() {
        var companyID = $(this).val();
        if(companyID) {
            $.ajax({
                url: '{{ url('') }}/dashboard/branch/bycompany/'+companyID,
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                dataType: "json",
                success:function(data)
                {
                  if(data){
                      $('#branch').empty();
                      $('#branch').append('<option value="">Select Branch</option>');
                      $.each(data, function(key, branch){
                          $('#branch').append('<option value="'+ branch.id +'">' + branch.name+ '</option>');
                      });
                  }else{
                      $('#branch').empty();
                  }
              }
            });
        }else{
          $('#branch').empty();
        }
      });
      });
</script>

@endsection
