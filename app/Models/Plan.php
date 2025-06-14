<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    
    protected $fillable = ['name', 'features', 'duration', 'type', 'price'];

    public function subscriptions()
    {
        return $this->hasOne(Subscription::class);
    }
}
