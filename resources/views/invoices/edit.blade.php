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
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('invoices.index') }}">Invoices</a></li>
                                <li class="breadcrumb-item active">Edit Invoice</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Edit Invoice</h4>
                    </div>
                </div>
            </div>

            <a href="{{ route('invoices.index') }}" style="font-size: 20px;"><i class="fa fa-arrow-circle-left mb-2" aria-hidden="true"></i></a>

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

                        <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Invoice No</label>
                                        <input type="text" class="form-control" value="{{ $invoice->invoice_number }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Client</label>
                                        <input type="text" class="form-control" value="{{ optional($invoice->client)->name ?: '-' }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Organization</label>
                                        <input type="text" class="form-control" value="{{ optional($invoice->client)->organization ?: '-' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Package</label>
                                        <input type="text" class="form-control" value="{{ $invoice->package_title }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Invoice Type</label>
                                        <input type="text" class="form-control" value="{{ $invoice->invoice_type }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Expiry Date</label>
                                        <input type="text" class="form-control" value="{{ $invoice->expiry_date }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Status</strong>
                                        <select name="status" class="form-control" required>
                                            <option value="1" {{ (string) $invoice->status === '1' ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ (string) $invoice->status === '0' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Update Invoice</button>
                                <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
