<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    //
    use HasFactory;
    protected $fillable=['floor','has_warehouse','type'];

    public function property()
    {
        return $this->morphOne(Property::class, 'propertyable');
    }
}
