@extends('vendor.layout.main')
@section('content')

<div class="main_div pb-4">
        <div class="header d-flex align-items-center justify-content-center px-4 mb-2 w-100 t">
            <a href=""><h4>Marketplace</h4></a>
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
                            <div class="col-lg-12 d-flex p-3">
                                <button class="btn button_color min_width_btn">Clear Filter</button>
                            </div>
                        </div>
                    </div>
                  <span class="ml-2"><b>{{$supplier_products->count()}}</b> product(s)</span>
                </form>
            </div>
        </div>
        <div class="row mx-0 my-3">
            <div class="col-lg-12 justify-content-center d-flex">
                <button class="btn button_color min_width_btn">Get Seller Api</button>
            </div>
        </div>

        <form action="{{ route('vendor.marketplace-buy-products') }}" method="POST">
            @csrf
            <div class="d-flex mx-auto justify-content-center">
                <button class="btn button_color mt-2 min_width_btn mt-sm-0 mb-2" type="submit" id="buyBtn" disabled >Buy</button>
            </div>
            <div class="row mt-4 mx-0 table_overflow">
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
                    {{-- <th><button class="btn button_color">Save All</button></th> --}}
                </tr>
                @foreach ($supplier_products as $key => $p)
                @php
                    $pct = ($p->wholesale_price/100) * 20;
                @endphp
                <tr class="row-item2">
                    <td><input type="checkbox" onclick={EnableInputFields()}  id="checkItem_{{ $p->sku }}" class="dynamic-checkbox checkItem1" name="product_sku[]" value="{{ $p->sku }}" ></td>
                    <td>{{$p->status == 'enable' ? 'active' : 'inactive'}}</td>
                    <td><input type="number" class="{{ $p->sku }}" disabled name="quantity[{{ $p->sku }}]" required></td>
                    <td><img src="{{$p->original_image_url}}" class="product_image" alt=""></td>
                    <td>{{$p->sku}}</td>
                    <td>{{$p->title}}</td>
                    <td>{{$p->created_at->format('d/m/Y')}}<br> </td>
                    <td><input type="number" value="{{$p->stock}}" disabled></td>
                    <td>${{$pct}}</td>
                    <input type="hidden" value="{{$pct}}" name="nature_fee[{{ $p->sku }}]">
                    <td><input type="number" id="wholesale_price{{ $p->sku }}" value="{{$p->wholesale_price}}" disabled>+$0.00</td>
                    <td><input type="number" class="{{ $p->sku }}" onblur="calculateRetailPrice('{{ $p->sku }}');" id="profit_expected{{ $p->sku }}" required disabled ></td>
                    <td>
                        <input type="number" class="d-none" name="retail_price[{{ $p->sku }}]" id="retail_price{{ $p->sku }}">
                        <input type="number" disabled name="retail_price[{{ $p->sku }}]" id="retail_price_span{{ $p->sku }}">
                    </td>
                    {{-- <td><button class="btn button_color">Edit</button></td> --}}
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
        var wholesale_price = document.getElementById('wholesale_price'+$this).value;
        var profit_expected = document.getElementById('profit_expected'+$this).value;
        var retail_price = document.getElementById('retail_price'+$this).value;
        total_retail_price = parseInt(profit_expected)+parseInt(wholesale_price);
        document.getElementById('retail_price'+$this).value  = total_retail_price;
        document.getElementById('retail_price_span'+$this).value  = total_retail_price;
    }
    function EnableInputFields() {

        document.getElementById('buyBtn').disabled = true
        // Get all checkboxes with the class "dynamic-checkbox"
        const checkboxes = document.querySelectorAll('.dynamic-checkbox');
        // Loop through each checkbox and check its checked property
        checkboxes.forEach(checkbox => {
            const checkboxId = checkbox.id;
            const dynamicId = checkboxId.slice('checkItem_'.length);
        if (checkbox.checked) {
            document.querySelectorAll(`.${dynamicId}`)[0].disabled = false
            document.querySelectorAll(`.${dynamicId}`)[1].disabled = false
            document.getElementById('buyBtn').disabled = false
            document.querySelectorAll(`.${dynamicId}`)[0].parentNode.parentNode.style.backgroundColor = "#008ee25e"
        }
        else {
            document.querySelectorAll(`.${dynamicId}`)[0].parentNode.parentNode.style.backgroundColor = "#e9eaec"
            document.querySelectorAll(`.${dynamicId}`)[0].disabled = true
            document.querySelectorAll(`.${dynamicId}`)[1].disabled = true
        }
    });

    }
</script>

<script>
    $('#checkAll').click(function () {
     $(':checkbox.checkItem1').prop('checked', this.checked);
     EnableInputFields()
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
