@extends('admin.layout.main')

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <div class="left"><!-- <i class="fa fa-address-book-o"></i> --><span>Edit Menu</span></div>
      </div>
      <div class="card-body">
         @if ($errors->any())
       <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
        <form id="signupForm" method="post" action="{{ route('menus.update',$menu->id) }}" enctype="multipart/form-data">
          @csrf
          @method('PATCH')
          
          <div class="form-group row">
            <label for="input-10" class="col-sm-2 col-form-label">Name<span class="text-danger">*</span></label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="input-10" name="name" placeholder="Enter Name" value="{{$menu->menu_name}}">
            </div>
            <label for="input-11" class="col-sm-2 col-form-label">Position<span class="text-danger">*</span></label>
            <div class="col-sm-4">
              <select name="position" class="form-control">
                <option value="">Select Position</option>
                <option value="header" @if($menu->position =='header') selected="selected" @endif>Header</option>
                <option value="footer" @if($menu->position=='footer') selected="selected" @endif>Footer</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="input-13" class="col-sm-2 col-form-label">Status<span class="text-danger">*</span></label>
            <div class="col-sm-4">
              <select name="status" class="form-control">
                <option value="">Select Status</option>
                <option value="active" @if($menu->status=='active') selected="selected" @endif>Active</option>
                <option value="deactive" @if($menu->status=='deactive') selected="selected" @endif>Deactive</option>
              </select>
            </div>
          </div>
          <center>
            <div class="form-footer">
              <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
              <button type="submit" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button>
            </div>
          </center>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection 