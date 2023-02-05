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


<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><!-- <i class="fa fa-newspaper-o"></i> --><span>View Newsletter</span></div>
				<div class="float-sm-right">        

				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<label for="input-10" class="col-sm-2 col-form-label">Subject</label>
					<div class="col-sm-10">
						<p>{{$newsletter->subject_name}}</p>
					</div>
				</div>
				<div class="row">
					<label for="input-10" class="col-sm-2 col-form-label">Description</label>
					<div class="col-sm-10">
						<p style="text-align: justify;">{!!html_entity_decode($newsletter->description)!!}</p>
					</div>
				</div>
			 	<br>
				<div class="table-responsive">
                	<ul class="nav nav-tabs nav-tabs-warning top-icon">
                  		<li class="nav-item">
                    		<a class="nav-link active" data-toggle="tab" href="#tabe-10"><span class="hidden-xs">User</span></a>
                  		</li>
                  		<li class="nav-item">
                    		<a class="nav-link" data-toggle="tab" href="#tabe-11"><span class="hidden-xs">Vendor</span></a>
                  		</li>	
                	</ul>
                	<div class="tab-content">
                  		<div id="tabe-10" class="container tab-pane active">
                    		<div class="table-responsive">
								<table id="example" class="table table-bordered example">
									<thead>
										<tr>
											<th >#</th>
											<th >User</th>
											<th >Date</th>
										</tr>
									</thead>
									<tbody>
										@foreach($user_newsletters as $key => $newsletter)
											<tr>
												<td >{{$key+1}}</td>
												<td >{{$newsletter->first_name}} {{$newsletter->last_name}}</td>
												<td> @php echo date('d-m-Y H:i:s:a',strtotime($newsletter->created_at));@endphp </td>
											</tr>
										@endforeach
									</tbody>
									<tfoot>     
										<tr>
											<th >#</th>
											<th >User</th>
											<th >Date</th>
										</tr>
									</tfoot>
								</table>
							</div>
                  		</div>
                  		<div id="tabe-11" class="container tab-pane fade">
                    		<div class="table-responsive">
								<table id="example1" class="table table-bordered example">
									<thead>
										<tr>
											<th >#</th>
											<th >Vendor</th>
											<th >Date</th>
										</tr>
									</thead>
									<tbody>
										@foreach($vendor_newsletters as $key => $newsletter)
											<tr>
												<td >{{$key+1}}</td>
												<td >{{$newsletter->name}}</td>
												<td> @php echo date('d-m-Y H:i:s:a',strtotime($newsletter->created_at));@endphp </td>
											</tr>
										@endforeach
									</tbody>
									<tfoot>     
										<tr>
											<th >#</th>
											<th >Vendor</th>
											<th >Date</th>
										</tr>
									</tfoot>
								</table>
							</div>
                  		</div>
                	</div>				
				</div>
			</div>
		</div>
	</div><!-- End Row-->
</div>
<script>
$(document).ready(function() {
	var table = $('.example').DataTable( {
		// lengthChange: false,
		// searching: true,
		columnDefs: [
			{ "orderable": false, "targets": 2 }
		]
	} );
	table.buttons().container()
	.appendTo( '.example_wrapper .col-md-6:eq(0)' );
} );

</script>
@endsection

