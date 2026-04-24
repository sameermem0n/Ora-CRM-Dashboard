<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoicem;
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
        // $data = "Yes wrking";
        $data = Invoicem::with(['client', 'package.service', 'purchase.service', 'purchase.package'])
            ->orderBy('id', 'DESC')
            ->paginate(5);
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
    public function show()
    {
        return view("invoices.show");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inovice  $inovice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoices = Invoicem::find($id);
        return view("invoices.edit", compact('invoices'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inovice  $inovice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inovice  $inovice
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
