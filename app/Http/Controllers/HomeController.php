<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {

        $invoices = invoices::all();

        $dataChart = [
            invoices::where('Value_Status', '3')->count(),
            invoices::where('Value_Status', '2')->count(),
            invoices::where('Value_Status', '1')->count(),
            ];

        return view('Invoices.index', compact('invoices','dataChart'));

    }
}
