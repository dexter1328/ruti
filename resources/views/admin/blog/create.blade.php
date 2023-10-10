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
                        <form action="" method="post">
                            <div class="col-lg-12 mb-3">
                                <label>Title<span class="text-danger">*</span></label>
                                <input class='form-control' type='text' placeholder='Enter Account Title'>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label>Blog Content<span class="text-danger">*</span></label>
                                <textarea class='form-control' type='text' placeholder='Enter blog content here'></textarea>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label>Image<span class="text-danger">*</span></label>
                                <input class='form-control' type='file' placeholder='Enter Account Title'>
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
@endsection
