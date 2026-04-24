<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\Invoicem;
use App\Models\Package;
use App\Models\Services;
use Livewire\Component;
use App\Models\Purchase_service;

class Invoice extends Component
{
    public $clients;
    public $services;
    public $packages;
    public $purchase_services;

    public $clientid;
    public $serviceid;
    public $client;
    public $service;
    public $package;
    public $duration;
    public $ouroffer;
    public $date;
    public $status;
    public $purchases;
    public $type = "add";
    public $invoices;
    public $expiry_date;
    public $invoice_type;
    public $data;

    public function mount()
    {
        $this->clients = Client::all();

        $this->services = collect();
        $this->packages = collect();
        $this->purchases = collect();
        $this->invoices = collect();
    }
    public function render()
    {
        return view('livewire.invoice');
    }

    public function updatedClientid($id)
    {
        $this->services = Services::where('status', 1)->get();
        $this->packages = collect();
        $this->invoices = Invoicem::where('client_id', $id)
            ->with(['client', 'package.service', 'purchase.service', 'purchase.package'])
            ->get();
        $this->purchases = Purchase_service::where('client_id', $id)->with('client')->get();
    }


    public function updatedServiceid($id)
    {
        $this->packages = Package::where('service_id', $id)
            ->where('status', 1)
            ->get();
    }
    public function updateData($id)
    {
        $this->data = Invoicem::where('id', $id)->first();
    }
}
