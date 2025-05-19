<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Land extends Model
{
    //
    use HasFactory;
    protected $fillable=[];

    public function property()
    {
        return $this->morphOne(Property::class, 'propertyable');
    }
}
