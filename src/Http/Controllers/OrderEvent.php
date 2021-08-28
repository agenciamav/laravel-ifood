<?php

namespace Agenciamav\LaravelIfood\Http\Controllers\Ifood;

use Illuminate\Database\Eloquent\Model;

class OrderEvent extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'id',
        'order_id',
        'code',
        'metadata',
        'full_code',
        'created_at',
        'acknoledged_at'
    ];

    protected $casts = [
        'metadata' => 'array',
    ];
}
