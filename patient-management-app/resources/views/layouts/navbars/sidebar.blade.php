<div class="sidebar" data-image="{{ asset('light-bootstrap/img/sidebar-5.jpg') }}">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="http://www.yourwebsite.com" class="simple-text">
                {{ __("Your Clinic") }}
            </a>
        </div>
        <ul class="nav">
            <li class="nav-item @if($activePage == 'dashboard') active @endif">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="nc-icon nc-chart-pie-35"></i>
                    <p>{{ __("Dashboard") }}</p>
                </a>
            </li>

            <li class="nav-item @if($activePage == 'doctors') active @endif">
                <a class="nav-link" href="{{ route('doctors.index') }}">
                    <i class="nc-icon nc-single-02"></i>
                    <p>{{ __("Doctors") }}</p>
                </a>
            </li>

            <li class="nav-item @if($activePage == 'patients') active @endif">
                <a class="nav-link" href="{{ route('patients.index') }}">
                    <i class="nc-icon nc-circle-09"></i>
                    <p>{{ __("Patients") }}</p>
                </a>
            </li>

            <li class="nav-item @if($activePage == 'appointments') active @endif">
                <a class="nav-link" href="{{ route('appointments.index') }}">
                    <i class="nc-icon nc-notes"></i>
                    <p>{{ __("Appointments") }}</p>
                </a>
            </li>
        </ul>
    </div>
</div>
