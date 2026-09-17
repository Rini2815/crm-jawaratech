<?php

namespace App\Http\Controllers;

use App\Models\ServiceJob;
use Illuminate\Http\Request;

class ServiceJobController extends Controller
{
    public function index()
    {
        $serviceJobs = ServiceJob::latest()->get();
        return view('service-jobs.index', compact('serviceJobs'));
    }
}