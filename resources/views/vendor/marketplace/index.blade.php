@extends('vendor.layout.main')
@section('content')

<div class="main_div pb-4">
        <div class="header d-flex align-items-center justify-content-center px-4 mb-2 w-100 t">
            <h4>Marketplace</h4>
        </div>
        <div class="row mx-0">
            <div class="search_parent pl-2 col-lg-6 col-sm-12">
                <form class="d-flex align-items-center" action="{{route('vendor.product-search')}}" method="get">
                    <input class="form-control search_bar" placeholder="Search Products" aria-label="Search" type="text" name="query" id="query" value="{{request()->input('query')}}" >
                    <button class="btn button_color search_btn" type="submit"><i class="fa fa-search"></i></button>
                    <div class="input-group-append">
                        <button class="btn button_color search_btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-filter"></i></button>
                        <div class="dropdown-menu p-3">
                            <div class='d-flex'>
                                <form action="{{route('vendor.product-search')}}" method="get">
                                <div class='filters_sec mr-3'>
                                    <h4>Product Categories:</h4>
                                    @foreach ($categories as $c)
                                    <ul class="mb-0">
                                    <input type="checkbox" name="category_name[]" value="{{ $c->category1 }}"> {{ $c->category1 }}
                                    </ul>
                                    @endforeach
                                </div>
                                <div class='filters_sec mr-3'>
                                    <h4>Status:</h4>
                                    <span>
                                        <input type="radio" name="first_section" value="all">
                                        <label for="">All</label>
                                    </span>
                                    <span>
                                        <input type="radio" name="first_section" value="active">
                                        <label for="">Active</label>
                                        </span>
                                    <span>
                                        <input type="radio" name="first_section" value="inactive">
                                        <label for="">InActive</label>
                                        </span>
                                    <span>
                                        <input type="radio" name="first_section" value="incomplete">
                                        <label for="">Incomplete</label>
                                        </span>
                                    <span>
                                        <input type="radio" name="first_section" value="listing_removed">
                                        <label for="">Listing Removed</label>
                                        </span>
                                    <span>
                                        <input type="radio" name="first_section" value="listing_removed">
                                        <label for="">Search Suppressed</label>
                                    </span>
                                </div>
                                <div class='filters_sec mr-3'>
                                    <h4>Fulfilled By:</h4>
                                    <span>
                                        <input type="radio" name="second_section" value="all">
                                        <label for="">All</label>
                                    </span>
                                    <span>
                                        <input type="radio" name="second_section" value="amazon">
                                        <label for="">Nature Checkout</label>
                                    </span>
                                    <span>
                                        <input type="radio" name="second_section" value="merchant">
                                        <label for="">Vendor</label>
                                    </span>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                  <span class="ml-2"><b>{{$supplier_products->count()}}</b> product(s)</span>
                </form>
            </div>
        </div>
        <div class="row mx-0">
        <div class="col-lg-12">
        <table class="m-2 mt-4 border mx-auto main_area_table">
            <tr class="table_head border-bottom">
                <th colspan="3" class="p-3">Main Areas:
                    <span><input type="checkbox" name="" id=""> Supplier</span>
                    <span><input type="checkbox" name="" id=""> Seller</span>
                    <span><input type="checkbox" name="" id=""> Affiliate</span>
                </th>
            </tr>
            <tr class="first_table_body">
                <td class="px-4 py-4"><span class="me-4"><a href="">Seller Api</a></span></td>
                <td class="px-4 py-4"><span class="me-4"><a href="">Commission Details</a></span></td>
                <td class="px-2">
                    <button class="btn button_color mt-2 mt-sm-0 mb-2">Add Variation</button>
                    <button class="btn button_color mt-2 mt-sm-0 mb-2">Add Product</button>
                </td>
            </tr>
        </table>
        </div>
        </div>
        <div class="row mt-4 mx-0 table_overflow">
            <table class="details_table rounded col-12 border">
                <tr class="table_head">
                    <th><input type="checkbox" name="" id=""></th>
                    <th>Status</th>
                    <th>Quantity</th>
                    <th>Image</th>
                    <th>SKU</th>
                    <th>Product Name</th>
                    <th>Basic Control</th>
                    <th>Available</th>
                    <th>Estimated fee per unit sold</th>
                    <th>Price and Shipping Unit = Wholesale Price</th>
                    <th>Profit Expected / Commission</th>
                    <th>WholeSale Price + Profit Expected = Retail Price</th>
                    <th><button class="btn button_color">Save All</button></th>
                </tr>
                @foreach ($supplier_products as $p)
                @php
                    $pct = ($p->wholesale_price/100) * 30;
                @endphp
                <tr>
                    <td><input type="checkbox" name="" id=""></td>
                    <td>{{$p->status == 'enable' ? 'active' : 'inactive'}}</td>
                    <td><input type="number" value="1" disabled></td>
                    <td><img src="{{$p->original_image_url}}" class="product_image" alt=""></td>
                    <td>{{$p->sku}}</td>
                    <td>{{$p->title}}</td>
                    <td>{{$p->created_at->format('d/m/Y')}}<br> </td>
                    <td><input type="number" value="{{$p->stock}}" disabled></td>
                    <td>${{$pct}}</td>
                    <td><input type="number" id="wholesale_price" value="{{$p->wholesale_price}}" disabled>+$0.00</td>
                    <td><input type="number" onblur={calculateRetailPrice()} id="profit_expected"></td>
                    <td><input type="number" id="retail_price" disabled></td>
                    <td><button class="btn button_color">Edit</button></td>
                </tr>
                @endforeach

                {{-- <tr>
                    <td><input type="checkbox" name="" id=""></td>
                    <td>Active</td>
                    <td><img src="images/new.jpg" class="product_image" alt=""></td>
                    <td>YL-87-98-AB</td>
                    <td>Wireless Headphones</td>
                    <td>07/11/2023 12:50</td>
                    <td><input type="number" value="4"></td>
                    <td>$5.55</td>
                    <td><input type="number" value="24.99">+$0.00</td>
                    <td><input type="number" value="24.99"></td>
                    <td>$2.5</td>
                    <td><button class="btn button_color">Edit</button></td>
                </tr>
                <tr>
                    <td><input type="checkbox" name="" id=""></td>
                    <td>Active</td>
                    <td><img src="images/new.jpg" class="product_image" alt=""></td>
                    <td>YL-87-98-AB</td>
                    <td>Wireless Headphones</td>
                    <td>07/11/2023 12:50</td>
                    <td><input type="number" value="4"></td>
                    <td>$5.55</td>
                    <td><input type="number" value="24.99">+$0.00</td>
                    <td><input type="number" value="24.99"></td>
                    <td>$2.5</td>
                    <td><button class="btn button_color">Edit</button></td>
                </tr> --}}
                {{-- <tr>
                    <td><input type="checkbox" name="" id=""></td>
                    <td>Active</td>
                    <td><img src="images/new.jpg" class="product_image" alt=""></td>
                    <td>YL-87-98-AB</td>
                    <td>Wireless Headphones</td>
                    <td>07/11/2023 12:50</td>
                    <td><input type="number" value="4"></td>
                    <td>$5.55</td>
                    <td><input type="number" value="24.99">+$0.00</td>
                    <td><input type="number" value="24.99"></td>
                    <td>$2.5</td>
                    <td><button class="btn button_color">Edit</button></td>
                </tr>
                <tr>
                    <td><input type="checkbox" name="" id=""></td>
                    <td>Active</td>
                    <td><img src="images/new.jpg" class="product_image" alt=""></td>
                    <td>YL-87-98-AB</td>
                    <td>Wireless Headphones</td>
                    <td>07/11/2023 12:50</td>
                    <td><input type="number" value="4"></td>
                    <td>$5.55</td>
                    <td><input type="number" value="24.99">+$0.00</td>
                    <td><input type="number" value="24.99"></td>
                    <td>$2.5</td>
                    <td><button class="btn button_color">Edit</button></td>
                </tr>
                <tr>
                    <td><input type="checkbox" name="" id=""></td>
                    <td>Active</td>
                    <td><img src="images/new.jpg" class="product_image" alt=""></td>
                    <td>YL-87-98-AB</td>
                    <td>Wireless Headphones</td>
                    <td>07/11/2023 12:50</td>
                    <td><input type="number" value="4"></td>
                    <td>$5.55</td>
                    <td><input type="number" value="24.99">+$0.00</td>
                    <td><input type="number" value="24.99"></td>
                    <td>$2.5</td>
                    <td><button class="btn button_color">Edit</button></td>
                </tr>
                <tr>
                    <td><input type="checkbox" name="" id=""></td>
                    <td>Active</td>
                    <td><img src="images/new.jpg" class="product_image" alt=""></td>
                    <td>YL-87-98-AB</td>
                    <td>Wireless Headphones</td>
                    <td>07/11/2023 12:50</td>
                    <td><input type="number" value="4"></td>
                    <td>$5.55</td>
                    <td><input type="number" value="24.99">+$0.00</td>
                    <td><input type="number" value="24.99"></td>
                    <td>$2.5</td>
                    <td><button class="btn button_color">Edit</button></td>
                </tr> --}}
            </table>
        </div>
    </div>
<script type="text/javascript">
    var wholesale_price = document.getElementById('wholesale_price')
    var profit_expected = document.getElementById('profit_expected')
    var retail_price = document.getElementById('retail_price')
    function calculateRetailPrice() {
        console.log(retail_price.value)
        if(profit_expected.value > 1) {
            retail_price.value = profit_expected + wholesale_price
        }
    }
</script>
@endsection
