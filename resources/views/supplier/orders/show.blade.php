@extends('supplier.layout.main')

@section('content')

    @php $fund=0; @endphp

@if($order_items->isNotEmpty())
@php

    $id =  strtoupper($order->w2bOrder->order_id);
    $date = $order->created_at;
    $first_name = $order->user->first_name;
    $last_name = $order->user->last_name;
    $email = $order->user->email;
    $mobile = $order->user->mobile;
    $status = $order->w2bOrder->status;
@endphp
@foreach($order_items as $key => $order_item)
    @php
        $count = $key+1;
        $fund+=$order_item->quantity*$order_item->price;
    @endphp
@endforeach
<style>
    .media-body {
        flex: 0.3;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center">
                <div class="left">
                   <span>Order # {{$id}} Details</span>
                </div>
                <input type="hidden" name="" id="order_id" value="{{$id}}">
            </div>
            <div class="card-body">
                <div class="order-details">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <b>Customer:</b>
                                <span>{{$first_name}} {{$last_name}}</span>
                            </div>

                            <div class="form-group">
                                    <b>Mobile:</b>
                                    <span>{{$mobile}}</span>
                            </div>

                            <div class="form-group">
                                <b>Email:</b>
                                <span> {{$email}}</span>
                            </div>

                            <div class="form-group">
                                <b>Order Date:</b>
                                <span>{{$date}}</span>
                            </div>

                             <div class="form-group">
                                <b>Status:</b>
                                <span>{{ucfirst($status)}}</span>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <b>Total items:</b>
                                <span> {{$count}}</span>
                            </div>
                            <div class="form-group">
                                <b>Item Total:</b>
                                <span>${{number_format($order_item->quantity*$order_item->price,2)}}</span>
                            </div>
                            <div class="form-group">
                                <b>Tax:</b>
                                <span>@if(!empty($order->w2bOrder->tax))${{$order->w2bOrder->tax}}@else $0 @endif</span>
                            </div>
                            <div class="form-group">
                                <b>Total amount:</b>
                                <span> ${{number_format($order->w2bOrder->total_price,2)}}</span>
                            </div>

                        </div>

                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <table id="example" class="table table-bordered order-detail-table" width="100%">
                    <thead>
                        <tr>
                            <th width="15%">Image</th>
                            <th width="55%">Items</th>
                            <th width="10%">Cost</th>
                            <th width="10%">Qty</th>
                            <th width="10%">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order_items as $order_item)
                            <tr>
                                @if($order_item->image)
                                    <td><img src="{{$order_item->image}}" width="50" height="50" class="customer-img rounded-circle"></td>
                                @else
                                    <td><img src="{{asset('public/images/no-image.jpg')}}" width="50" height="50"></td>
                                @endif
                                <td>{{$order_item->title}}</td>
                                <td> ${{$order_item->price}}</td>
                                <td>{{$order_item->quantity}}</td>
                                <td>${{number_format($order_item->quantity*$order_item->price,2)}}</td>
                            </tr>
                        @endforeach
                         <tr align="right">
                            <td colspan="5">
                                Total: <b>${{number_format($fund,2)}}</b>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection

