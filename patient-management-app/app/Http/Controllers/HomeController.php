<?php

namespace App\Http\Controllers;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


    public function dashboard()
{
        // Fetch the data from your database (replace with actual query logic)
        $totalDoctors = Doctor::count();
        $totalPatients = Patient::count();
        
        $bookedCount = Appointment::where('status', 'Booked')->count();
        $completedCount = Appointment::where('status', 'Completed')->count();
        $canceledCount = Appointment::where('status', 'Canceled')->count();

        return view('dashboard', compact('totalDoctors', 'totalPatients', 'bookedCount', 'completedCount', 'canceledCount'));
}

}
