<?php

namespace App\Http\Controllers;

use App\BookingList;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;

class BookingListController extends Controller
{
    // Load the manage application users dashboard
    public function bookingList()
    {
        return view('bookingList');
    }

    // get all data in contact tracing users 
    public function bookingListDataApi(Request $request)
    {
        $model = BookingList::query();

        return Datatables::of($model)->addIndexColumn()
            ->filter(function ($query) use ($request) {
                $query->where('upsa_id', "<>", "")
                    ->whereNotNull('upsa_id')
                    ->orderBy('booked_date', 'desc');
            })->make(true);
    }

    public function updateBookingInfoApi(Request $request)
    {

        // Get variables from session
        $session_email = Session::get('email');

        // Set form process status here 

        $requesterForm =  BookingList::where("id", $request->get('requestId'))->first();

        //set values into db
        $requesterForm->visited_status =  $request->get('visitedStatus');
        $requesterForm->visited_date =  Carbon::parse($request->get('visitedDate'))->utc();
        $requesterForm->visit_confirmed_by =  $session_email;

        $saveResults = 0;
        DB::beginTransaction();
        $saveResults = $requesterForm->save();
        DB::commit();

        if ($saveResults) {
            $response_code = Response::HTTP_OK;
            $response_message = "User's visit was confirmed successfully";
        } else {
            $response_code = Response::HTTP_SERVICE_UNAVAILABLE;
            $response_message = "Error.Unable to confirm this visit";
            DB::rollBack();
        }
        return response()->json(["RESPONSE_MESSAGE" => $response_message, "RESPONSE_DATA" => $requesterForm, "RESPONSE_CODE" => $response_code]);
    }

    public function updateTestResultInfoApi(Request $request)
    {

        // Get variables from session
        $session_email = Session::get('email');

        // Set form process status here 

        $requesterForm =  BookingList::where("id", $request->get('requestId'))->first();

        //set values into db
        $requesterForm->test_result_status =  $request->get('status');
        $requesterForm->test_result_date =  Carbon::parse($request->get('date'))->utc();
        $requesterForm->result_confirmed_by =  $session_email;

        $saveResults = 0;
        DB::beginTransaction();
        $saveResults = $requesterForm->save();
        DB::commit();

        if ($saveResults) {
            $response_code = Response::HTTP_OK;
            $response_message = "User's test result was confirmed successfully";
        } else {
            $response_code = Response::HTTP_SERVICE_UNAVAILABLE;
            $response_message = "Error.Unable to confirm this test result";
            DB::rollBack();
        }
        return response()->json(["RESPONSE_MESSAGE" => $response_message, "RESPONSE_DATA" => $requesterForm, "RESPONSE_CODE" => $response_code]);
    }
}
