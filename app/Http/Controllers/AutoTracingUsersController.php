<?php

namespace App\Http\Controllers;

use App\AutoTracingUsers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Notifier;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;

class AutoTracingUsersController extends Controller
{
    // Load the manage application users dashboard
    public function autoTracingUsers()
    {
        return view('autoTracingUsers');
    }

   
    // get all data in contact tracing users 
    public function autoTracingUsersDataApi(Request $request)
    {
        $model = AutoTracingUsers::query();

        return Datatables::of($model)->addIndexColumn()
            ->filter(function ($query) use ($request) {
                $query->where('upsa_id', "<>", "")
                ->whereNotNull('upsa_id')
                ->orderBy('traced_date','desc');
            })->make(true);
    }


}
