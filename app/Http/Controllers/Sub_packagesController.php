<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Services;
use App\Models\Sub_Package;
use Illuminate\Http\Request;

class Sub_packagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Sub_Package::with(['package', 'sub_service'])->orderBy('id', 'DESC')->paginate(5);


        return view('sub-packages.index', compact('data'))
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
        return view("sub-packages.create", compact("services", "packages"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $input = $request->all();
        $this->validate($request, [
            'packageid' => 'required',
            'sub_service_id*' => 'required',
            'description*' => 'required'
        ]);
        for ($i = 0; $i < count($request->sub_service_id); $i++) {
            $data = [
                'package_id' => $request->packageid,
                'sub_service_id' => $request->sub_service_id[$i],
                'description' => $request->description[$i],
            ];
            // dd($request );
            $sub_package = Sub_Package::create($data);
        }
        return redirect()->route('sub_packages.index')->with('success', 'Sub Package created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sub_Package  $sub_Package
     * @return \Illuminate\Http\Response
     */
    public function show(Sub_Package $sub_package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sub_Package  $sub_Package
     * @return \Illuminate\Http\Response
     */
    public function edit(Sub_Package $sub_package)
    {
        $services = Services::pluck('title', 'id');
        $packages = Package::pluck('title', 'id');

        return view('sub-packages.edit', compact('sub_package', 'services', 'packages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sub_Package  $sub_Package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sub_Package $sub_package)
    {
        $this->validate($request, [
            'package_id' => 'required|exists:packages,id',
            'sub_service_id' => 'required|exists:sub_services,id',
            'description' => 'required|string',
        ]);

        $sub_package->update([
            'package_id' => $request->package_id,
            'sub_service_id' => $request->sub_service_id,
            'description' => $request->description,
        ]);

        return redirect()->route('sub_packages.index')->with('success', 'Sub Package updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sub_Package  $sub_Package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sub_Package $sub_package)
    {
        $sub_package->delete();

        return redirect()->route('sub_packages.index')->with('success', 'Sub Package deleted successfully');
    }
}
