<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\Package;
use App\Models\Purchase_service;
use Livewire\Component;
use App\Models\Services;

class PurchaseService extends Component
{
    public $clients;
    public $services;
    public $packages;
    public $purchase_services;

    public $client;
    public $service;
    public $package;
    public $duration;
    public $ouroffer;
    public $date;
    public $status;
    public $purchase;
    public $type;


    public function mount()
    {
        $this->type = 'add';
        $this->clients = Client::all();
        $this->services = Services::all();
        $this->packages = collect();
        //$this->client = collect();
        $this->purchase_services = collect();
    }
    public function render()
    {
        return view('livewire.purchase-service');
    }
    public function updated($field)
    {
        $this->validateOnly($field, [
            'client' => 'required',
            'service' => 'required',
            'package' => 'required',
            'ouroffer' => 'required',
            'duration' => 'required',
            'date' => 'required',
            'status' => 'required',
        ]);
    }
    public function updatedClient($client_id)
    {
        $this->purchase_services = Purchase_service::where('client_id', $client_id)->get();
    }
    public function updatedService($service_id)
    {
        $this->duration = 0;
        $this->packages = Package::where('service_id', $service_id)->get();
    }
    public function updatedPackage($package_id)
    {
        $this->duration = Package::where('id', $package_id)->first('duration')->duration;
    }
    public function storePurchaseService()
    {
        // dd();
        $this->validate([
            'client' => 'required',
            'service' => 'required',
            'package' => 'required',
            'ouroffer' => 'required',
            'duration' => 'required',
            'date' => 'required',
            'status' => 'required',
        ]);

        $data = [
            'client_id' => $this->client,
            'service_id' => $this->service,
            'package_id' => $this->package,
            'our_offer' => $this->ouroffer,
            'duration' => $this->duration,
            'purchased_date' => $this->date,
            'status' => $this->status,
        ];

        if ($this->type == 'add') {
            Purchase_service::create($data);
            $this->purchase_services = Purchase_service::where('client_id', $this->client)->get();
            session()->flash('success', 'Service purchased successfully');
        } else if ($this->type == 'update') {
            Purchase_service::where('id', $this->purchase->id)->update($data);
            session()->flash('success', 'Service purchased successfully updated');
        }

        $this->mount();
        $this->updatedClient($this->client);
    }
    public function deleteData($id)
    {
        Purchase_service::find($id)->delete();
        $this->mount();
        $this->updatedClient($this->client);
    }
    public function updateData($id)
    {
        $this->purchase = Purchase_service::where('id', $id)->first();

        $this->client = $this->purchase->client_id;
        $this->service = $this->purchase->service_id;
        $this->package = $this->purchase->package_id;
        $this->duration = $this->purchase->duration;
        $this->ouroffer = $this->purchase->our_offer;
        $this->date = $this->purchase->purchased_date;
        $this->status = $this->purchase->status;
        $this->type = 'update';

        $this->updatedClient($this->client);
        $this->updatedService($this->service);
        $this->updatedPackage($this->package);
    }
}
