<?php

namespace App\Http\Controllers\Backend;

use App\Member;
use App\Location;
use App\PracticeReport;
use App\MemberMissionPoint;
use Illuminate\Http\Request;
use Shahnewaz\Redprint\Traits\CanUpload;
use App\Http\Requests\Backend\MemberRequest;
use App\Http\Requests\Backend\CsvImportRequest;
use App\Http\Controllers\Controller;

class MembersController extends Controller
{
    use CanUpload;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $members = Member::withTrashed();
        
        if ($request->get('member_id')) {
            $members = $members->where('id', intval($request->get('member_id')));
        }

        if ($request->get('email')) {
            $members = $members->where('email', 'LIKE', '%'.$request->get('email').'%');
        }

        if ($request->get('name')) {
            $members = $members->where(\DB::raw("CONCAT(`last_name`,`first_name`)"), 'LIKE', '%'.$request->get('name').'%');
        }

        if ($request->get('number_practice')) {
            $members = $members->withCount('PracticeReport')->has('PracticeReport', '=' , $request->get('number_practice'));
        }

        if ($request->get('number_ranking')) {
            $userList = $this->getUserByRanking($request->get('number_ranking'));
            $members = $members->whereIn('id', $userList);
        }

        if ($request->get('status')) {
            $members = $members->where('status', $request->get('status'));
        }

        $members->orderBy('created_at', 'DESC');
        $membersData = $members->paginate(20);

        $locationList = Location::pluck('name', 'id');

        return view('backend.members.index')->with(compact('membersData', 'locationList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function form(Member $member = null)
    {
        $member = $member ?: new Member;

        $practiceReportCount= 0;
        if($member->id) {
            $practiceReportCount = PracticeReport::where('member_id', $member->id)->count();
        }
        
        $memberRanking = MemberMissionPoint::selectRaw('sum(point) AS total_point, member_id')
        ->groupBy('member_id')
        ->orderBy('total_point', 'DESC')
        ->get();

        $ranking=0;
        if($member->id) {
            foreach($memberRanking as $key=>$memberRankingItem) {
                if($memberRankingItem->total_point != @$totalPointPrev) {
                    $ranking += 1;
                } 

                if($memberRankingItem->member_id == $member->id) break;
                $totalPointPrev = $memberRankingItem->total_point;
            }
        }
        
        return view('backend.members.form')->with(compact('member', 'practiceReportCount', 'ranking'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function post(MemberRequest $request, Member $member)
    {
        $member = Member::firstOrNew(['id' => $request->get('id')]);
        $member->id = $request->get('id');
		$member->first_name = $request->get('first_name');
		$member->last_name  = $request->get('last_name');
        $member->gender     = $request->get('gender');
		$member->email      = $request->get('email');
        $member->status     = $request->get('status');
		
        if($request->get('created_at')) {
            $member->created_at = $request->get('created_at') .' '. $request->get('created_time');
        }

        if(!$request->get('id')) {
            $member->password = bcrypt($request->get('password'));
        }

		$member->title   = $request->get('title');
        $member->intro   = $request->get('intro');
        $member->goal    = $request->get('goal');
        $member->skill   = $request->get('skill');
        $member->role_create_knowhow = intval($request->get('role_create_knowhow'));
        
		if ($request->file('avatar_image')) {
			$member->avatar_image = $this->upload($request->file('avatar_image'), 'members')->getFileName();
		} else {
			$member->avatar_image = $member->avatar_image;
		}
		if ($request->file('cover_image')) {
			$member->cover_image = $this->upload($request->file('cover_image'), 'members')->getFileName();
		} else {
			$member->cover_image = $member->cover_image;
		}

        $member->save();

        $message = trans('redprint::core.model_added', ['name' => $member->last_name . $member->first_name]);
        return redirect()->route('member.index')->withMessage($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Member $member)
    {
        $member->delete();
        $message = trans('redprint::core.model_deleted', ['name' => $member->last_name . $member->first_name]);
        return redirect()->back()->withMessage($message);
    }

    /**
     * Restore the specified deleted resource to storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($memberId)
    {
        $member = Member::withTrashed()->find($memberId);
        $member->restore();
        $message = trans('redprint::core.model_restored', ['name' => $member->last_name . $member->first_name]);
        return redirect()->back()->withMessage($message);
    }

    public function forceDelete($memberId)
    {
        $member = Member::withTrashed()->find($memberId);
        $member->forceDelete();
        $message = trans('redprint::core.model_permanently_deleted', ['name' => $member->last_name . $member->first_name]);
        return redirect()->back()->withMessage($message);
    }

    private function getUserByRanking($rankingFilter) 
    {
        $memberRanking = MemberMissionPoint::selectRaw('sum(point) AS total_point, member_id')
        ->groupBy('member_id')
        ->orderBy('total_point', 'DESC')
        ->get();

        $members=[];
        $ranking=0;
        $totalPointPrev=0;

        foreach($memberRanking as $key=>$memberRankingItem) {
            if($memberRankingItem->total_point != $totalPointPrev) {
                $ranking += 1;
            } 

            if($ranking == $rankingFilter) {
                $members[] = $memberRankingItem->member_id;
            }

            if($ranking > $rankingFilter) break;

            $totalPointPrev = $memberRankingItem->total_point;
        }

        return $members;
    }

    public function ajaxChangeStatus(Request $request) 
    {
        $memberIdList = $request->get('member_id_list');
        $status = $request->get('status_action');

        Member::whereIn('id', explode(',', $memberIdList))->update(['status' => $status]);
        return redirect()->route('member.index')->withMessage('Status Changed');
    }

    public function importCSV(CsvImportRequest $request) 
    {
        $path = $request->file('csv_file')->getRealPath();
        $data = array_map('str_getcsv', file($path));

        $memberStatus = \Config::get('constants.member_status');

        if (count($data) > 0) {
            $csv_data = array_slice($data, 0, count($data));
            foreach ($csv_data as $key=>$row) {
                if($key == 0) continue;
                
                $email = $row[2];
                $status = $row[3];

                if($memberStatus[$status]) {
                    Member::where('email', $email)->update(['status' => $memberStatus[$status]]);
                }
            }
        }

        $message = trans('redprint::core.model_added');
        return redirect()->route('member.index')->withMessage($message);
    }

    public function downloadCsv(Request $request)
    {   
        header('Content-Encoding: UTF-8');
        header( 'Content-Type: text/csv;charset=UTF-8' );
        header( 'Content-Disposition: attachment;filename=csv_sample.csv');
        echo "\xEF\xBB\xBF";
        
        $list = array (
            array('No', '名前', 'メールアドレス', 'ステータス'),
            array('1', '04Fss', 'fss10@mailinator.com', '退会'),
            array('2', 'YuriHuyen', 'fss10@mailinator.com', '利用停止中')
        );

        $fp = fopen('php://output', 'w');

        foreach ($list as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);
        exit;

        //PDF file is stored under project/public/download/info.pdf
        //$file= public_path(). "/uploads/csv/csv_sample.csv";

        /*$headers = array(
          'Content-Type: application/csv',
        );

        return Response::download($file, 'csv_sample.csv', $headers);
        */
    }    
}
