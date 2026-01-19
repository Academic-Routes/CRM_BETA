@extends('layouts.admin.master')

@section('title', 'Roles')

@section('content')
<div class="dashboard-body">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Roles Management</h4>
        <button type="button" class="btn btn-primary my-sidebar-btn">Add Role</button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Join Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <button type="button" class="edit-sidebar-btn dropdown-item" data-id="{{ $role->id }}" data-name="{{ $role->name }}" data-date="{{ $role->created_at->format('Y-m-d') }}">
                                                <i class="ri-edit-2-line"></i> Edit
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-danger" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $role->id }}" data-name="{{ $role->name }}">
                                                <i class="ri-delete-bin-6-line"></i> Delete
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add sidebar -->
<div class="my-sidebar bg-white position-fixed end-0 top-0 h-100vh overflow-y-auto z-99 max-w-700-px w-100 translate-x-full duration-300">
    <div class="px-20 py-12 border-bottom d-flex align-items-center justify-content-between gap-20">
        <h5 class="text-lg mb-0">Add Role & Access</h5>
        <button type="button" class="close-my-sidebar text-danger-600 text-lg d-flex">
            <i class="ri-close-large-line"></i>
        </button>
    </div>
    <form action="{{ route('roles.store') }}" method="POST" class="d-flex flex-column p-20">
        @csrf
        <div class="row g-3">
            <div class="col-sm-12">
                <div>
                    <label for="roleName" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Role Name</label>
                    <input type="text" name="name" class="form-control" id="roleName" placeholder="Enter Role Name" required>
                </div>
            </div>
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-center gap-3 mt-8">
                    <button type="button" class="close-my-sidebar border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-50 py-11 radius-8">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary-600 border border-primary-600 text-md px-28 py-12 radius-8 max-w-156-px w-100">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Edit sidebar -->
<div class="edit-sidebar bg-white position-fixed end-0 top-0 h-100vh overflow-y-auto z-99 max-w-700-px w-100 translate-x-full duration-300">
    <div class="px-20 py-12 border-bottom d-flex align-items-center justify-content-between gap-20">
        <h5 class="text-lg mb-0">Edit Role</h5>
        <button type="button" class="close-edit-sidebar text-danger-600 text-lg d-flex">
            <i class="ri-close-large-line"></i>
        </button>
    </div>
    <form id="editForm" method="POST" class="d-flex flex-column p-20">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-sm-12">
                <div>
                    <label for="roleNameEdit" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Role Name</label>
                    <input type="text" name="name" class="form-control" id="roleNameEdit" placeholder="Enter Role Name" required>
                </div>
            </div>
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-center gap-3 mt-8">
                    <button type="button" class="close-edit-sidebar border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-50 py-11 radius-8">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary-600 border border-primary-600 text-md px-28 py-12 radius-8 max-w-156-px w-100">
                        Update
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered max-w-340-px">
        <div class="modal-content radius-16 bg-base">
            <div class="modal-body pt-32 px-36 pb-24 text-center">
                <span class="mb-16 fs-1 line-height-1 text-danger">
                    <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                </span>
                <h6 class="text-lg fw-semibold text-primary-light mb-0">Are you sure you want to delete this role?</h6>
                <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                    <button type="button" class="flex-grow-1 border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-24 py-11 radius-8" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <form id="deleteForm" method="POST" class="flex-grow-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-100 btn btn-primary-600 border border-primary-600 text-md px-16 py-12 radius-8">
                            Yes, Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="overlay bg-black bg-opacity-50 w-100 h-100 position-fixed z-9 visibility-hidden opacity-0 duration-300"></div>
@endsection

@push('scripts')
<script>
    // Add sidebar
    $('.my-sidebar-btn').on('click', function () {
        $('.my-sidebar').removeClass('translate-x-full');
        $('.overlay').removeClass('visibility-hidden opacity-0').addClass('opacity-50');
    });
    $('.close-my-sidebar, .overlay').on('click', function () {
        $('.my-sidebar').addClass('translate-x-full');
        $('.overlay').addClass('visibility-hidden opacity-0').removeClass('opacity-50');
    });

    // Edit sidebar
    $('.edit-sidebar-btn').on('click', function () {
        const id = $(this).data('id');
        const name = $(this).data('name');
        
        $('#roleNameEdit').val(name);
        $('#editForm').attr('action', '/roles/' + id);
        
        $('.edit-sidebar').removeClass('translate-x-full');
        $('.overlay').removeClass('visibility-hidden opacity-0').addClass('opacity-50');
    });
    $('.close-edit-sidebar, .overlay').on('click', function () {
        $('.edit-sidebar').addClass('translate-x-full');
        $('.overlay').addClass('visibility-hidden opacity-0').removeClass('opacity-50');
    });

    // Delete modal
    $('#deleteModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const id = button.data('id');
        $('#deleteForm').attr('action', '/roles/' + id);
    });
</script>
@endpush