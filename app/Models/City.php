<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCity
 */
class City extends Model
{
    //
    use HasFactory;
    protected $fillable=['name','governorate_id'];
   // protected $casts=['governorate_id'=>'integer'];

    protected $table='cities';

    public function locations(){
        return $this->hasMany(Location::class);
    }
    public function governorate(){
        return $this->belongsTo(Governorate::class);
    }
}
