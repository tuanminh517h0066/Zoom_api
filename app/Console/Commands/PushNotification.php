<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\UserFacebook; 

class PushNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:push_notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This cron to push notification News, Know How is published';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //get know how create by admin
        $knowHowList = KnowHow::whereDate('publish_date', \Carbon\Carbon::today())->where('member_id', 2)->get();
        
        //get news will publissh in current day
        $newsList = News::whereDate('publish_date', \Carbon\Carbon::today())->get();
   
        //get member active
        $memberList = Member::where('status', 1)->get();

        $client = new \GuzzleHttp\Client();
        $pushNotificaitonNewsText = \Config::get('constants.push_notificaiton_text.publish_news');

        //push notification for publish news
        foreach($newsList as $newsItem) {
			
            $userList = [];
            foreach($memberList as $memberItem) {
	    		if(@$memberItem->MemberNotificationSetting->turnoff_news) continue;
                
                if($newsItem->enable_limit_target) {
                    if(strtotime($memberItem->created_at) < strtotime($newsItem->limit_target)) {
                        $userList[] = $memberItem->id;
                    }
                } else {
                    $userList[] = $memberItem->id;
                }
	    	}   

            $body = [
                'id'      => $userList,
                'title'   => $pushNotificaitonNewsText,
                'link'    => route('news.frontend.detail', $newsItem->id)
            ];

            $url = config('app.url') . "/api/notify";
            $client->post($url, ['form_params' => $body]);         
        }

        $pushNotificaitonKnowHowText = \Config::get('constants.push_notificaiton_text.publish_knowhow');

        //push notification for know how puslish
        foreach($knowHowList as $knowhowItem) {
    		$userList = [];
            foreach($memberList as $memberItem) {
	    		if(@$memberItem->MemberNotificationSetting->turnoff_knowhow) continue;
	    		$userList[] = $memberItem->id;
	    	} 

            $body = [
                'id'      => $userList,
                'title'   => $pushNotificaitonKnowHowText,
                'link'    => route('knowHow.frontend.detail', $knowhowItem->id)
            ];

            $url = config('app.url') . "/api/notify";
            $client->post($url, ['form_params' => $body]);
    	}

        $this->comment('Cron Push Notificaiton run successfully!');
    }
}
