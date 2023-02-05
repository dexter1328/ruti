@extends('admin.layout.main')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left">
					<span>Customer Incentive {{ucfirst($type)}}</span>
				</div>
				<div class="float-sm-right"> 
					<form method="post">
						@csrf
						<label for="startDate">Date :</label>
						<input name="startDate" id="startDate" class="date-picker" value="{{$date}}" size="5" />
						<input type="submit" name="search" value="Search" class="btn btn-primary btn-sm waves-effect waves-light m-1" style="width: 100px;">
					</form>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>E-mail</th>
								<th>Mobile</th>
								<th>Plan</th>
								<th>Type</th>
								@if($type == 'winners')
									<th>Sub-Type</th>
								@endif
							</tr>
						</thead>
						<tbody>
							@foreach($incentives as $key=> $incentive)
								<tr>
									<td>{{$key+1}}</td>
									<td>
										<a href="{{ url('/admin/customer/view',$incentive->user->user_id)}}" >{{$incentive->user->first_name}}</a>
									</td>
									<td>{{$incentive->user->email}}</td>
									<td>{{$incentive->user->mobile}}</td>
									<td>{{ucfirst($incentive->membership_code)}}</td>
									<td>{{$incentive_types[$incentive->type]}}</td>
									@if($type == 'winners')
										<td>{{$incentive_sub_types[$incentive->sub_type]}}</td>
									@endif
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>E-mail</th>
								<th>Mobile</th>
								<th>Plan</th>
								<th>Type</th>
								@if($type == 'winners')
									<th>Sub-Type</th>
								@endif
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
	var type = '{{$type}}';
	if(type == 'winners') {
		var total_columns  = [0,1,2,3,4,5,6]
	}else{
		var total_columns  = [0,1,2,3,4,5]
	}
	var table = $('#example').DataTable( {
		lengthChange: false,
		buttons: [
			{
				extend: 'copy',
				title: 'Customer List',
				exportOptions: {
					columns: total_columns
				}
			},
			{
				extend: 'excelHtml5',
				title: 'Customer List',
				exportOptions: {
					columns: total_columns
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'Customer List',
				exportOptions: {
					columns: total_columns
				}
			},
			{
				extend: 'print',
				title: 'Customer List',
				autoPrint: true,
				exportOptions: {
					columns: total_columns
				}
			},
			'colvis'
		],
		//columnDefs: [
			//{ "orderable": false, "targets": 6 }
		//]
		/*columnDefs: [
            { width: "05%", targets: 0 },
            { width: "20%", targets: 1 },
            { width: "15%", targets: 2 },
            { width: "15%", targets: 3 },
            { width: "15%", targets: 4 },
            { width: "15%", targets: 5 },
            { width: "15%", targets: 6 },
        ],*/
        fixedColumns: true
	});
	table.buttons().container()
	.appendTo( '#example_wrapper .col-md-6:eq(0)' );

	$('.date-picker').datepicker({
		format: "mm-yyyy",
		viewMode: "months", 
		minViewMode: "months"
	})
});
</script>

@endsection