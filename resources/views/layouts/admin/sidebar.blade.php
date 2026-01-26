<aside class="sidebar">
  <button type="button" class="sidebar-close-btn">
    <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
  </button>
  <div class="">
    <div class="sidebar-logo d-flex align-items-center justify-content-between">
      <a href="/" class="">
        <img src="/admin/assets/images/logo.png" alt="site logo" class="light-logo">
        <img src="/admin/assets/images/logo-light.png" alt="site logo" class="dark-logo">
        <img src="/admin/assets/images/logo-icon.png" alt="site logo" class="logo-icon">
      </a>
    </div>
    <div class="sidebar-menu-area">
      <ul class="sidebar-menu" id="sidebar-menu">
        <li class="sidebar-menu-group-title">Menu</li>
        <li>
          <a href="/" class="active">
            <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
            <span>Dashboard</span>
          </a>
        </li>
        
        @if(auth()->check())
          @if(auth()->user()->hasRole('Counselor') || auth()->user()->hasRole('FrontDesk'))
            {{-- Counselor/FrontDesk Menu --}}
            <li>
              <a href="{{ route('students.index') }}">
                <iconify-icon icon="solar:users-group-two-rounded-outline" class="menu-icon"></iconify-icon>
                <span>Student List</span>
              </a>
            </li>
            <li>
              <a href="{{ route('students.sent-for-application') }}">
                <iconify-icon icon="solar:document-text-outline" class="menu-icon"></iconify-icon>
                <span>Sent to Application</span>
              </a>
            </li>
            <li>
              <a href="{{ route('students.application-completed') }}">
                <iconify-icon icon="solar:check-circle-outline" class="menu-icon"></iconify-icon>
                <span>Application Completed</span>
              </a>
            </li>
          @elseif(auth()->user()->hasRole('Application'))
            {{-- Application Menu --}}
            <li>
              <a href="{{ route('students.sent-for-application') }}">
                <iconify-icon icon="solar:document-text-outline" class="menu-icon"></iconify-icon>
                <span>Sent for Application</span>
              </a>
            </li>
            <li>
              <a href="{{ route('students.application-completed') }}">
                <iconify-icon icon="solar:check-circle-outline" class="menu-icon"></iconify-icon>
                <span>Application Completed</span>
              </a>
            </li>
          @else
            {{-- Admin/Supervisor Menu --}}
            @if(auth()->user()->canManageRoles())
            <li>
              <a href="{{ route('roles.index') }}">
                <iconify-icon icon="solar:shield-user-outline" class="menu-icon"></iconify-icon>
                <span>Assign Roles</span>
              </a>
            </li>
            <li>
              <a href="{{ route('users.index') }}">
                <iconify-icon icon="solar:user-outline" class="menu-icon"></iconify-icon>
                <span>Add User</span>
              </a>
            </li>
            @endif
            <li>
              <a href="{{ route('students.index') }}">
                <iconify-icon icon="solar:users-group-two-rounded-outline" class="menu-icon"></iconify-icon>
                <span>Students</span>
              </a>
            </li>
            <li>
              <a href="{{ route('students.sent-for-application') }}">
                <iconify-icon icon="solar:document-text-outline" class="menu-icon"></iconify-icon>
                <span>Sent for Application</span>
              </a>
            </li>
            <li>
              <a href="{{ route('students.application-completed') }}">
                <iconify-icon icon="solar:check-circle-outline" class="menu-icon"></iconify-icon>
                <span>Application Completed</span>
              </a>
            </li>
          @endif
        @endif
      </ul>
    </div>
  </div>
</aside>