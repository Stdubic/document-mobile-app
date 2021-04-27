<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationNotificationGroup extends Model
{
    protected $fillable = [
        'notification_id', 'notification_group_id',
    ];

    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }

    public function notificationGroup()
    {
        return $this->belongsTo(NotificationGroup::class);
    }
}
