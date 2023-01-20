@extends('layouts.admin')
@section('content')

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header card_header">
				<div class="row">
					<div class="col-md-8 tbl_text">
						<i class=" uil-user-exclamation "></i> All Income Information
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
				<table id="allTableInfo" class="table table-bordered table-striped table-hover dt-responsive nowrap w-100">
					<thead class="table-dark">
						<tr>
							<th>Income Date</th>
							<th>Income Title</th>
							<th>Category</th>
							<th>Amount</th>
							<th>Manage</th>
						</tr>
					</thead>


					<tbody>
						@foreach($all as $data)
						<tr>
							<td>{{date('d-m-Y', strtotime($data->income_date))}}</td>
							<td>{{$data->income_title}}</td>
							<td>{{$data->category->incate_name}}</td>
							<td>{{number_format($data->income_amount,2)}}</td>
							<td>
								<div class="btn-group">
									<button type="button" class="btn btn-dark dropdown-toggle d-print-none" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Manage
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item" href="{{url('dashboard/income/view/'.$data->income_slug)}}"><i class=" uil-plus "></i> View</a>
										<a class="dropdown-item" href="{{url('dashboard/income/edit/'.$data->income_slug)}}"><i class=" uil-comment-edit"></i> Edit</a>
										<a class="dropdown-item" href="#" id="softDelete" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{$data->income_id}}"><i class=" uil-trash "></i> Delete</a>
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
		 </form>
			 </div><!-- /.modal-content -->
	 </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
