<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityController extends Controller
{
    public function index()
    {
        // $logs = Activity::latest('id')->get();
        $logs = Activity::latest('id')->paginate(100);

        return view('logs/index', compact('logs'));
    }

    public function logsByName($name)
    {
        // $logs = Activity::where('log_name', $name)->latest('id')->get();
        $logs = Activity::where('log_name', $name)->latest('id')->paginate(100);

        return view('logs/index', compact('logs'));
    }

    public function deleteAll()
    {
        $this->authorize('deleteAll', 'App\Activity');

        Activity::all()->each(function($row) {
            $row->delete();
        });

        return redirect('logs')->with('success', 'Successfully deleted!');
    }
}
