@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header card_header">
                <div class="row">
                    <div class="col-md-8 tbl_text">
                    <i class=" uil-cog "></i> System Logs Details
                    </div>
                </div>
            </div>
            <div class="card-body card_body" style="overflow-x: auto;">
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
                <table id="allTableInfo" class="table table-bordered table-striped table-hover w-100" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            {{-- <th> Action ID </th> --}}
                            {{-- <th> User ID </th> --}}
                            {{-- <th> User IP </th> --}}
                            <th> Title </th>
                            <th> Action </th>
                            <th> Who </th>
                            <th> User IP </th>
                            <th> Action Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $data)
                        <tr>
                            {{-- <td style="width:10%">{{$data->action_id}}</td> --}}
                            {{-- <td>{{$data->user_id}}</td>
                            <td>{{$data->user_ip}}</td> --}}
                            <td style="width:20%" >{{$data->title}}</td>
                            <td style="width:60%">{{$data->action}}</td>
                            <td style="width:60%">{{$currency=App\helper::userName($data->user_id)}}</td>
                            <td style="width:60%">{{$data->user_ip}}</td>
                            @php
                                $dateflow = $data->created_at;
								$dateflow= date_create($dateflow);
								$time = date_format($dateflow,"d/m/Y h:i A");
                            @endphp
                            <td>{{$time}}</td>

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
