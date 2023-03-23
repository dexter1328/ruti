@extends('front_end.layout')
@section('content')


<!--breadcrumbs area start-->
<div class="mt-70">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                   <h3>My Account</h3>
                    <ul>
                        <li><a href="#">home</a></li>
                        <li>My Account</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!-- my account start  -->
<section class="main_content_area">
    <div class="container">
        <div class="account_dashboard">
            <div class="row">
                <div class="col-sm-12 col-md-3 col-lg-3">
                    <!-- Nav tabs -->
                    <div class="dashboard_tab_button">
                        <ul role="tablist" class="nav flex-column dashboard-list">
                            <li><a href="#dashboard" data-toggle="tab" class="nav-link active">Dashboard</a></li>
                            <li> <a href="#orders" data-toggle="tab" class="nav-link">Orders</a></li>
                            {{-- <li><a href="#downloads" data-toggle="tab" class="nav-link">Downloads</a></li>
                            <li><a href="#address" data-toggle="tab" class="nav-link">Addresses</a></li>
                            <li><a href="#account-details" data-toggle="tab" class="nav-link">Account details</a></li>
                            <li><a href="login.html" class="nav-link">logout</a></li> --}}
                        </ul>
                    </div>
                </div>
                <div class="col-sm-12 col-md-9 col-lg-9">
                    <!-- Tab panes -->
                    <div class="tab-content dashboard_content">
                        <div class="tab-pane fade" id="dashboard">
                            <h3>Hello {{Auth::guard('w2bcustomer')->user()->first_name}} {{Auth::guard('w2bcustomer')->user()->last_name}} </h3>
                            <p>Click On Orders to check your orders</p>
                        </div>
                        <div class="tab-pane fade show active" id="orders">
                            <h3>Products</h3>
                            <h5><a href="{{route('user-account-page')}}" style="color:#E96725">Back To Orders</a></h5>
                            <div class="table-responsive">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12  mt-5">
                                            <div class="card">
                                                <div class="card-header bg-info">
                                                    <h6 class="text-white">Share Gift Receipt :</h6>
                                                </div>
                                                <div class="card-body">
                                                    <form method="post" action="{{ route('gift-receipt-update',$orderId) }}" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <label><strong>Write Your Gift Note :</strong></label>
                                                            <textarea class="summernote6" name="gift_receipt"></textarea>
                                                        </div>
                                                        <div class="form-group text-center">
                                                            <button type="submit" class="btn btn-success btn-sm">Save</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- my account end   -->


@endsection


@section('scriptss')

<script type="text/javascript">
    $(document).ready(function() {
      $('.summernote6').summernote({
      height: 200, // set editor height
      minHeight: null, // set minimum height of editor
      maxHeight: null, // set maximum height of editor
      focus: true // set focus to editable area after initializing summernote
   });
    });
</script>

@endsection
