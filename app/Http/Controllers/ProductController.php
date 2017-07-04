<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductController extends BaseController
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
		$products = DB::table("produits")
			->get();

		http_response_code(200);
		return json_encode($products);
	}

	// GET a user profile
	public function show($id)
	{
        $product = DB::table("produits")
			->where('product_id', $id)
			->get();

		http_response_code(200);
        return json_encode($product);
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

	/**
	 * Retrieves the sales of given products on a given period
	 *
	 * Period input is needed
	 * {
	 * 		"start": "2017-03-01 00:00:00",
	 * 		"end": "2017-03-04 00:00:00",
	 * 		"products": [1, 2, 3]
	 * }
	 * 
	 * @return void
	 */
    public function sales()
    {
		$params = json_decode(file_get_contents("php://input"), true);

        $sales = DB::table("produits_adherents")
			->join("transactions", "produits_adherents.id_transaction_foreign", "=", "transactions.id_transaction")
			->whereIn("produits_adherents.id_produit_foreign", $params['products'])
			->whereBetween("date_achat", [$params['start'], $params['end']])
			->get();

		http_response_code(200);
		return json_encode($sales);
    }
}