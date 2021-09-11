<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use App\Member;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\MessageBag;
use Cookie;
class AuthController extends Controller
{
    public function getLogin()
    {
        if (Auth::guard('members')->check()) {
            
            //add a mission point when member join 7day contineu, 3, 6, 9, 12 month
            $this->addMissioPoint();

            return redirect(route('frontend.home'));
        }

        if (Auth::viaRemember()){
            return redirect(route('frontend.home'));
        }
        
        return view('auth.member');
    }

    public function getForgot()
    {
        return view('auth.forgot');
    }

    public function getChangePwd()
    {
        return view('auth.changePwd');
    }

    public function postLogin(LoginRequest $request)
    {
        $password = $request->get('password');
        $email = $request->get('email');

        if ($token = Auth::guard('members')->attempt(['email' => $email, 'password' => $password], $request->filled('remember'))) {
            if(Auth::guard('members')->user()->status=='1') {
//              Cookie::queue('cookie-app-rn', Auth::guard('members')->user()->id, 3600*24*30);
                setcookie("cookie-app-rn", Auth::guard('members')->user()->id, time()+3600*24*30);

                //$cookie = cookie('name', 'value', $minutes);
                //$value = $request->cookie('name');

                //add a mission point when member join 7day contineu, 3, 6, 9, 12 month
                $this->addMissioPoint();

                //return redirect()->intended(route('frontend.home'));
                return redirect(route('frontend.home'));
            }else{
                Auth::guard('members')->logout();

                //$errors['inactive'] = 'You are temporary blocked. please contact to admin';
                $errors = new MessageBag(['inactive' => 'You are temporary blocked. please contact to admin']);
                return redirect()->route('login.form')->withInput()->with('errors', $errors);
            }
        }

        //$errors['incorrect'] = 'Login failed, please try again!';
        $errors = new MessageBag(['incorrect' => 'Login failed, please try again!']);
        return redirect()->back()->withInput()->with('errors', $errors);
    }

    public function addMissioPoint()
    {
        $memberJoined = Auth::guard('members')->user()->created_at;
        $memberId = Auth::guard('members')->user()->id;
        $countContinueLogin = Auth::guard('members')->user()->count_continue_login;

        $to = \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
        $from = \Carbon\Carbon::createFromFormat('Y-m-d', substr($memberJoined,0,10));
        $diffInMonths = $to->diffInMonths($from) + 1;
//dd($diffInMonths);
        $timeJoined = 0;
        if($diffInMonths >= 3) {
            $missionJoin = \Config::get('constants.mission.join_3_month');
            $objId = 3;
            $timeJoined = 1;
        } 
        if($diffInMonths >= 6) {
            $missionJoin = \Config::get('constants.mission.join_6_month');
            $objId = 6;
            $timeJoined = 1;
        } 
        if($diffInMonths >= 9) {
            $missionJoin = \Config::get('constants.mission.join_9_month');
            $objId = 9;
            $timeJoined = 1;
        } 
        if($diffInMonths >= 12) {
            $missionJoin = \Config::get('constants.mission.join_12_month');
            $objId = 12;
            $timeJoined = 1;
        } 

        if($diffInMonths >= 13) {
            $missionJoin = \Config::get('constants.mission.join_after_12_month');
            $objId = $diffInMonths;
            $timeJoined = 1;
        }

        if($timeJoined) {
            $memberMissionPoint = new \App\MemberMissionPoint();
            $memberMissionPoint->add($missionJoin, $objId, $memberId);
        }

        //add point for login one day
        $missionLogin1Day = \Config::get('constants.mission.login_1_day');
        $memberMissionPoint = new \App\MemberMissionPoint();
        $memberMissionPoint->add($missionLogin1Day, date('Ymd'), $memberId);

        if($countContinueLogin == 7 || $countContinueLogin == 8) {
            $missionLogin7DayContinue = \Config::get('constants.mission.login_7_day');
            $memberMissionPoint = new \App\MemberMissionPoint();
            $memberMissionPoint->add($missionLogin7DayContinue, $missionLogin7DayContinue, $memberId);
        }
    }

    public function logout()
    {
        Auth::guard('members')->logout();
        \Session::flush();
        return redirect()->route('login.form');
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }


/*
    public function getProfile()
    {
        return view('profile.form')->with('member', auth()->user());
    }

    public function postProfile(Request $request)
    {
        $rules = [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255'
        ];

        if ($request->get('password')) {
            $rules['password'] = 'sometimes|min:6|max:25|confirmed';
        }

        $request->validate($rules);

        $user = auth()->user();
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        if ($request->get('password')) {
            $user->password = $request->get('password');
        }

        $user->save();

        return redirect()->back()->withSuccess('Profile Saved.');
    }
*/
}
