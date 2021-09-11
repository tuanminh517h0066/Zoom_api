<?php

namespace App\Http\Controllers\Frontend;

use App\KnowHow;
use App\Member;
use App\Meeting;
use App\News;
use App\NewsDaily;
use App\NewsDailyComment;
use App\Event;
use App\EventNotice;
use App\PracticeReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;
use Cookie;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $meetings = Meeting::all();
        return view('frontend.home')->with(compact('meetings'));
    }
 
}
