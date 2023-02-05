@extends('admin.layout.main')

@section('content')

@if(!empty($order_items))
@php   $fund=0; @endphp
    @php 
        $count = 1;
        $id =  $order_items->order_id;
        $date = $order_items->created_at;
        $type = $order_items->type;
        $status = $order_items->status;
        $fund+=$order_items->quantity*$order_items->price; 
        $first_name = $order_items->first_name;
        $last_name = $order_items->last_name;
        $email = $order_items->email;
        $mobile = $order_items->mobile;
        $store = $order_items->store;
        $gems_points = $order_items->gems_point;
        $coins_point = $order_items->coin_point;
        $promo_code = $order_items->promo_code;
    @endphp
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
                                <span>${{number_format($order_items->item_total,2)}}</span>
                            </div>
                            <div class="form-group">
                                <b>Tax:</b>
                                <span>@if(!empty($order_items->tax))${{$order_items->tax}}@else $0 @endif</span>
                            </div>
                            @if(!empty($order_items->reward_point))
                            <div class="form-group">
                                <b>Reward:</b>

                                <span>${{$gems_points/$gem_setting->value + $coins_point/$coin_setting->value}}</span>
                              
                              
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
                                <span> ${{number_format($order_items->total_price,2)}}</span>
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
                        <tr>
                            @if($order_items->image)
                                <td><img src="{{asset('public/images/product_images').'/'.$order_items->image}}" width="50" height="50" class="customer-img rounded-circle"></td>
                            @else
                                <td><img src="{{asset('public/images/no-image.jpg')}}" width="50" height="50"></td>
                            @endif
                            <td class="title">
                                <div class="item-title">{{$order_items->title}}</div>
                                <div class="change-status">
                                    <form method="POST" action="{{route('order_return.update',$order_items->id)}}">
                                        @csrf
                                        @method('PATCH')
                                       <!--  <select name="status_change" class="form-control status-change">
                                            <option value="return_request" {{$order_items->status == 'return_request' ? 'selected="selected"' : ''}}>Return Request</option>
                                            <option value="return" {{$order_items->status == 'return' ? 'selected="selected"' : ''}}>Return</option>
                                        </select> -->
                                   
                                </div>
                            </td>
                            <td> ${{$order_items->price}}</td>
                            <td>{{$order_items->quantity}}</td>
                            <td>
                                ${{$order_items->quantity*$order_items->price}}
                            </td>
                        </tr>
                        <tr align="right">
                            <td colspan="5">
                                Total: <b>${{$order_items->quantity*$order_items->price}}</b>
                            </td>
                        </tr>
                        <tr align="right">
                            <td colspan="5">
                                <span class="change-status">
                                    <input type="submit" name="submit" value="Return" class="btn btn-outline-primary btn-sm waves-effect waves-light">
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

