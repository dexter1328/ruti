@extends('admin.layout.main')
@section('content')

@if(session()->get('success'))
<div class="alert alert-success alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<div class="alert-icon">
		<i class="fa fa-check"></i>
	</div>
	<div class="alert-message">
		<span><strong>Success!</strong> {{ session()->get('success') }}</span>
	</div>
</div>
@endif
<div class="success-alert" style="display:none;"></div>

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><!-- <i class="fa fa-user"></i> --> <span>Customer Transactions</span></div>
				<div class="float-sm-right">
					<form method="POST">
						@csrf
						<select name="transaction_filter" class="form-control" onchange="this.form.submit()" >
							<option value="daily" @if($input=='daily') selected="selected" @endif>Daily</option>
							<option value="weekly" @if($input=='weekly') selected="selected" @endif>Weekly</option>
							<option value="monthly" @if($input=='monthly') selected="selected" @endif>Monthly</option>
						</select>
					</form>
				</div>
			</div>
			<div class="card-body">
					<div class="table-responsive" id="transaction_div">
						<table id="example" class="table table-bordered">
							<thead>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>Type</th>
									<th>Description</th>
									<th>Amount</th>
									<th>Closing Amount</th>
									<th>Placed On</th>
								</tr>
							</thead>
							<tbody>
								@if(!empty($data))
									@foreach($data as $key => $value)
										<tr>
											<td>{{$key+1}}</td>
											<td>{{$value['first_name']}} {{$value['last_name']}}</td>
											<td>{{ucwords(str_replace("_"," ",$value['type']))}}</td>
											<td>{{$value['description']}}</td>
											<td>{{$value['amount']}}</td>
											<td>{{$value['closing_amount']}}</td>
											<td>{{$value['placed_on']}}</td>
										</tr>
									@endforeach
								@endif
							</tbody>
							<tfoot>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>Type</th>
									<th>Description</th>
									<th>Amount</th>
									<th>Closing Amount</th>
									<th>Placed On</th>
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
 	
 	// $('[data-toggle="tooltip"]').tooltip(); 
    var table = $('#example').DataTable( {
        lengthChange: false,
        // buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ],
        buttons: [
        	{
                extend: 'copy',
                title: 'Customer Transactions List',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                }
            },
            {
                extend: 'excelHtml5',
                title: 'Customer Transactions List',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'Customer Transactions List',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                }
            },
            {
                extend: 'print',
                title: 'Customer Transactions List',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                }
            },
            'colvis'
        ],
        /*columnDefs: [
        	{ "orderable": false, "targets": 0 }
      	],*/
      	/*columnDefs: [
            { width: "5%", targets: 0 },
            { width: "15%", targets: 1 },
            { width: "50%", targets: 2 },
            { width: "15%", targets: 3 },
            { "orderable": false, width: "15%", targets: 4 },
        ],*/
        //order: [[1, 'asc']],
    });
    table.buttons().container()
      .appendTo( '#example_wrapper .col-md-6:eq(0)' );
      
    });

   
</script>
@endsection
