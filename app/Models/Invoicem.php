<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoicem extends Model
{
    use HasFactory;
    protected $table = "invoices";
    protected $fillable = [
        'status',
        'client_id',
        'package_id',
        'purchase_service_id',
        'invoice_type',
        'expiry_date',
        'invoice_number',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase_service::class, 'purchase_service_id');
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function getPackageTitleAttribute(): string
    {
        $package = $this->resolvePackage();

        return $package ? $package->title : '-';
    }

    public function getServiceTitleAttribute(): string
    {
        $package = $this->resolvePackage();
        if ($package && $package->relationLoaded('service')) {
            return optional($package->service)->title ?: '-';
        }

        if ($package) {
            return optional($package->service)->title ?: '-';
        }

        return optional(optional($this->purchase)->service)->title ?: '-';
    }

    private function resolvePackage(): ?Package
    {
        if ($this->relationLoaded('package') && $this->package) {
            return $this->package;
        }

        if (!empty($this->package_id)) {
            return Package::with('service')->find($this->package_id);
        }

        if ($this->relationLoaded('purchase') && $this->purchase && $this->purchase->package) {
            return $this->purchase->package;
        }

        if (!empty($this->purchase_service_id)) {
            $purchase = $this->relationLoaded('purchase') ? $this->purchase : $this->purchase()->with('package')->first();
            if ($purchase && $purchase->package) {
                return $purchase->package;
            }

            // Compatibility fallback when package IDs were saved into purchase_service_id.
            return Package::with('service')->find($this->purchase_service_id);
        }

        return null;
    }
}
