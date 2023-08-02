@extends('supplier.layout.main')
@section('content')

{{-- <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">CSV Import</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('import_parse') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('csv_file') ? ' has-error' : '' }}">
                            <label for="csv_file" class="col-md-4 control-label">CSV file to import</label>

                            <div class="col-md-6">
                                <input id="csv_file" type="file" class="form-control" name="csv_file" required>

                                @if ($errors->has('csv_file'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('csv_file') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="header" checked> File contains header row?
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Parse CSV
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<div class="inventory_body py-2 d-flex justify-content-center">
    <div class="container_withdraw">
        <form method="POST" action="{{ route('import_parse') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="inner-container pt-4 m-auto">
                <h1 class='import_heading text-center'>Import Inventory</h1>
                <div class="d-flex justify-content-center pt-4 form-group{{ $errors->has('csv_file') ? ' has-error' : '' }}">
                    <input id="csv_file" type="file" name="csv_file" required hidden>
                    <label class='uploader_label' for="csv_file"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-cloud-arrow-down" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M7.646 10.854a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 9.293V5.5a.5.5 0 0 0-1 0v3.793L6.354 8.146a.5.5 0 1 0-.708.708l2 2z" />
                        <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z" />
                        </svg><br>Upload a CSV file
                    </label>
                </div>
                    @if ($errors->has('csv_file'))
                        <span class="help-block">
                        <strong>{{ $errors->first('csv_file') }}</strong>
                        </span>
                    @endif
                <div class="form-group text-center py-4">
                    <div class="">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="header" checked> Does this file contain header row?
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn parse_btn w-50">
                        Parse CSV
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>
<table class="table upload_field_table border">
    <tr>
        <th>sku</th>
        <th>title</th>
        <th>description</th>
        <th>Category</th>
        <th>brand</th>
        <th>retail price</th>
        <th>wholesale price</th>
        <th>stock</th>
        <th>image</th>
        <th>shipping price</th>
    </tr>

</table>
@endsection
