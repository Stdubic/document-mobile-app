<?php

namespace App;

use App\Observers\NotificationObserver;
use Illuminate\Database\Eloquent\Model;


class Notification extends Model
{
    protected $fillable = [
        'title', 'body',
    ];

    public function groups()
    {
        return $this->hasMany(NotificationNotificationGroup::class);
    }

    public function devices()
    {
        return UserDevice::all()->pluck('device_id')->toArray();
    }

    protected static function boot()
    {
        parent::boot();

        self::observe(NotificationObserver::class);
    }
}
