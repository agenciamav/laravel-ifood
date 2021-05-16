<?php
namespace Agenciamav\LaravelIfood\Models;

use Illuminate\Database\Eloquent\Model;

class IfoodOrderEvent extends Model
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
