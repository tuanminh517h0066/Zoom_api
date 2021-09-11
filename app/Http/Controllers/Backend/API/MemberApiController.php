<?php

namespace App\Http\Controllers\Backend\API;

use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberApiController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function form(Member $member = null)
    {
        $member = new Member();
        return view('backend.members.form_api')->with(compact('member'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), $this->rules());
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (Member::where('email', '=', $request->get('mail_address'))->exists()) {
           $validator->errors()->add('mail_address', 'Email has exists.');
           return response()->json($validator->errors(), 422);
        }

        $member = new Member();
        $member->first_name = $request->get('user_first_name');
        $member->last_name  = $request->get('user_last_name');
        $member->email      = $request->get('mail_address');
        $member->password   = bcrypt($request->get('password'));
        $member->gender     = $request->get('gender');
        $member->created_at = date("Y-m-d H:i:s", strtotime($request->get('registerd_date')));
        
        $member->save();

        $responseCode = $member->id ? 200 : 201;
        return response()->json(['saved' => true], $responseCode);
    }

    public function rules()
    {
        $rules = [
            'user_first_name' => 'required|max:191',
            'user_last_name'  => 'required|max:191',
            'gender'          => 'required',
            'mail_address'    => 'required|email',
            'password'        => 'required|max:191',
            'registerd_date'  => ['required', 'date_format:Y/m/d H:i:s' ],
        ];

        return $rules;
    }
}