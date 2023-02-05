@extends('admin.layout.main')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="left"><!-- <i class="fa fa-bell"></i> --><span>Add Push Notification</span></div>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <form id="signupForm" method="post" action="{{ route('push_notifications.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="input-11" class="col-sm-2 col-form-label">Title<span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" name="title" placeholder="Enter Title" value="{{old('title')}}" class="form-control">
                                @if ($errors->has('title'))
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="input-11" class="col-sm-2 col-form-label">Description<span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="description">{{old('description')}}</textarea>
                                @if ($errors->has('description'))
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                                @endif
                            </div>
                        </div>
                        <center>
                            <div class="form-footer">
                                <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                                <a href="{{url('admin/push_notifications')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
                            </div>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 