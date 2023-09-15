@extends('admin.layout.main')
@section('content')
    <style type="text/css">
        div#importModal {
            width: 50%;
            margin:
                0 auto;
        }

        .vendor-btn-right a,
        .vendor-btn-right button {
            width: 100%;
        }

        .vendor-btn-right input.form-control {
            padding: 2px;
            border: 1px solid #003366;
            position: relative;
            top: 4px;
        }

        .card-img-top {
            width: 50%;
            height: auto;
            margin: 10px auto;
        }
    </style>
    @if (session()->get('success'))
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
    @if (session()->get('error-data'))
        <input type="hidden" id="error" value="{{ session()->get('error-data') }}"></span>
    @endif
    @if (session()->get('success-data'))
        <!-- <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <div class="alert-icon">
       <i class="fa fa-check"></i>
      </div>
      <div class="alert-message">
       <span><strong>Success!</strong> {{ session()->get('success-data')['message'] }}</span>
      </div>
     </div> -->
        @if (!empty(session()->get('success-data')['emails']))
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <div class="alert-message">
                    <span><strong>Error!</strong> These email are already exist.</span>
                    <ul>
                        @foreach (session()->get('success-data')['emails'] as $value)
                            <li>{{ $value }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @else
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <div class="alert-icon">
                    <i class="fa fa-check"></i>
                </div>
                <div class="alert-message">
                    <span><strong>Success!</strong> {{ session()->get('success-data')['message'] }}</span>
                </div>
            </div>
        @endif
    @endif
    <div class="success-alert" style="display:none;"></div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="col-3">
                            <div class="left">
                                <!-- <i class="fa fa-product-hunt"></i> --><span>Supplier</span>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="vendor-btn-right">
                                <div class="row justify-content-end">
                                    {{-- <div class="col-3" style="margin-top:4px">
                                        <select name="search" id="filter_country" class="form-control waves-effect waves-light mr-2" required>
                                           <option value="">--See Country wise--</option>
											@foreach ($countries as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                    <div class="col-xs-12 col-sm-3">
                                        <a href="{{ route('supplier.create') }}"
                                            class="btn btn-outline-primary btn-sm waves-effect waves-light m-1"
                                            title="Add Supplier">
                                            <span class="name">Add Supplier</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Zip Code</th>
                                    <th>Mobile No</th>
                                    <th>Email</th>
                                    <th>Country</th>
                                    <th>Review</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                             <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Zip Code</th>
                                    <th>Mobile No</th>
                                    <th>Email</th>
                                    <th>Country</th>
                                    <th>Review</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Row-->

    <script>
        // validation error of import
        var errors = '<?php echo $errors; ?>';
        var obj = $.parseJSON(errors);


        // end validation error of import
        $(document).ready(function() {

            const dTblOptions = {
                "processing": true,
                "serverSide": true,
                "lengthChange": false,
                "ajax": {
                    "url": "{{ url('admin/supplier/view/supplier_datatable') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}"
                    }
                },
                "columns": [{
                    "data": "name"
                },
                    {
                        "data": "pincode"
                    },
                    {
                        "data": "mobile_number"
                    },
                    {
                        "data": "email"
                    },
                    {
                        "data": "supplier_country.name",
                        "name": "supplierCountry.name",
                        "orderable": false
                    },
                    {
                        "data": "is_approved",
                        "orderable": false,
                        "searchable": false
                    },
                    {
                        "data": "action",
                        "orderable": false,
                        "searchable": false
                    },

                ],
                "dom": 'Bfrtip',
                buttons: [{
                    extend: 'copy',
                    title: 'supplier List',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                },
                    {
                        extend: 'excelHtml5',
                        title: 'supplier List',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'supplier List',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    },
                    {
                        extend: 'print',
                        title: 'supplier List',
                        autoPrint: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    },
                    'colvis'
                ]

            };
            const dtTable = $('#example').DataTable(dTblOptions);
            dtTable.buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');

            $('#filter_country').on('change', function() {
                const countryId = $(this).val();
                const url = "{{ url('admin/supplier/view/supplier_datatable') }}?country_id=" + countryId;
                dtTable.ajax.url(url).load();
            });



        });

        function deleteRow(id) {
            $('#deletefrm_' + id).submit();
        }

        function changeStatus(id) {
            $.ajax({
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                url: "{{ url('admin/supplier') }}/" + id,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    var status = '';
                    // $('.status_'+id).attr('title',data);
                    if (data == 'active') {
                        status = 'activated';
                        $('.status_' + id).css('color', '#009933');

                    } else {
                        status = 'deactivated';
                        $('.status_' + id).css('color', '#ff0000');
                    }
                    $('.success-alert').show();
                    var suc_str = '';
                    suc_str += '<div class="alert alert-success alert-dismissible" role="alert">';
                    suc_str += '<button type="button" class="close" data-dismiss="alert">×</button>';
                    suc_str += '<div class="alert-icon"><i class="fa fa-check"></i></div>';
                    suc_str += '<div class="alert-message"><span><strong>Success!</strong> Supplier has been ' +
                        status + '.</span></div>';
                    suc_str += '</div>';
                    $('.success-alert').html(suc_str);
                },
                error: function(data) {}
            });
        }

        function exportVendor() {
            $.ajax({
                url: "{{ url('admin/supplier/export/supplier') }}",
                type: 'get',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                contentType: false,
                processData: false,
                success: function(response) {

                }
            });
        }
    </script>
@endsection
