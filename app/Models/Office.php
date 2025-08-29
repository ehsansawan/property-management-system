<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperOffice
 */
class Office extends Model
{
    //
    use HasFactory;
    protected $fillable=['floor','rooms','bathrooms','meeting_rooms','has_parking','furnished',
    //    'furnished_type'
    ];
    protected $casts=['floor'=>'integer','rooms'=>'integer','bathrooms'=>'integer','meeting_rooms'=>'integer'
        ,'has_parking'=>'boolean','furnished'=>'boolean'];
    public function property()
    {
        return $this->morphOne(Property::class, 'propertyable');
    }
}
