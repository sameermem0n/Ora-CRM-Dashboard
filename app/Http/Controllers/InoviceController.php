<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoicem;
use App\Models\Paymint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class InoviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Invoicem::with(['client', 'package.service', 'purchase.service', 'purchase.package']);

        if ($request->filled('clientid')) {
            $query->where('client_id', $request->input('clientid'));
        }

        if ($request->filled('serviceid')) {
            // filter invoices where package's service or purchase's service matches
            $serviceId = $request->input('serviceid');
            $query->where(function ($q) use ($serviceId) {
                $q->whereHas('package', function ($q2) use ($serviceId) {
                    $q2->where('service_id', $serviceId);
                })->orWhereHas('purchase', function ($q3) use ($serviceId) {
                    $q3->where('service_id', $serviceId);
                });
            });
        }

        if ($request->has('package_id')) {
            $ids = (array) $request->input('package_id');
            $query->where(function ($q) use ($ids) {
                $q->whereIn('package_id', $ids)->orWhereIn('purchase_service_id', $ids);
            });
        }

        $data = $query->orderBy('id', 'DESC')->paginate(5);
        return view('invoices.index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("invoices.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'clientid' => 'required',
            'serviceid' => 'required',
            'package_id' => 'required|array|min:1',
            'invoice_status' => 'required',
            'invoice_type' => 'required',
            'expiry_date' => 'required',
        ]);

        $packageIds = $request->input('package_id', []);
        $hasPackageColumn = Schema::hasColumn('invoices', 'package_id');
        $hasPurchaseColumn = Schema::hasColumn('invoices', 'purchase_service_id');

        foreach ($packageIds as $packageId) {
            $data = [
                'status' => $request->invoice_status,
                'client_id' => $request->clientid,
                'purchase_service_id' => null,
                'expiry_date' => $request->expiry_date,
                'invoice_number' => 44,
                'invoice_type' => $request->invoice_type,
            ];

            if ($hasPackageColumn) {
                $data['package_id'] = $packageId;
            }

            // Fallback for older schemas where package_id does not exist yet.
            if (!$hasPackageColumn && $hasPurchaseColumn) {
                $data['purchase_service_id'] = $packageId;
            }

            Invoicem::create($data);
        }

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inovice  $inovice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoicem::with(['client', 'package.service', 'purchase.service', 'purchase.package'])->findOrFail($id);
        $client = $invoice->client ?: (object) [
            'name' => '-',
            'organization' => '-',
            'city' => '-',
            'address' => '-',
            'contact' => '-',
        ];
        $purchase = $invoice->purchase ?: (object) [
            'purchased_date' => optional($invoice->created_at)->format('Y-m-d') ?: '-',
            'id' => $invoice->id,
        ];
        $orderDate = optional($invoice->purchase)->purchased_date;

        if (empty($orderDate) || $orderDate === '-') {
            $orderDate = optional($invoice->created_at)->format('Y-m-d')
                ?: optional($invoice->updated_at)->format('Y-m-d')
                ?: '-';
        }

        $orderId = optional($invoice->purchase)->id ?: $invoice->id;

        return view("invoices.show", compact('invoice', 'client', 'purchase', 'orderDate', 'orderId'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inovice  $inovice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = Invoicem::with(['client', 'package.service', 'purchase.service', 'purchase.package'])->findOrFail($id);
        return view("invoices.edit", compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inovice  $inovice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|in:0,1',
        ]);

        $invoice = Invoicem::findOrFail($id);
        $invoice->status = (int) $request->status;
        $invoice->save();

        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inovice  $inovice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoicem::findOrFail($id);

        Paymint::where('invoice_id', $invoice->id)->delete();
        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully');
    }
}

