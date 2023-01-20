@extends('layouts.admin')
@section('content')

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header card_header">
				<div class="row">
					<div class="col-md-8 tbl_text">
						<i class=" uil-user-exclamation "></i> All Income Category Information
					</div>
					<div class="col-md-4 card_butt_part">
						<a class="btn btn-sm btn-dark" href="{{url('dashboard/income/category/add')}}"><i class=" uil-plus "></i> Add Category</a>
					</div>
				</div>

			</div>
			<div class="card-body card_body">
				<table id="allTableInfo" class="table table-bordered table-striped table-hover dt-responsive nowrap w-100">
					<thead class="table-dark">
						<tr>
							<th>Category Name</th>
							<th>Remarks</th>
							<th>Total Income</th>
							<th>Manage</th>
						</tr>
					</thead>


					<tbody>
						@foreach($all as $data)
						<tr>
							<td>{{$data->incate_name}}</td>
							<td>{{$data->incate_remarks}}</td>
							<td>
								@php 
									$cateId=$data->incate_id;
									$categoryIncome=App\Models\Income::where('income_status',1)->where('incate_id',$cateId)->sum('income_amount');
								@endphp
								{{number_format($categoryIncome,2)}}
							</td>
							<td>
								<div class="btn-group">
									<button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Manage
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item" href="{{url('dashboard/income/category/view/'.$data->incate_slug)}}"><i class=" uil-plus "></i> View</a>
										<a class="dropdown-item" href="{{url('dashboard/income/category/edit/'.$data->incate_slug)}}"><i class=" uil-comment-edit"></i> Edit</a>
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
