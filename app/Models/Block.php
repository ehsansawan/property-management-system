<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperBlock
 */
class Block extends Model
{
    //
    use HasFactory,softDeletes;
    protected $fillable=['blocker_id','blocked_id','start_date','end_date','reason'];

    public function blocker()
    {
        return $this->belongsTo(User::class,'blocker_id');
    }
    public function blocked()
    {
        return $this->belongsTo(User::class,'blocked_id');
    }
}
