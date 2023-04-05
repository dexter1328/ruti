@extends('admin.layout.main')
@section('content')
    @if(session()->has('success'))
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
                <div class="card-header">
                    <div class="left"><span>Email Templates</span></div>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <table id="example" class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Template Name</th>
                                <th>Subject</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($templates as $template)
                                <tr>
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td>{{$template->name}}</td>
                                    <td>{{Str::limit($template->subject, 50)}}</td>
                                    <td class="action">
                                        <a href="{{ route('admin.email_template.edit', $template->id) }}" class="edit" data-toggle="tooltip" data-placement="bottom" title="Edit Template">
                                            <i class="icon-note icons p-0"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3">No template found</td>
                                </tr>
                            @endforelse
                            </tbody>
                            <tfoot>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Template Name</th>
                                <th>Subject</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </tfoot>
                        </table>
                        {{$templates->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Row-->
@endsection
