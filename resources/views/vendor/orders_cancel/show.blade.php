@extends('vendor.layout.main')

@section('content')

@if($order_items->isNotEmpty())
@php   $fund=0; @endphp
@foreach($order_items as $key => $order_item)
    @php 
        $count = $key+1;
        $id =  $order_item->order_id;
        $date = $order_item->created_at;
        $type = $order_item->type;
        $status = $order_item->order_status;
        $fund+=$order_item->quantity*$order_item->price; 
        $first_name = $order_item->first_name;
        $last_name = $order_item->last_name;
        $email = $order_item->email;
        $mobile = $order_item->mobile;
        $store = $order_item->store;
        $gems_points = $order_item->gems_point;
        $coins_point = $order_item->coin_point;
        $promo_code = $order_item->promo_code;
    @endphp
@endforeach
<style type="text/css">
    .media-body {
        flex: 0.3;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center">
                <div class="left"> 
                   Order # {{$id}} Details               
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
                                <b>Store:</b>
                                <span>{{$store}}</span>
                            </div>
                            <div class="form-group">
                                <b>Order Date:</b>
                                <span>{{$date}}</span>
                            </div>

                             <div class="form-group">
                                <b>Type:</b>
                                <span>{{$type}}</span>
                            </div>
                            <div class="form-group">
                                <b>Status:</b>
                                <span>{{$status}}</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            

                            <div class="form-group">
                                <b>Total items:</b>
                                <span> {{$count}}</span>
                            </div>
                            <div class="form-group">
                                <b>Item Total:</b>
                                <span>${{number_format($order_item->item_total,2)}}</span>
                            </div>
                            <div class="form-group">
                                <b>Tax:</b>
                                <span>@if(!empty($order_item->tax))${{$order_item->tax}}@else $0 @endif</span>
                            </div>
                            @if(!empty($order_item->reward_point))
                            <div class="form-group">
                                <b>Reward:</b>

                                <span>${{$gems_points/$gem_setting->value + $coins_point/$coin_setting->value}}</span>
                              
                                <!-- <span>{{$order_item->reward_point}}</span> -->
                            </div>
                            @endif
                             @if(!empty($promo_code))
                                <div class="form-group">
                                    <b>Promo Code:</b>
                                    <span>@if(!empty($promo_code))${{$promo_code}}@else $0 @endif</span>
                                </div>
                            @endif
                            <div class="form-group">
                                <b>Total amount:</b>
                                <span> ${{number_format($order_item->total_price,2)}}</span>
                            </div>
                        </div>
                </div>    
                <table id="example" class="table table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th width="55%">Items</th>
                            <th width="15%">Image</th>
                            <th width="10%">Cost</th>
                            <th width="10%">Qty</th>
                            <th width="10%">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order_items as $order_item)
                            <tr>
                                <td>{{$order_item->title}}</td>
                                @if($order_item->image)
                                    <td><img src="{{asset('public/images/product_images').'/'.$order_item->image}}" width="50" height="50" class="customer-img rounded-circle"></td>
                                @else
                                    <td><img src="{{asset('public/images/no-image.jpg')}}" width="50" height="50"></td>
                                @endif
                                <td> ${{$order_item->price}}</td>
                                <td>{{$order_item->quantity}}</td>
                                <td>${{$order_item->quantity*$order_item->price}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

