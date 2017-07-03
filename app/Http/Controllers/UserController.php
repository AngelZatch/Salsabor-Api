<?php
/**
 * Created by PhpStorm.
 * User: AngelZatch
 * Date: 26/02/2017
 * Time: 16:35
 */

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;

class UserController extends BaseController
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

	// GET all profiles
	public function index()
	{
		$users = DB::table("users")
			->get();

		http_response_code(200);
		return json_encode($users);
	}

	// GET a user profile
	public function show($id)
	{
        $user = DB::table("users")
			->where('user_id', $id)
			->get();

		http_response_code(200);
        return json_encode($user);
    }

	public function create()
	{

	}

	public function destroy()
	{

	}

	public function update()
	{

	}

}