<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    //
    use HasFactory;
    protected $fillable = ['property_id','start_date','end_date','is_active','views'];
    protected $casts =[
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'views' => 'integer',
        'property_id' => 'integer'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function favorites()
    {
        $this->hasMany(Favorite::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

}
