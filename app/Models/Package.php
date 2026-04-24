<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'service_id',
        'price',
        'duration',
        'status',
    ];

    public function service()
    {
        return $this->belongsTo(Services::class, 'service_id');
    }
}
