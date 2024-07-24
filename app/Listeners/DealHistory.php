<?php

namespace App\Listeners;

use App\Events\DealSuccess;
use App\Models\Deal;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DealHistory implements ShouldQueue, ShouldHandleEventsAfterCommit
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DealSuccess $event): void
    {
        Deal::create([
            'seller' => $event->seller->name,
            'buyer' => $event->buyer->name,
            'product' => $event->product->title,
            'cost' => $event->cost
        ]);
    }
}
