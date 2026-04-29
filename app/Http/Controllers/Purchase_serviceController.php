<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Services;
use Illuminate\Http\Request;
use App\Models\Purchase_service;
use App\Models\Client;

class Purchase_serviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Purchase_service::with(['client', 'package', 'service'])->orderBy('id', 'DESC')->paginate(5);
        return view('purchases.index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Services::get();
        $packages = Package::get();
        $clients = Client::get();
        return view("purchases.create", compact('services', 'packages', 'clients'));
        // return view("purchases.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client_id = $request->client_id;
        $service_id = $request->service_id;
        $package_id = $request->package_id;
        $duration = $request->duration;
        for ($i = 0; $i < count($client_id); $i++) {
            $data = [
                'client_id' => $client_id[$i],
                'service_id' => $service_id[$i],
                'package_id' => $package_id[$i],
                'duration' => $duration[$i],
            ];
            $save = Purchase_service::create($data);
            return redirect()->route('purchases.index')->with('success', 'Purchase created successfully');
        }
        // $this->validate($request, [
        //     'name' => 'required',
        //     'email' => 'required',
        //     'password' => 'required',
        //     'contact' => 'required',
        //     'address' => 'required',
        //     'city' => 'required',
        //     'status' => 'required',
        // ]);
        // $input = $request->all();
        // $Purchases = Purchase_service::create($input);
        // return redirect()->route('purchases.index')->with('success', 'Purchase created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $Purchase
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Purchase = Purchase_service::with(['client', 'package', 'service'])->find($id);
        return view('purchases.show', compact('Purchase'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $Purchase
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $services = Services::get()->pluck('title', 'id');
        $packages = Package::get()->pluck('title', 'id');
        $clients = Client::get()->pluck('name', 'id');
        $purchase = Purchase_service::find($id);
        return view("purchases.edit", compact('purchase', 'services', 'packages', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $Purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        dd($input);
        // $Purchase = Purchase_service::find($id);
        // $Purchase->update($input);
        // return redirect()->route('purchases.index')->with('success', 'Purchase Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $Purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Purchase_service::find($id)->delete();
        return redirect()->route('purchases.index')->with('success', 'Purchase deleted successfully');
    }
}
