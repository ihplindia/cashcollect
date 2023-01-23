@extends('layouts.admin')
@section('content')

<div class="row">
<div class="col-12">
<div class="card">
<div class="card-header card_header">
    <div class="row">
        <div class="col-md-8 tbl_text">
           <i class=" uil-user-exclamation "></i>  All User Information
        </div>
        <div class="col-md-4 card_butt_part">
            <a class="btn btn-sm btn-dark" href="{{route('add.user')}}"><i class=" uil-plus "></i>  Add User</a>
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
</div>
<div class="card-body card_body">
    <table id="allTableInfo" class="table table-bordered table-striped table-hover dt-responsive nowrap w-100">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Photo</th>
                        <th>Manage</th>
                    </tr>
                </thead>


                <tbody>
                  @foreach($allUser as $data)
                    <tr>
                        <td>{{$data->name}}</td>
                        <td>{{$data->phone}}</td>
                        <td>{{$data->email}}</td>
                        <td>{{$data->roleInfo->role_name ?? ''}}</td>
                        <td>
                          @if($data->avatar!='')
                          <img class="img-thumbail rounded-circle" height="40" src="{{asset('uploads/users/'.$data->avatar)}}"/>
                          @else
                          <img class="img-thumbail rounded-circle" height="40" src="{{asset('uploads/avatar.png')}}"/>
                          @endif
                        </td>
                        <td>
                             <div class="btn-group">
                                <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Manage
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="user/view/{{$data->id}}"><i class=" uil-plus "></i> View</a>
                                    <a class="dropdown-item" href="user/edit/{{$data->id}}"><i class=" uil-comment-edit"></i> Edit</a>
                                    <a class="dropdown-item" href="{{route('changepassword',$data->id)}}"><i class=" uil-comment-edit"></i> Change Password</a>
                                </div>
                            </div>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

</div> <!-- end card body-->
<div class="card-footer card_footer">
       <div class="btn-group mb-2">
        <a href="#" class="btn btn-secondary">Print</a>
        <a href="#" class="btn btn-dark">PDF</a>
        <a href="#" class="btn btn-secondary">Excel</a>
    </div>
</div>
</div> <!-- end card -->
</div><!-- end col-->
</div>
@endsection
