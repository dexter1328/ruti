@extends('admin.layout.main')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
               <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <form id="signupForm" method="post" action="{{ route('banners.store') }}" enctype="multipart/form-data">
               @csrf
                <h4 class="form-header text-uppercase">
                  <i class="fa fa-address-book-o"></i>
                  Banners
                </h4>
                <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">Name</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="input-10" name="name" placeholder="Enter Name">
                  </div>
                  <label for="input-11" class="col-sm-2 col-form-label">Content</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="input-11" name="content" placeholder="Enter Content">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="input-12" class="col-sm-2 col-form-label">Image</label>
                  <div class="col-sm-4">
                    <input type="file" class="form-control" id="input-8" name="file" required>
                  </div>
                  <label for="input-13" class="col-sm-2 col-form-label">Status</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="input-13" name="status" placeholder="Enter Status">
                  </div>
                </div> 

                 
               <center> <div class="form-footer">
               	 <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                    <button type="submit" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button>
                   
                </div></center>
              </form>
            </div>
          </div>
        </div>
      </div><!--End Row-->
            </div>
        </div>
    </div>
</div>
 <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script>

    $(document).ready(function() {

   // validate signup form on keyup and submit
    $("#signupForm").validate({
        rules: {
            name: "required",
            content: "required",
            username: {
                required: true,
                minlength: 2
            },
            status:{
              required:true
            },
            password: {
                required: true,
                minlength: 5
            },
            confirm_password: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            },
            email: {
                required: true,
                email: true
            },
             contactnumber: {
                required: true,
                minlength: 10
            },
            topic: {
                required: "#newsletter:checked",
                minlength: 2
            },
            agree: "required"
        },
        messages: {
            name: "Please enter your name",
            content: "Please enter your content",
            username: {
                required: "Please enter a username",
                minlength: "Your username must consist of at least 2 characters"
            },
            file:{
              required:"Please choose file"
            },
            status:{
              required:"Please enter your status",
              },
              password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
            confirm_password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Please enter the same password as above"
            },
            email: "Please enter a valid email address",
            contactnumber: "Please enter your 10 digit number",
            agree: "Please accept our policy",
            topic: "Please select at least 2 topics"
        }
    });

});

    </script>
   
@endsection
