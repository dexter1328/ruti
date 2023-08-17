@extends('vendor.layout.main')
@section('content')

<div class="main_div pb-4">
        <div class="header d-flex align-items-center justify-content-center px-4 mb-2 w-100 t">
            <h4>Marketplace</h4>
        </div>
        <div class="row mx-0">
            <div class="search_parent pl-2 col-lg-6 col-sm-12">
                <form class="d-flex align-items-center" role="search">
                    <input class="form-control search_bar" type="search" placeholder="Search Products" aria-label="Search">
                    <button class="btn button_color search_btn" type="submit"><i class="fa fa-search"></i></button>
                  <span class="ml-2">76 product(s)</span>
                </form>
            </div>
        </div>
        <div class="row mx-0">
        <div class="col-lg-6">
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
        <div class="col-lg-6">
        <table class="m-2 mt-4 border mx-auto main_area_table">
            <tr class="table_head border-bottom">
                <th colspan="3" class="p-3">Product Categories </th>
            </tr>
            <tr class="first_table_body">
                <td class="px-4 py-4">
                    <ul class="mb-0">
                        <input type="checkbox" name="" id=""> General
                        <input type="checkbox" name="" id=""> Grocery
                        <input type="checkbox" name="" id=""> Fashion
                        <input type="checkbox" name="" id=""> Digital
                        <input type="checkbox" name="" id=""> Designer
                        <input type="checkbox" name="" id=""> Pharmacy
                    </ul>
                </td>
            </tr>
        </table>
        </div>
        </div>
        <div class="d-flex filter_div mx-2 my-4 justify-content-between p-3">
            <span class="d-flex align-items-center w-100">
            <form class="w-100 second_filter_form justify-content-around" action="">
              <label>Status:</label>
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
            </form>
        </div>
        <div class="filter_div mx-2 my-4 justify-content-between p-3">
            <form class="fulfil_filter d-flex justify-content-around" action="">
                <label>Fulfilled By:</label>
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
            </form>
            </span>
            <span>
                <label for="">Filter:</label>
                <select name="" id="">
                    <option value="">Additional Items</option>
                    <option value="">Additional Items1</option>
                    <option value="">Additional Items2</option>
                </select>
            </span>
        </div>
        <div class="row mx-0 table_overflow">
            <table class="details_table rounded col-12 border">
                <tr class="table_head">
                    <th><input type="checkbox" name="" id=""></th>
                    <th>Status</th>
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
            </table>
        </div>
    </div>

@endsection
