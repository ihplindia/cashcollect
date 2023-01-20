
@extends('layouts.admin')
@section('content')

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header card_header">
				<div class="row">
					<div class="col-md-8 tbl_text">
						<i class=" uil-user-exclamation "></i>Total Collection Summary
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
						<div class="col-md-3"></div>
						<div class="col-md-6">
							<form method="get" action="{{url('dashboard/report/search')}}"  enctype="multipart/form-data" >
									<div class="input-group">
											<input type="date" id="s-from" name="start" class="form-control"  placeholder="" style="margin-right:5px;" onclick="this.showPicker()">
											<input type="date" id="s-to"name="end" class="form-control"  placeholder="" onclick="this.showPicker()">
											<button class="input-group-text btn-primary" type="submit">Search</button>
									</div>
							</form>
						</div>
						<div class="col-md-3"></div>
					</div>
					<table id="allTableInfo" class="table table-bordered table-striped table-hover dt-responsive nowrap w-100">
					<thead class="table-dark">
						<tr>
							<th>Income Ref. No.</th>
							<th>Guest Name</th>
							<th>File Ref. No.</th>
							<th>Status</th>
							<th>Amount</th>
							<th>Manage</th>
						</tr>
					</thead>
					<tbody>
						@foreach($RtottalIncome as $income)
						<tr>

							<td>{{$income->income_ref_no}}</td>
							{{-- <td>{{date('Y-m-d', strtotime($income->income_date))}}</td> --}}
							<td>{{$income->guest_name}}</td>
							<td>{{$income->file_ref_no}}</td>
							<td>{{$income->income_status}}</td>
							<td>{{number_format($income->income_amount,2)}}</td>
							<td>
								<div class="btn-group">
								   <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									   Manage
								   </button>
								   <div class="dropdown-menu">
									   <a class="dropdown-item" href="{{url('dashboard/report/view/'.$income->income_id)}}"><i class=" uil-plus "></i> View</a>
								   </div>
							   </div>
						   </td>
						</tr>
						@endforeach

						@foreach($Rtottalexpense as $expense)
						<tr>
							<td>{{date('Y-m-d', strtotime($expense->expense_date))}}</td>
							<td>{{$expense->expense_title}}</td>
							<td>{{$expense->category->expcate_name}}</td>
							<td>---</td>
							<td>{{number_format($expense->expense_amount,2)}}</td>
						</tr>
						@endforeach
						<tfoot class="table-dark">
						<tr>
							<td></td>
							<td></td>
							<td></td>
							{{-- <td>{{number_format($Tottalexpense,2)}}</td> --}}
							<td></td>
							<td style="text-align:right;">Total</td>
							<td>{{number_format($TottalIncome,2)}}</td>
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
