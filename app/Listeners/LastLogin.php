<?php
namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Login;

class LastLogin
{
	/**
     * Create the event listener.
     *
     * @param  Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login $event
     * @return void
     */
    public function handle(Login $event)
    {
        if ($event->guard != 'members') return;

    	$user = $event->user;
    	$yesterday = Carbon::yesterday()->toDateString();
		$lastLogin = $user->last_login_at;

		$countContinueLogin = 0;
		if(substr($yesterday, 0,10) == substr($lastLogin, 0,10)) {
			$countContinueLogin = $user->count_continue_login + 1;
		}

        $user->last_login_at = date('Y-m-d H:i:s');
        $user->count_continue_login = $countContinueLogin;
        //$user->last_login_ip = $this->request->ip();
        $user->save();

        return;
    }
}