<?php

namespace Abn\ArmenianPayments\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbnArmenianPayments extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'currency',
        'language',
        'payment_method',
        'payment_status',
        'payment_response',
    ];
}
