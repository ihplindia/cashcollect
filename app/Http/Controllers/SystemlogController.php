<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SysetmLogs;

class SystemlogController extends Controller
{
    public function index()
    {
        $logs = SysetmLogs::orderBy('id','DESC')->get();
        return view('systemlogs.all',compact('logs'));
    }
}
