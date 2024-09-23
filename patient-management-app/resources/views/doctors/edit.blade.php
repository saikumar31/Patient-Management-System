@extends('layouts.app', ['activePage' => 'doctors', 'title' => 'Edit Doctor', 'navName' => 'Doctors', 'activeButton' => 'laravel'])

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Edit Doctor</h3>
        <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Back to Doctors List</a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <!-- Form to edit doctor details -->
            <form action="{{ route('doctors.update', $doctor->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Doctor's Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $doctor->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="specialization" class="form-label">Specialization</label>
                    <input type="text" name="specialization" class="form-control @error('specialization') is-invalid @enderror" id="specialization" value="{{ old('specialization', $doctor->specialization) }}" required>
                    @error('specialization')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="contact_info" class="form-label">Contact Information</label>
                    <input type="text" name="contact_info" class="form-control @error('contact_info') is-invalid @enderror" id="contact_info" value="{{ old('contact_info', $doctor->contact_info) }}" required>
                    @error('contact_info')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Doctor</button>
            </form>
        </div>
    </div>
</div>
@endsection
