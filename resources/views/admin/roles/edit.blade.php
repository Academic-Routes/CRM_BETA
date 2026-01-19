@extends('layouts.admin.master')

@section('title', 'Edit Role')

@section('content')
<div class="dashboard-body">
    <div class="card">
        <div class="card-header">
            <h5>Edit Role</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('roles.update', $role) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Role Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Update Role</button>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection