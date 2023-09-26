@extends('vendor.layout.main')

@section('content')

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
                   <span>Order # {{$return_item->order_no}} Return Details</span>
                </div>
            </div>
            <div class="card-body">
                <div class="order-details">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <b>Customer:</b>
                                <span>{{$return_item->first_name}} {{$return_item->last_name}}</span>
                            </div>

                            <div class="form-group">
                                <b>Mobile:</b>
                                <span>{{$return_item->mobile}}</span>
                            </div>

                            <div class="form-group">
                                <b>Email:</b>
                                <span> {{$return_item->email}}</span>
                            </div>


                        </div>

                        <div class="col-sm-6">


                            <div class="form-group">
                                <b>Item Total:</b>
                                <span>${{number_format($return_item->retail_price,2)}}</span>
                            </div>

                        </div>

                    </div>
                </div>

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
                            <th width="30%">Image</th>
                            <th width="40%">Product title</th>
                            <th width="30%">Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @if($return_item->original_image_url)
                                <td><img src="{{$return_item->original_image_url}}" width="50" height="50" class="customer-img rounded-circle"></td>
                            @else
                                <td><img src="{{asset('public/images/no-image.jpg')}}" width="50" height="50"></td>
                            @endif
                            <td class="title">
                                <div class="item-title">{{$return_item->title}}</div>
                            </td>
                            <td> ${{$return_item->retail_price}}</td>

                        </tr>


                    </tbody>
                </table>
                <div class="return-reason mt-5">
                    <div class="form-group">
                        <b>Reason for Return:</b>
                        <span>{{$return_item->reason}}</span>
                    </div>

                    <div class="form-group">
                        <b>Comment by Customer:</b>
                        <span>{{$return_item->comment}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
