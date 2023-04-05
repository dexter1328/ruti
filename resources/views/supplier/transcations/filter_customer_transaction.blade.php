
<table id="example" class="table table-bordered">
<thead>
	<tr>
		<th>#</th>
		<th>Image</th>
		<th>Name</th>
		<th>Quantity</th>
		<th>Amount</th>
	</tr>
</thead>
<tbody>
	@foreach($orders as $key => $order)
		<tr>
			<td>{{$key+1}}</td>
			<td>@if($order->image == '')<img src="{{asset('public/images/deafult.jpg')}}" height="100" width="100">@else<img src="{{asset('public/user_photo/'.$order->image)}}" height="100" width="100">@endif</td>
			<td>{{$order->first_name}} {{$order->last_name}}</td>
			<td>{{$order->quantity}}</td>
			<td>{{$order->total_price}}</td>
		</tr>
	@endforeach
</tbody>
<tfoot>
	<tr>
		<th>#</th>
		<th>Image</th>
		<th>Name</th>
		<th>Quantity</th>
		<th>Amount</th>
	</tr>
</tfoot>
</table>
					
<script>

 $(document).ready(function() {
 	
    var table = $('#example').DataTable( {
        lengthChange: false,
        // buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ],
        buttons: [
        	{
                extend: 'copy',
                title: 'Admin List',
                exportOptions: {
                    columns: [ 0, 1, 2, 3]
                }
            },
            {
                extend: 'excelHtml5',
                title: 'Admin List',
                exportOptions: {
                    columns: [ 0, 1, 2, 3]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'Admin List',
                exportOptions: {
                    columns: [ 0, 1, 2, 3]
                }
            },
            {
                extend: 'print',
                title: 'Admin List',
                exportOptions: {
                    columns: [ 0, 1, 2, 3]
                }
            },
            'colvis'
        ],
        columnDefs: [
        	{ "orderable": false, "targets": 4 }
      	]
      	/*columnDefs: [
            { width: "5%", targets: 0 },
            { width: "15%", targets: 1 },
            { width: "50%", targets: 2 },
            { width: "15%", targets: 3 },
            { "orderable": false, width: "15%", targets: 4 },
        ],*/
    });
    table.buttons().container()
      .appendTo( '#example_wrapper .col-md-6:eq(0)' );
      
    });

   
</script>

