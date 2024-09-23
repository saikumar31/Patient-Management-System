<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['patient', 'doctor'])->paginate(10); // 10 items per page
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $doctors = Doctor::all();
        return view('appointments.create', compact('doctors'));
    }

    public function searchDoctor(Request $request)
    {
        $query = $request->get('query');
        $doctors = Doctor::where('name', 'LIKE', "%{$query}%")->get();
    
        $output = '';
        if ($doctors->count()) {
            foreach ($doctors as $doctor) {
                $output .= '<a href="#" class="dropdown-item" data-id="' . $doctor->id . '">' . $doctor->name . '</a>';
            }
        } else {
            $output .= '<a href="#" class="dropdown-item disabled">No doctors found</a>';
        }
    
        return response()->json($output);
    }
    
    

    public function getDoctorDetails($doctorId, Request $request)
    {
        $date = $request->get('date'); // Get the selected date
        $doctor = Doctor::findOrFail($doctorId);
    
        // Define available time slots
        $allSlots = ['10am', '12pm', '2pm', '4pm', '6pm', '10pm'];
    
        // Fetch booked time slots for this doctor on the selected date
        $bookedSlots = Appointment::where('doctor_id', $doctorId)
                                    ->where('date', $date)
                                    ->pluck('time')
                                    ->toArray();
    
        // Send back the response
        return response()->json([
            'doctor' => $doctor,
            'booked_slots' => $bookedSlots // List of booked time slots
        ]);
    }    

    // AJAX: Fetch patient by phone number
    public function getPatientByPhone($phone)
    {
        $patient = Patient::where('contact_info', $phone)->first();
        return response()->json($patient);
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'time_slot' => 'required|string', // Assuming this is in '2pm' format
            'patient_phone' => 'required|exists:patients,contact_info'
        ]);
    
        try {
            // Convert the 12-hour time (e.g., '2pm') to 24-hour time (e.g., '14:00:00')
            $time24Format = Carbon::createFromFormat('gA', $validatedData['time_slot'])->format('H:i:s');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid time format'], 400);
        }
    
        // Find the patient by phone number
        $patient = Patient::where('contact_info', $validatedData['patient_phone'])->first();
    
        // Create the appointment
        Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $validatedData['doctor_id'],
            'date' => $validatedData['appointment_date'],
            'time' => $time24Format, // 24-hour format
            'status' => 'Booked'
        ]);
    
        return response()->json(['message' => 'Appointment successfully scheduled.']);
    }
    
    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);
        $doctors = Doctor::all();
    
        return view('appointments.edit', compact('appointment', 'doctors'));
    }
    
    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
    
        // Validate the form input
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i:s',
        ]);
    
        // Check if the doctor has another appointment at the same time and date
        $conflict = Appointment::where('doctor_id', $request->input('doctor_id'))
                    ->where('date', $request->input('date'))
                    ->where('time', $request->input('time'))
                    ->where('id', '!=', $appointment->id) // Exclude the current appointment
                    ->exists();
    
        if ($conflict) {
            return back()->withErrors(['conflict' => 'Another appointment is booked for this doctor at the selected time. Please select a different time or doctor.']);
        }
    
        // Update if no conflict exists
        $appointment->doctor_id = $request->input('doctor_id');
        $appointment->date = $request->input('date');
        $appointment->time = $request->input('time');
        $appointment->save();
        
        Log::info('Appointment updated.', ['appointment_id' => $appointment->id]);
        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully.');
    }
    
    


    public function updateStatus(Request $request, $id)
{
    $appointment = Appointment::findOrFail($id);
    // Validate the request
    $validatedData = $request->validate([
        'status' => 'required|in:Booked,Completed,Canceled',
    ]);

    $appointment->status = $validatedData['status'];
    $appointment->save();
    return redirect()->route('appointments.index')->with('success', 'Appointment status updated successfully.');
}

public function cancel($id)
{
    $appointment = Appointment::findOrFail($id);

    $appointment->status = 'Canceled';
    $appointment->save();

    Log::info('Appointment canceled.', ['appointment_id' => $appointment->id]);
    return redirect()->route('appointments.index')->with('success', 'Appointment cancelled successfully.');
}

}
