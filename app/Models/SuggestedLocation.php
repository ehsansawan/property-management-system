<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuggestedLocation extends Model
{
    //
    protected $table = 'suggested_location';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }
}
