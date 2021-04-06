<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LINE\LINEBot;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\Event\FollowEvent;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\SignatureValidator;
use PhpParser\Node\Expr\Print_;

class WebhookController extends Controller
{
    public function webhook(Request $request)
    {
        $httpClient = new CurlHTTPClient(env('LINE_BOT_CHANNEL_TOKEN'));
        $bot = new LINEBot($httpClient, ['channelSercret' => 'LINE_BOT_CHANNEL_SECRET']);

        $signature = $_SERVER['HTTP_'.HTTPHeader::LINE_SIGNATURE];

        logger()->info("getContent");
        logger()->info(print_r($request->getContent()));

        if (!SignatureValidator::validateSignature($request->getContent(), env('LINE_BOT_CHANNEL_SECRET'), $signature)) {
            logger()->warning("abort 400");
            abort(400);
        }

        $events = $bot->parseEventRequest($request->getContent(), $signature);
        foreach ($events as $event) {
            $reply_token = $event->getReplyToken();
            $reply_message = 'not supported .[' . get_class($event) . '][' . $event->gettype() . ']';

            switch (true) {
                case $event instanceof FollowEvent:

                    $line_id = $event->getUserId();
                    $res = $bot->getProfile($line_id);
                    if (!$res->isSucceeded()) {
                        logger()->info('!!! failed !!! ');
                        $reply_message = "failed process";
                    } else {
                        $profile = $res->getJSONDecodedBody();
                        // 返り値 Modelのオブジェクト
                        $user = LineUser::where('line_id', $line_id)->first();
                        if(!$user) {
                            $user = new LineUser();
                            $user->line_id = $line_id;
                            $user->line_name = $profile['lineName'];
                            $user->save();
                        }
                        $reply_message = "thanks test";
                    }
                    break;

                    // msassege Receive
                    case $event instanceof TextMessage:
                        $line_id = $event->getUserId();
                        $text = $event->getText();
                        $message = new LineMessage();
                        $message->line_id = $line_id;
                        $message->message = $text;
                        $message->save();
            }
        }
    }
}
