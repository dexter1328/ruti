@extends('front_end.layout')
@section('content')

{{-- blog start --}}

<div class="blog_main_div">
    <div class="blog_banner w-100 d-flex justify-content-end p-3">
        <h2 class="align-self-center">Nature Checkout Blog</h2>
    </div>
    <div class="row mx-0">
        <div class="blog_cards col-lg-8 col-md-7 p-4">

            <div class="row justify-content-around">
                @foreach ($blogs as $blog)

                <div class="card col-lg-5 px-0 mt-3" style="width: 18rem;">
                    <a class="primary_img" href="{{ route('nature-blog-detail',$blog->id) }}">
                    <img class="card-img-top" src="{{ asset('public/images/blog/' . $blog->image) }}" alt="Card image cap">
                    </a>
                    <div class="card-body">
                        <a href=""><h3>{{ $blog->title }}</h3></a>
                        <p class="card-text"><a href="{{ route('nature-blog-detail',$blog->id) }}"> Click to read the blog</a></p>
                    </div>
                </div>

                @endforeach


            </div>
        </div>
        <div class="latest_blog_cards col-lg-4 col-md-5 p-4 my-4">
            <h3>Latest Posts:</h3>
            <div class="mt-4">
                <div class="card" style="width: 18rem;">
                    <ul class="list-group list-group-flush">
                        @foreach ($latest_blogs as $blog)
                            <li class="list-group-item d-flex align-items-center">
                                <div class="latest_card_pic">
                                    <img src="{{ asset('public/images/blog/' . $blog->image) }}" alt="">
                                </div>
                                <div class="ml-2">
                                    <p class="text-secondary mb-0">51 mins ago</p>
                                    <a href=""><p class="mb-0">{{ $blog->title }}</p></a>
                                </div>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- blog end --}}

@endsection
