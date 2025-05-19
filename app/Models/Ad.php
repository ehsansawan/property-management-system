<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;
    protected $fillable = [];

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function properties()
    {
         $this->hasMany(Property_Ad::class);
    }

}
