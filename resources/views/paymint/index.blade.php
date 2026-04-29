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
                <li class="breadcrumb-item"><a href="javascript: void(0);">payments</a></li>
                <li class="breadcrumb-item active">Payment Detail</li>
              </ol>
            </div>
            <h4 class="page-title">Payments</h4>
          </div>
        </div>
      </div>
      <!-- end page title -->

      <a href="{{ route('paymint.create') }}" class="btn btn-success mb-2">
        <i class="fa fa-plus"></i> Create Payment
      </a>

      @if($selectedInvoice)
      <div class="card-box">
        @if(session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
        @endif

        @if (count($errors) > 0)
        <div class="alert alert-danger">
          <strong>Whoops!</strong> There were some problems with your input.<br><br>
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        <form action="{{ route('paymint.store') }}" method="post" class="parsley-examples" novalidate="">
          {{ csrf_field() }}
          <input type="hidden" name="clientid" value="{{ $selectedInvoice->client_id }}">
          <input type="hidden" name="invoice_id" value="{{ $selectedInvoice->id }}">
          <input type="hidden" id="package_amount_value" value="{{ $packageAmount }}">

          <h5 class="mb-3">Payment Detail #1</h5>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Client Name</label>
                <input type="text" class="form-control" value="{{ optional($client)->name ?: '-' }}" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Invoice No</label>
                <input type="text" class="form-control" value="{{ $selectedInvoice->invoice_number }}" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Invoice Type</label>
                <input type="text" class="form-control" value="{{ $selectedInvoice->invoice_type }}" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Invoice Status</label>
                <input type="text" class="form-control" value="{{ $selectedInvoice->status == '1' ? 'Active' : 'Inactive' }}" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Expiry Date</label>
                <input type="text" class="form-control" value="{{ $selectedInvoice->expiry_date }}" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Service</label>
                <input type="text" class="form-control" value="{{ $selectedInvoice->service_title }}" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Package</label>
                <input type="text" class="form-control" value="{{ $packageName }}" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Package Total Amount</label>
                <input type="text" class="form-control" value="{{ number_format($packageAmount, 0) }}" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Package Price</label>
                <input type="text" class="form-control" value="{{ number_format($selectedInvoice->package_price, 0) }}" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Payment Status</label>
                <input type="text" class="form-control" value="{{ $paymentStatusLabel }}" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Payment Amount <span class="text-danger">*</span></label>
                <input type="text" name="pay_amount" inputmode="numeric" pattern="[0-9]*" class="form-control js-digit-only" placeholder="0" value="{{ (int) $payAmount }}" required autocomplete="off">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Remaining Amount</label>
                <input type="text" id="total_amount" class="form-control" value="{{ number_format($totalAmount, 0) }}" readonly>
              </div>
            </div>
          </div>

          <div class="form-group text-left mb-0">
            <button class="btn btn-primary waves-effect waves-light mr-1" type="submit">
              Save Payment
            </button>
          </div>
        </form>
      </div>
      @else
      <div class="card-box">
        <p class="mb-0">No payment details found.</p>
      </div>
      @endif

    </div> <!-- end container-fluid -->

  </div> <!-- end content -->


  @endsection

  @section('style')
  <!-- third party css -->
  <link href="assets/libs/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
  <link href="assets/libs/datatables/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />
  <link href="assets/libs/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />
  @endsection

  @section('script')

  <!-- Required datatable js -->
  <script src="assets/libs/datatables/jquery.dataTables.min.js"></script>
  <script src="assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
  <!-- Buttons examples -->
  <script src="assets/libs/datatables/dataTables.buttons.min.js"></script>
  <script src="assets/libs/datatables/buttons.bootstrap4.min.js"></script>
  <script src="assets/libs/jszip/jszip.min.js"></script>
  <script src="assets/libs/pdfmake/pdfmake.min.js"></script>
  <script src="assets/libs/pdfmake/vfs_fonts.js"></script>
  <script src="assets/libs/datatables/buttons.html5.min.js"></script>
  <script src="assets/libs/datatables/buttons.print.min.js"></script>
  <script src="assets/libs/datatables/buttons.colVis.js"></script>

  <!-- Responsive examples -->
  <script src="assets/libs/datatables/dataTables.responsive.min.js"></script>
  <script src="assets/libs/datatables/responsive.bootstrap4.min.js"></script>

  <!-- Datatables init -->
  <script src="assets/js/pages/datatables.init.js"></script>

  <script>
    function updateTotalAmount() {
      var packageAmount = parseInt(document.getElementById('package_amount_value')?.value || '0', 10) || 0;
      var payAmountInput = document.querySelector('input[name="pay_amount"]');
      var totalAmountInput = document.getElementById('total_amount');

      if (!payAmountInput || !totalAmountInput) {
        return;
      }

      var payAmount = parseInt(payAmountInput.value || '0', 10) || 0;
      var remainingAmount = packageAmount - payAmount;
      totalAmountInput.value = remainingAmount > 0 ? remainingAmount : 0;
    }

    document.addEventListener('input', function (event) {
      if (!event.target.classList || !event.target.classList.contains('js-digit-only')) {
        return;
      }

      event.target.value = event.target.value.replace(/\D/g, '');
      updateTotalAmount();
    });

    document.addEventListener('paste', function (event) {
      if (!event.target.classList || !event.target.classList.contains('js-digit-only')) {
        return;
      }

      event.preventDefault();
      var text = (event.clipboardData || window.clipboardData).getData('text') || '';
      event.target.value = text.replace(/\D/g, '');
      updateTotalAmount();
    });

    document.addEventListener('DOMContentLoaded', updateTotalAmount);
  </script>

  @endsection
