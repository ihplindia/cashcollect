@extends('layouts.admin')
@section('content')

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header card_header">
				<div class="row">
					<div class="col-md-8 tbl_text">
						<i class=" uil-user-exclamation "></i> All Expense Category Information
					</div>
					<div class="col-md-4 card_butt_part">
						<a class="btn btn-sm btn-dark" href="{{url('dashboard/expense/category/add')}}"><i class=" uil-plus "></i> Add Category</a>
					</div>
				</div>

			</div>
			<div class="card-body card_body">
				<table id="allTableInfo" class="table table-bordered table-striped table-hover dt-responsive nowrap w-100">
					<thead class="table-dark">
						<tr>
							<th>Category Name</th>
							<th>Remarks</th>
							<th>Total Expense</th>
							<th>Manage</th>
						</tr>
					</thead>


					<tbody>
						@foreach($all as $data)
						<tr>
							<td>{{$data->expcate_name}}</td>
							<td>{{$data->expcate_remarks}}</td>
							<td>
								@php
								$cateID=$data->expcate_id;
								$categoryExpense=App\Models\Expense::where('expense_status',1)->where('expcate_id',$cateID)->sum('expense_amount');
								@endphp
								{{number_format($categoryExpense,2)}}
							</td>
							<td>
								<div class="btn-group">
									<button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Manage
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item" href="{{url('dashboard/expense/category/view/'.$data->expcate_slug)}}"><i class=" uil-plus "></i> View</a>
										<a class="dropdown-item" href="{{url('dashboard/expense/category/edit/'.$data->expcate_slug)}}"><i class=" uil-comment-edit"></i> Edit</a>
										<a class="dropdown-item" href="#"><i class=" uil-trash "></i> Delete</a>
									</div>
								</div>

							</td>
						</tr>
						@endforeach
					</tbody>
				</table>

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