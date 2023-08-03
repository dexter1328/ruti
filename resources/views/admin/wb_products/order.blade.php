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
				<div class="left"><!-- <i class="fa fa-group"></i> --><span>Wholesale2b Orders</span></div>
				<div class="float-sm-right">
					@php /* @endphp
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('membership.create', $type) }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Membership">
						<!-- <i class="fa fa-group" style="font-size: 15px;"></i> --> <span class="name">Add Membership</span>
					@php */ @endphp
					</a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th style="width: 15%">Order No</th>
								<th style="width: 25%">Customer Name</th>
								<th>Order Notes</th>
								<th>Status</th>
								<th>Products</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
                            @foreach($orders as  $key=> $order)

								<tr>
									<td>{{$loop->iteration}}</td>
									<td>{{$order->order_id}}</td>
									<td>{{$order->first_name}} {{$order->last_name}}</td>
									{{-- <td>{{$order->total_price}}</td> --}}
									<td>{{$order->order_notes}}</td>
									<td>{{$order->status}}</td>
									<td><a href="{{route('admin.wborderedproducts',$order->order_id)}}" class="btn btn-info">Show</a></td>
									<td class="w-20">
                                        @if($order->status == "processing")
                                            <select class="form-control" onchange="updateStatus1({{$order->id}}, $(this))" >
                                            <option value="processing" selected> processing</option>
                                            <option value="shipped" > shipped</option>
                                            <option value="delivered" > Delivered</option>
                                            <option value="cancelled" > Cancel</option>
                                            </select>
                                         @elseif($order->status == "shipped")
                                            <select class="form-control" onchange="updateStatus1({{$order->id}}, $(this))" >
                                            <option value="processing" > processing</option>
                                            <option value="shipped" selected> shipped</option>
                                            <option value="delivered" > Delivered</option>
                                            <option value="cancelled" > Cancel</option>

                                            </select>
                                        @elseif($order->status == "delivered")
                                            <select class="form-control" onchange="updateStatus1({{$order->id}}, $(this))" >
                                            <option value="processing" > processing</option>
                                            <option value="shipped" > shipped</option>
                                            <option value="delivered" selected> Delivered</option>
                                            <option value="cancelled" > Cancel</option>

                                            </select>
                                         @else
                                            <select class="form-control" onchange="updateStatus1({{$order->id}}, $(this))" >
                                            <option value="processing" > processing</option>
                                            <option value="shipped" > shipped</option>
                                            <option value="delivered" > Delivered</option>
                                            <option value="cancelled" selected> Cancel</option>

                                            </select>

                                        @endif
                                    </td>

								</tr>
                                @endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>#</th>
								<th style="width: 15%">Order No</th>
								<th style="width: 25%">Customer Name</th>
								<th>Order Notes</th>
								<th>Status</th>
								<th>Products</th>
								<th>Actions</th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div><!-- End Row-->

@endsection

@section('scripts1')
<script>
    $(document).ready(function() {
    var table = $('#example').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
    } );

    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );
</script>

<script>
       function updateStatus1(id,$this) {

$.ajax({
           url: "{{ url('/admin/wborder/status') }}/"+id+'/'+$this.val(),


}).done(function(res) {
console.log(res)
location.reload();
});
}

</script>

@endsection
