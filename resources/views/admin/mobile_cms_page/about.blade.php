
<!DOCTYPE html>
<html>
<head>
    <title>{{$pages->title}}</title>
    @if(!$pages->image)
        <style type="text/css">
            .img{
                display: none;
            }
        </style>
    @endif
        <style type="text/css">
            .card-header{
                text-align: center;
            }
            p{
                text-align: justify;
            }
        </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <center><div class="card-header"><h1>{{$pages->title}}</h1></div></center>
                    <center><div id ="img" class="img"><img src="{{asset('public/images/page').'/'.$pages->image}}" width="100%" height="50%"></div></center>
                    <div class="card-body">
                
                       {!!html_entity_decode($pages->content)!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

