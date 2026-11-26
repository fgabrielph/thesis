<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Logs;

class LogsController extends Controller
{
    public function index()
    {
        $logs = Logs::all();

        return view('admin.logs.index')->with('logs', $logs);
    }
}
