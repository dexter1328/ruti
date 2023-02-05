@extends('employee.layout.main')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="left"><span>Footerr</span></div>
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
                    <form id="addFrm" method="post" action="{{route('pagemeta.footer')}}" enctype="multipart/form-data"> 
                        @csrf 
                        <div class="form-group">
                            <label for="title">Title<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" value="{{old('title', isset($footer['footer_title']) ? $footer['footer_title'] : '')}}"> 
                            @if ($errors->has('title')) 
                                <span class="text-danger">{{ $errors->first('title') }}</span> 
                            @endif 
                        </div>
                        <div class="form-group">
                            <label for="description">Description<span class="text-danger">*</span></label>
                            <textarea class="form-control" name="description" rows="5">{{old('description', isset($footer['footer_description']) ? $footer['footer_description'] : '')}}</textarea>
                            @if ($errors->has('description')) 
                                <span class="text-danger">{{ $errors->first('description') }}</span> 
                            @endif 
                        </div>
                        <div class="form-group">
                            <label for="facebook_link">Facebook Link<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="facebook_link" value="{{old('facebook_link', isset($footer['footer_facebook_link']) ? $footer['footer_facebook_link'] : '')}}"> 
                            @if ($errors->has('facebook_link')) 
                                <span class="text-danger">{{ $errors->first('facebook_link') }}</span> 
                            @endif 
                        </div>
                        <div class="form-group">
                            <label for="twitter_link">Twitter Link<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="twitter_link" value="{{old('twitter_link', isset($footer['footer_twitter_link']) ? $footer['footer_twitter_link'] : '')}}"> 
                            @if ($errors->has('twitter_link')) 
                                <span class="text-danger">{{ $errors->first('twitter_link') }}</span> 
                            @endif 
                        </div>
                        <div class="form-group">
                            <label for="linkedin_link">LinkedIn Link<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="linkedin_link" value="{{old('linkedin_link', isset($footer['footer_linkedin_link']) ? $footer['footer_linkedin_link'] : '')}}"> 
                            @if ($errors->has('linkedin_link')) 
                                <span class="text-danger">{{ $errors->first('linkedin_link') }}</span> 
                            @endif 
                        </div>
                        <div class="form-group">
                            <label for="instagram_link">Instagram Link<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="instagram_link" value="{{old('instagram_link', isset($footer['footer_instagram_link']) ? $footer['footer_instagram_link'] : '')}}"> 
                            @if ($errors->has('instagram_link')) 
                                <span class="text-danger">{{ $errors->first('instagram_link') }}</span> 
                            @endif 
                        </div>
                        <div class="form-group">
                            <label for="pinterest_link">Pinterest Link<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="pinterest_link" value="{{old('pinterest_link', isset($footer['footer_pinterest_link']) ? $footer['footer_pinterest_link'] : '')}}"> 
                            @if ($errors->has('pinterest_link')) 
                                <span class="text-danger">{{ $errors->first('pinterest_link') }}</span> 
                            @endif 
                        </div>
                        <div class="form-group">
                            <label for="tiktok_link">TikTok Link<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="tiktok_link" value="{{old('tiktok_link', isset($footer['footer_tiktok_link']) ? $footer['footer_tiktok_link'] : '')}}"> 
                            @if ($errors->has('tiktok_link')) 
                                <span class="text-danger">{{ $errors->first('tiktok_link') }}</span> 
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