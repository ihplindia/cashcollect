@extends('layouts.admin')
@section('content')

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header card_header">
				@if(Session::has('success'))
						<div class="alert alert-success" role="alert">
							{{session::get('success')}}
						</div>
						@endif
						@if(Session::has('error'))
						<div class="alert alert-danger" role="alert">
							{{session::get('error')}}
						</div>
						@endif
				<div class="row">
					<div class="col-md-8 tbl_text">
						<i class=" uil-user-exclamation "></i> All Payment Category Information
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
							<th>Manage</th>
						</tr>
					</thead>
					<tbody>
						@foreach($all as $data)
						<tr>
							<td>{{$data->incate_name}}</td>
							<td>{{$data->incate_remarks}}</td>							
							<td>
								<div class="btn_group">
									<a class="btn btn-dark" href="{{url('dashboard/income/category/view/'.$data->incate_id)}}"><i class=" uil-plus "></i> View</a>
									<a class="btn btn-dark" href="{{url('dashboard/income/category/edit/'.$data->incate_id)}}"><i class=" uil-comment-edit"></i> Edit</a>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>

			</div> <!-- end card body-->
		</div> <!-- end card -->
	</div><!-- end col-->
</div>
@endsection
