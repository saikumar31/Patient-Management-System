<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::paginate(10);
        return view('doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the form view for creating a new doctor
        return view('doctors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'contact_info' => 'required|string|unique:doctors|digits:10',
        ]);

        Doctor::create($validatedData);
        return redirect()->route('doctors.index')->with('success', 'Doctor created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $doctor = Doctor::findOrFail($id);
        return view('doctors.edit', compact('doctor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validating the request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'contact_info' => 'required|string|max:255',
        ]);

        $doctor = Doctor::findOrFail($id);
        $doctor->update($validatedData);

        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Doctor::destroy($id);
        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully.');
    }
}
