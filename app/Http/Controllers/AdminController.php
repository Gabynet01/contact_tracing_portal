<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\SpecialUsers;

class AdminController extends Controller
{

    public function index(Request $request)
    {
        return view('isolatedPersons');
    }

    // unauthorised error 404 page
    public function unauthorisedPage()
    {
        return view('error.404');
    }

    // unsupported page
    public function unsupportedPage()
    {
        return view('error.unsupported');
    }

    public function indexPage(Request $request)
    {
        return view("pages.admins.index");
    }

    public function unsupported()
    {
        return view('errors.unsuported');
    }

    public function dashboard()
    {
        return redirect()->action('AdminController@db_login', ['userEmail' => Session::get('email')]);
    }

    //Logout
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login');
    }

    // Login
    public function login(Request $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');
        $loginResp =  $this->db_login($username, $password);

        $responseObj = [];
        $responseObj['RESPONSE_CODE'] = $loginResp['RESPONSE_CODE'];
        $responseObj['RESPONSE_MESSAGE'] = $loginResp['RESPONSE_MESSAGE'];


        if ($loginResp['RESPONSE_CODE'] == Response::HTTP_OK) {
            $this->reg_user_session($loginResp['RESPONSE_DATA']);

            $responseObj['RESPONSE_EXTRA']['EMAIL'] = Session::get('email');
            $responseObj['RESPONSE_EXTRA']['FULLNAME'] = Session::get('full_name');
            $responseObj['RESPONSE_EXTRA']['APPROLE'] = Session::get('app_user_role');

            // This case handles special users
            $specialPersonAppRole = strtolower(Session::get('app_user_role'));
           

            if ($specialPersonAppRole !== "") {
            
                // This handles super admins
                if ($specialPersonAppRole === "super admin") {
                    Session::put('superAdmin', true);
                }
                // This handles only regular user
                if ($specialPersonAppRole === "regular user") {
                    Session::put('regularUser', true);
                }

                if ($specialPersonAppRole === "admin") {
                    Session::put('admin', true);
                }
            }
        }

        return response()->json($responseObj)->setStatusCode($loginResp['RESPONSE_CODE']);
    }

    // Assign Sessions
    private function reg_user_session($row)
    {
        if (count($row) > 0) {
            foreach ($row as $as) {

                Session::put('username', strtolower($as["username"]));
                Session::put('email', strtolower($as["email"]));
                Session::put('full_name', strtolower($as["full_name"]));
                Session::put('app_user_role', strtolower($as["app_user_role"]));
                Session::put('job_position', strtolower($as["job_position"]));
                
            }
        }
    }

    // System Login Check
    private function db_login($username, $password)
    {
        $user = SpecialUsers::where("username", $username)
                ->where("password", $password)
                ->get();

        if (!$user->isEmpty()) {
            $responseObj['RESPONSE_CODE'] = Response::HTTP_OK;
            $responseObj['RESPONSE_MESSAGE'] = "Login Successful";
            $responseObj['RESPONSE_DATA'] = $user;
        } else {
            session()->flush();
            $responseObj['RESPONSE_CODE'] = Response::HTTP_UNAUTHORIZED;
            $responseObj['RESPONSE_MESSAGE'] = "Invalid Username Or Password";
        }

        return $responseObj;
    }
}