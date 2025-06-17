<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    //
    use HasFactory;
    protected $fillable=['floor','has_warehouse','type','has_ac','has_bathroom'];
    protected $casts = ['floor'=>'integer','has_warehouse'=>'boolean','has_ac'=>'boolean','has_bathroom'=>'boolean'];

    public function property()
    {
        return $this->morphOne(Property::class, 'propertyable');
    }
}
