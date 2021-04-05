<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LINE\Laravel\Facade\LINEBot as FacadeLINEBot;
use LINE\LINEBot as LINELINEBot;
use Mockery\ReceivedMethodCalls;
use App\Services\Line\Event\RecieveLocationService;
use App\Services\Line\Event\RecieveTextService;
use App\Services\Line\Event\FollowService;
use log;

class LineBotController
{
    protected $access_token;
    protected $channel_secret;

    public function __construct()
    {
        $this->access_token = env('LINE_BOT_CHANNEL_TOKEN');
        $this->channel_secret = env('LINE_BOT_CHANNEL_SECRET');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view()
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
    * callback from LINE Message API(webhook)
    * @param Request $request
    * @throws \LINE\LINEBot\Exception\InvalidSignatureException
    */

    public function callback (Request $request)
    {
        $input = $request->all();
        $type = $input['events'][0]['type'];

        // タイプごとに分岐
    switch ($type) {
        // メッセージ受信
        case 'message':
            // 返答に必要なトークンを取得
            $reply_token = $input['events'][0]['replyToken'];
            // テスト投稿の場合
            // if ($reply_token == '00000000000000000000000000000000') {
            //     Log::info('Succeeded');
            //     return;
            // }
            // Lineに送信する準備
            $http_client = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($this->access_token);
            $bot         = new \LINE\LINEBot($http_client, ['channelSecret' => $this->channel_secret]);
            // LINEの投稿処理
            $message_data = "メッセージありがとうございます。ただいま準備中です";
            $response     = $bot->replyText($reply_token, $message_data);

            // Succeeded
            if ($response->isSucceeded()) {
                Log::info('返信成功');
                break;
            }
            // Failed
            Log::error($response->getRawBody());
            break;
            break;

        // 友だち追加 or ブロック解除
        case 'follow':
            // ユーザー固有のIDを取得
            $mid = $request['events'][0]['source']['userId'];
            // ユーザー固有のIDはどこかに保存しておいてください。メッセージ送信の際に必要です。
            LineUser::updateOrCreate(['line_id' => $mid]);
            Log::info("ユーザーを追加しました。 user_id = " . $mid);
            break;

        // グループ・トークルーム参加
        case 'join':
            Log::info("グループ・トークルームに追加されました。");
            break;

        // グループ・トークルーム退出
        case 'leave':
            Log::info("グループ・トークルームから退出させられました。");
            break;

        // ブロック
        case 'unfollow':
            Log::info("ユーザーにブロックされました。");
            break;

        default:
            Log::info("the type is" . $type);
            break;
    }

    return;
        // /** @var LINEBot $bot */
        // $bot = app('line-bot');

        // $signature = $_SERVER['HTTP_'.LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
        // if (!LineBot\SignatureValidator::validateSignature($request->getContent(), env('LINE_CHANNEL_SECRET'), $signature)) {
        //     abort(400);
        // }

        // $events = $bot->parseEventRequest($request->getContent(), $signature);
        // foreach ($events as $event) {
        //     $reply_token = $event->getReplyToken();
        //     $reply_message = 'not supported .[' . get_class($event) . '][' . $event->getType() . ']';

        //     //友達登録部分＆解除
        //     switch (ture) {
        //         case $event instanceof LINEBot\Event\FollowEvent:
        //             $service = new FollowService($bot);
        //             $reply_message = $service->execute($event)
        //                 ? 'Line ID access'
        //                 : 'error access';

        //             break;
                
        //         // メッセージの受信
        //         case $event instanceof LINEBot\Event\MessageEvent\TextMessage:
        //             $service = new RecieveTextService($bot);
        //             $reply_message = $service->execute($event);
        //             break;

        //         // 位置情報
        //         case $event instanceof LINEBot\Event\MessageEvent\LocationMessage:
        //             $service = new ReceiveLocationService($bot);
        //             $reply_message = $service->execute($event);
        //             break;

        //         // 選択肢イベント
        //         case $event instanceof LINELINEBot\Event\PostbackEvent:
        //             break;
        //         // ブロック
        //         case $event instanceof LINELINEBot\Event\UnfollowEvent:
        //             break;
        //         default:
        //             $body = $event->getEventBody();
        //             logger()->warning('unknown event.['.  get_class($event) . ']', compact('body'));
        //     }

        //     $bot->replyText($reply_token, $reply_message);
        // }
    }
}
