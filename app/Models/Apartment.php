<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;
    protected $fillable=[
        'floor','rooms','bedrooms','bathrooms','has_elevator','has_garage','furnished','furnished_type','has_alternative_power'
    ];

    protected $casts = [
        'floor' => 'integer',
        'rooms' => 'integer',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
        'has_elevator' => 'boolean',
        'has_garage' => 'boolean',
        'furnished' => 'boolean',
        'has_alternative_power' => 'boolean',
    ];

    public function property()
    {
        return $this->morphOne(Property::class, 'propertyable');
    }
}
