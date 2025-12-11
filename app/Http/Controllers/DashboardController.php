<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Queue;
use App\Models\Information;
use Carbon\Carbon;


class DashboardController extends Controller
{

    public function index()
    {
        $latestInfo = Information::orderBy('updated_at', 'desc')->take(5)->get();

        $today = Carbon::now('Asia/Jakarta')->toDateString();

        $queues = Queue::with('patient')
            ->whereDate('tanggal', $today)
            ->orderBy('created_at')
            ->get()
            ->values()
            ->map(function ($queue, $index) {
                $queue->display_no = $index + 1;
                return $queue;
            });

        return view('dashboard', compact('latestInfo', 'queues'));
    }


}
