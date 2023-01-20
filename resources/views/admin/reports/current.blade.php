@extends('layouts.admin')
@section('content')

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header card_header">
				<div class="row">
					<div class="col-md-8 tbl_text">
						<i class=" uil-user-exclamation "></i>{{$fullmonth}}--{{$year}} Income And Expense Reports
					</div>
					<div class="col-md-4 card_butt_part">
						<a class="btn btn-sm btn-dark d-print-none" href="{{url('dashboard/income/add')}}"><i class=" uil-plus "></i> Add Category</a>
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
				<table id="reportsTableInfo" class="table table-bordered table-striped table-hover dt-responsive nowrap w-100">
					<thead class="table-dark">
						<tr>
							<th>Date</th>
							<th>Title</th>
							<th>Category</th>
							<th>Income</th>
							<th>Expense</th>
						</tr>
					</thead>


					<tbody>
						@foreach($RtottalIncome as $income)
						<tr>
							<td>{{date('Y-m-d', strtotime($income->income_date))}}</td>
							<td>{{$income->income_title}}</td>
							<td>{{$income->category->incate_name}}</td>
							<td>{{number_format($income->income_amount,2)}}</td>
							<td>---</td>
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
						<tr>
							<th></th>
							<th></th>
							<th style="text-align:right;">Tottal</th>
							<th>{{number_format($TottalIncome,2)}}</th>
							<th>{{number_format($Tottalexpense,2)}}</th>
						</tr>
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
