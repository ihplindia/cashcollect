@extends('layouts.admin')
@section('content')

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header card_header">
				<div class="row">
					<div class="col-md-8 tbl_text">
						<i class=" uil-user-exclamation "></i> View Income Information
					</div>
					<div class="col-md-4 card_butt_part">
						<a class="btn btn-sm btn-dark" href="{{url('dashboard/income')}}"><i class=" uil-users-alt "></i> All Income</a>
					</div>
				</div>

			</div>
			<div class="card-body card_body">
				<div class="row">
					<div class="col-2"></div>
					<div class="col-8">
						<table class="table table-bordered table-striped custom_view_table">
						<tr>
							<td>Income Date<td>
							<td>:</td>
							<td>{{$data->income_date}} </td>
						</tr>
						<tr>
								<td>Income Title<td>
								<td>:</td>
								<td>{{$data->income_title}} </td>
						</tr>
						<tr>
								<td>Income Category<td>
								<td>:</td>
								<td>{{$data->category->incate_name}} </td>
						</tr>
						<tr>
								<td>Income Amount<td>
								<td>:</td>
								<td>{{$data->income_amount}} </td>
						</tr>
							</table>
					</div>
					<div class="col-2"></div>
				</div>
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
