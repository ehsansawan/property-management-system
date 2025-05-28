<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    //
    use HasFactory;
    protected $fillable=['floor','rooms','bathrooms','meeting_rooms','has_parking','furnished'];

    public function property()
    {
        return $this->morphOne(Property::class, 'propertyable');
    }
}
