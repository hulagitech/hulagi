<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class Notification extends Model
{
     protected $table = 'notifications';
   public static function scopeToSingleDevice($query,$token=null, $title=null, $body=null, $icon, $click_action,$user_id,$order_id)
   {
          $instance = $query->where('notifiable_id',$user_id)->where('read_at',null)->count();
          $user = User::where('id',$user_id)->first();
          $comment_count = $user->unreadComments($user_id);
          $optionBuilder = new OptionsBuilder();
          $optionBuilder->setTimeToLive(60*20);
          $notificationBuilder = new PayloadNotificationBuilder($title);
          $notificationBuilder->setBody($body)
                              ->setSound('default')
                              ->setBadge($instance)
                              ->setIcon($icon)
                              ->setClickAction($click_action);
          $dataBuilder = new PayloadDataBuilder();
          $dataBuilder->addData([
               'badge'=>$instance,
               'order'=>$order_id,
               'user'=>$user_id,
               'comment'=>$comment_count,
               
          ]);
          $option = $optionBuilder->build();
          $notification = $notificationBuilder->build();
          $data = $dataBuilder->build();
          $token = $token;
          $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
          $downstreamResponse->numberSuccess();
          $downstreamResponse->numberFailure();
          $downstreamResponse->numberModification();
          $downstreamResponse->tokensToDelete();
          $downstreamResponse->tokensToModify();
          $downstreamResponse->tokensToRetry();
          $downstreamResponse->tokensWithError();
    
   }

   public static function commentNotify($model, $title=null, $body=null, $icon, $click_action,$comment_count)
   {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);
        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($body)
                                ->setSound('default')
                                ->setBadge(1)
                                ->setIcon($icon)
                                ->setClickAction($click_action);
        $dataBuilder = new PayloadDataBuilder();
       
        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();
        $tokens = $model;
        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);
        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();
        $downstreamResponse->tokensToDelete();
        $downstreamResponse->tokensToModify();
        $downstreamResponse->tokensToRetry();
        $downstreamResponse->tokensWithError();
    
}
}