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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">invoices</a></li>
                                <li class="breadcrumb-item active">All Inovices</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Invoices</h4>
                    </div>
                </div>
            </div>

            <!-- end page title -->
            <a href="{{Route('invoices.index')}}" style="font-size: 20px;"><i class="fa fa-arrow-circle-left mb-2" aria-hidden="true"></i></a>

            <div class="row">
                <div class="col-md-12">
                    <div class="card-box">
                        <div class="clearfix">
                            <div class="float-left mb-2">
                                <img src="assets/images/logo-dark.png" alt="" height="28">
                            </div>
                            <div class="float-right">
                                <h3 class="m-0 d-print-none">Invoice</h3>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mt-3">
                                    <p><b>Hello, {{ $client->name }}</b></p>
                                    <p class="text-muted">Thanks a lot because you keep purchasing our products. Our company
                                        promises to provide high quality products for you as well as outstanding
                                        customer service for every transaction. </p>
                                </div>

                            </div><!-- end col -->
                            <div class="col-md-6">
                                <div class="mt-3 text-md-right">
                                    <div><strong>Order Date: </strong> {{ $orderDate }}</div>
                                    <div><strong>Order Status: </strong> <span class="badge badge-success">Paid</span></div>
                                    <div><strong>Order ID: </strong> #{{ $orderId }}</div>
                                </div>
                            </div><!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <h5>Billing Address</h5>

                                <address class="line-h-24">
                                    {{ $client->name }}<br>
                                    {{ $client->organization ?: '-' }}<br>
                                    {{ $client->address }}<br>
                                    {{ $client->city }}<br>
                                    {{ $client->contact }}
                                </address>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table mt-4 table-centered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Item</th>
                                                <th>Quantity</th>
                                                <th>Unit Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>{{ $invoice->package_title }}</td>
                                                <td>1</td>
                                                <td>{{ number_format($invoice->package_price, 0) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="clearfix pt-4">
                                    <h6 class="text-muted">PAYMENT DETAILS:</h6>

                                    <small>
                                        Bank Name: MCB Islamic Bank<br>
                                        Account No: 3661005996050001
                                    </small>
                                </div>
                                <div class="clearfix pt-4">
                                    <h6 class="text-muted">Notes:</h6>

                                    <small>
                                        All accounts are to be paid within 7 days from receipt of
                                        invoice. To be paid by cheque or credit card or direct payment
                                        online. If account is not paid within 7 days the credits details
                                        supplied as confirmation of work undertaken will be charged the
                                        agreed quoted fee noted above.
                                    </small>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="text-right">
                                    <h4>Total Cost: {{ number_format($invoice->package_price, 0) }} </h4>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <div class="hidden-print mt-4">
                            <div class="text-right d-print-none">
                                <a href="javascript:window.print()" class="btn btn-blue waves-effect waves-light"><i class="fa fa-print mr-1"></i> Print</a>
                                <a href="#" class="btn btn-info waves-effect waves-light">Submit</a>
                            </div>
                        </div>
                                                <hr class="mt-4 mb-3">
                        <div class="d-flex flex-wrap align-items-center justify-content-between" style="gap: 12px; font-size: 13px; color: #495057;">
                            <div>
                                <span class="text-muted" style="font-weight: 600; letter-spacing: .4px;">CONTACT US</span>
                                <span style="margin-left: 10px; font-weight: 600; color: #212529;">+92-311-3785306</span>
                            </div>
                            <div class="text-md-right">
                                <span style="font-weight: 700; color: #212529;">OraSoft.pk</span>
                                <span class="text-muted" style="margin-left: 10px;">Behind PSO Petrol Station, Jamshoro</span>
                            </div>
                        </div>
                    </div>

                </div>
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

    <script src="{{asset('assets/libs/jquery-mask-plugin/jquery.mask.min.js')}}"></script>
    <script src="{{asset('assets/libs/autonumeric/autoNumeric-min.js')}}"></script>
    <script src="{{asset('assets/js/pages/form-masks.init.js')}}"></script>
    @endsection

    @section('style')
    <style>
        @media print {
            @page {
                margin: 12mm;
            }

            body {
                background: #fff !important;
            }

            .navbar-custom,
            .left-side-menu,
            .footer,
            .right-bar,
            .rightbar-overlay,
            .demos-show-btn,
            .page-title-box,
            .hidden-print,
            .content-page > .content > .container-fluid > a {
                display: none !important;
            }

            .content-page {
                margin-left: 0 !important;
                padding: 0 !important;
            }

            .content,
            .container-fluid {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
            }

            .card-box {
                border: 0 !important;
                box-shadow: none !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .row {
                display: flex !important;
                flex-wrap: wrap !important;
            }

            .col-md-6 {
                flex: 0 0 50% !important;
                max-width: 50% !important;
            }

            .col-md-12 {
                flex: 0 0 100% !important;
                max-width: 100% !important;
            }

            .float-left {
                float: left !important;
            }

            .float-right {
                float: right !important;
            }

            .text-md-right,
            .text-right {
                text-align: right !important;
            }

            .d-print-none {
                display: block !important;
            }

            .hidden-print .d-print-none {
                display: none !important;
            }

            .table-responsive {
                display: block !important;
                overflow: visible !important;
                width: 100% !important;
            }

            .table {
                width: 100% !important;
            }
        }
    </style>
    @endsection





