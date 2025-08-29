<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperSuggestedLocation
 */
class SuggestedLocation extends Model
{
    //
    protected $fillable = ['user_id','governorate_id','city_name'];
    protected $casts=['governorate_id'=>'integer'];
    protected $table = 'suggested_locations';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }
}
