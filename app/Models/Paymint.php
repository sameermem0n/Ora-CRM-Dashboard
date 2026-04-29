<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paymint extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'invoice_id',
        'pay_amount',
    ];
}
