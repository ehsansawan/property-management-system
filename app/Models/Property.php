<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory;
    protected $fillable=['user_id','area','name','title','description','price','is_ad','latitude','longitude','address'];
    protected $casts=['location_id'=>'integer','area'=>'integer','price'=>'float','is_ad'=>'boolean','latitude'=>'float','longitude'=>'float','address'=>'string'];

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
        return $this->belongsTo(Location::class);
    }

    public function Ad()
    {
        return $this->hasone(Ad::class);
    }

    //morph relationship
    public function propertyable()
    {
        return $this->morphTo();
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

}
