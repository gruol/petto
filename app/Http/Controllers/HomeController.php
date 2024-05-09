<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
  Shipment ,
  CustomerPets,

};
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   

        $pageTitle = 'Dashboard';
        $registeredPets = CustomerPets::
        selectRaw(" count( CASE WHEN category = 'Dog' THEN 1 ELSE NULL END ) AS DogCount,
                    count( CASE WHEN category = 'Cat' THEN 1 ELSE NULL END ) AS CatCount,
                    count( CASE WHEN category = 'Bird' THEN 1 ELSE NULL END ) AS BirdCount,count(*) as totaRegisteredPets")->first();
        // dd($registeredPets);

//         SELECT
//     count( CASE WHEN query_status = 'Pending' THEN 1 ELSE NULL END ) AS queryPendingCount,
//     count( CASE WHEN query_status = 'Responded' THEN 1 ELSE NULL END ) AS queryRespondedCount,
    
// FROM
//     `shipments` 
        return view('admin.dashboard.dashboard',compact('registeredPets'))->with('pageTitle');
    }
}
