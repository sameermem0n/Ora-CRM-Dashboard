<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoicem;
use App\Models\Paymint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PaymintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clientId = $request->query('client_id');
        $invoiceId = $request->query('invoice_id');

        $selectedInvoice = null;

        if (!empty($invoiceId)) {
            $selectedInvoice = Invoicem::with(['client', 'purchase.package', 'purchase.service', 'package.service'])
                ->find($invoiceId);
        }

        if (!$selectedInvoice && !empty($clientId)) {
            $selectedInvoice = Invoicem::with(['client', 'purchase.package', 'purchase.service', 'package.service'])
                ->where('client_id', $clientId)
                ->orderBy('id', 'DESC')
                ->first();
        }

        if (!$selectedInvoice) {
            $selectedInvoice = Invoicem::with(['client', 'purchase.package', 'purchase.service', 'package.service'])
                ->orderBy('id', 'DESC')
                ->first();
        }

        $client = $selectedInvoice ? $selectedInvoice->client : null;
        $packageName = $selectedInvoice ? $selectedInvoice->package_title : '-';
        $packageAmount = $selectedInvoice ? (int) $selectedInvoice->package_price : 0;
        $paymint = $selectedInvoice ? Paymint::where('invoice_id', $selectedInvoice->id)->first() : null;
        $payAmount = $paymint ? (int) $paymint->pay_amount : 0;
        $totalAmount = max($packageAmount - $payAmount, 0);
        $paymentStatusLabel = 'Unpaid';

        if ($payAmount > 0 && $totalAmount > 0) {
            $paymentStatusLabel = 'Partially Paid';
        } elseif ($payAmount > 0 && $totalAmount === 0) {
            $paymentStatusLabel = 'Paid';
        }

        return view('paymint.index', compact(
            'client',
            'selectedInvoice',
            'packageName',
            'paymint',
            'packageAmount',
            'payAmount',
            'totalAmount',
            'paymentStatusLabel'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::get();
        $invoices = Invoicem::get();
        return view('paymint.create', compact('clients', 'invoices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $hasPayAmountColumn = Schema::hasColumn('paymints', 'pay_amount');

        $rules = [
            'clientid' => 'required',
            'invoice_id' => 'required|exists:invoices,id',
        ];

        if ($hasPayAmountColumn) {
            $rules['pay_amount'] = 'required|integer|min:0';
        }

        $this->validate($request, $rules);

        $invoice = Invoicem::find($request->invoice_id);
        if (!$invoice || (int) $invoice->client_id !== (int) $request->clientid) {
            return redirect()->back()->withErrors(['invoice_id' => 'Selected invoice does not belong to selected client.'])->withInput();
        }

        $data = [
            'invoice_id' => $request->invoice_id,
            'status' => 1,
        ];

        if ($hasPayAmountColumn) {
            $data['pay_amount'] = (int) $request->pay_amount;
        }

        $packageAmount = (int) $invoice->package_price;
        $paidAmount = (int) ($data['pay_amount'] ?? 0);

        if ($paidAmount <= 0) {
            $data['status'] = 0;
        } elseif ($paidAmount < $packageAmount) {
            $data['status'] = 2;
        } else {
            $data['status'] = 1;
        }

        Paymint::updateOrCreate([
            'invoice_id' => $request->invoice_id,
        ], $data);

        return redirect()->route('paymint.index', [
            'client_id' => $request->clientid,
            'invoice_id' => $request->invoice_id,
        ])->with('success', 'Payment created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Paymint  $paymint
     * @return \Illuminate\Http\Response
     */
    public function show(Paymint $paymint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Paymint  $paymint
     * @return \Illuminate\Http\Response
     */
    public function edit(Paymint $paymint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Paymint  $paymint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paymint $paymint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Paymint  $paymint
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paymint $paymint)
    {
        //
    }
}
