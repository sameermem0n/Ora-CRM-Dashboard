@extends('layouts.web')
@section('title', 'Dashboard')
@section('content')

<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('sub-services.index') }}">Sub Services</a></li>
                                <li class="breadcrumb-item active">Edit Service Item</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Edit Service Item</h4>
                    </div>
                </div>
            </div>

            <a href="{{ route('sub-services.index') }}" style="font-size: 20px;"><i class="fa fa-arrow-circle-left mb-2" aria-hidden="true"></i></a>

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

                        <form action="{{ route('sub-services.update', $subService->id) }}" method="post" class="parsley-examples" novalidate="">
                            @csrf
                            @method('PATCH')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Service<span class="text-danger">*</span></label>
                                        <select name="service_id" required parsley-trigger="change" class="form-control">
                                            <option value="">Select Service</option>
                                            @foreach($services as $service)
                                            <option value="{{ $service->id }}" {{ (int) $subService->service_id === (int) $service->id ? 'selected' : '' }}>{{ $service->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Service Name<span class="text-danger">*</span></label>
                                        <input type="text" name="title" value="{{ $subService->title }}" parsley-trigger="change" required placeholder="Enter Name" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group text-left mb-0">
                                <button class="btn btn-primary waves-effect waves-light mr-1" type="submit">Submit</button>
                                <a href="{{ route('sub-services.index') }}" class="btn btn-secondary waves-effect waves-light">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{asset('assets/libs/parsleyjs/parsley.min.js')}}"></script>
<script src="{{asset('assets/js/pages/form-validation.init.js')}}"></script>
<script src="{{asset('assets/libs/jquery-mask-plugin/jquery.mask.min.js')}}"></script>
<script src="{{asset('assets/libs/autonumeric/autoNumeric-min.js')}}"></script>
<script src="{{asset('assets/js/pages/form-masks.init.js')}}"></script>
@endsection
