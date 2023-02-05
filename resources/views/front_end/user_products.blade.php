@extends('front_end.layout')
@section('content')

@if(session('success'))
<div class="alert alert-success">
  {{ session('success') }}
</div>
@endif


<!--breadcrumbs area start-->
<div class="mt-70">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                   <h3>Ordered Products</h3>
                    <ul>
                        <li><a href="#">home</a></li>
                        <li>Ordered Products</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!--breadcrumbs area end-->


<!--wishlist area start -->
<div class="wishlist_area mt-70">
    <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="table_desc wishlist">
                        <div class="cart_page table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="product_thumb">#</th>
                                        <th class="product_thumb">Image</th>
                                        <th class="product_name">Product</th>
                                        <th class="product-price">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $p)
                                    <tr>

                                         <td class="product_thumb">{{$loop->iteration}}</td>
                                         <td class="product_thumb"><a href="#"><img src="{{$p->image}}" alt=""></a></td>
                                         <td class="product_name"><a href="#">{{$p->title}}</a></td>
                                         <td class="product-price">{{$p->price}}</td>


                                     </tr>

                                    @endforeach


                                </tbody>
                            </table>
                        </div>

                    </div>
                 </div>
             </div>
        {{-- <div class="row">
            <div class="col-12">
                 <div class="wishlist_share">
                    <h4>Share on:</h4>
                    <ul>
                        <li><a href="#"><i class="fa fa-rss"></i></a></li>
                        <li><a href="#"><i class="fa fa-vimeo"></i></a></li>
                        <li><a href="#"><i class="fa fa-tumblr"></i></a></li>
                        <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
        </div> --}}

    </div>
</div>
<!--wishlist area end -->



@endsection


@section('scriptss')

<script>
     $("document").ready(function(){
        setTimeout(function() {
        $('.alert-success').fadeOut('fast');
        }, 3000);

    });
</script>
@endsection
