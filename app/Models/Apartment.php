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

    public function property()
    {
        return $this->morphOne(Property::class, 'propertyable');
    }
}
