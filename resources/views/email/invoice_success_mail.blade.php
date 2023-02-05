@extends('email.layout')

@section('title', 'Invoice Success')
@section('content')
	@php setlocale(LC_MONETARY, 'en_US'); @endphp
	<style type="text/css">
		.tar{
			text-align: right;
		}
		.vat{
			vertical-align: top;
		}
		.td-hdg{
			color: slategrey;
		}
	</style>
	<table width="100%">
		<tr>
			<td>
				<table width="100%" style="padding: 30px;">
					<tr>
						<td width="50%" class="td-hdg">Billed to</td>
						<td width="50%" class="td-hdg tar">Invoice</td>
					</tr>
					<tr>
						<td>
							{{$invoice->vendor->name}}<br>
							@if($invoice->vendor->address!='')
								{{$invoice->vendor->address}}<br>
							@endif
							@if($invoice->vendor->city!= '')
								{{$invoice->vendor->city.', '.trim($invoice->vendor->state.' '.$invoice->vendor->pincode)}}<br><br>
							@else
								{{trim($invoice->vendor->state.' '.$invoice->vendor->pincode)}}<br><br>
							@endif
							{{$invoice->vendor->email}}
						</td>
						<td class="tar vat">
							<table align="right" style="margin-right: -5px;">
								<tr>
									<td class="td-hdg">Invoice number:</td>
									<td>{{$invoice->invoice_number}}</td>
								</tr>
								<tr>
									<td class="td-hdg">Invoice date: </td>
									<td>{{date('m/d/Y', strtotime($invoice->invoice_created_date))}}</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table width="100%" style="padding: 30px;">
					<tr>
						<td class="td-hdg" width="70%">Description</td>
						<td width="15%">&nbsp;</td>
						<td class="td-hdg tar" width="15%">Amount</td>
					</tr>
					@foreach($invoice->invoiceItems as $invoice_item)
					<tr>
						<td>
							@php
								if (strpos($invoice_item->description, ' × ') !== false) {
									$description = explode(' × ', $invoice_item->description);
									echo $description[1];
								}else{
									echo $invoice_item->description;
								}
							@endphp
						</td>
						<td>&nbsp;</td>
						<td class="tar">
							{{invoiceAmountFormat($invoice_item->amount)}}
						</td>
					</tr>
					@endforeach
					<tr>
						<td colspan="3"><hr></td>	
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td class="tar">Subtotal</td>
						<td class="tar">
							{{invoiceAmountFormat($invoice->subtotal)}}
						</td>
					</tr>
					@if(!empty($invoice->membershipCoupon))
						<tr>
							<td>&nbsp;</td>
							<td class="tar">{{$invoice->membershipCoupon->name}} ({{$invoice->membershipCoupon->discount}}% off)</td>
							<td class="tar">-${{number_format(($invoice->total_discount_amount/100),2,".","")}}</td>
						</tr>
					@endif
					<tr>
						<td>&nbsp;</td>
						<td class="tar">Total</td>
						<td class="tar">
							{{invoiceAmountFormat($invoice->total)}}
						</td>
					</tr>
					@if($invoice->starting_balance != 0)
					<tr>
						<td>&nbsp;</td>
						<td class="tar">Applied balance</td>
						<td class="tar">
							{{invoiceAmountFormat($invoice->starting_balance)}}
						</td>
					</tr>
					@endif
					<tr>
						<td>&nbsp;</td>
						<th class="tar">Amount paid</th>
						<th class="tar">
							{{invoiceAmountFormat($invoice->amount_paid)}}
						</th>
					</tr>
				</table>
			</td>
		</tr>
    </table>
@endsection