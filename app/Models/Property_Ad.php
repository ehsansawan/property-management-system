<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property_Ad extends Model
{
    //
    use HasFactory;
    protected $table = 'property_ads';
    protected $fillable = [];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }

}
