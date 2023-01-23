@extends('layouts.admin')
@section('content')

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header card_header">
				<div class="row">
					<div class="col-md-4 tbl_text">
						<i class="uil-rupee"></i> All Payment
					</div>
					<div class="col-md-8 card_butt_part">
						@if (( Auth::user()->admin_view < 4))
						<a class="btn btn-sm btn-dark d-print-none" href="{{route('add')}}"><i class=" uil-plus "></i> Add Payment</a>
						@endif
						<!-- <a class="btn btn-sm btn-dark d-print-none" href="#" id="Search" ><i class=" uil-search "></i> Advance Search</a> -->
					</div>

				</div>
			</div>
			<div class="card-body d-none" id="searchBox">
				<div class="row">
					<div class="col-md-11 tbl_text center">
						<i class=" uil-search-alt "></i> Advance Search
					</div>
					<div class="col-md-1 tbl_text right">
						<i class=" uil-times-square " style="cursor:pointer; font-size:20px;" id="searchCloseIcon"></i>
					</div>
					<form name="searchForm" method="GET" action="report/search">
						<div class="row g-2 mt-1">
							<div class="mb-3 col-md-12">
								<input name="keyword" type="text" class="form-control" placeholder="Search by Payment Ref. No., File ref. no, Guest name, Guest email or Tally ref. no.">
							</div>
						</div>

						<div class="row g-2 mb-3">
							<div class="input-group">
								<label for="example-input-normal" class="form-label mt-1">Created between &nbsp; &nbsp; </label>
								<input name="start" type="date" id="s-from" name="start" class="form-control" style="margin-right:10px;" onclick="this.showPicker()">
								<input name="end" type="date" id="s-to"name="end" class="form-control" onclick="this.showPicker()">
							</div>
						</div>
						<div class="row g-2 mb-3">
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
								@php
									$status = App\Helper::paymentStatus('all');
								@endphp
								<select name="payment_status" class="form-select">
									<option value="">Payment Status</option>
									@foreach($status as $key=>$val)
									<option value="{{$key}}">{{$val}}</option>
									@endforeach
								</select>
							</div>
							<div class="mb-6 col-md-4">
								@php
								$allCurrency = \App\Models\Currency::where('status',1)->orderBy('title','ASC')->get();
								@endphp
								<select name="currency_type" class="form-select">
									<option value="">Currency Type</option>
									@foreach($allCurrency as $curr)
									<option value="{{$curr->id}}">{{$curr->title}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="row g-2 mb-3">
							<div class="mb-6 col-md-4">
								@php
								$alluser=\App\Models\User::where('status',1)->orderBy('name','ASC')->get();
								@endphp
								<select class="form-select" id="" name="income_collector">
									<option value="">Collector</option>
									@foreach($alluser as $user)
									<option value="{{$user->id}}">{{$user->name}}</option>
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

						<div class="row g-2 mb-3">
							<div class="form-check form-switch col-md-3">
								<input type="checkbox" class="form-check-input" name="is_expired">
								<label class="form-check-label" for="customCheck11">Expired</label>
							</div>
						</div>

						<div class="row g-2 mb-3">
							<div class="tbl_text center col-md-12">
								<button type="submit" class="btn btn-primary">Search</button>
							</div>
						</div>
					</form>

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
				<table id="allTableInfo" class="table table-bordered table-striped table-hover dt-responsive nowrap w-100">
					<thead class="table-dark">
						<tr>
							<th>Ref. No.</th>
							<th>Collection Date</th>
							<th>Guest</th>
							<th>Amount</th>
							<th>Status</th>
							{{-- <th>Collector Name</th> --}}
							<th>Manage</th>
						</tr>
					</thead>
					<tbody>
						@php
							$i=0;
						@endphp
						@foreach($all as $data)
						@php
							$income_date = App\Helper::setDate($data->income_date);
							$deadline = strtotime($data->income_date . "+7 days");
							$today = mktime(0, 0, 0);
							$l='';
							if ($today > $deadline) {
								$data_array =array(
									'income_status' => 0
								);
								$update = App\Models\Income::where('income_id',$data->income_id)->where('income_status',1)->update($data_array);
							}
							if($data->income_status==0){
								$l='text-danger';
							}
						@endphp
						<tr>
							<td><a style="cursor:pointer; color:#6c757d;" href="{{url('/dashboard/income/view/'.bin2hex($data->income_ref_no)) }}">{{$data->income_ref_no}}</a></td>
							<td>{{$income_date}}</td>
							<td>{{$data->guest_name}}</td>
							<td>
                                <b>
                                @php
                                $currency=App\helper::currenyType($data->income_currency);
                                echo $currencyIcon=App\helper::get_currency_symbol($currency->code);
                                @endphp
                                </b>
                                 {{App\Helper::setNumbur($data->income_amount)}}
                            </td>
							<td class="{{$l}}">{{App\Helper::paymentStatus($data->income_status)}} </td>
							{{-- <td>{{App\Helper::userName($data->income_collector)}} </td> --}}
							<td>

								<a class="btn btn-dark m-1 " href="{{url('/dashboard/income/view/'.bin2hex($data->income_ref_no)) }} " ><i class="uil-plus" ></i> View</a>
								@if ( Auth::user()->admin_view == 1 && $data->income_status !== 0 )
								<a class="btn btn-dark " href="{{url('dashboard/income/edit/'.$data->income_id)}}"><i class=" uil-comment-edit"></i> Edit</a>
								@endif
								@if ( Auth::user()->admin_view == 3 && $data->income_status == 1 )
								<a class="btn btn-dark " href="{{route('income.cancelled',[$data['income_id'],bin2hex($data['income_ref_no'])])}}"><i class=" uil-cancel"></i> Cancelled</a>

								@endif
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>

			</div> <!-- end card body-->
			<div class="card-footer card_footer d-print-none">
				<div class="btn-group mb-2">
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
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
