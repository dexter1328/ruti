@extends('admin.layout.main')
@section('content')

{{-- code here --}}
<div class="i_funds_body py-5 d-flex justify-content-center">
    <div class="container_withdraw">
        <div class="inner-container">
            <div class="mx-auto">
                <div class="main_section p-4 mb-4">
                    <h5 class="i_text_color my-3">Add New Blog:</h5>
                    <div>
                        <form  method="post" action="{{route('blog.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="col-lg-12 mb-3">
                                <label>Title<span class="text-danger">*</span></label>
                                <input class='form-control' name="title" type='text' placeholder='Enter Title' required>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label>Description<span class="text-danger">*</span></label>
                                <textarea class='form-control' name="description" placeholder='Enter Description' required></textarea>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label>Blog Content<span class="text-danger">*</span></label>
                                <textarea class="summernote7" name="content" required></textarea>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label>Image<span class="text-danger">*</span></label>
                                <input class='form-control' type='file' name="image" required>
                            </div>
                            <div class="form-group row">
                                <div class="col-12 i_buttons">
                                    <button class="btn custom_button w-100" type="submit">Submit</button>
                                </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function() {
          $('.summernote7').summernote({
          height: 200, // set editor height
          minHeight: null, // set minimum height of editor
          maxHeight: null, // set maximum height of editor
          focus: true // set focus to editable area after initializing summernote
       });
        });
    </script>
@endsection
