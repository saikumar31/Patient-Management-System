@extends('layouts.app', ['activePage' => 'appointments', 'title' => 'Appointments List', 'navName' => 'Appointments', 'activeButton' => 'laravel'])

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Appointments</h3>
        <a href="{{ route('appointments.create') }}" class="btn btn-primary">Schedule Appointment</a>
    </div>

    <!-- Appointments Table -->
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Patient Name</th>
                        <th>Doctor Name</th>
                        <th>Date</th>
                        <th>Time Slot</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->id }}</td>
                            <td>{{ $appointment->patient->name }}</td>
                            <td>{{ $appointment->doctor->name }}</td>
                            <td>{{ $appointment->date }}</td>
                            <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $appointment->time)->format('g:i A') }}</td>
                            <td>
                                <span class="badge alert-{{ $appointment->status == 'Completed' ? 'success' : ($appointment->status == 'Canceled' ? 'danger' : 'primary') }}">
                                    {{ $appointment->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-sm btn-warning me-2 {{ $appointment->status != 'Booked' ? "disabled" : "" }}">Edit</a>
                            
                                <!-- Cancel Button triggers the modal -->
                                <button type="button" class="btn btn-sm btn-danger {{ $appointment->status == 'Canceled' ? "disabled" : "" }}" data-bs-toggle="modal" data-bs-target="#cancelModal{{ $appointment->id }}">
                                    Cancel
                                </button>
                            
                                <!-- Cancel Confirmation Modal -->
                                <div class="modal fade" id="cancelModal{{ $appointment->id }}" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel{{ $appointment->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="cancelModalLabel{{ $appointment->id }}">Confirm Cancellation</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to cancel this appointment?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                
                                                <!-- Form to cancel the appointment -->
                                                <form action="{{ route('appointments.cancel', $appointment->id) }}" method="POST">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="btn btn-danger">Yes, Cancel</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No appointments found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-3 d-flex justify-content-end">
        {{ $appointments->links() }} <!-- This will render the pagination links -->
    </div>
</div>

<style>
    .custom-badge {
        font-size: 1rem; /* Increase font size */
}
</style>
@endsection
