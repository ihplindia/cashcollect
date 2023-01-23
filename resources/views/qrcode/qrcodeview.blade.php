@extends('layouts.admin')
@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header card_header">
				<div class="row">
					<div class="col-md-8 tbl_text">
						<i class=" uil-user-exclamation "></i> Send Payment
					</div>
					<div class="col-md-4 card_butt_part">
						{{-- <a class="btn btn-sm btn-dark" href="{{url('dashboard/income')}}"><i class=" uil-users-alt "></i> Income Details </a> --}}
					</div>
				</div>
			</div>
			<div class="card-body card_body">
				
				<div class="row">
					<div class="col-md-12 mt-4">
						<table width="100%" class="table table-bordered table-striped custom_view_table">
							<tr>
								<td>Payment Ref No.
							    <td>{{$data->income_ref_no}} </td>
							</tr>
							<tr>
								<td>File Ref No.
								<td>{{$data->file_ref_no}} </td>
							</tr>
							<tr>
								<td>Payment Date
							    <td>{{$data->income_date}} </td>
							</tr>
							<tr>
								<td>Guest Name 
							    <td>{{$data->guest_name}} </td>
							</tr>
							<tr>
								<td>Payment Category
							    <td>{{$data->category->incate_name}} </td>
							</tr>
							<tr>
								<td>Payment Amount
							    <td>{{$data->income_amount}} </td>
							</tr>
							<tr>
								<td>Payment Receiver
							    <td>{{$receiver->name}} </td>
							</tr>
							<tr>
								<td>Payment Sender
							    <td>{{isset(Auth::user()->name)?Auth::user()->name:''}} </td>
							</tr>
						</table>
					</div>
					<div class="col-2"></div>
					<div class="col-12 center">
						@php
							$user = Auth::user()->id;
							$collector = $data->income_collector;							
							$account = $data->account_receiver;
							$status = $data->income_status;
							$show = $data->qrcode;
							$array = array (
								'income_ref_no' => $data->income_ref_no ,
								'id' => $data->income_id ,
								'income_status' => $data->income_status ,
								'user' => $user,
								'receiver' =>$receiver->name
							);
						$array =App\Helper::encode_arr($array);
						@endphp
						@if($show == 1 )
						{{-- Payment Send Button --}}
							<a class="btn btn-dark d-print-none" href="{{route('paidPayment',$array)}}"> Send </a>
						@endif
					</div>
				</div>
			</div> <!-- end card body-->

			<div class="card-body card_body">
				<div class="row">
					
				</div>
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
