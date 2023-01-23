@extends('layouts.admin')
@section('content')

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header card_header">
				<div class="row">
					<div class="col-md-8 tbl_text">
						<i class=" uil-user-exclamation "></i> View Income Information
					</div>
					<div class="col-md-4 card_butt_part">
						<a class="btn btn-sm btn-dark" href="{{url('dashboard/income')}}"><i class=" uil-users-alt "></i> All Income</a>
					</div>
				</div>
			</div>
			<div class="card-body card_body">
				<div class="row">
					<div class="col-2">
						<div class="card">
						</div>

					</div>
					<div class="col-8">
						<table class="table table-bordered table-striped custom_view_table">
							<tr>
								<td>Income Date<td>
								{{-- <td>:</td> --}}:
								<td>{{$data->income_date}} </td>
							</tr>
							<tr>
								<td>Guest Name<td>
								{{-- <td>:</td> --}}:
								<td>{{$data->guest_name}} </td>
							</tr>
							<tr>
								<td>Income Category<td>
								{{-- <td>:</td> --}}:
								<td>{{$data->category->incate_name}} </td>
							</tr>
							<tr>
								<td>Income Amount<td>
								{{-- <td>:</td> --}}:
								<td>{{$data->income_amount}} </td>
							</tr>
							<tr>
								<td>Income Status<td>
								{{-- <td>:</td> --}}:
								<td>{{$data->income_status}} </td>
							</tr>
						</table>
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

<div class="container">
	
	
	<button type="button" class="btn btn-primary " data-toggle="modal" data-target="#myModal">
	  Open modal
	</button>
  
	<!-- The Modal -->
	<div class="modal fade" id="myModal">
	  	<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
				<h4 class="modal-title">Scan Qrcode</h4>
				
				<button type="button" class="close" data-dismiss="modal"><a href="http://127.0.0.1:8000/dashboard/income">Back</a> </button>
				</div>
				
				<!-- Modal body -->
				<div class="modal-body">
					<div class="col-12 center">
						{{ QrCode::size(200)->generate('http://127.0.0.1:8000/qrcode/scan/'.bin2hex($data->income_ref_no)) }}
					</div>
					@php
						$userid = Auth::user()->id;
						$account = $data->account_receiver;
						$incomeReceiver = $data->income_receiver;                        
						$status = $data->income_status;
					@endphp
					<div class="col-12 center mt-3">
						@if($userid == $incomeReceiver)
							<a class="btn btn-dark d-print-none" href="{{url('dashboard/income/collectorReceiver/'.$data->income_ref_no)}}">Accept</a>
							
						@endif
							<a class="btn btn-dark d-print-none" href="{{url('dashboard/income/collectorAccount/'.$data->income_ref_no)}}">Accept</a>
					</div>
				</div>
			</div>
	  	</div>
	</div>
	
  </div>
@endsection
