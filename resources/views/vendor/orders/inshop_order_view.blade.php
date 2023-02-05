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
                                    <td><img src="{{asset('public/images/product_images').'/'.$order_item->image}}" width="50" height="50" class="customer-img rounded-circle"></td>
                                @else
                                    <td><img src="{{asset('public/images/no-image.jpg')}}" width="50" height="50"></td>
                                @endif
                               <td class="title">
                                    <div class="item-title">{{$order_item->title}}</div>
                                    <div class="change-status">
                                        <form method="POST" action="{{url('vendor/orders/pickup_order/change_status',$order_item->order_id)}}">
                                            @csrf
                                            <select name="status_change" class="form-control status-change">
                                                <option value="pending" {{$order_item->order_status == 'pending' ? 'selected="selected"' : ''}}>pending</option>
                                                <option value="completed" {{$order_item->order_status == 'completed' ? 'selected="selected"' : ''}}>completed</option>
                                                <option value="cancelled" {{$order_item->order_status == 'cancelled' ? 'selected="selected"' : ''}}>cancelled</option>
                                            </select>
                                       
                                    </div>
                                </td>
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
                        <tr align="right">
                            <td colspan="5">
                                <span class="change-status">
                                    <input type="hidden" name="btnsubmit" value="inshop">
                                    <input type="submit" value="submit" name = "submit" class="btn btn-outline-primary btn-sm waves-effect waves-light">
                                     </form>
                                </span>    
                            </td>
                        </tr>
                    </tbody>
                </table> 
            </div>
        </div>
    </div>
</div>


@endsection

