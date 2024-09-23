@extends('layouts.app', ['activePage' => 'patients', 'title' => 'Edit Patient', 'navName' => 'Patients', 'activeButton' => 'laravel'])

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Edit Patient</h3>
        <a href="{{ route('patients.index') }}" class="btn btn-secondary">Back to Patients List</a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <!-- Form to edit patient details -->
            <form action="{{ route('patients.update', $patient->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Patient's Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $patient->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" name="age" class="form-control @error('age') is-invalid @enderror" id="age" value="{{ old('age', $patient->age) }}" required>
                    @error('age')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select name="gender" class="form-control @error('gender') is-invalid @enderror" id="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male" {{ old('gender', $patient->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender', $patient->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="contact_info" class="form-label">Contact Information</label>
                    <input type="text" name="contact_info" class="form-control @error('contact_info') is-invalid @enderror" id="contact_info" value="{{ old('contact_info', $patient->contact_info) }}" required>
                    @error('contact_info')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Patient</button>
            </form>
        </div>
    </div>
</div>
@endsection
