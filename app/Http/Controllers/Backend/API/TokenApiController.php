<?php

namespace App\Http\Controllers\Backend\API;

use App\Member;
use App\NotificationUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TokenApiController extends Controller
{
    /* save token */
    public function saveToken(Request $request){
        $data = $request->all();
//        $result = NotificationUser::firstOrCreate(['user_id' => 10, 'token' => '123', 'platforms' => 'android']);
        $result = NotificationUser::firstOrCreate(['user_id' => $data['user_id'], 'token' => $data['token'], 'platforms' => $data['platforms']]);
        return json_encode($result);
    }

    /* Sample to send notify for user */
    public function index(Request $request){
        $data = [
            'user_id' => $request->get('id'),
            'title' => $request->get('title'),
            'link' => $request->get('link'),
        ];
        
        return $this->sendNotifyToUser($data);
    }

    public function sendNotifyToUser($data){
        // get list token
        if(is_array($data['user_id'])){
            $notify_user = NotificationUser::whereIn('user_id', $data['user_id'])->pluck('token')->toArray();
        }else{
            if($data['user_id']){
                $notify_user = NotificationUser::where('user_id', $data['user_id'])->pluck('token')->toArray();
            }else{
                // send to all users
                $notify_user = NotificationUser::get()->pluck('token')->toArray();
            }
        }
        if(sizeof($notify_user)){
            $notify_user = array_unique($notify_user);
            $data['title'] = (isset($data['title']))?$data['title']:'';
            $data['body'] = (isset($data['body']))?$data['body']:'';
            $data['link'] = (isset($data['link']))?$data['link']:'';
            $data['to'] = $notify_user;
            return $this->sendNotify($data);
        }
        return '';
    }

    /* Send notify to user*/
    public function sendNotify($data){
        $fcm_server_url = \Config::get('fcm.FCM_SERVER_URL');
        $fcm_server_key = \Config::get('fcm.FCM_SERVER_KEY');

        $arrayToSend = array(
            "notification"=>array(
                "title"=> $data['title'],
                "body"=> $data['body'],
                "sound"  => "default",
                "click_action"=>"FCM_PLUGIN_ACTIVITY"
            ),
            "data"=>array(
                "title"=> $data['title'],
                "text"=> $data['title'],
                "body"=> $data['body'],
                "link"=> $data['link']
            ),
            "priority"=>"high"
        );

        if(is_array($data['to'])){
            $arrayToSend['registration_ids'] = $data['to'];
        }else{
            $arrayToSend['to'] = $data['to'];
        }

        $json = json_encode($arrayToSend);
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key=' . $fcm_server_key;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcm_server_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //Send the request
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;

    }
}