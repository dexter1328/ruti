@extends('employee.layout.main')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="left"><span>About</span></div>
            </div>
            <div class="card-body">
            	<div class="container-fluid">
                    @if(session()->get('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <div class="alert-icon">
                                <i class="fa fa-check"></i>
                            </div>
                            <div class="alert-message">
                                <span><strong>Success!</strong> {{ session()->get('success') }}</span>
                            </div>
                        </div>
                    @endif
                    <div id="ajaxMsg"></div>
                    <form id="addFrm" method="post" action="{{route('pagemeta.about')}}" enctype="multipart/form-data"> 
                        @csrf 
                        <div class="form-group">
                            <label for="title">Title<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" value="{{old('title', isset($about['about_title']) ? $about['about_title'] : '')}}"> 
                            @if ($errors->has('title')) 
                                <span class="text-danger">{{ $errors->first('title') }}</span> 
                            @endif 
                        </div>
                        <div class="form-group">
                            <label for="description">Description<span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="15">{{old('description', isset($about['about_description']) ? $about['about_description']: '')}}</textarea>
                            @if ($errors->has('description')) 
                                <span class="text-danger">{{ $errors->first('description') }}</span> 
                            @endif 
                        </div>
                        <div class="form-group">
                            <label for="image">Image<span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="image">
                            <input type="hidden" name="exist_image" value="{{$about['about_image']}}">
                            @if($about['about_image']!='')
                                <a href="{{asset('public/images/pagemeta/'.$about['about_image'])}}" target="_blank">Click here</a> to view image <br>
                            @endif
                            @if ($errors->has('image')) 
                                <span class="text-danger">{{ $errors->first('image') }}</span> 
                            @endif 
                        </div>
                        <center>
                            <button type="submit" id="submitBtn" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        //$('#description').summernote();
    });
</script>
@endsection 