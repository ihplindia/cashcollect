@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header card_header">
                <div class="row">
                    <div class="col-md-6 tbl_text">
                    <i class=" uil-building "></i> Company Details
                    </div>
                    <div class="col-md-6 card_butt_part">
                        <a class="btn btn-sm btn-dark" href="{{route('add.company')}}"><i class=" uil-plus "></i>  Add New Company</a>
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
                            <th> Company Name </th>
                            <th> Status</th>
                            <th> Manage </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($company as $data)
                           
                            <td>{{$data->name}}</td>
                            <td>{{$data->status == 1 ? 'Active':'Inactive'}}</td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-dark " href="{{route('edit.company',$data->id)}}"><i class=" uil-comment-edit"></i> Edit</a>
                                </div>
                            
                                <div class="btn-group">
                                    <a class="btn btn-dark " href="{{route('branch',$data->id)}}"><i class=" uil-comment-edit"></i> Branchs </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<!-- softdelete part -->
<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
            <div class="modal-content">
            <form method="post" action="{{url('dashboard/permission/permissiongroup/delete')}}">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Confirm  Message</h4>
                </div>
                <div class="modal-body modal_body">
                    <input type="hidden" name="modal_id" id="modal_id" value=""/>
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