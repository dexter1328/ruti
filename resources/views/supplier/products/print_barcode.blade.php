<table id="example" class="table table-bordered display barcode-print" style="width: 100%">
	<tbody>
		<tr>
			@if(!empty($products))
				@php $i = 1; @endphp
				@foreach($products as $key => $product)
					<td>
						<span>${{$product->price}}</span>
						<img src="data:image/png;base64,{{DNS1D::getBarcodePNG($product->barcode, 'C39')}}" alt="barcode" />
						<div class="title">{{$product->title}}</div>
					</td>
					@if($i%4 == 0)
						</tr><tr>
					@endif
					@php $i++; @endphp
				@endforeach
				<script type="text/javascript">
					$(document).ready(function() {
						$('#btnPrint').show();
					});
				</script>
			@else
				<td>Please select at least one product to print barcode.</td>
				<script type="text/javascript">
					$(document).ready(function() {
						$('#btnPrint').hide();
					});
				</script>
			@endif
		</tr>
	</tbody>
</table>


