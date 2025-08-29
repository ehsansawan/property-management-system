<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperNotifyMe
 */
class NotifyMe extends Model
{
    //
    protected $fillable= ['user_id', 'filters'];
    protected $casts=['filters'=>'array'];
}
