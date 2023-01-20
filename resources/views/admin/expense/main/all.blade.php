@extends('layouts.admin')
@section('content')

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header card_header">
				<div class="row">
					<div class="col-md-8 tbl_text">
						<i class=" uil-user-exclamation "></i> All  Expense Information
					</div>
					<div class="col-md-4 card_butt_part">
						<a class="btn btn-sm btn-dark d-print-none" href="{{url('dashboard/expense/add')}}"><i class=" uil-plus "></i> Add Expense</a>
					</div>
				</div>

			</div>
			<div class="card-body card_body">
				<table id="allTableInfo" class="table table-bordered table-striped table-hover dt-responsive nowrap w-100">
					<thead class="table-dark">
						<tr>
							<th>Expense Date</th>
							<th>Expense Title</th>
							<th>Category</th>
							<th>Amount</th>
							<th>Manage</th>
						</tr>
					</thead>


					<tbody>
						@foreach($all as $data)
						<tr>
							<td>{{date('d-m-Y', strtotime($data->expense_date))}}</td>
							<td>{{$data->expense_title}}</td>
							<td>{{$data->category->expcate_name}}</td>
							<td>{{number_format($data->expense_amount,2)}}</td>
							<td>
								<div class="btn-group d-print-none">
									<button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Manage
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item" href="{{url('dashboard/expense/view/'.$data->income_slug)}}"><i class=" uil-plus "></i> View</a>
										<a class="dropdown-item" href="{{url('dashboard/expense/edit/'.$data->income_slug)}}"><i class=" uil-comment-edit"></i> Edit</a>
										<a class="dropdown-item" href="#"><i class=" uil-trash "></i> Delete</a>
									</div>
								</div>

							</td>
						</tr>
						@endforeach
					</tbody>
				</table>

			</div> <!-- end card body-->
			<div class="card-footer card_footer d-print-none">
				<div class="btn-group mb-2">
					<a href="#" class="btn btn-secondary" onclick='window.print()'>Print</a>
					<a href="{{url('dashboard/expense/pdf')}}" class="btn btn-dark">PDF</a>
					<a href="{{url('dashboard/expense/export')}}" class="btn btn-secondary">Excel</a>
				</div>
			</div>
		</div> <!-- end card -->
	</div><!-- end col-->
</div>
@endsection
