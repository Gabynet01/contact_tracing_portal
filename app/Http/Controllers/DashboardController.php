<?php

namespace App\Http\Controllers;

use App\DispatchedItems;
use App\InventoryItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use App\InvoiceRequester;
use App\PickedUpItems;
use App\ThirdPartyItems;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{
    // Load the dashboard view
    public function index()
    {
        return view('dashboard');
    }
}
