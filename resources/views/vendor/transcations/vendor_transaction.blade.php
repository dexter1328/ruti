@extends('admin.layout.main')
@section('content')

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
<div class="success-alert" style="display:none;"></div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="left"><!-- <i class="fa fa-user"></i> --> <span>Vendor Transactions</span></div>
                <div class="float-sm-right">
                    <form method="POST">
                        @csrf
                        <select name="transaction_filter" onchange="this.form.submit()" class="form-control">
                            <option value="daily" @if($input=='daily') selected="selected" @endif>Daily</option>
                            <option value="weekly" @if($input=='weekly') selected="selected" @endif>Weekly</option>
                            <option value="monthly" @if($input=='monthly') selected="selected" @endif>Monthly</option>
                        </select>
                    </form>
                </div>
            </div>
            <div class="card-body">
                    <div class="table-responsive" id="transaction_div">
                        <table id="example" class="table table-bordered">
                            <thead>
                                <tr>
                                    <!-- <th>#</th> -->
                                    <th>Image</th>
                                    <th>Vendor <br>Name</th>
                                    <th>Vendor <br>Contact <br>Person</th>
                                    <th>Vendor <br>Address</th>
                                    <th>Bank <br>Routing <br>Number</th>
                                    <th>Bank <br>Account <br>Number</th>
                                    <th>Amount <br>Received</th>
                                    <th>Less <br>Transaction <br>fee</th>
                                    <th>Amount <br>Remitting</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $key => $order)
                                    <tr>
                                        <!-- <td>{{$key+1}}</td> -->
                                        <td>@if($order->image == '')<img src="{{asset('public/images/deafult.jpg')}}" height="75" width="75">@else<img src="{{asset('public/images/vendors/'.$order->image)}}" height="75" width="75">@endif</td>
                                        <td>{{$order->business_name}}</td>
                                        <td>{{$order->name}}</td>
                                        <td>{{$order->address}},{{$order->city_name}}, {{$order->state_name}}, {{$order->country_name}}</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>{{$order->total_price}}</td>
                                        <td>@php echo number_format($order->total_price*$order->admin_commision/100,2); @endphp</td>
                                        <td>@php echo number_format($order->total_price-$order->total_price*$order->admin_commision/100,2)@endphp</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <!-- <th>#</th> -->
                                    <th>Image</th>
                                    <th>Vendor <br>Name</th>
                                    <th>Vendor <br>Contact Person</th>
                                    <th>Vendor <br>Address</th>
                                    <th>Bank <br>Routing Number</th>
                                    <th>Bank <br>Account Number</th>
                                    <th>Amount <br>Received</th>
                                    <th>Less <br>Transaction fee</th>
                                    <th>Amount <br>Remitting</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>

 $(document).ready(function() {
    
    // $('[data-toggle="tooltip"]').tooltip(); 
    var table = $('#example').DataTable( {
        lengthChange: false,
        // buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ],
        buttons: [
            {
                extend: 'copy',
                title: 'Vendor Transactions List',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]
                }
            },
            {
                extend: 'excelHtml5',
                title: 'Vendor Transactions List',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'Vendor Transactions List',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]
                }
            },
            {
                extend: 'print',
                title: 'Vendor Transactions List',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]
                }
            },
            'colvis'
        ],
        /*columnDefs: [
            { "orderable": false, "targets": 0 }
        ],*/
        columnDefs: [
            { width: "8%", "orderable": false, "targets": 0 },
            { width: "10%", targets: 1 },
            { width: "10%", targets: 2 },
            { width: "20%", targets: 3 },
            { width: "10%", targets: 4 },
            { width: "10%", targets: 5 },
            { width: "10%", targets: 6 },
            { width: "12%", targets: 7 },
            { width: "10%", targets: 8 },
        ],
        order: [[1, 'asc']],
    });
    table.buttons().container()
      .appendTo( '#example_wrapper .col-md-6:eq(0)' );
      
    });

   
</script>
@endsection
