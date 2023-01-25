@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header card_header">
                <div class="row">
                    <div class="col-md-6 tbl_text">
                    <i class=" uil-user-exclamation "></i> Currencies
                    </div>
                    <div class="col-md-6 card_butt_part">
                        <a class="btn btn-sm btn-dark" href="{{url('dashboard/currency/add')}}"><i class=" uil-plus "></i>  Add New</a>
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
                            <th> Currency Name </th>
                            <th> Rate </th>
                            <th> Symbol </th>
                            <th> Code </th>
                            <th> Status </th>
                            <th> Manage </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allcurrency as $data)
                        <tr>
                            <td>{{$data->title}}</td>
                            <td>{{$data->rate}}</td>
                            <td>
                                <b>
                                    @php
                                        echo $currencyIcon=App\helper::get_currency_symbol($data->code);
                                    @endphp
                                    </b>
                                {{$data->code}}
                            </td>
                            <td>{{$data->status==1 ? 'Active':'Inactive'}}</td>
                            <td>
                                <div class="">
                                    <a class="btn btn-dark" href="{{route('currency.rate',$data->id)}}"><i class=" uil-plus "></i>Update Currency Rate </a>
                                    <a class="btn btn-dark" href="{{url('dashboard/currency/edit/'.$data->id)}}"><i class=" uil-comment-edit"></i> Edit</a>
                                    <a class="btn btn-dark" href="{{url('dashboard/currency/delete/'.$data->id)}}" id="softDelete" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{$data->id}}"><i class=" uil-trash "></i> Delete</a>
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
