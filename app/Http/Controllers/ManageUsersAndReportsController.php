<?php

namespace App\Http\Controllers;

use App\Articles;
use App\FormRequester;
use App\MobileAppUsers;
use App\SpecialUsers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Notifier;
use App\Testimonials;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;

class ManageUsersAndReportsController extends Controller
{
    // Load the manage application users dashboard
    public function manageApplicationUsers()
    {
        return view('manageAppUsers');
    }

    public function manageMobileAppUsers()
    {
        return view('manageMobileAppUsers');
    }

    public function addAdminUserApi(Request $request)
    {

        // Get variables from session
        $session_email = Session::get('username');

        $creatorForm = new SpecialUsers();

        $creatorForm->app_user_id =  $request->get('app_user_id');
        $creatorForm->username =  $request->get('username');
        $creatorForm->password =  $request->get('password');
        $creatorForm->full_name =  $request->get('full_name');
        $creatorForm->email =  $request->get('email');
        $creatorForm->job_position =  $request->get('job_position');
        $creatorForm->app_user_role =  $request->get('app_user_role');
        $creatorForm->created_by =  $session_email;


        $saveResults = 0;
        DB::beginTransaction();
        $saveResults = $creatorForm->save();
        DB::commit();

        if ($saveResults) {
            $response_code = Response::HTTP_OK;
            $response_message = "User was created successfully.";

        } else {
            $response_code = Response::HTTP_SERVICE_UNAVAILABLE;
            $response_message = "Error.Unable to save";
            DB::rollBack();
        }
        return response()->json(["RESPONSE_MESSAGE" => $response_message, "RESPONSE_DATA" => $creatorForm, "RESPONSE_CODE" => $response_code]);
    }

    // Edit user data
    public function editAdminUserApi(Request $request)
    {

        // Get variables from session
        $session_email = Session::get('email');

        // Set form process status here 

        $requesterForm =  SpecialUsers::where("app_user_id", $request->get('app_user_id'))->first();

        //set values into db
        $requesterForm->full_name =  $request->get('fullName');
        $requesterForm->created_by =  $session_email;

        $saveResults = 0;
        DB::beginTransaction();
        $saveResults = $requesterForm->save();
        DB::commit();

        if ($saveResults) {
            $response_code = Response::HTTP_OK;
            $response_message = "User was edited successfully";
        } else {
            $response_code = Response::HTTP_SERVICE_UNAVAILABLE;
            $response_message = "Error.Unable to save";
            DB::rollBack();
        }
        return response()->json(["RESPONSE_MESSAGE" => $response_message, "RESPONSE_DATA" => $requesterForm, "RESPONSE_CODE" => $response_code]);
    }


    // Delete user data
    public function deleteAdminUserApi(Request $request)
    {
        // delete user here 

        $requesterForm =  SpecialUsers::where("app_user_id", $request->get('app_user_id'))->first();

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
    public function getAdminUsersData(Request $request)
    {
        $model = SpecialUsers::query();

        return Datatables::of($model)->addIndexColumn()
            ->filter(function ($query) use ($request) {

                $query->where('username', "<>", "")
                ->whereNotNull('username')
                ->orderBy('created_at','desc');
            })->make(true);
    }

    // get all data in app users 
    public function getMobileAppUsersDataApi(Request $request)
    {
        $model = MobileAppUsers::query();

        return Datatables::of($model)->addIndexColumn()
            ->filter(function ($query) use ($request) {

                $query->where('upsa_id', "<>", "")
                ->whereNotNull('upsa_id')
                ->orderBy('registered_date','desc');
            })->make(true);
    }


    // Delete global data
    public function deleteGlobalApi(Request $request)
    {
        // delete articles
        if ($request->get('deleteType') == "article") {
            $requesterForm = SpecialUsers::where("app_user_id", $request->get('deleteId'))->first();
            $message = "User was deleted successfully";
        }
    
        $saveResults = 0;

        DB::beginTransaction();
        $saveResults = $requesterForm->delete();
        DB::commit();

        if ($saveResults) {
            $response_code = Response::HTTP_OK;
            $response_message = $message;
        } else {
            $response_code = Response::HTTP_SERVICE_UNAVAILABLE;
            $response_message = "Error.Unable to delete";
            DB::rollBack();
        }
        return response()->json(["RESPONSE_MESSAGE" => $response_message, "RESPONSE_DATA" => $requesterForm, "RESPONSE_CODE" => $response_code]);
    }
}
