<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperUserSearches
 */
class UserSearches extends Model
{
    //

    protected $fillable= ['user_id', 'filters'];
    protected $casts=['filters'=>'array'];
}
