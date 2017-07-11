<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PlanningController extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	/*public function __construct()
	{
		$this->middleware('auth');
	}*/

	/**
	 * Computes the mean frequentation of all session groups in the period
	 *
	 * Period input is needed
	 * {
	 * 		"start": "2017-03-01 00:00:00",
	 * 		"end": "2017-03-04 00:00:00",
	 * }
	 * 
	 * @return void
	 */
    public function frequentation()
    {
		$params = json_decode(file_get_contents("php://input"), true);

        $groups = DB::table("session_groups")
            ->whereBetween("parent_start_date", [$params['start'], $params['end']])
            ->select("session_group_id")
            ->get();

        $groups = json_decode(json_encode($groups), true);

        $frequentation = DB::table("sessions")
            ->join("participations", "sessions.session_id", "=", "participations.session_id")
            ->select("sessions.session_id", "sessions.session_name", "sessions.session_group", "sessions.session_start", "sessions.session_end", DB::raw('count(passage_id) as crowd'))
            ->whereIn("sessions.session_group", $groups)
            ->whereBetween("session_start", [$params['start'], $params['end']])
            ->groupBy("sessions.session_id", "sessions.session_name", "sessions.session_group", "sessions.session_start", "sessions.session_end")
            ->get();

		http_response_code(200);
		return json_encode($frequentation);
    }
}