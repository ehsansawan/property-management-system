<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    //
    use HasFactory;
    protected $fillable=['user_id', 'plan_id', 'start_date', 'end_date', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    protected static function booted()
    {
        // كل مرة ينحفظ subscription (إنشاء أو تعديل)
        static::saved(function ($subscription) {
            $subscription->user->update([
                'has_active_subscription' => $subscription->user->subscriptions()
                    ->where('status', 'active')
                    ->exists(),
            ]);
        });

        // كل مرة ينحذف subscription
        static::deleted(function ($subscription) {
            $subscription->user->update([
                'has_active_subscription' => $subscription->user->subscriptions()
                    ->where('status', 'active')
                    ->exists(),
            ]);
        });
    }

}
