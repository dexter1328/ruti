@extends('supplier.layout.main')

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

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><div class="left"><span>Return Orders</span></div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-bordered">
                    <thead>
                        <tr>
                            <th >SR No.</th>
                            <th >Order Id</th>
                            <th >Product SKU</th>
                            <th >Supplier</th>
                            <th >Customer</th>

                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($return_orders as $key =>$return_order)
                            <tr>
                                <td >{{$loop->iteration}}</td>
                                <td >{{$return_order->order_no}}</td>
                                <td >{{$return_order->product_sku}}</td>
                                <td >{{$return_order->owner_name}}</td>
                                <td >{{$return_order->first_name}}</td>

                                <td>
                                    <a href="{{ route('supplier.orders.show-return', ['order_no' => $return_order->order_no, 'sku' => $return_order->product_sku]) }}" class="edit" data-toggle="tooltip" data-placement="bottom" title="View ReturnOrder">
                                        <i class="icon-eye icons"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th >SR No.</th>
                            <th >Order Id</th>
                            <th >Product SKU</th>
                            <th >Supplier</th>
                            <th >Customer</th>

                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    var table = $('#example').DataTable( {
        lengthChange: false,
            buttons: [
            {
                extend: 'copy',
                title: 'Return Order List',
                exportOptions: {
                columns: [ 0, 1,2,3,4]
                }
            },
            {
                extend: 'excelHtml5',
                title: 'Return Order List',
                exportOptions: {
                columns: [ 0, 1, 2,3,4]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'Return Order List',
                exportOptions: {
                columns: [ 0, 1, 2,3,4]
                }
            },
            {
                extend: 'print',
                title: 'Return Order List',
                autoPrint: true,
                exportOptions: {
                columns: [ 0, 1, 2,3,4]
                }
            },
            'colvis'
        ],
        columnDefs: [
            { "orderable": false, "targets": 5 }
        ]
    });
    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );
</script>
@endsection

