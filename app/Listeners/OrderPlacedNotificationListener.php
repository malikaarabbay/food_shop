<?php

namespace App\Listeners;

use App\Events\OrderPlacedNotificationEvent;
use App\Models\Order;
use App\Mail\OrderPlacedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;

class OrderPlacedNotificationListener
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
     * @param  \App\Events\OrderPlacedNotificationEvent  $event
     * @return void
     */
    public function handle(OrderPlacedNotificationEvent $event)
    {
        $orderId = $event->orderId;

        $order = Order::with('user')->find($orderId);

        Mail::send(new OrderPlacedMail($order));
    }
}
