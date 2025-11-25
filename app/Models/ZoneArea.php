<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * ZoneArea Model
 *
 * Represents a zone area entity in the application.
 * Corresponds to the 'zone_areas' table.
 */
class ZoneArea extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'division_name',
        'zone_name',
        'shipping_charge',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'shipping_charge' => 'decimal:2',
        'status' => 'string',
    ];

    // Relationships can be added here if needed in the future
}
