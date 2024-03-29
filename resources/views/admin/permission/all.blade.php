@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header card_header">
                <div class="row">
                    <div class="col-md-8 tbl_text">
                    <i class=" uil-user-exclamation "></i>  All Permission
                    </div>
                    <div class="col-md-4 card_butt_part">
                        <a class="btn btn-sm btn-dark" href="{{url('dashboard/permission/add')}}"><i class=" uil-plus "></i>  Add Permission</a>
                    </div>
                </div>
            </div>    
            <div class="card-body card_body">          
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
                
                <table id="allTableInfo" class="table table-bordered table-striped table-hover dt-responsive nowrap w-100">
                    <thead class="table-dark">
                        <tr>
                            <th> Group Name </th>
                            <th> Name </th>
                            <th> URL </th>
                            <th>Status</th>
                            <th>Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allpermission as $data)
                        <tr>
                            @php
                            $all=App\Models\PermissionGroup::where('id',$data->group_name)->orderBy('id','ASC')->get();
                            @endphp
                                @foreach($all as $graouppermission)
                            <td>{{ $graouppermission->group_name}}</td>
                           
                            @endforeach
                            <td>{{$data->name}}</td>
                            <td>{{$data->guard_name}}</td>
                            <td>{{$data->status==1?'Active':'Inactive'}}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Manage
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#"><i class=" uil-plus "></i> View</a>
                                        <a class="dropdown-item" href="{{url('dashboard/permission/edit/'.$data->id)}}"><i class=" uil-comment-edit"></i> Edit</a>
                                        <a class="dropdown-item" href="#" id="softDelete" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{$data->id}}"><i class=" uil-trash "></i> Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div> <!-- end card body-->
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

<!-- softdelete part -->
<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
	 <div class="modal-dialog">
			<div class="modal-content">
				<form method="post" action="{{route('delete.permission')}}">
                    @csrf
                    
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Confirm  Message</h4>
                    </div>
                    <div class="modal-body modal_body">
                        <input type="hidden" name="id" value="{{$data->id}}">
                        Sure!! Do you want to sure Delete?
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Confirm</button>
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
                    </div>
		        </form>
			</div><!-- /.modal-content -->
	 </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection