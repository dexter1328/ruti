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
                                <div class='filters_sec mr-3'>
                                    <h5>Product Categories:</h5>
                                    @foreach ($categories as $c)
                                    <ul class="mb-0">
                                    <input type="checkbox" name="category_name[]" value="{{ $c->category1 }}"> {{ $c->category1 }}
                                    </ul>
                                    @endforeach
                                </div>
                                <div class='filters_sec mr-3'>
                                    <h5>Status:</h5>
                                    <span>
                                        <input type="radio"  value="">
                                        <label for="">All</label>
                                    </span>
                                    <span>
                                        <input type="radio" name="status" value="enable">
                                        <label for="">Active</label>
                                        </span>
                                    <span>
                                        <input type="radio" name="status" value="disable">
                                        <label for="">InActive</label>
                                        </span>

                                </div>
                                <div class='filters_sec mr-3'>
                                    <h5>Fulfilled By:</h5>
                                    <span>
                                        <input type="radio"  value="">
                                        <label for="">All</label>
                                    </span>
                                    <span>
                                        <input type="radio" name="fulfill_type" value="nature">
                                        <label for="">Nature Checkout</label>
                                    </span>
                                    <span>
                                        <input type="radio" name="fulfill_type" value="seller">
                                        <label for="">Vendor</label>
                                    </span>
                                </div>
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
            <form action="{{ route('vendor.marketplace-buy-products') }}" method="POST">
            @csrf
            <button class="btn button_color mt-2 mt-sm-0 mb-2" type="submit" id="buyBtn" disabled >Buy</button>
            <table class="details_table rounded col-12 border">
                <tr class="table_head">
                    <th><input type="checkbox" name="" id="checkAll"></th>
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
                @foreach ($supplier_products as $key => $p)
                @php
                    $pct = ($p->wholesale_price/100) * 30;
                @endphp
                <tr class="row-item2">
                    <td><input type="checkbox"  id="chkk1" class="checkItem1" name="product_sku[]" value="{{ $p->sku }}" ></td>
                    <td>{{$p->status == 'enable' ? 'active' : 'inactive'}}</td>
                    <td><input type="number"  name="quantity[{{ $p->sku }}]"></td>
                    <td><img src="{{$p->original_image_url}}" class="product_image" alt=""></td>
                    <td>{{$p->sku}}</td>
                    <td>{{$p->title}}</td>
                    <td>{{$p->created_at->format('d/m/Y')}}<br> </td>
                    <td><input type="number" value="{{$p->stock}}" disabled></td>
                    <td>${{$pct}}</td>
                    <td><input type="number" id="wholesale_price{{ $p->sku }}" value="{{$p->wholesale_price}}" disabled>+$0.00</td>
                    <td><input type="number" onblur="calculateRetailPrice('{{ $p->sku }}');" id="profit_expected{{ $p->sku }}" value="0"></td>
                    <td><input type="number" name="retail_price[{{ $p->sku }}]" id="retail_price{{ $p->sku }}"    ></td>
                    <td><button class="btn button_color">Edit</button></td>
                </tr>
                @endforeach

            </table>
            </form>
        </div>
    </div>




@endsection

@section('customJS')
<script type="text/javascript">

    function calculateRetailPrice($this) {
        console.log($this);
        var wholesale_price = document.getElementById('wholesale_price'+$this).value;
        var profit_expected = document.getElementById('profit_expected'+$this).value;
        var retail_price = document.getElementById('retail_price'+$this).value;
         console.log(profit_expected)

            total_retail_price = parseInt(profit_expected)+parseInt(wholesale_price);
            document.getElementById('retail_price'+$this).value  = total_retail_price;
            console.log(total_retail_price)
    }
</script>

<script>
    $('#checkAll').click(function () {
     $(':checkbox.checkItem1').prop('checked', this.checked);
 });

</script>
<script>
   var checker = document.getElementById('checkAll');
    var checker2 = document.getElementById('chkk1');
 var buyBtn = document.getElementById('buyBtn');
//  when unchecked or checked, run the function
 checker.onchange = function(){
if(this.checked){
    buyBtn.disabled = false;
} else {
    buyBtn.disabled = true;
}
}

checker2.onchange = function(){
    if(this.checked){
    buyBtn.disabled = false;
} else {
    buyBtn.disabled = true;
}
}




</script>


<script>

</script>

@endsection
