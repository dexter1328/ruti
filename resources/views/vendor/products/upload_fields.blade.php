@extends('vendor.layout.main')
@section('content')

<div class="i_funds_body py-5 d-flex justify-content-center">
    <div class="container_upload_field">
        <div class="inner-container">
            <div class="mx-auto">
                <div class="main_section p-4 mb-4">
                <h1 class='import_heading text-center'>Uploaded Inventory</h1>
                    <form class="form-horizontal" method="POST" action="{{ route('vendor.import_process') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="csv_data_file_id" value="{{ $csv_data_file->id }}" />
                        <div class="container table_parent">

                            <table class="table upload_field_table border">
                                @if (isset($headings))
                                <tr>
                                    @foreach ($headings[0][0] as $csv_header_field)
                                        <th>{{ $csv_header_field }}</th>
                                    @endforeach
                                </tr>
                                @endif
                                @foreach ($csv_data as $row)
                                <tr>
                                @foreach ($row as $key => $value)
                                    <td class='border'>{{ $value }}</td>
                                @endforeach
                                </tr>
                                @endforeach
                                <tr>
                                    @foreach ($csv_data[0] as $key => $value)
                                        <td class='border'>
                                            <select class='select_dropdown p-2' name="fields[{{ $key }}]">
                                                @foreach (config('app.db_fields2') as $db_field)
                                                <option value="{{ (\Request::has('header')) ? $db_field : $loop->index }}"
                                                    @if ($key === $db_field) selected @endif>{{ $db_field }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    @endforeach
                                </tr>
                                {{-- @foreach ($csv_data as $row)
                                    <tr>
                                    @foreach ($row as $key => $value)
                                        <td class='border'>{{ $value }}</td>
                                    @endforeach
                                    </tr>
                                @endforeach --}}
                            </table>
                        </div>
                            <div class='w-100 d-flex justify-content-center'>
                                <button type="submit" class="btn parse_btn w-50 mx-auto">
                                    Import Data
                                </button>
                            </div>
                        </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
