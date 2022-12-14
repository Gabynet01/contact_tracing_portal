<?php

namespace App\Http\Controllers;

use App\IsolatedPersons;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;

class IsolatedPersonsController extends Controller
{
    // Load the manage application users dashboard
    public function isolatedPersons()
    {
        return view('isolatedPersons');
    }

   
    // get all data in contact tracing users 
    public function isolatedPersonsDataApi(Request $request)
    {
        $model = isolatedPersons::query();

        return Datatables::of($model)->addIndexColumn()
            ->filter(function ($query) use ($request) {
                $query->where('upsa_id', "<>", "")
                ->whereNotNull('upsa_id')
                ->orderBy('reported_date','desc');
            })->make(true);
    }


}
