<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Land extends Model
{
    //
    use HasFactory;
    protected $fillable=['type','slope','is_serviced','is_inside_master_plan'];
    protected $casts=['is_serviced'=>'boolean', 'is_inside_master_plan'=>'boolean',];
    public function property()
    {
        return $this->morphOne(Property::class, 'propertyable');
    }
}
