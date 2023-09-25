@extends('front_end.layout')
@section('content')

{{-- blog start --}}

<div class="blog_main_div">
    <div class="blog_banner w-100 d-flex justify-content-end p-3">
        <h2 class="align-self-center">Nature Checkout Blog</h2>
    </div>
    <div class="row mx-0">
        <div class="blog_cards col-lg-8 col-md-7 p-4">
            <h3 class="mt-2">All Blogs: </h3>
            <div class="row justify-content-around">
                <div class="card col-lg-5 px-0 mt-3" style="width: 18rem;">
                    <img class="card-img-top" src="https://t4.ftcdn.net/jpg/03/84/55/29/360_F_384552930_zPoe9zgmCF7qgt8fqSedcyJ6C6Ye3dFs.jpg" alt="Card image cap">
                    <div class="card-body">
                        <a href=""><h3>Blog Title</h3></a>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content. Some quick example text to build on the card title and make up the bulk of the card's content. Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
                <div class="card col-lg-5 px-0 mt-3" style="width: 18rem;">
                    <img class="card-img-top" src="https://t4.ftcdn.net/jpg/03/84/55/29/360_F_384552930_zPoe9zgmCF7qgt8fqSedcyJ6C6Ye3dFs.jpg" alt="Card image cap">
                    <div class="card-body">
                        <a href=""><h3>Blog Title</h3></a>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content. Some quick example text to build on the card title and make up the bulk of the card's content. Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
                <div class="card col-lg-5 px-0 mt-3" style="width: 18rem;">
                    <img class="card-img-top" src="https://t4.ftcdn.net/jpg/03/84/55/29/360_F_384552930_zPoe9zgmCF7qgt8fqSedcyJ6C6Ye3dFs.jpg" alt="Card image cap">
                    <div class="card-body">
                        <a href=""><h3>Blog Title</h3></a>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content. Some quick example text to build on the card title and make up the bulk of the card's content. Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
                <div class="card col-lg-5 px-0 mt-3" style="width: 18rem;">
                    <img class="card-img-top" src="https://t4.ftcdn.net/jpg/03/84/55/29/360_F_384552930_zPoe9zgmCF7qgt8fqSedcyJ6C6Ye3dFs.jpg" alt="Card image cap">
                    <div class="card-body">
                        <a href=""><h3>Blog Title</h3></a>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content. Some quick example text to build on the card title and make up the bulk of the card's content. Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="latest_blog_cards col-lg-4 col-md-5 p-4 my-4">
            <h3>Latest Posts:</h3>
            <div class="mt-4">
                <div class="card" style="width: 18rem;">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex align-items-center">
                            <div class="latest_card_pic">
                                <img src="https://t4.ftcdn.net/jpg/03/84/55/29/360_F_384552930_zPoe9zgmCF7qgt8fqSedcyJ6C6Ye3dFs.jpg" alt="">
                            </div>
                            <div class="ml-2">   
                                <p class="text-secondary mb-0">51 mins ago</p>
                                <a href=""><p class="mb-0">Latest Post Title</p></a>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <div class="latest_card_pic">
                                <img src="https://t4.ftcdn.net/jpg/03/84/55/29/360_F_384552930_zPoe9zgmCF7qgt8fqSedcyJ6C6Ye3dFs.jpg" alt="">
                            </div>
                            <div class="ml-2">   
                                <p class="text-secondary mb-0">51 mins ago</p>
                                <a href=""><p class="mb-0">Latest Post Title</p></a>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <div class="latest_card_pic">
                                <img src="https://t4.ftcdn.net/jpg/03/84/55/29/360_F_384552930_zPoe9zgmCF7qgt8fqSedcyJ6C6Ye3dFs.jpg" alt="">
                            </div>
                            <div class="ml-2">   
                                <p class="text-secondary mb-0">51 mins ago</p>
                                <a href=""><p class="mb-0">Latest Post Title</p></a>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <div class="latest_card_pic">
                                <img src="https://t4.ftcdn.net/jpg/03/84/55/29/360_F_384552930_zPoe9zgmCF7qgt8fqSedcyJ6C6Ye3dFs.jpg" alt="">
                            </div>
                            <div class="ml-2">   
                                <p class="text-secondary mb-0">51 mins ago</p>
                                <a href=""><p class="mb-0">Latest Post Title</p></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- blog end --}}

@endsection
