@extends('layouts.admin')
@section('content')

@php
    $user = Auth::user()->id;
	$collector = $data->income_collector;
	$receiver = $data->income_receiver;
	$account = $data->account_receiver;
	$income_status = $data->income_status;
	$trans = $data->transaction_status;
	$show = $data->qrcode;
	$array = array (
		'income_ref_no' => $data->income_ref_no ,
		'id' => $data->income_id ,
		'income_status' => $data->income_status ,
		'guest' => $data->guest_name ,
		'user' => $user
	);
	$array = App\Helper::encode_arr($array);
	//$cid=App\Helper::company_Id($data->income_collector);


@endphp

<style type="text/css">
	.timeing{ font-size:0.8rem; }
</style>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header card_header">
				<div class="row">
					<div class="col-md-8 tbl_text">
						<i class=" uil-user-exclamation"></i> View Payment Information
					</div>
					<div class="col-md-4 card_butt_part">
						<a class="btn btn-sm btn-dark" href="{{url('dashboard/income')}}"><i class=" uil-users-alt "></i> All Payment</a>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-3"></div>
					<div class="col-6">
						@if(Session::has('success'))
						<div class="alert alert-success alertsuccess" role="alert">
							{{session::get('success')}}
						</div>
						@endif
						@if(Session::has('error'))
						<div class="alert alert-danger alerterror" role="alert">
							{{session::get('error')}}
						</div>
						@endif
					</div>
					<div class="col-3"></div>
				</div>
		        <table class="table table-bordered table-striped mt-4">
					<div>
						@if ($errors->any())
							@foreach ($errors->all() as $error)
								<div class="text-danger ">{{$error}}</div>
							@endforeach
						@endif
					</div>
					<tr>
						<th colspan="2">Payment Ref No. </th>
						<td>{{$data->income_ref_no}} </td>
					</tr>
					<tr>
						<th colspan="2">File Ref No.</th>
						<td>{{$data->file_ref_no}} </td>
					</tr>
					<tr>
						<th colspan="2">Payment Date</th>
						<td>{{$data->income_date}} </td>
					</tr>
					<tr>
						<th colspan="2"> Amount</th>
						<td>{{ $data->currency->title}} {{$data->income_amount }} </td>
					</tr>
                    @if ($data->tally_ref_no)
					<tr>
						<th colspan="2">Tally Ref. No.</th>
						<td>{{$data->tally_ref_no}}</td>
					</tr>
					@endif
                    <tr>
						<th colspan="2">Guest Name </th>
						<td>{{$data->guest_name}} </td>
					</tr>
					<tr>
						<th colspan="2">Guest Email </th>
						<td>{{$data->guest_email}} </td>
					</tr>
					<tr>
						<th colspan="2">Payment Category</th>
						<td>{{$data->category->incate_name}} </td>
					</tr>
					@if($data->collection_amount)
					<tr>
						<th colspan="2">Collection Amount</th>
						<td>{{$data->collection_amount }} {{ $data->currency->title}} </td>
					</tr>
                    @endif
                    @if($data->amountremarks)
					<tr>
						<th colspan="2">Collector Remarks</th>
						<td>{{$data->amountremarks }}</td>
					</tr>
					@endif
					@if(isset($data->partial_amount))
					<tr>
						<th colspan="2">Partial Amount</th>
						<td>{{$data->partial_amount}} {{ $data->currency->title}}</td>
					</tr>
					<tr>
						<th colspan="2">Partial Remarks</th>
						<td>{{$data->partial_remarks}}</td>
					</tr>
					@endif
					<tr>
						<th colspan="2"> Collector Name</th>
						<td>{{isset($data->user->name)?$data->user->name:'Vendor Payments'}} </td>
					</tr>
					<tr>
						<th colspan="2">Payment Status</th>
						<td>{{$status = App\Helper::paymentStatus($data->income_status)}} </td>
					</tr>

					{{-- Collection amount --}}
					@if( $user == $collector && $data->income_status == 1 && $trans == 0 && $show == 0 )
						<tr>
							<th colspan="2"> Collection Amount <span class="req_star">*</span></th>
							<td>
								<form method="post" action="{{route('collector.collect')}}" enctype="multipart/form-data" onsubmit="return validateForm(this)">
									@csrf
									<input type="hidden" name="income_id" value={{$data->income_id}}>
                                    <input type="hidden" name="collected_days" value={{$data->created_at}}>
									<input type="hidden" name="self" value="{{$user==$receiver?'self':''}}">
									<input type="hidden" name="income_status" value={{$data->income_status}}>
									<input type="hidden" name="income_ref_no" value={{$data->income_ref_no}}>
									<input type="hidden" name="guest_name" value={{$data->guest_name}}>
								<div>
									<input type="radio" name="is_partial" class="m-2" value="0" onclick="toggleDiv('partial','hide');" required> Full Amount
									<input type="radio" name="is_partial" class="m-2" value="1" onclick="toggleDiv('partial,partial_r','show');" required> Partial Amount
								</div>
							</td>
						</tr>
						<tr id="partial" style="display: none;">
							<th colspan="2">Collection Details <span class="req_star">*</span> </th>
							<td>
								<div class="col-xs-1" >
									<input type="text" name="partial_amount" class="form-control " placeholder="Collection Amount" >
									{{-- <textarea class="form-control mt-1" name="partial_remarks" placeholder="Collection Remarks"></textarea> --}}
								</div>
							</td>
						</tr>
                        <tr>
							<th colspan="2">Remarks <span class="req_star">*</span> </th>
							<td>
								<div class="col-xs-1" >
									<textarea class="form-control mt-1" name="partial_remarks" placeholder="Collection Remarks" required></textarea>
								</div>
							</td>
						</tr>
					@endif
					{{-- Accountent Update the tally Refrence Numbar --}}
					@if($user == $account && $data->income_status == 4 )
					<tr>
						<form method="get" action="{{route('income.settled')}}" >
							@csrf
						<th colspan="2"> Payment Settled <span class="req_star">*</span> </th>
						<td>
							<div class="mt-2">
								<input type="hidden" name="vendor" value="1" >
								<input type="radio" name="income_settled_type" value="0" {{isset($data->income_settled_type)?$data->income_settled_type == 0 ? 'checked':'':''}}> Payment settled by cash
								&nbsp; &nbsp; &nbsp;
								<input type="radio" name="income_settled_type" value="1" {{isset($data->income_settled_type)?$data->income_settled_type == 1 ? 'checked':'':''}}> Payment is adjusted  &nbsp; &nbsp; &nbsp;

							 </div>
						</td>
					</tr>
					<tr>
						<th colspan="2">Remarks <span class="req_star">*</span> </th>
						<td>
							<div class="col-xs-1">
								<input type="text" placeholder="Payments Settled Remarks" class="form-control" value="{{isset($data->income_remarks)?$data->income_remarks:''}}" name="income_remarks" required >
							</div>
						</td>
					</tr>
					<tr>
						<th colspan="2"> Tally Ref. No. <span class="req_star">*</span></th>
						<td>
							<div class="col-xs-1">
								<input type="hidden" name="income_id" value={{$data->income_id}}>
								<input type="hidden" name="income_status" value={{$data->income_status}}>
								<input type="hidden" name="income_ref_no" value={{$data->income_ref_no}}>
								<input type="text" placeholder="Tally Reference Number" class="form-control" value="{{isset($data->tally_ref_no)?$data->tally_ref_no:''}}" name="tally_ref_no" required >
							</div>
						</td>
					</tr>

					@endif
					{{--Vendor Payments Attchment income file --}}
					@if( $income_status == 1 && $user == $receiver && $data->collection_type == 1 )
                        <form method="post" action="{{route('income.attchment')}}" enctype="multipart/form-data" >
                        @csrf
					<tr>
						<th colspan="2"> Upload File </th>
						<td>
							<div class="col-xs-1">
								<input type="hidden" name="income_id" value={{$data->income_id}}>
								<input type="hidden" name="income_ref_no" value={{$data->income_ref_no}}>
                                <input type="hidden" name="created_at" value={{$data->created_at}}>
								<input type="hidden" name="income_status" value={{$data->income_status}}>
								<input type="file" name="attachment">
								@if ($errors->has('attachment'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('attachment') }}</strong>
								</span>
								@endif
							</div>
						</td>
					</tr>
                    <tr>
                        <th colspan="2">Remarks</th>
                        <td><input type="text" name="vendor_remarks" id="" required></td>
                    </tr>
					@endif

						@if (!empty($data->income_file))
					<tr>
						<th colspan="2"> Attchment </th>
						<td>
							<a href="{{asset('uploads/payments/'.$data->income_file)}}" target="_blank" rel="noopener noreferrer"> {{$data->income_file}} </a>
						</td>
					</tr>
						@endif
				</table>
					<div class="col-12 center">
						@php
							$user = Auth::user()->id;
							$collector = $data->income_collector;
							$receiver = $data->income_receiver;
							$opr = $data->income_operation;
							$account = $data->account_receiver;
							$status = $data->income_status;
							$trans = $data->transaction_status;
							$show = $data->qrcode;
							$vendor_payment = $data->collection_type;
							$self = App\Helper::checkConditation($collector,$receiver, $true ='self' ,$false ='');
							$receiver = App\Helper::checkConditation($user,$receiver, $receiver ,$opr);
							$array = array (
								'income_ref_no' => $data->income_ref_no ,
								'id' => $data->income_id ,
								'income_status' => $data->income_status ,
								'guest' 	=> $data->guest_name ,
								'user' 		=> $user,
								'self'		=> $self,
								'vendor'	=> $vendor_payment,
                                'collected_date'=>$data->collected_date,
                                'receive_date'=>$data->receive_date
							);
							$array = App\Helper::encode_arr($array);
						@endphp
						{{-- If collector is Vendor    --}}
						@if( $income_status == 1 && $user == $receiver && $vendor_payment == 1 )
						@php echo "<strong>  Receive vendor payment with attchment</strong>" ; @endphp<br><br>
							<button type="submit" class="btn btn-md btn-dark" > Receive  </button>
						</form>
						{{-- <a class="btn btn-dark d-print-none" href="{{route('receiver.accept',$array)}}"> Accept </a> --}}
						{{-- Collect Button --}}
						@elseif( $user == $collector && $status == 1 && $trans == 0 && $show == 0 )
							<button type="submit" class="btn btn-md btn-dark"> Collect </button>
							</form>
							{{-- <a class="btn btn-dark d-print-none" href="{{route('collector.collect',$array)}}"> Collect</a>  --}}
						@elseif( $receiver == $collector && $status == 2 && $trans == 0 && $show == 0 )
							@php echo "<strong> Payment deposite to OPR/Sales Department  </strong>" ; @endphp<br><br>
							<a class="btn btn-dark d-print-none" href="{{route('collector.deposit',$array)}}">Deposit</a>
							{{-- Collector Deposite Button --}}
						@elseif( $user == $collector && $status == 2 && $trans == 0 && $show == 0 )
							@php echo "<strong> Payment Deposite to Sales or Opr  </strong>" ; @endphp
							<br><br>
							<a class="btn btn-dark d-print-none" href="{{route('collector.deposit',$array)}}">Deposit</a>
							{{-- 	Recever  Shos the QrCode	 --}}
						@elseif( $user == $receiver && $status == 2 && $trans == 0 && $show == 1 )
							@php echo "<strong> Show the QrCode for Collector scan code and send payment </strong>" ; @endphp
							<br><br>
							<a class="btn btn-dark d-print-none" href="#" id="qrcode" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{$data->income_id}}"><i class=" uil-capture "></i> QrCode</a>
							{{-- Receiver Payment  Accept Payment Button --}}
						@elseif( $user == $receiver && $status == 2 && $trans == 1 && $show == 0 )
							@php echo "<strong> Collection Amount Recieve  </strong>" ; @endphp <br><br>
							<a class="btn btn-dark d-print-none" href="{{route('receiver.accept',$array)}}">Accept</a>
							{{-- Receiver Deposite Button --}}
						@elseif( $user == $receiver && $status == 3 && $trans == 0 && $show == 0)
							@php echo "<strong> Payment Deposite to Account  </strong>" ; @endphp
							<br><br>
							<a class="btn btn-dark d-print-none" href="{{route('collector.deposit',$array)}}">Deposit</a>
							{{--	Account Show the QrCode	 --}}
						@elseif( Auth::user()->admin_view == 2 && $status == 3 && $show == 1 && $trans == 0 )
							@php echo "<strong> Click the Qrcode button  </strong>" ; @endphp<br><br>
							<a class="btn btn-dark d-print-none" href="#" id="qrcode" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{$data->income_id}}"><i class=" uil-capture "></i> QrCode </a>
							{{-- Account Payment Accept Button --}}
						@elseif( Auth::user()->admin_view == 2 && $status == 3 && $trans == 1 && $show == 0 )
							<a class="btn btn-dark d-print-none" href="{{route('receiver.accept',$array)}}">Accept</a>
							{{-- Income Settled Button	--}}
						@elseif($user == $account && $status == 4 )
							<button type="submit" class="btn btn-md btn-dark"> Settled </button>
							</form>
						@endif
					</div>

					{{-- Income History  --}}
					<table width="100%" class="table table-bordered mt-5">
						@php
							$paymenthistory = App\Helper::IncomeHistory($data->income_id);
							// $paymenthistory = App\Helper::checkuser($user);
							$i=1;
						@endphp
						<thead class="thead-dark">
							<tr>
								<th> Action log </th>
							</tr>
						</thead>
						@foreach ($paymenthistory as $history)
							@php
								$dateflow = $history->created_at;
								$dateflow= date_create($dateflow);
								$time = date_format($dateflow,"d/m/Y h:i A");

							@endphp
						<tbody>
							<tr>
								<td>{{$history->details}}
									<span class="timeing" style="float:right;">{{$time}}</span>
								</td>
							</tr>
						</tbody>

						@endforeach
					</table>
				</div>

			 <!-- end card body-->
			<div class="card-body card_body">
				<div class="row">

				</div>
			</div> <!-- end card body-->

			<div class="card-footer card_footer">
				<div class="btn-group mb-2">
					<a href="#" class="btn btn-secondary" onclick="window.print()">Print</a>
					{{-- <a href="#" class="btn btn-dark">PDF</a>
					<a href="#" class="btn btn-secondary">Excel</a> --}}
				</div>
			</div>
		</div> <!-- end card -->
	</div><!-- end col-->
</div>

<script>
	function validateForm(frm)
	{
		if(frm.is_partial.value==1)
		{
			if(frm.partial_amount.value=='')
			{
				alert('Please enter partial collected amount');
				return false;
			}
			if(frm.partial_remarks.value=='')
			{
				alert('Please enter partial collection remarks');
				return false;
			}
		}
		// return false;
	}
</script>
<!-- qrcode part -->
<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
	   <div class="modal-content">

			<div class="modal-header">
				<h4 class="modal-title" id="standard-modalLabel">Scan QrCode </h4>
			</div>
			<div class="modal-body modal_body">
			<div class="col-12 center">
				{{ QrCode::size(250)->generate('https://cash.indianholiday.com/qrcode/scan/'.bin2hex($data->income_ref_no).'/'.$user) }}
				{{-- {{ QrCode::size(250)->generate('pradeep/cashcollectrole/qrcode/scan/'.bin2hex($data->income_ref_no).'/'.$user) }} --}}
			</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			</div>
	   </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
