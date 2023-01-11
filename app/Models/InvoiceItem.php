<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    // fillable

    protected $fillable =[
        'name',
        'price',
        'quantity',
        'invoice_id',
    ];
}
