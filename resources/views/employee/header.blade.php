@extends('employee.layout.main')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="left"><span>Header</span></div>
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
                    <form id="addFrm" method="post" action="{{route('pagemeta.header')}}" enctype="multipart/form-data"> 
                        @csrf 
                        <div class="form-group">
                            <label for="title">Title<span class="text-danger">*</span></label>
                            <textarea class="form-control" name="title" rows="5">{{old('title', isset($header['header_title']) ? $header['header_title']: '')}}</textarea>
                            @if ($errors->has('title')) 
                                <span class="text-danger">{{ $errors->first('title') }}</span> 
                            @endif 
                        </div>
                        <div class="form-group">
                            <label for="android_app_link">Android APP Link<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="android_app_link" value="{{old('android_app_link', isset($header['header_android_app_link']) ? $header['header_android_app_link'] : '')}}"> 
                            @if ($errors->has('android_app_link')) 
                                <span class="text-danger">{{ $errors->first('android_app_link') }}</span> 
                            @endif 
                        </div>
                        <div class="form-group">
                            <label for="ios_app_link">IOS APP Link<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="ios_app_link" value="{{old('ios_app_link', isset($header['header_ios_app_link']) ? $header['header_ios_app_link'] : '')}}"> 
                            @if ($errors->has('ios_app_link')) 
                                <span class="text-danger">{{ $errors->first('ios_app_link') }}</span> 
                            @endif 
                        </div>
                        <div class="form-group">
                            <label for="image">Image<span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="image">
                            <input type="hidden" name="exist_image" value="{{isset($header['header_image']) ? $header['header_image'] : ''}}">
                            @if(isset($header['header_image']) && $header['header_image']!='')
                                <a href="{{asset('public/images/pagemeta/'.$header['header_image'])}}" target="_blank">Click here</a> to view image <br>
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
@endsection 