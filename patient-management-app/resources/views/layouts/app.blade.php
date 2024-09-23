<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Management System</title>
    
    <!-- Custom theme CSS (Light Bootstrap Dashboard) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('light-bootstrap/css/light-bootstrap-dashboard.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Add Bootstrap Datepicker CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <!-- Additional styles from child views -->
    @stack('styles')
    <style>
        body, html {
            height: 100%;
        }

        .wrapper {
            display: flex;
            height: 100vh;
            flex-direction: column;
        }

        .content {
            display: flex;
            flex: 1;
            overflow: hidden;
        }

        .sidebar {
            width: 250px;
            background-color: #f8f9fa;
            min-height: 100vh; 
        }

        .main-panel {
            flex: 1;
            padding: 70px;
            overflow-y: auto;
        }

       /* Footer stays at the bottom and spans the full width */
        .footer {
            width: calc(100% - 250px); 
            margin-left: 150px;
            background-color: #f8f9fa;
            padding: 10px;
            text-align: center;
            position: relative;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="content">
            <!-- Sidebar -->
            @include('layouts.navbars.sidebar')
            @include('layouts.navbars.header')

            <!-- Main Content -->
            <div class="main-panel">
                @yield('content')
            </div>
        </div>

        <!-- Footer -->
        @include('layouts.navbars.footer')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    @stack('scripts')

</body>
</html>
