
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Suggested Producs</title>

   <style>

            body{
        background-color: #eeeeee;
    }

    .container{
        margin-top:50px;
        margin-bottom: 50px;
    }

    a{
        text-decoration: none !important;
    }

    .card-product-list, .card-product-grid {
        margin-bottom: 0;
    }

    .card {

        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 0.10rem;
        margin-top: 10px;



    }

    .card-product-grid:hover {
        -webkit-box-shadow: 0 4px 15px rgba(153, 153, 153, 0.3);
        box-shadow: 0 4px 15px rgba(153, 153, 153, 0.3);
        -webkit-transition: .3s;
        transition: .3s;
    }


    .card-product-grid .img-wrap {
        border-radius: 0.2rem 0.2rem 0 0;
        height: 220px;
    }


    .card .img-wrap {
        overflow: hidden;
    }

    .card-lg .img-wrap {
        height: 280px;
    }


    .card-product-grid .img-wrap {
        border-radius: 0.2rem 0.2rem 0 0;
            height: 228px;
            padding: 16px;
    }

    [class*='card-product'] .img-wrap img {
        height: 100%;
        max-width: 100%;
        width: auto;
        display: inline-block;
        -o-object-fit: cover;
        object-fit: cover;
    }

    .img-wrap {
        text-align: center;
        display: block;
    }

    .card-product-grid .info-wrap {
        overflow: hidden;
        padding: 18px 20px;
    }

    [class*='card-product'] a.title {
        color: #212529;
        display: block;
    }

    .rating-stars {
        display: inline-block;
        vertical-align: middle;
        list-style: none;
        margin: 0;
        padding: 0;
        position: relative;
        white-space: nowrap;
        clear: both;
    }


    .rating-stars li.stars-active {
        z-index: 2;
        position: absolute;
        top: 0;
        left: 0;
        overflow: hidden;
    }

    .rating-stars li {
        display: block;
        text-overflow: clip;
        white-space: nowrap;
        z-index: 1;
    }

    .card-product-grid .bottom-wrap {
        padding: 18px;
        border-top: 1px solid #e4e4e4;
    }

    .btn {
        display: inline-block;
        font-weight: 600;
        color: #343a40;
        text-align: center;
        vertical-align: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        background-color: transparent;
        border: 1px solid transparent;
        padding: 0.45rem 0.85rem;
        font-size: 1rem;
        line-height: 1.5;
            border-radius: 0.2rem;

    }

    .btn-primary {
        color: #fff;
        background-color: #3167eb;
        border-color: #3167eb;
    }

    .fa{
            color: #FF5722;
    }

    </style>
       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" integrity="sha512-3P8rXCuGJdNZOnUx/03c1jOTnMn3rP63nBip5gOP2qmUh5YAdVAvFZ1E+QLZZbC1rtMrQb+mah3AfYW11RUrWA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

    <h4>Hi {{$customer->first_name}},</h4>
    <p>You can buy the Suggested product</p>

    <div class="container">
        <div class="row">
@foreach ($suggested_products as $item)
<div class="col-md-4">
    <figure class="card card-product-grid card-lg">
        <a href="#" class="img-wrap" data-abc="true"><img src="{{$item->original_image_url}}"></a>
        <figcaption class="info-wrap">
                   <div class="row">

                       <div class="col-4" style="text-align:center;">

                           <a href="#" class="title" data-abc="true">{{$item->title}}</a>

                       </div>

                   </div>

        </figcaption>
        <div class="bottom-wrap" style="text-align:center;">
            <a href="{{url('shop/product_detail').'/'.$item->slug.'/'.$item->Sku}}" class="btn  btn-primary text-centr" data-abc="true"> Buy now </a>
            <div class="price-wrap">
                <span class="price h5">Retail Price:{{$item->retail_price}}</span> <br> <small class="text-success">shipping {{$item->shipping_price}}:</small>
            </div>
        </div>
    </figure>
</div>
@endforeach


      </div>
    </div>


    Regards,<br>
    <p>from {{$supplier->name}},</p>


</body>
</html>

