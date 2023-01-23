@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header card_header">
                <div class="row">
                    <div class="col-md-8 tbl_text">
                       <i class="uil-user-exclamation"></i>View User Information
                    </div>
                    <div class="col-md-4 card_butt_part">
                        <a class="btn btn-sm btn-dark" href="{{url('dashboard/user')}}"><i class="uil-users-alt"></i>  All User</a>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                   <table class="table table-bordered table-striped custom_view_table">
                      <tr>
                          <td colspan="3" class="text-center">
                          @if($data->photo!='')
                          <img class="img-thumbail" height="150" src="{{asset('uploads/users/'.$data->photo)}}"/>
                          @else
                          <img class="img-thumbail" height="150" src="{{asset('uploads/avatar.png')}}"/>
                          @endif
                          </td>
                      </tr>
                      <tr>
                        <td>Name</td>
                        <td>{{$data->name}}</td>
                       </tr> 
                       <tr>
                        <td>Email</td>
                        <td>{{$data->email}}</td>
                       </tr> 
                       <tr>
                        <td>Phone</td>
                        <td>{{$data->phone}}</td>
                       </tr> 
                       <tr>
                        <td>Role</td>
                        <td>{{$data->roleInfo->role_name}}</td>
                       </tr>
                   </table>
                </div>
            </div>
            <!-- end card body-->
            <div class="card-footer center">
                <a class="btn btn-md btn-dark" href="{{route('changepassword',$data->id)}}">Update Password</a>
            </div>
            {{-- <div class="card-footer card_footer">
                   <div class="btn-group mb-2">
                    <a href="#" class="btn btn-secondary">Print</a>
                    <a href="#" class="btn btn-dark">PDF</a>
                    <a href="#" class="btn btn-secondary">Excel</a>
                </div>
            </div> --}}            
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
@endsection