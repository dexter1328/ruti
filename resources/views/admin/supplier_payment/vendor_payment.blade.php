<table class="table table-striped">
	@foreach($payments as $payment)
		<tr>
			<td><input type="checkbox" class="select_payment" name="select_payment" value="{{$payment->payment_id}}"/></td>
			<td>{{$payment->store}}</td>
			<td>{{$payment->order_no}}</td>
			<td>{{$payment->amount}}</td>
		</tr>
	@endforeach
</table>