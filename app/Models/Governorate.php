<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperGovernorate
 */
class Governorate extends Model
{
    //
    use HasFactory;
    protected $fillable=['name'];

    public function cities(){
        return $this->hasMany(City::class);
    }

    public function suggestedLocations(){
        return $this->hasMany(SuggestedLocation::class);
    }

}
