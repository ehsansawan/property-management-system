<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $fillable=['user_id','location_id','area','name','title','description','price'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function favorites()
    {
        $this->hasMany(Favorite::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function location()
    {
        $this->belongsTo(Location::class);
    }

    public function Ads()
    {
        $this->hasMany(Property_Ad::class);
    }

    //morph relationship
    public function propertyable()
    {
        return $this->morphTo();
    }

}
