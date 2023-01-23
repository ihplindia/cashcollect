@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header card_header">
                <div class="row">
                    <div class="col-md-8 tbl_text">
                       <i class=" uil-user-exclamation "></i>  View Income Information
                    </div>
                    <div class="col-md-4 card_butt_part">
                        <a class="btn btn-sm btn-dark" href="{{url('dashboard/report/summary')}}"><i class=" uil-users-alt "></i>  Report</a>
                    </div>
                </div>
            
            </div>
            <div class="card-body card_body">
                <div class="row">
                    <div class="col-2"></div>
                      <div class="col-8 mt-5">
                         <table class="table table-bordered table-striped custom_view_table">
                            {{-- <tr>
                                 {{print_r($alldata)}}
                                {{die;}}
                                <td colspan="3" class="text-center">
                                @if($data->photo!='')
                                <img class="img-thumbail" height="150" src="{{asset('uploads/users/'.$data->photo)}}"/>
                                @else
                                <img class="img-thumbail" height="150" src="{{asset('uploads/avatar.png')}}"/>
                                @endif
                                </td>
                            </tr> --}}
                            <tr>
                                <td>Income Ref No.</td>
                                <td>:</td>
                                <td>{{$alldata->income_ref_no}}</td>
                             </tr>
                            <tr>
                              <td>Guest Name</td>
                              <td>:</td>
                              <td>{{$alldata->guest_name}}</td>
                             </tr> 
                             <tr>
                              <td>Email</td>
                              <td>:</td>
                              <td>{{$alldata->guest_email}}</td>
                             </tr> 
                             <tr>
                              <td>Phone</td>
                              <td>:</td>
                              <td>{{$alldata->guest_phone}}</td>
                             </tr> 
                             <tr>
                                <td>Title</td>
                                <td>:</td>
                                <td>{{$alldata->ncome_title}}</td>
                             </tr>
                             
                             <tr>
                                <td>Date</td>
                                <td>:</td>
                                <td>{{date('d-m-Y', strtotime($alldata->created_at))}}</td>
                             </tr>
                             <tr>
                                <td>Amount</td>
                                <td>:</td>
                                <td>{{$alldata->income_amount}}</td>
                             </tr>
                             <tr>
                                <td>Status</td>
                                <td>:</td>
                                <td>{{$alldata->income_status}}</td>
                             </tr>
                         </table>
                      </div>
                    <div class="col-2"></div>
                </div>
            </div> <!-- end card body-->
            {{-- <div class="card-footer center">
                <a class="btn btn-md btn-dark" href="{{url('dashboard/user')}}/edit/{{$alldata->income_id}}">EDIT</a>
            </div> --}}
            <div class="card-footer card_footer">
                   <div class="btn-group mb-2">
                    <a href="#" class="btn btn-secondary"  onclick="window.print()">Print</a>
                    {{-- <a href="" class="btn btn-dark">PDF</a>
                    <a href="#" class="btn btn-secondary">Excel</a> --}}
                </div>
            </div>
            
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
@endsection