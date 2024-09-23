<?php
namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class PatientController extends Controller
{
    /**
     * listing data.
     */
    public function index()
    {
        $patients = Patient::paginate(10);
        return view('patients.index', compact('patients'));
    }

    /**
     * form for a new resource.
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'gender' => 'required|string|in:Male,Female,Other',
            'contact_info' => 'required|string|unique:patients|digits:10',
        ]);

        Patient::create($validated);
        return redirect()->route('patients.index')->with('success', 'Patient created successfully.'); // Redirect to index with success message
    }

    /**
     * Display the single resource.
     */
    public function show(string $id)
    {
        try {
            $patient = Patient::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Log::error('Invalid patient ID accessed.', ['patient_id' => $id]);
            return back()->withErrors(['error' => 'Patient not found.']);
        }

        return view('patients.show', compact('patient'));
    }

    /**
     * Show the form for editing.
     */
    public function edit(string $id)
    {
        $patient = Patient::findOrFail($id);
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $patient = Patient::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'gender' => 'required|string|in:Male,Female,Other',
            'contact_info' => 'required|string|max:255|unique:patients,contact_info,' . $patient->id,
        ]);

        $patient->update($validated);
        return redirect()->route('patients.index')->with('success', 'Patient updated successfully.'); // Redirect to index with success message
    }

    /**
     * Removing resource from storage.
     */
    public function destroy(string $id)
    {
        Patient::destroy($id);
        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully.'); // Redirect to index with success message
    }
}
