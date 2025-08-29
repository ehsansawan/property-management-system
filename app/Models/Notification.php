<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FcmNotification
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $body
 * @property bool $is_read
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|FcmNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|FcmNotification whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FcmNotification whereIsRead($value)
 */
class Notification extends Model
{
    //
    protected $table = 'notifications';
    use HasFactory;
    protected $fillable = ['user_id', 'title', 'body', 'type', 'is_read'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
