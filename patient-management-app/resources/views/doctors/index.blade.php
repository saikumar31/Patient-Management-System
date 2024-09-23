@extends('layouts.app', ['activePage' => 'doctors', 'title' => 'Doctors List', 'navName' => 'Doctors', 'activeButton' => 'laravel'])

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Doctors</h3>
        <a href="{{ route('doctors.create') }}" class="btn btn-primary">Add +</a>
    </div>

    <!-- Search Form -->
    <form action="{{ route('doctors.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by doctor name or specialization" value="{{ request()->query('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </div>
    </form>

    <!-- Doctors Table -->
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Specialization</th>
                        <th>Contact Info</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($doctors as $doctor)
                        <tr>
                            <td>{{ $doctor->id }}</td>
                            <td>{{ $doctor->name }}</td>
                            <td>{{ $doctor->specialization }}</td>
                            <td>{{ $doctor->contact_info }}</td>
                            <td>
                                <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-sm btn-warning me-2">Edit</a>
                                <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No doctors found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3 d-flex justify-content-end">
        {{ $doctors->links() }}
    </div>
</div>
@endsection
