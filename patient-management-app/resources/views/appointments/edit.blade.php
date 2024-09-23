@extends('layouts.app', ['activePage' => 'appointments', 'title' => 'Appointments List', 'navName' => 'Appointments', 'activeButton' => 'laravel'])


@section('content')
<div class="container">
    <h3>Edit Appointment</h3>

    <!-- Display any validation errors or conflict errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Edit Appointment Form -->
    <form id="edit-appointment-form" action="{{ route('appointments.update', $appointment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Doctor Selection -->
        <div class="mb-3">
            <label for="doctor_id" class="form-label">Doctor</label>
            <select name="doctor_id" id="doctor_id" class="form-control" required>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}" {{ $appointment->doctor_id == $doctor->id ? 'selected' : '' }}>
                        {{ $doctor->name }} ({{ $doctor->specialization }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Date Selection -->
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="date" class="form-control" id="date" value="{{ $appointment->date }}" required>
        </div>

        <!-- Time Slot Selection (Dropdown) -->
    <!-- Time Slot Selection (Dropdown) -->
    <div class="mb-3">
        <label for="time" class="form-label">Time Slot</label>
        <select name="time" id="time" class="form-control" required>
            @php
                $allSlots = ['10:00 AM', '12:00 PM', '2:00 PM', '4:00 PM', '6:00 PM', '10:00 PM'];
                // Convert the current appointment time to a 12-hour format
                $currentTime = \Carbon\Carbon::createFromFormat('H:i:s', $appointment->time)->format('g:i A');
            @endphp
            @foreach($allSlots as $slot)
                <!-- Convert the time slot to H:i:s format for submission -->
                <option value="{{ \Carbon\Carbon::createFromFormat('g:i A', $slot)->format('H:i:s') }}" 
                    {{ $currentTime == $slot ? 'selected' : '' }}>
                    {{ $slot }}
                </option>
            @endforeach
        </select>
    </div>


        <button type="submit" class="btn btn-primary" id="update-button">Save Changes</button>
        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<!-- Custom script to disable update button -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('edit-appointment-form');
        const updateButton = document.getElementById('update-button');

        const initialDoctor = document.getElementById('doctor_id').value;
        const initialDate = document.getElementById('date').value;
        const initialTime = document.getElementById('time').value;

        // Disable the update button initially
        updateButton.disabled = true;

        form.addEventListener('input', function() {
            const currentDoctor = document.getElementById('doctor_id').value;
            const currentDate = document.getElementById('date').value;
            const currentTime = document.getElementById('time').value;

            // Enable the update button only if the values have changed
            if (currentDoctor !== initialDoctor || currentDate !== initialDate || currentTime !== initialTime) {
                updateButton.disabled = false;
            } else {
                updateButton.disabled = true;
            }
        });
    });
</script>
@endsection
