<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperAppointment
 */
class Appointment extends Model
{
    protected $fillable=[];

    public function user()
    {
        $this->belongsTo(User::class);
    }
    public function property()
    {
        $this->belongsTo(Property::class);
    }
}
