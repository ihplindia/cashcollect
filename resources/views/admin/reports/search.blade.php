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
					<div class="col-md-1 tbl_text right">
						<i class=" uil-times-square " style="cursor:pointer; font-size:20px;" id="searchCloseIcon"></i>
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
								@endphp
								<select name="income_status" class="form-select">
									<option value="">Select Status</option>
									@foreach($status as $key=>$val)
									<option value="{{$key}}" <?php if($key==$income_status){print 'selected';} ?>>{{$val}}</option>
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
					<table id="allTableInfo" class="table table-bordered table-striped table-hover nowrap w-100">
					<thead class="table-dark">
						<tr>
							<th>S. No </th>
							<th>File Ref. No.</th>
							<th>Amount</th>
							<th>Sales</th>
							<th>OPR</th>
							<th>Collected By</th>
							<th>Status</th>
							<th>Last Updated date</th>
							<th> No of days</th>
						</tr>
					</thead>
					<tbody>
						@php
							$i=1;
						@endphp
						@if (count($RtottalIncome))
							@foreach($RtottalIncome as $income)
							<tr>
								@php
									$l='';
									if($income->income_status==0)
									{
										$l='text-danger';
									}
								@endphp
								<td>{{$i}}</td>
								{{-- <td>{{date('Y-m-d', strtotime($income->income_date))}}</td> --}}
								<td><a style="color:gray" href="{{url('dashboard/income/view/'.bin2hex($income->income_ref_no))}}">{{$income->file_ref_no}}</a></td>
								@php
								$currency=App\helper::currenyType($income->income_currency);
                                // {{$currency->title}} name

                                @endphp
							<td>
                                <b>
                                    @php
                                    echo $currencyIcon=App\helper::get_currency_symbol($currency->code);
                                    @endphp
                                    </b>
                                     {{App\Helper::setNumbur($income->income_amount)}}
                             </td>
								{{-- <td>{{App\helper::currenyType($income->income_currency)}} {{$income->income_amount}}</td> --}}
								{{-- <td>{{ $income->currency->title}}  </td> --}}
								<td>{{App\helper::userName($income->income_receiver)}}</td> {{--  Receiver Name --}}
								<td>{{App\helper::userName($income->income_operation)}}</td>{{--  Operation Name --}}
								<td>{{App\helper::userName($income->income_collector)}}</td>{{--  Collector Name --}}
								<td class="{{$l}}">{{$status = App\Helper::paymentStatus($income->income_status)}} </td>
								<td>{{date('d-m-Y',strtotime($income->updated_at))}}</td>
								<td>
									@php
										// Count no of days between created date and last updated date
										$date1=date_create($income->updated_at);
										$date2=date_create($income->created_at);
										$diff=date_diff($date1,$date2);
										// echo $diff->format("%a");
										echo '<b>'.$diff->format("%a days").'</b>';
										// echo $income->updated_at;
									@endphp
								</td>
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
						</tr>
						</tfoot>
					</tbody>
				</table>

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
