@extends('layouts.app', ['activePage' => 'patients', 'title' => 'patients list', 'navName' => 'Patients', 'activeButton' => 'laravel'])


@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Patients</h3>
        <a href="{{ route('patients.create') }}" class="btn btn-primary">Add +</a>
    </div>

    <!-- Search Form -->
    <form action="{{ route('patients.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by patient name or contact" value="{{ request()->query('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </div>
    </form>

    <!-- Patients Table -->
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Contact Info</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($patients as $patient)
                        <tr>
                            <td>{{ $patient->id }}</td>
                            <td>{{ $patient->name }}</td>
                            <td>{{ $patient->age }}</td>
                            <td>{{ $patient->gender }}</td>
                            <td>{{ $patient->contact_info }}</td>
                            <td>
                                <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-sm btn-warning me-2">Edit</a>
                                <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No patients found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3 d-flex justify-content-end">
        {{ $patients->links() }}
    </div>
</div>
@endsection
