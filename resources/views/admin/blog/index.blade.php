@extends('admin.layout.main')
@section('content')

{{-- code here --}}
<!-- <link href="https://unpkg.com/tabulator-tables@5.5.2/dist/css/tabulator.min.css" rel="stylesheet">
<div id="exampleTable"></div>
 <script type="text/javascript" src="https://unpkg.com/tabulator-tables@5.5.2/dist/js/tabulator.min.js"></script>
<script>
//define some sample data
var tabledata = [
 	{id:1, blogTitle:"Oli Bob", writer:"John Doe", date:"22/05/2023"},
 	{id:1, blogTitle:"Oli Bob", writer:"John Doe", date:"22/05/2023"},
 	{id:1, blogTitle:"Oli Bob", writer:"John Doe", date:"22/05/2023"},
 	{id:1, blogTitle:"Oli Bob", writer:"John Doe", date:"22/05/2023"},
 	{id:1, blogTitle:"Oli Bob", writer:"John Doe", date:"22/05/2023"},
 	{id:1, blogTitle:"Oli Bob", writer:"John Doe", date:"22/05/2023"},
 ];
 var table = new Tabulator("#exampleTable", {
 	height:205, // set height of table (in CSS or here), this enables the Virtual DOM and improves render speed dramatically (can be any valid css height value)
 	data:tabledata, //assign data to table
 	layout:"fitColumns", //fit columns to width of table (optional)
 	columns:[ //Define Table Columns
	 	{title:"Blog Title", field:"blogTitle"},
	 	{title:"Written By", field:"writer"},
	 	{title:"Published Date", field:"date", sorter:"date", hozAlign:"center"},
 	],
});
</script> -->
<div class="row mx-0" style="margin-top: 50px">
    <div class="col-lg-12 mt-4">
        <div class="card">
            <div class="card-header">
                <div class="left"><!-- <i class="fa fa-group"></i> --><span>Blogs</span></div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th style="width: 15%">Title</th>
                                <th style="width: 25%">Description</th>
                                <th style="width: 25%">Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($blogs as $blog)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <th style="width: 30%">{{ $blog->title }}</th>
                                <th style="width: 30%">{{ $blog->description }}</th>
                                <th style="width: 25%">{{ $blog->created_at }}</th>
                                <th>Actions</th>
                            </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th style="width: 15%">Title</th>
                                <th style="width: 25%">Description</th>
                                <th style="width: 25%">Created At</th>
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
