@extends('layouts.admin.master')

@section('title', 'My Profile')

@section('content')
<div class="dashboard-main-body">
    <div class="breadcrumb d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <div class="">
            <h1 class="fw-semibold mb-4 h6 text-primary-light">My Profile</h1>
            <div class="">
                <a href="/" class="text-secondary-light hover-text-primary hover-underline">Dashboard </a>
                <span class="text-secondary-light">/ My Profile</span>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-24">
        @csrf
        <div class="row gy-3">
            <!-- Profile Info -->
            <div class="col-lg-12">
                <div class="shadow-1 radius-12 bg-base h-100 overflow-hidden">
                    <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center justify-content-between">
                        <h6 class="text-lg fw-semibold mb-0">Profile Information</h6>
                    </div>
                    <div class="card-body p-20">
                        <div class="row gy-3">
                            <!-- Profile Picture -->
                            <div class="col-12 text-center mb-4">
                                <div class="d-flex flex-column align-items-center">
                                    @if(auth()->user()->profile_picture)
                                        <img src="{{ auth()->user()->profile_picture_url ?: asset('storage/' . auth()->user()->profile_picture) }}" alt="{{ auth()->user()->name }}" class="w-120-px h-120-px object-fit-cover rounded-circle mb-3 border border-3 border-primary">
                                        <div class="d-flex gap-2">
                                            <label for="profile_picture" class="btn btn-primary-600 btn-sm">
                                                <i class="ri-camera-line"></i> Change Photo
                                            </label>
                                            <button type="button" class="btn btn-danger-600 btn-sm" onclick="removeProfilePicture()">
                                                <i class="ri-delete-bin-line"></i> Remove
                                            </button>
                                        </div>
                                    @else
                                        <div class="w-120-px h-120-px bg-primary text-white rounded-circle d-flex justify-content-center align-items-center fw-bold mb-3 border border-3 border-primary" style="font-size: 3rem;">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        </div>
                                        <label for="profile_picture" class="btn btn-primary-600 btn-sm">
                                            <i class="ri-camera-line"></i> Change Photo
                                        </label>
                                    @endif
                                    <input type="file" name="profile_picture" id="profile_picture" class="d-none" accept="image/*">
                                </div>
                            </div>
                            
                            <!-- Name (Read Only) -->
                            <div class="col-md-6">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Name</label>
                                <div class="form-control bg-neutral-50">
                                    {{ auth()->user()->name }}
                                </div>
                            </div>
                            
                            <!-- Email (Read Only) -->
                            <div class="col-md-6">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Email</label>
                                <div class="form-control bg-neutral-50">
                                    {{ auth()->user()->email }}
                                </div>
                            </div>
                            
                            <!-- Change Password -->
                            <div class="col-md-6">
                                <label for="current_password" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Current Password</label>
                                <input type="password" name="current_password" class="form-control" id="current_password">
                                @error('current_password')
                                    <div class="text-danger-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="new_password" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">New Password</label>
                                <input type="password" name="new_password" class="form-control" id="new_password">
                                @error('new_password')
                                    <div class="text-danger-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="new_password_confirmation" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation">
                            </div>
                            
                            <!-- Role (Read Only) -->
                            <div class="col-md-6">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Role</label>
                                <div class="form-control bg-neutral-50">
                                    <span class="badge bg-primary">{{ auth()->user()->role ? auth()->user()->role->name : 'No Role' }}</span>
                                </div>
                            </div>
                            
                            <!-- Member Since -->
                            <div class="col-md-6">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Member Since</label>
                                <div class="form-control bg-neutral-50">
                                    {{ auth()->user()->created_at->format('M d, Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="col-lg-12">
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <button type="button" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8" onclick="window.history.back()">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary-600 text-md px-56 py-12 radius-8">
                        Update Profile
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.getElementById('profile_picture').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.querySelector('img[alt="{{ auth()->user()->name }}"]');
            const div = document.querySelector('.w-120-px.h-120-px.bg-primary');
            
            if (img) {
                img.src = e.target.result;
            } else if (div) {
                div.outerHTML = `<img src="${e.target.result}" alt="{{ auth()->user()->name }}" class="w-120-px h-120-px object-fit-cover rounded-circle mb-3 border border-3 border-primary">`;
            }
        };
        reader.readAsDataURL(file);
    }
});

function removeProfilePicture() {
    if (confirm('Are you sure you want to remove your profile picture?')) {
        fetch('/profile/picture', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    }
}
</script>
@endsection