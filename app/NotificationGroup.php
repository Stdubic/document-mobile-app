<?php

namespace App;

use App\Observers\NotificationGroupObserver;
use Illuminate\Database\Eloquent\Model;

class NotificationGroup extends Model
{
    protected $fillable = [
        'name',
    ];

    public function notifications()
    {
        return $this->hasMany(NotificationNotificationGroup::class);
    }

    protected static function boot()
    {
        parent::boot();

        self::observe(NotificationGroupObserver::class);
    }
}
