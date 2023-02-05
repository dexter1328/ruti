<?php

namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use App\User;
use App\CustomerIncentiveQualifier;
use App\CustomerIncentiveWinner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerIncentiveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $type)
    {
        if ($request->isMethod('post')) {
            $date = $request->startDate;
        }else{
            $date = date('m-Y', strtotime('-1 month'));
        }

        if($type == 'qualifiers') {
            $model = 'App\CustomerIncentiveQualifier';
            $table = 'customer_incentive_qualifiers';
        }elseif ($type == 'winners') {
            $model = 'App\CustomerIncentiveWinner';
            $table = 'customer_incentive_winners';
        }

        $incentives = $model::with('user')
            ->where('month_year', $date)
            ->get();

        $incentive_types = customer_incentive_types();
        $incentive_sub_types = customer_incentive_sub_types();

        return view('admin.customer_incentive.index', compact('date', 'type','incentives', 'incentive_types', 'incentive_sub_types'));
    }
}
