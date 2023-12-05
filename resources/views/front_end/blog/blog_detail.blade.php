@extends('front_end.layout')
@section('content')


<div class="blog_view_container">
    <div class="blog_container my-4 p-4">
      <div class="blog_view_heading">
        <h2 class="text-center">{{ $blog->title }}</h2>
        <p class="text-right text-secondary">{{ $blog->created_at->format('d M, Y') }}</p>
      </div>
      <div class="blog_view_image text-center">
        <img src="{{ asset('public/images/blog/' . $blog->image) }}" alt="">
      </div>
      <div class="blog_writer_section mt-3">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSDxEjIh3dGm94I_hwVByxG08ZY64lZU7qjhA&usqp=CAU" alt="">
        <div class="mt-2">Joseph Larnyoh</div>
      </div>
      <div class="blog_content">
        {!! $blog->content !!}
        <h5 class="text-center">Credits: Nature Checkout</h5>
      </div>
    </div>
  </div>


  @endsection
