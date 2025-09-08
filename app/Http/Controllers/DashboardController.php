<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Queue;
use App\Models\Information;


class DashboardController extends Controller
{

    public function index()
    {
        $latestInfo = Information::orderBy('created_at', 'desc')->take(5)->get();

        $queues = Queue::all();

        return view('dashboard', compact('latestInfo', 'queues'));
    }


}
