<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'customer_id',
        'endpoint_url',
        'payload',
        'status',
        'attempts',
        'last_error',
    ];

    protected $casts = [
        'payload' => 'array',
    ];
}