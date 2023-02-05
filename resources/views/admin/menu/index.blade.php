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

<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <div class="left"> 
                    Add menu items
                </div>
            </div>
            <div class="card-body">
                <div id="accordion1">
                    <div class="card mb-2">
                        <div class="card-header">
                            <button class="btn btn-link shadow-none collapsed" data-toggle="collapse" data-target="#collapse-1" aria-expanded="false" aria-controls="collapse-1"> Pages </button>
                        </div>
                        <div id="collapse-1" class="collapse" data-parent="#accordion1">
                            <form id="pageFrm">
                                <div class="card-body">
                                    @foreach($pages as $page)
                                    <div class="form-group">
                                        <input type="hidden" name="page_title[{{$page->id}}]" value="{{$page->title}}">
                                        <div class="icheck-material-primary">
                                            <input type="checkbox" class="checkbox" name="page_slug[{{$page->id}}]" id="page_{{$page->id}}" value="{{$page->slug}}">
                                            <label for="page_{{$page->id}}">{{$page->title}}</label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="card-body">
                                    <div class="left">
                                        <div class="form-group py-2">
                                            <div class="icheck-material-primary" style="float: left;">
                                                <input type="checkbox" class="checked_all" id="checked_all">
                                                <label for="checked_all">Select All</label> 
                                                <div class="clearfix"></div>
                                            </div>
                                             <button type="button" id="pageBtn" class="btn btn-outline-primary btn-sm" style="float: right;"> Add to Menu</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card mb-2">
                        <div class="card-header">
                            <button class="btn btn-link shadow-none collapsed" data-toggle="collapse" data-target="#collapse-2" aria-expanded="false" aria-controls="collapse-2"> Custom Links </button>
                        </div>
                        <div id="collapse-2" class="collapse" data-parent="#accordion1">
                            <form id="customFrm">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="input-1">URL</label>
                                        <input type="text" name="custom_link" id="custom_link" class="form-control" value="http://">
                                    </div>
                                    <div class="form-group">
                                        <label for="input-1">Link Text</label>
                                        <input type="text" name="custom_title" id="custom_title" class="form-control">
                                    </div>
                                    <div class="form-group py-2">
                                        <div class="icheck-material-primary" style="float: left;">
                                            <input type="checkbox" class="checkbox" name="custom_target" id="custom_target" value="_blank">
                                            <label for="custom_target">Open New Tab</label>
                                        </div>
                                        <button type="button" id="customBtn" class="btn btn-outline-primary btn-sm" style="float: right;"> Add to Menu</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header align-items-center">
                <div class="left"> 
                    Menu structure
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <select name="position" id="position" class="form-control">
                                <option value="header">Header Menu</option>
                                <option value="footer">Footer Menu</option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="add-cluster-right">
                                <input type="hidden" id="nestable-output" name="nestable-output">
                                <div class="dd" id="nestable">
                                </div>
                                <div style="clear:both;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        var position = $('#position').val();
        $('#position').on('change', function() {
            position = $(this).val();
            get_menu(position);
        });
        get_menu(position);

        setTimeout(function(){

            var updateOutput = function(e)
            {
                var list   = e.length ? e : $(e.target),
                    output = list.data('output');
                if (window.JSON) {
                    output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
                } else {
                    output.val('JSON browser support required for this demo.');
                }
            };

            $('#nestable').nestable({
                group: 1,
                maxDepth: 10
            })
            .on('change', updateOutput);

            // output initial serialised data
            updateOutput($('#nestable').data('output', $('#nestable-output')));

            $('#nestable').on('change', function() {
             
                var dataString = { 
                    data : $("#nestable-output").val(),
                };
                $.ajax({
                    url: "{{ route('menus.store') }}",
                    type: "POST",
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: dataString,
                    success: function(data) {
                        
                    }
                });
            });

        }, 1000);

        

        $('.checked_all').on('change', function() {
            $('.checkbox').prop('checked', $(this).prop("checked"));
        });
        $('.checkbox').change(function() { 
            if ($('.checkbox:checked').length == $('.checkbox').length) {
                $('.checked_all').prop('checked', true);
            } else {
                $('.checked_all').prop('checked', false);
            }
        });

        $('#pageBtn').click(function(){
            var data = $("#pageFrm").serialize()+'&position='+position+'&type=page';
            add_menu(data)
        });

        $('#customBtn').click(function(){
            var data = $("#customFrm").serialize()+'&position='+position+'&type=custom';
            add_menu(data)
        });
    }); 

    function get_menu(position){

        $.ajax({
            type: "GET",
            url: "{{ url('admin/menus/get-menus')}}/"+position,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data){
                $("#nestable").html(data);
            }
        });
    }

    function add_menu(data){

        if(data!='' &&  data!=null){
            $.ajax({
                url: "{{ route('menus.store') }}",
                type: "POST",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                success: function(data) {
                    $("#list-items").append(data.menu);
                    $('#pageFrm').trigger("reset");
                    $("#customFrm").trigger("reset");
                    $('#nestable').trigger('change');
                }
            });
        }
    }

    function deleteMenu(id){

        var x = confirm('Are you sure?');
        if(x){
            $.ajax({
                type: "DELETE",
                url: "{{ url('admin/menus')}}"+'/'+id,
                cache : false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data){
                    $("li[data-id='" + id +"']").remove();
                }
            });
        }
    }
</script>

@endsection