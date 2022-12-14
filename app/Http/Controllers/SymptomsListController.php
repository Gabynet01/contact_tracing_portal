<?php

namespace App\Http\Controllers;

use App\SymptomsList;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;

class SymptomsListController extends Controller
{
    // Load the manage application users dashboard
    public function symptomsList()
    {
        return view('symptomsList');
    }

    public function addSymptomApi(Request $request)
    {

        // Get variables from session
        $session_email = Session::get('username');

        $creatorForm = new SymptomsList();

        $creatorForm->label =  $request->get('label');
        $creatorForm->description =  $request->get('description');
        $creatorForm->created_by =  $session_email;


        $saveResults = 0;
        DB::beginTransaction();
        $saveResults = $creatorForm->save();
        DB::commit();

        if ($saveResults) {
            $response_code = Response::HTTP_OK;
            $response_message = "Symptom was created successfully.";
        } else {
            $response_code = Response::HTTP_SERVICE_UNAVAILABLE;
            $response_message = "Error.Unable to save";
            DB::rollBack();
        }
        return response()->json(["RESPONSE_MESSAGE" => $response_message, "RESPONSE_DATA" => $creatorForm, "RESPONSE_CODE" => $response_code]);
    }

    // Edit user data
    public function editSymptomApi(Request $request)
    {

        // Get variables from session
        $session_email = Session::get('email');

        // Set form process status here 

        $requesterForm =  SymptomsList::where("id", $request->get('requestId'))->first();

        //set values into db
        $requesterForm->label =  $request->get('label');
        $requesterForm->description =  $request->get('description');
        $requesterForm->created_by =  $session_email;

        $saveResults = 0;
        DB::beginTransaction();
        $saveResults = $requesterForm->save();
        DB::commit();

        if ($saveResults) {
            $response_code = Response::HTTP_OK;
            $response_message = "Symptom was edited successfully";
        } else {
            $response_code = Response::HTTP_SERVICE_UNAVAILABLE;
            $response_message = "Error.Unable to save";
            DB::rollBack();
        }
        return response()->json(["RESPONSE_MESSAGE" => $response_message, "RESPONSE_DATA" => $requesterForm, "RESPONSE_CODE" => $response_code]);
    }


    // Delete user data
    public function deleteSymptomApi(Request $request)
    {
        // delete user here 

        $requesterForm =  SymptomsList::where("id", $request->get('requestId'))->first();

        $saveResults = 0;
        DB::beginTransaction();
        $saveResults = $requesterForm->delete();
        DB::commit();

        if ($saveResults) {
            $response_code = Response::HTTP_OK;
            $response_message = "User was deleted successfully";
        } else {
            $response_code = Response::HTTP_SERVICE_UNAVAILABLE;
            $response_message = "Error.Unable to save";
            DB::rollBack();
        }
        return response()->json(["RESPONSE_MESSAGE" => $response_message, "RESPONSE_DATA" => $requesterForm, "RESPONSE_CODE" => $response_code]);
    }

    // get all data in users 
    public function getSymptomsListDataApi(Request $request)
    {
        $model = SymptomsList::query();

        return Datatables::of($model)->addIndexColumn()
            ->filter(function ($query) use ($request) {

                $query->where('label', "<>", "")
                    ->whereNotNull('label')
                    ->orderBy('created_at', 'desc');
            })->make(true);
    }
}
