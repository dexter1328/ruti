@extends('admin.layout.main')

@section('content')
<style type="text/css">
  .sorting{
  border: 1px solid #000000;
    list-style: none;
    width: 50%;
    padding: 10px;
    background-color:#cccccc;
}
  
</style>
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <div class="left"><!-- <i class="fa fa-address-book-o"></i> --><span>Add Menu</span></div>
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
        <form id="signupForm" method="post" action="{{ route('menus.store') }}" enctype="multipart/form-data">
          @csrf
          <div class="form-group row">
            <label for="input-10" class="col-sm-2 col-form-label">Name<span class="text-danger">*</span></label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="input-10" name="name" placeholder="Enter Name" value="{{old('name')}}">
            </div>
            <label for="input-11" class="col-sm-2 col-form-label">Position<span class="text-danger">*</span></label>
            <div class="col-sm-4">
              <select name="position" class="form-control">
                <option value="">Select Position</option>
                <option value="header" @if(old('position')=='header') selected="selected" @endif>Header</option>
                <option value="footer" @if(old('position')=='footer') selected="selected" @endif>Footer</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="input-10" class="col-sm-2 col-form-label">Page<span class="text-danger">*</span></label>
            <div class="col-sm-4">

            </div>
          </div>
          <div class="form-group row">
            <label for="input-13" class="col-sm-2 col-form-label">Status<span class="text-danger">*</span></label>
            <div class="col-sm-4">
              <select name="status" class="form-control">
                <option value="">Select Status</option>
                <option value="active" @if(old('status')=='active') selected="selected" @endif>Active</option>
                <option value="deactive" @if(old('status')=='deactive') selected="selected" @endif>Deactive</option>
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
         @foreach($page as $value)
         <input type='checkbox' class="messageCheckbox" name='txt' value='{{$value->title}}' id="locationthemes" />{{$value->title}}<br>
         @endforeach
         <button name="submit" onclick="menu()">Submit</button>
     </div>
   </div>
 </div>
</div>
<!-- <div id="myList"></div> -->
<ul id="sort"></ul>
<input type="hidden" id="nestable-output" name="nestable-output">
<div class="dd" id="nestable">
  <ol class="dd-list" id="list-items">
       <!--  <ol class="dd-list" id="list-items">
        </ol>  -->                                        
  </ol>
</div>
<!-- <div style="clear:both;"></div> -->
<script type="text/javascript">
  function menu(){
    var str = '';
    var checkedValue = $('input[name=txt]:checked').map(function()
    {
        return $(this).val();
    }).get();
    // alert(checkedValue);
    str += '<li class="dd-item dd3-item" data-id="'+checkedValue+'" >';
        str += '<div class="dd-handle"><i class="fa fa-bars" aria-hidden="true"></i></div>';
        str += '<div class="dd3-content">'+checkedValue+' ('+checkedValue+' | '+checkedValue+')';
        //$str .= '<div class="dd3-content">'.$value['name'];;
          str += '<span class="span-right">';
                        str += '<a class="del-button" onclick="deleteUser('+checkedValue+')"><i class="fa fa-trash"></i></a>';
                    str += '</span>';
                str += '</div>';
            str += '</li>';
      console.log(str);
      $("#list-items").append(str);
    $('.messageCheckbox').prop('checked', false);
  }
</script>
<script>
  $( function() {
    var updateOutput = function(e)
        {
            var list   = e.length ? e : $(e.target),
                output = list.data('output');
                // console.log(list);
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };
     $('#nestable').nestable({
            group: 1,
            maxDepth: 15
        }).on('change', updateOutput);
        updateOutput($('#nestable').data('output', $('#nestable-output')));

        $('#nestable').on('change', function() {
         
          
            // var dataString = {
            //     data : $("#nestable-output").val(),
            // };
            var data = $("#nestable-output").val();
            //alert(dataString);
            console.log(data);
            $.ajax({
                url: "{{ route('menus.store') }}",
                type: "POST",
               data: {
                "_token": "{{ csrf_token() }}",
                "data": data
              },
                // cache : false,
                success: function(data){

                }
            });
        });
  } );
</script>
  @endsection 