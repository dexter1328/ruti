@extends('admin.layout.main')
@section('content')


<div class="row mx-0" style="margin-top: 50px">
    <div class="col-lg-12 mt-4">
        <div class="card">
            <div class="card-header">
                <div class="left"><!-- <i class="fa fa-group"></i> --><span>Withdraw Requests</span></div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Bank Name</th>
                                <th>Account Title</th>
                                <th>Account No</th>
                                <th>Routing No</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($WithdrawRequests as $wr)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td >{{ $wr->bank_name }}</td>
                                    <td >{{ $wr->account_title }}</td>
                                    <td >{{ $wr->account_no }}</td>
                                    <td>{{ $wr->routing_number }}</td>
                                    <td>{{ $wr->amount }}</td>
                                    <td>
                                        <!-- Add a form to toggle status -->
                                        <form action="{{ route('withdraw_request.update-status', ['id' => $wr->id]) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm {{ $wr->status == 'paid' ? 'btn-success' : 'btn-danger' }}">
                                                {{ $wr->status == 'paid' ? 'Paid' : 'Unpaid' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Bank Name</th>
                                <th>Account Title</th>
                                <th>Account No</th>
                                <th>Routing No</th>
                                <th>Amount</th>
                                <th>Status</th>
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
