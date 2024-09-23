@extends('layouts.app', ['activePage' => 'appointments', 'title' => 'Schedule Appointment', 'navName' => 'Appointments', 'activeButton' => 'laravel'])

@section('content')
<div class="container-fluid">
    <!-- Row for Doctor and Patient Sections -->
    <div class="row align-items-start">
        <!-- Left side: Doctor profile, available slots -->
        <div class="col-md-6">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">Schedule an Appointment</h3>
                <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Back to Appointments List</a>
            </div>

            <!-- Doctor Profile -->
            <div class="card shadow">
                <div class="card-body">
                    <form id="appointmentForm">
                        <!-- Select Date -->
                        <div class="mb-3">
                            <label for="appointment_date" class="form-label">Select Appointment Date</label>
                            <input type="date" name="appointment_date" class="form-control" id="appointment_date" 
                                   min="{{ \Carbon\Carbon::today()->toDateString() }}" 
                                   max="{{ \Carbon\Carbon::today()->addDays(10)->toDateString() }}" required>
                        </div>

                        <!-- Select Doctor -->
                        <div class="mb-3">
                            <label for="doctor_search" class="form-label">Search Doctor</label>
                            <select class="form-control" id="doctor_search" name="doctor_id">
                                <option value="">Select a doctor...</option>
                                @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Doctor Details Card -->
                        <div id="doctor_details" class="card mt-4" style="display: none;">
                            <div class="card-body">
                                <h4 class="card-title fw-bold highlight-name">Name: <span id="doctor_name"></span></h4>
                                <p class="card-text">specialization: <span id="doctor_specialization"></span></p>
                                <p class="card-text">Contact: <span id="doctor_contact"></span></p>
                            </div>
                        </div>

                        <!-- Available Time Slots -->
                        <div id="time_slots" style="display: none;" class="mt-3">
                            <label for="time_slot" class="form-label">Available Time Slots</label>
                            <div id="available_slots">
                                <!-- Time slots will be populated here by JavaScript -->
                            </div>
                        </div>

                        <!-- Hidden input to store the selected time slot -->
                        <input type="hidden" name="selected_time_slot" id="selected_time_slot" required>

                        <!-- Continue Button -->
                        <button type="button" class="btn btn-primary mt-3" id="continueButton">Continue with Appointment Booking</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right side: Patient profile -->
        <div class="col-md-6">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">Confirm Patient's Details</h3>
            </div>
            <div id="patientSection" class="card shadow" style="display: none;">
                <div class="card-body">
                    <!-- Patient Phone Number -->
                    <div class="mb-3">
                        <label for="patient_phone" class="form-label">Enter Patient's Mobile Number</label>
                        <input type="text" name="patient_phone" class="form-control" id="patient_phone" placeholder="Enter mobile number" autocomplete="off">
                    </div>

                    <!-- Fetch Patient Button -->
                    <button type="button" class="btn btn-info" id="fetchPatientButton">Fetch Patient</button>

                    <!-- Patient Details Card -->
                    <div id="patient_details" class="card mt-4" style="display: none;">
                        <div class="card-body">
                            <h4 class="card-title fw-bold">Name: <span id="patient_name"></span></h4>
                            <p class="card-text">Phone: <span id="patient_phone_display"></span></p>
                            <p class="card-text">Age: <span id="patient_age"></span></p>
                            <p class="card-text">Gender: <span id="patient_gender"></span></p>
                        </div>
                    </div>


                    <!-- Confirm Scheduling Button -->
                    <button type="button" class="btn btn-success mt-4" id="confirmSchedulingButton" style="display: none;">Confirm Scheduling</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('styles')
<style>
.selected-slot {
    background-color: #007bff !important; /* Blue background to indicate selection */
    color: white !important;
}

.disabled-slot {
    opacity: 1; /* Override opacity if needed */
    color: #fff; /* Set text color */
    background-color: #6c757d; /* Keep background color consistent */
    pointer-events: none; /* Prevent interaction */
}

</style>
@endpush

@endsection

@push('scripts')
<script>
        $(document).ready(function() {
        // Initialize Select2 with preloaded doctor list
        $('#doctor_search').select2({
            placeholder: 'Start typing to search for a doctor...',
            allowClear: true
        });

        // Handle doctor selection (unchanged)
    $('#doctor_search').on('select2:select', function(e) {
        var doctorId = e.params.data.id;
        var selectedDate = $('#appointment_date').val();

        if (doctorId && selectedDate) {
            // Fetch doctor details and time slots via AJAX
            $.ajax({
                url: `/doctor-details/${doctorId}`,
                type: 'GET',
                data: { date: selectedDate },
                success: function(data) {
                    $('#doctor_name').text(data.doctor.name);
                    $('#doctor_specialization').text(data.doctor.specialization);
                    $('#doctor_contact').text(data.doctor.contact_info);
                    $('#doctor_details').show();

                    let timeSlotsHtml = '';
                    let allSlots = ['10:00 AM', '12:00 PM', '2:00 PM', '4:00 PM', '6:00 PM', '10:00 PM'];

                    allSlots.forEach(function(slot) {
                        // Convert the slot to 24-hour format to match the booked slots
                        var slotIn24Hr = moment(slot, 'h:mm A').format('HH:mm:ss');

                        if (data.booked_slots.includes(slotIn24Hr)) {
                            // Booked slots (disabled)
                            timeSlotsHtml += `<button class="btn btn-secondary m-1 disabled-slot" readonly>${slot}</button>`;
                        } else {
                            // Available slots (clickable)
                            timeSlotsHtml += `<button type="button" class="btn btn-primary m-1 time-slot" data-slot="${slot}">${slot}</button>`;
                        }
                    });

                    // Show the time slots
                    $('#time_slots').html(timeSlotsHtml).show();

                    // Handle time slot selection
                    $('.time-slot').on('click', function() {
                        $('.time-slot').removeClass('selected-slot');
                        $(this).addClass('selected-slot');
                        var selectedSlot = $(this).data('slot');
                        $('#selected_time_slot').val(selectedSlot);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching doctor details:', error);
                }
            });
        }
    });

        // Show patient section on continue (unchanged)
        $('#continueButton').on('click', function() {
            var selectedSlot = $('#selected_time_slot').val();
            if (selectedSlot) {
                $('#patientSection').show();
            } else {
                alert('Please select a time slot before continuing.');
            }
        });

        // Fetch patient details and display them
        $('#fetchPatientButton').on('click', function() {
            var patientPhone = $('#patient_phone').val();
            
            $.ajax({
                url: `/patient/${patientPhone}`, // Corrected API endpoint
                type: 'GET',
                success: function(data) {
                    console.log('Patient Data:', data);  // Debugging to ensure correct data structure

                    // Assuming the data contains the patient's name, phone, age, and gender
                    if (data.name && data.contact_info && data.age && data.gender) {
                        $('#patient_name').text(data.name);
                        $('#patient_phone_display').text(data.contact_info);
                        $('#patient_age').text(data.age);
                        $('#patient_gender').text(data.gender);
                        
                        // Show patient details and confirm button
                        $('#patient_details').show();
                        $('#confirmSchedulingButton').show();
                    } else {
                        alert('Missing patient details. Check the data format.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching patient details:', error);
                    alert('Patient not found');
                }
            });
        });


        // Confirm scheduling (unchanged)
        $('#confirmSchedulingButton').on('click', function() {
            // Gather all the necessary data
            var doctorId = $('#doctor_search').val();
            var patientPhone = $('#patient_phone').val();
            var appointmentDate = $('#appointment_date').val();
            var timeSlot = $('#selected_time_slot').val();

            if (doctorId && patientPhone && appointmentDate && timeSlot) {
                // Send the data via AJAX to the resourceful store route
                $.ajax({
                    url: '{{ route("appointments.store") }}', // Resourceful store route
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // Laravel CSRF token
                        doctor_id: doctorId,
                        patient_phone: patientPhone,
                        appointment_date: appointmentDate,
                        time_slot: timeSlot
                    },
                    success: function(response) {
                        alert(response.message); // Show success message
                        window.location.href = "{{ route('appointments.index') }}"; // Redirect to the appointment list
                    },
                    error: function(xhr, status, error) {
                        console.error('Error storing appointment:', error);
                        alert('Failed to schedule the appointment. Please try again.');
                    }
                });
            } else {
                alert('Please make sure all fields are filled in before confirming the appointment.');
            }
        });
    });
</script>
@endpush
