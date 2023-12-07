@extends('admin.layout.main')
@section('content')


<div class="row mx-0" style="margin-top: 50px">
    <div class="col-lg-12 mt-4">
        <div class="card">
            <div class="card-header">
                <div class="left"><!-- <i class="fa fa-group"></i> --><span>Coupons</span></div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Code</th>
                                <th>Discount type</th>
                                <th>Discount</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupons as $coupon)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td >{{ $coupon->title }}</td>
                                    <td >{{ $coupon->code }}</td>
                                    <td >{{ $coupon->discount_type }}</td>
                                    <td>{{ $coupon->discount }}</td>
                                    <td>{{ $coupon->start_date }}</td>
                                    <td>{{ $coupon->expire_date }}</td>
                                    <td>
                                        <!-- Add a form to toggle status -->
                                        <form action="{{ route('admin_coupon.update-status', ['id' => $coupon->id]) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm {{ $coupon->status == 1 ? 'btn-success' : 'btn-danger' }}">
                                                {{ $coupon->status == 1 ? 'Active' : 'Inactive' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <!-- Add a form to handle delete -->
                                        <form action="{{ route('admin_coupon.destroy', ['id' => $coupon->id]) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Code</th>
                                <th>Discount type</th>
                                <th>Discount</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Actions</th>

                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

    @section('scripts1')
<script>
    $(document).ready(function() {
    var table = $('#example').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
    } );

    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );
</script>

<!-- <script>
       function updateStatus1(id,$this) {

$.ajax({
           url: "{{ url('/admin/wborder/status') }}/"+id+'/'+$this.val(),


}).done(function(res) {
console.log(res)
location.reload();
});
}

</script> -->
@endsection
