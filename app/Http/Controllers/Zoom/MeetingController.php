<?php

namespace App\Http\Controllers\Zoom;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ZoomMeetingTrait;
use App\Meeting;


class MeetingController extends Controller
{
    //
    use ZoomMeetingTrait;

    const MEETING_TYPE_INSTANT = 1;
    const MEETING_TYPE_SCHEDULE = 2;
    const MEETING_TYPE_RECURRING = 3;
    const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;

    // protected $api_key = '4GTcS0WnSYmBDoU9BtYnqQ';
    // protected $api_secret = 'sATMtQKbrbHng1z20mWb3lxkCutVsx5IymAT';

    public function list(Request $request)
    {
        $meetings = $this->list();

        
    }

    public function show($id)
    {
        $meeting = $this->get($id);

        return view('meetings.index', compact('meeting'));
    }

    public function getcreate(Request $request)
    {
        return view('frontend.meeting.create');
    }
    

    public function store(Request $request)
    {
        //  dd('check');
        $this->create($request->all());

        return redirect()->route('frontend.home');
    }

    public function update($meeting, Request $request)
    {
        $this->update($meeting->zoom_meeting_id, $request->all());

        return redirect()->route('meetings.index');
    }

    public function destroy(ZoomMeeting $meeting)
    {
        $this->delete($meeting->id);

        return $this->sendSuccess('Meeting deleted successfully.');
    }

    public function joinMeeting($id) 
    {
        $zoom = Meeting::find($id);
        // dd($zoom);
        $api_key = env('ZOOM_API_KEY');
        $api_secret = env('ZOOM_API_SECRET');
        // dd($api_key);
        $data = [
            'leaveUrl' => route('frontend.home'), 
            'meetingNumber' => $zoom->meeting_id, 
            'passWord' => $zoom->meeting_pwd, 
            'userName' => 'Larvel', 
            'apiKey' => $api_key, 
            'role'  => 0,
            'signature' => $this->generate_signature($api_key,$api_secret,$zoom->meeting_id,0), // chữ kỹ định danh cho meeting // Ở đây role có 3 kiểu 1: người chủ meeting , 0: người tham gia meeting , 5: người support cho người chủ meeting 

        ];
        $data = json_encode($data);
        // dd($check);

        return view('frontend.meeting.meet')->with(compact('data'));
    }

    private function generate_signature ( $api_key, $api_secret, $meeting_number, $role){

        $time = time() * 1000 - 30000;//time in milliseconds (or close enough)

        $data = base64_encode($api_key . $meeting_number . $time . $role);

        $hash = hash_hmac('sha256', $data, $api_secret, true);

        $_sig = $api_key . "." . $meeting_number . "." . $time . "." . $role . "." . base64_encode($hash);

        //return signature, url safe base64 encoded
        return rtrim(strtr(base64_encode($_sig), '+/', '-_'), '=');
    }
}
