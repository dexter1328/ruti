<div class="tab-pane fade" id="dashboard">
    <h3>Hello {{Auth::guard('w2bcustomer')->user()->first_name}} {{Auth::guard('w2bcustomer')->user()->last_name}} </h3>
    <p>Click On Orders to check your orders</p>
</div>
