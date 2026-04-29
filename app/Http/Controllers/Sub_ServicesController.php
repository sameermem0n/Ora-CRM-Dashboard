<?php

namespace App\Http\Controllers;

use App\Models\Sub_service;
use Illuminate\Http\Request;
use App\Models\Services;

class Sub_ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $services = Services::get();
        $data = Sub_service::with('service')->orderBy('id', 'DESC')->paginate(5);
        return view('sub-services.index', compact('data', 'services'))
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
        return view("sub-services.create", compact("services"));
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
        $this->validate($request, [
            'service_id' => 'required',
            'title' => 'required'
        ]);
        $input = $request->all();
        $sub = Sub_service::create($input);
        return redirect()->route('sub-services.index')->with('success', 'Service created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('sub-services.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subService = Sub_service::findOrFail($id);
        $services = Services::get();

        return view('sub-services.edit', compact('subService', 'services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'service_id' => 'required',
            'title' => 'required',
        ]);

        $subService = Sub_service::findOrFail($id);
        $subService->update($request->only('service_id', 'title'));

        return redirect()->route('sub-services.index')->with('success', 'Sub service updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Sub_service::findOrFail($id)->delete();

        return redirect()->route('sub-services.index')->with('success', 'Sub service deleted successfully');
    }
}
