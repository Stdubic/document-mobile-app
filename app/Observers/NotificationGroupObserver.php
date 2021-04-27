<?php

namespace App\Observers;

use App\NotificationGroup;

class NotificationGroupObserver
{
    /**
     * Handle the notification group "created" event.
     *
     * @param  \App\NotificationGroup  $notificationGroup
     * @return void
     */
    public function created(NotificationGroup $notificationGroup)
    {
        //
    }

    /**
     * Handle the notification group "updated" event.
     *
     * @param  \App\NotificationGroup  $notificationGroup
     * @return void
     */
    public function updated(NotificationGroup $notificationGroup)
    {
        //
    }

    /**
     * Handle the notification group "deleted" event.
     *
     * @param  \App\NotificationGroup  $notificationGroup
     * @return void
     */
    public function deleting(NotificationGroup $notificationGroup)
    {
        $notificationGroup->notifications()->delete();
    }

    /**
     * Handle the notification group "restored" event.
     *
     * @param  \App\NotificationGroup  $notificationGroup
     * @return void
     */
    public function restored(NotificationGroup $notificationGroup)
    {
        //
    }

    /**
     * Handle the notification group "force deleted" event.
     *
     * @param  \App\NotificationGroup  $notificationGroup
     * @return void
     */
    public function forceDeleted(NotificationGroup $notificationGroup)
    {
        //
    }
}
