<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperResetCodePassword
 */
class ResetCodePassword extends Model
{
    //
    use HasFactory;
    protected $fillable=[
      'email','code'
    ];
}
