@extends('layouts.app', ['activePage' => 'dashboard', 'title' => 'dashboard list', 'navName' => 'Dashboard', 'activeButton' => 'laravel'])

@section('content')
<div class="container">
    <h3>Dashboard</h3>

    <!-- Chart for Total Doctors and Patients -->
    <div class="mb-4">
        <canvas id="doctorsPatientsChart" width="400" height="300"></canvas>
    </div>

    <!-- Pie Chart for Appointments by Status -->
    <div>
        <canvas id="appointmentsStatusChart" width="400" height="300"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    var doctorsPatientsData = {
        labels: ['Total Doctors', 'Total Patients'],
        datasets: [{
            label: 'Count',
            data: [{{ $totalDoctors }}, {{ $totalPatients }}], // Use data from the controller
            backgroundColor: ['#1f77b4', '#ff7f0e'],
            borderColor: ['#1f77b4', '#ff7f0e'],
            borderWidth: 1
        }]
    };

    var doctorsPatientsCtx = document.getElementById('doctorsPatientsChart').getContext('2d');
    var doctorsPatientsChart = new Chart(doctorsPatientsCtx, {
        type: 'bar',
        data: doctorsPatientsData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var appointmentsStatusData = {
        labels: ['Booked', 'Completed', 'Canceled'],
        datasets: [{
            label: 'Appointments by Status',
            data: [{{ $bookedCount }}, {{ $completedCount }}, {{ $canceledCount }}], // Use data from the controller
            backgroundColor: ['#1f77b4', '#2ca02c', '#d62728'],
            hoverOffset: 4
        }]
    };

    var appointmentsStatusCtx = document.getElementById('appointmentsStatusChart').getContext('2d');
    var appointmentsStatusChart = new Chart(appointmentsStatusCtx, {
        type: 'pie',
        data: appointmentsStatusData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });
</script>
@endsection
