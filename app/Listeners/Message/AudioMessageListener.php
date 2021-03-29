<?php

namespace App\Listeners\Message;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use LINE\LINEBot\Event\MessageEvent\AudioMessage;
use Revolution\Line\Facades\Bot;

class AudioMessageListener
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
     * @param  AudioMessage  $event
     * @return void
     */
    public function handle(AudioMessage $event)
    {
        //
    }
}
