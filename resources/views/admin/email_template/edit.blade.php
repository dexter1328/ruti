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
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="left"><span>Email Template</span></div>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <form id="signupForm" method="post" action="{{ route('admin.email_template.update', $template->id) }}">
                            @csrf
                            @method('PUT')

                            @include('admin.email_template.form')

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save Template</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Row-->
@endsection
