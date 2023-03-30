@extends('admin.layout.main')
@section('content')
<style type="text/css">
	.pending_amount{
		position: relative;
    	left: 138px;
	}

	.amount{
		float: right;
	}

	#payment{
		height: auto;
		width:auto;
	}
</style>

<div class="row">
	<div class="col-lg-4">
		<div class="card">
			<div class="card-header">
				<div class="left"><!-- <i class="fa fa-users"></i> --><span>Vendors</span></div>
				<div class="float-sm-right">        
				</div>
			</div>
			<div class="card-body">
				<label class="pending_amount">Pending Amount</label>
				<div class="list-group">
					@foreach($vendor_payments as $vendor_payment)
						<a href="javascript:void(0);" class="list-group-item list-group-item-action" onclick="Payment({{$vendor_payment->vendor_id}})">{{$vendor_payment->vendor}}<p class="amount">${{$vendor_payment->total_price}}</p></a>
					@endforeach
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-8">
		<div class="card">
			<div class="card-header">
				<div class="left"><i class="fa fa-usd"></i><span>Payment</span></div>
				<div class="right"><button type="submit" class="btn btn-success" id="pay">PAY</button></div>
			</div>
			<div class="card-body">
				<div id="payment">
				</div>
			</div>
		</div>
	</div>
</div><!-- End Row-->
<!-- modal -->
<div id="myModal" class="modal fade barcode-modal" role="dialog">
  	<div class="modal-dialog" style="width:50%;">
    	<div class="modal-content">
      		<div class="modal-header">
        		<h4 class="modal-title">Payment</h4>
      		</div>
      		<div class="modal-body">
      			<span id="success" style="color:green;"></span>
      			<div class="form-group row">
					<label for="input-10" class="col-sm-4 col-form-label">Transcation ID<span class="text-danger">*</span></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="transaction_id" name="transaction_id">
						<span class="text-danger error-transcation"></span>
					</div>
				</div>
				<div class="form-group row">
					<label for="input-11" class="col-sm-4 col-form-label">Amount</label>
					<div class="col-sm-8">
						<label id="total_amount"></label>
					</div>
				</div>
      			<!-- <span id="success" style="color:green;"></span>
      			<label>Transcation ID</label>
      			<input type="text" name="transaction_id" class="form-controll" id="transaction_id">
      			<label>Amount</label>
      			<div id="total_amount"></div> -->
      		</div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-success" id="pay_submit">Submit</button>
      			<button type="button" class="btn btn-default" id="close" data-dismiss="modal">Close</button>
      		</div>
    	</div>
  	</div>
</div>
<!-- end modal -->
<script type="text/javascript">
	function Payment(id){
		var assigned_html = '';
		$.ajax({
			data: {
			"_token": "{{ csrf_token() }}"
			},
			url: "{{ url('admin/vendor_payment') }}/"+id,
			type: "GET",
			dataType: 'html',
			success: function (data) {
				$('#payment').html(data);
			},
			error: function (data) {
			}
		});

	}
	$(document).ready(function() {
		var id = [];
		var sum;
		$('#pay').click(function() {
			
			$.each($("input[name='select_payment']:checked"), function(){
				id.push($(this).val());
			});
			if (id.length === 0) {
			    $("#total_amount").html('please select order to pay.');
				$("#myModal").modal('show');
			}else{
				$.ajax({
					data: {
					"_token": "{{ csrf_token() }}",
					"id": id
					},
					url: "{{ url('admin/vendor_payment/vendor_pay') }}",
					type: "post",
					dataType: 'json',
					success: function (data) {
						$("#total_amount").html(data.sum);
						$("#myModal").modal('show');
						id = data.id;
						sum = data.sum;
					},
					error: function (data) {
					}
				});
			}
			
		});

		$('#pay_submit').click(function() {
			if($('#transaction_id').val() != ''){
				$.ajax({
					data: {
					"_token": "{{ csrf_token() }}",
					"id": id,
					"sum":sum,
					"transaction_id":$('#transaction_id').val(),
					},
					url: "{{ route('vendor_payment.store') }}",
					type: "post",
					dataType: 'html',
					success: function (data) {
						$('#success').html('Payment has been done');
						$('.error-transcation').empty();
					},
					error: function (data) {
					}
				});
			}else{
				$('.error-transcation').html('Transcation Id is required.');
			}
		});

		$('#myModal').on('hidden.bs.modal', function () {
  			location.reload();
		});
	});
</script>
@endsection

