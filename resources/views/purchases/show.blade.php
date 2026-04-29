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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">purchases</a></li>
                                <li class="breadcrumb-item active">All Purchases</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Purchases</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            {{-- <a href="{{Route('purchases.index')}}" class="btn btn-secondary mb-2" title="Back to Purchases">
                <i class=""></i> Back
            </a> --}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-box">
                        <div class="row text-dark">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Client Name:</strong>
                                    {{ optional($Purchase->client)->name ?: '-' }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Service Type:</strong>
                                    {{ optional($Purchase->service)->title ?: '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="row text-dark">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Package:</strong>
                                    {{ optional($Purchase->package)->title ?: '-' }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Package Price:</strong>
                                    {{ optional($Purchase->package)->price ?: 0 }}
                                </div>
                            </div>
                        </div>
                        <div class="row text-dark">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Duration:</strong>
                                    {{ $Purchase->duration ?: optional($Purchase->package)->duration }} Months
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Status: </strong>
                                    <?php if ($Purchase->status == 1) {
                                        echo "<span class='bg-success text-white rounded p-1'>Active</span>";
                                    } else {
                                        echo "<span class='bg-danger text-white p-1 rounded'>Inactive</span>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
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