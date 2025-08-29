<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperImage
 */
class Image extends Model
{
    //
    protected $table = 'images';
    protected $fillable = ['property_id', 'image_url'];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
