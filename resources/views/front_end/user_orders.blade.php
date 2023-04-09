        <div class="tab-pane fade show active" id="orders">
            @if(session('success'))
            <div class="container alert alert-success text-center" id="ordd">
            {{ session('success') }}
            </div>
            @endif
            <div class="search-container">
                    <input type="text" class='search_bar' placeholder="Search..." id="orderInput">
                    <div class="dropdown">
                        <button class="dropbtn2">Filter</button>
                        <div class="dropdown-content-new">
                            <label class='border-top border-bottom'>Filter by Order Type</label>
                            <label><input type="radio" onclick="window.location='{{ url("user-account/orders") }}'"  name="filter-option" value="option2">All Orders</label>
                            <label><input type="radio" onclick="window.location='{{ url("user-account/processing") }}'"  name="filter-option" value="option1">Orders in Process</label>
                            <label><input type="radio" onclick="window.location='{{ url("user-account/shipped") }}'" name="filter-option" value="option3">Shipped Orders</label>
                            <label><input type="radio" onclick="window.location='{{ url("user-account/delivered") }}'" name="filter-option" value="option4">Delivered Orders</label>
                            <label><input type="radio" onclick="window.location='{{ url("user-account/cancelled") }}'" name="filter-option" value="option4">Cancelled Orders</label>
                            <label class='border-top border-bottom'>Filter by Order Date</label>
                            <label><input type="radio" onclick="window.location='{{ url("user-account/onemonth") }}'" name="filter-option" value="option2">Last 30 days</label>
                            <label><input type="radio" onclick="window.location='{{ url("user-account/threemonth") }}'" name="filter-option" value="option1">Last 3 months</label>
                            <label><input type="radio" onclick="window.location='{{ url("user-account/2023") }}'" name="filter-option" value="option3">2023</label>
                            <label><input type="radio" onclick="window.location='{{ url("user-account/2022") }}'" name="filter-option" value="option4">2022</label>
                            <label><input type="radio" onclick="window.location='{{ url("user-account/2021") }}'" name="filter-option" value="option4">2021</label>
                        </div>
                    </div>
                </div>
            <h3>Orders</h3>
            <div class="table-responsive ordertab" >

                @foreach ($orders as $order)
                <div class="col-12 order_main px-0 border gboo">
                    <div class='d-flex justify-content-between p-3 border orders_header'>
                        <div class='orders_header1 d-flex justify-content-between w-75'>
                            <div>
                                #{{$loop->iteration}}
                            </div>
                            <div>
                                Order Placed
                                <span class='d-block'>{{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y')}}</span>
                            </div>
                            <div>
                                Total
                                <span class='d-block'>${{$order->total_price}}</span>
                            </div>
                            <div>
                                Status
                                <span class='d-block text-primary'>{{ucfirst(trans($order->status))}}</span>
                            </div>
                            <div>
                                Order Duration:
                                <span class='d-block'>3-4 days</span>
                            </div>
                        </div>
                        <div class="orders_header2 text-center">
                            <div>
                                Order# <span>{{$order->order_id}}</span>
                            </div>
                            <div>
                                <span><a href="{{route('user-product-page',$order->order_id)}}" class='text-primary'>Order details</a> | <a href="{{route('order-invoice',$order->order_id)}}" class='text-primary'>Invoice</a></span>
                            </div>
                        </div>
                    </div>

                </div>
                @endforeach
            </div>
        </div>




