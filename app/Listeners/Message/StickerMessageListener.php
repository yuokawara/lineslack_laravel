<?php

namespace App\Listeners\Message;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;
use LINE\LINEBot\Event\MessageEvent\StickerMessage;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use Revolution\Line\Facades\Bot;
use Revolution\Line\Facades\LineNotify;

class StickerMessageListener
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
     * @param  StickerMessage  $event
     * @return void
     */
    public function handle(StickerMessage $event)
    {
        $token = $event->getReplyToken();
        $packageId = $event->getPackageId();
        $stickerId = $event->getStickerId();

        $response = Bot::reply($token)->sticker($packageId, $stickerId);

        Notification::route('line-notify', config('line.notify.personal_access_token'))
            ->notify(new LineNotifyTest("packageId : $packageId / stickerId : $stickerId"));

        if (! $response->isSucceeded()) {
            logger()->error(static::class.$response->getHTTPStatus(), $response->getJSONDecodedBody());
        }

        // Bot::replyMessage($event->getReplyToken(), new StickerMessageBuilder($packageId, $stickerId));
    }
}
