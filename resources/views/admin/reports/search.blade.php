@extends('layouts.admin')
@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header card_header">
				<div class="row">
					<div class="col-md-8 tbl_text">
						<i class=" uil-user-exclamation "></i>Total Payment Summary
					</div>
				</div>
			</div>
			<div class="card-body card_body">
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
				<div class="row mb-2">
					<div class="col-md-11 tbl_text center">
						<i class=" uil-search-alt "></i> Advance Search
					</div>
					<form name="searchForm" method="get" action="{{route('advanced.search')}}">
						<div class="row g-2 mt-1">
							@php
								if(isset($_GET['keyword']))
								$keyword= $_GET['keyword'];
							@endphp
							<div class="mb-3 col-md-12">
								<input name="keyword" type="text" value="{{isset($keyword)?$keyword:''}}" class="form-control" placeholder="Search by Payment Ref. No., File ref. no, Guest name, Guest email or Tally ref. no.">
							</div>
						</div>
						<div class="row g-2 mb-3">
							@php
							if(isset($_GET['start']) && isset($_GET['end'])){
								$start=$_GET['start'];
								$end=$_GET['end'];
							}
							@endphp
							<div class="input-group">
								<label for="example-input-normal" class="form-label mt-1">Created between &nbsp; &nbsp; </label>
								<input name="start" type="date" value="{{isset($start)?$start:''}}" id="s-from" name="start" class="form-control" style="margin-right:10px;" onclick="this.showPicker()">
								<input name="end" type="date" value="{{isset($end)?$end:''}}" id="s-to"name="end" class="form-control" onclick="this.showPicker()">
							</div>
						</div>
						<div class="row g-2 mb-3">
							<div class="mb-6 col-md-6">
								@php
									$income_collector='';
									if(isset($_GET['income_collector']))
									$income_collector=$_GET['income_collector'];
									$alluser=\App\Models\User::where('status',1)->orderBy('name','ASC')->get();
								@endphp
								<select class="form-select" name="income_collector">
									<option value="">Select User</option>
									@foreach($alluser as $user)
									<option value="{{$user->id}}" <?php if($user->id==$income_collector){print 'selected';} ?> >{{$user->name}}</option>
									@endforeach
								</select>
							</div>
							<div class="mb-6 col-md-6">
								@php
									$income_status='';
									if(isset($_GET['income_status']))
									$income_status=$_GET['income_status'];
									$status = App\Helper::paymentStatus('all');
									$statusStr_arr = ['Expired/Cancelled','Pending/No action','Pending with Collector','Pending with Sales/OPR','Pending with accounts','Settled'];
								@endphp
								<select name="income_status" class="form-select">
									<option value="">Select Payment Status</option>
									@foreach($status as $key=>$val)
									<option value="{{$key}}" <?php if($key==$income_status){print 'selected';} ?> >{{$statusStr_arr[$key]}}</option>
									@endforeach
								</select>
							</div>
							@php
								if(isset($_GET['pendingsubmission']))
								$pendingsubmission= $_GET['pendingsubmission'];
								if(isset($_GET['pendingdays']))
								$pendingdays= $_GET['pendingdays'];
							@endphp
							{{-- <div class="mb-6 col-md-3">
								<input name="pendingsubmission" value="{{isset($pendingsubmission)?$pendingsubmission:''}}" type="text" class="form-control" placeholder="Pending Submission">
							</div>
							<div class="mb-6 col-md-3">
								<input name="pendingdays" type="text" value="{{isset($pendingdays)?$pendingdays:''}}" class="form-control" placeholder="Pending Days">
							</div> --}}
						</div>
						{{-- <div class="row g-2 mb-3">
							<div class="mb-6 col-md-4">
								@php
								$allCate=\App\Models\IncomeCategory::where('incate_status',1)->orderBy('incate_name','ASC')->get();
								@endphp
								<select name="payment_type" class="form-select">
									<option value="">Payment Against</option>
									@foreach($allCate as $cate)
									<option value="{{$cate->incate_id}}">{{$cate->incate_name}}</option>
									@endforeach
								</select>
							</div>
							<div class="mb-6 col-md-4">
								<select class="form-select" id="" name="income_receiver">
									<option value="">Receiver</option>
									@foreach($alluser as $user)
									<option value="{{$user->id}}">{{$user->name}}</option>
									@endforeach
								</select>
							</div>
							<div class="mb-6 col-md-4">
								@php
								$allCompany=\App\Models\Companyinfo::where('status',1)->orderBy('name','ASC')->get();
								@endphp
								<select class="form-select" id="" name="income_receiver">
									<option value="">Company</option>
									@foreach($allCompany as $company)
									<option value="{{$company->id}}">{{$company->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						--}}
						<div class="row g-2 mb-3">
							{{-- <div class="form-check form-switch col-md-3">
								<input type="checkbox" class="form-check-input" name="is_expired">
								<label class="form-check-label" for="customCheck11">Expired</label>
							</div> --}}
						</div>
						<div class="row g-2 mb-3">
							<div class="tbl_text center col-md-12">
								<a href="{{url('dashboard/income/report')}}" class="btn btn-danger
								"> Reset </a>
								<button type="submit" class="btn btn-primary">Search</button>
							</div>
						</div>
					</form>
					</div>
					<div class="row" style="overflow-x:scroll; width:100%;">
							<table id="allTableInfo" class="table table-bordered table-striped table-hover nowrap w-100 table-responsive-xl" >
								<thead class="table-dark">
									<tr>
										<th>S. No </th>
										<th>File Ref. No.</th>
										<th>Amount</th>
										<th>Collected Amount</th>
										<th>Collected By</th>
										<th>Sales</th>
										<th>OPR</th>
										<th>Accounts</th>
                                        <th>Collection Date</th>
                                        <th>No of Days</th>
                                        <th>Submission Days</th>
                                        <th>Pending Days</th>
                                        <th> Pending On</th>
									</tr>
								</thead>
								<tbody>
									@php
										$i=1;
									@endphp
									@if (count($RtottalIncome) > 0)
										@foreach($RtottalIncome as $income)
                                        @php
                                        extract($income);
                                        @endphp
                                            <tr>
                                                <td>{{$i}}</td>
                                                <td>
                                                    @if ($file_ref_no)
                                                    {{$file_ref_no}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($income_currency)
                                                        @php
                                                        $currency=App\helper::currenyType($income_currency);
                                                        echo $currencyIcon=App\helper::get_currency_symbol($currency->code);
                                                        @endphp
                                                        {{$income_amount}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                         echo $currencyIcon.' '; //SPACE
                                                    @endphp
                                                    @if (!empty($partial_amount))
                                                        {{$partial_amount}}
                                                    @else
                                                        {{$income_amount}}
                                                    @endif
                                                </td>

											    <td>
                                                    @if ($income_collector)
                                                    {{App\helper::userName($income_collector)}}
                                                    @endif
                                                </td>{{--  Collector Name --}}
											    <td>
                                                    @if ($income_receiver)
                                                    {{App\helper::userName($income_receiver)}}
                                                    @endif
                                                </td>{{--  Sales Name --}}
											    <td>
                                                    @if ($income_operation)
                                                    {{App\helper::userName($income_operation)}}
                                                    @endif
                                                </td>{{--  Collector Name --}}
											    <td>
                                                    @if ($account_receiver)
                                                    {{App\helper::userName($account_receiver)}}
                                                    @endif
                                                </td>{{--  Account Name --}}
                                                <td>
                                                    @if ($collected_date)
                                                        {{isset($collected_date)?$collected_date:$receive_date}}
                                                    @endif
                                                </td>{{-- collection date --}}

                                                <td>
                                                    @if ($setteled_days)
                                                    @php
                                                        echo $t_days=$collected_days+$receive_days+$approved_days+$setteled_days;
                                                    @endphp
                                                    @endif
                                                </td>{{-- No of  days --}}
                                                <td>
                                                    @if ($approved_days)
                                                    @php
                                                         echo $t_days=$collected_days+$receive_days+$approved_days;
                                                    @endphp
                                                    @endif
                                                </td>{{-- Submission Days  days --}}

                                                <td>
                                                    @php
                                                    if($income_status !== 5){
                                                        $daysdate=App\helper::PendingOn($income_id,$income_status);
                                                        // print_r($daysdate);
                                                        echo $daysdate['day'];
                                                    }
                                                    else{
                                                        echo 'NA';
                                                    }
                                                    @endphp
                                                </td>
                                                <td>
                                                    @if ($income_status==5)
                                                        @php
                                                            echo 'Payment settled';
                                                        @endphp
                                                    @else
                                                        @php
                                                              echo isset($daysdate['p_by'])?$daysdate['p_by']:'';
                                                        @endphp
                                                    @endif
                                                    </td>{{-- Pending On --}}
                                            </tr>
										    @php $i++; @endphp
										@endforeach
									@else
										<tr>
											<td></td>
										<p class="text-danger">No data Found</p>
										</tr>
									    @endif
									<tfoot class="table-dark">
									<tr>
										<td></td>
										<td></td>
										{{-- <td>{{number_format($TottalIncome,2)}}</td> --}}
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									</tfoot>
								</tbody>
							</table>
					</div>
			</div> <!-- end card body-->
			<div class="card-footer card_footer d-print-none">
				<div class="btn-group mb-2">
					<a href="#" class="btn btn-secondary" onclick="window.print()">Print</a>
					<a href="{{url('dashboard/income/pdf')}}" class="btn btn-dark">PDF</a>
					<a href="{{url('dashboard/income/export')}}" class="btn btn-secondary">Excel</a>
				</div>
			</div>
		</div> <!-- end card -->
	</div><!-- end col-->
</div>

<!-- softdelete part -->
<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
	 <div class="modal-dialog">
			 <div class="modal-content">
				 <form method="post" action="{{url('dashboard/income/softdelete')}}">
					 @csrf
					 <div class="modal-header">
							 <h4 class="modal-title" id="standard-modalLabel">Confirm  Message</h4>
					 </div>
					 <div class="modal-body modal_body">
						 <input type="hidden" name="modal_id" id="modal_id" value=""/>
							 Are You Want To Sure Delete?
					 </div>
					 <div class="modal-footer">
							 <button type="submit" class="btn btn-danger">Confirm</button>
							 <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>

					 </div>
			 </div><!-- /.modal-content -->
		 </form>
	 </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
