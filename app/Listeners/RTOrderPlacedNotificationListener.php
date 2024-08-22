<?php

namespace App\Listeners;

use App\Events\RTOrderPlacedNotificationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\OrderPlacedNotification;

class RTOrderPlacedNotificationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\RTOrderPlacedNotificationEvent  $event
     * @return void
     */
    public function handle(RTOrderPlacedNotificationEvent $event)
    {
        $notification = new OrderPlacedNotification();
        $notification->message = $event->message;
        $notification->order_id = $event->orderId;
        $notification->save();
    }
}
