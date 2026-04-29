@extends('layouts.web')
@section('title', 'Dashboard')
@section('content')

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Clients</a></li>
                                <li class="breadcrumb-item active">Edit Client</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Clients Management</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <a href="{{Route('clients.index')}}" style="font-size: 20px;"><i class="fa fa-arrow-circle-left mb-2" aria-hidden="true"></i></a>
            <div class="row">
                <div class="col-lg-12">

                    <div class="card-box">

                        @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        {!! Form::model($client, ['method' => 'PATCH','route' => ['clients.update', $client->id]]) !!}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name<span class="text-danger">*</span></label>
                                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control', 'required')) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Organization<span class="text-danger">*</span></label>
                                    {!! Form::text('organization', null, array('placeholder' => 'Organization','class' => 'form-control', 'required')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email<span class="text-danger">*</span></label>
                                    {!! Form::text('email', null, array('placeholder' => 'Email','disabled','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Address<span class="text-danger">*</span></label>
                                    {!! Form::text('address', null, array('placeholder' => 'Address','class' => 'form-control', 'required')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>City<span class="text-danger">*</span></label>
                                    {!! Form::text('city', null, array('placeholder' => 'City','class' => 'form-control', 'required')) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Contact<span class="text-danger">*</span></label>
                                    {!! Form::text('contact', null, array('placeholder' => 'Contact','class' => 'form-control', 'required')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Account Status<span class="text-danger">*</span></label>
                                    <select name="status" class="form-control" required>
                                        <option value="0" {{ (string) $client->status === '0' ? 'selected' : '' }}>In Active</option>
                                        <option value="1" {{ (string) $client->status === '1' ? 'selected' : '' }}>Active</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group text-right mb-0" style="padding-top: 28px;">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                                    <a href="{{ route('clients.index') }}" class="btn btn-secondary waves-effect waves-light">Cancel</a>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div> <!-- end card-box -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div> <!-- end container-fluid -->
    </div> <!-- end content -->

    @endsection

    @section('script')
    <!-- Plugin js-->
    <script src="{{asset('assets/libs/parsleyjs/parsley.min.js')}}"></script>

    <!-- Validation init js-->
    <script src="{{asset('assets/js/pages/form-validation.init.js')}}"></script>
    @endsection
