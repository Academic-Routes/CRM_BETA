<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CRM</title>
    @include('layouts.admin.styles')
</head>
<body>
    @include('layouts.admin.theme')

    <div class="d-lg-flex bg-white">
        <div class="w-50 d-lg-flex d-none overflow-hidden">
            <img src="/admin/assets/images/thumbs/login-img.png" alt="Login Image" class="w-100 h-100 object-fit-cover">
        </div>
        <div class="lg-w-50 px-24 py-32 d-flex justify-content-center align-items-center">
            <div class="max-w-540-px mx-auto">
                <a href="/" class="">
                    <img src="/admin/assets/images/logo.png" alt="Logo">
                </a>
                <div class="mt-32 mb-32">
                    <h1 class="h6 fw-bold text-primary-light mb-8">
                        Welcome Back 👋
                    </h1>
                    <p class="text-sm text-secondary-light mb-0">
                        Log in to your account to continue
                    </p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger mb-3">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="d-flex flex-column gap-32 submit-form">
                    @csrf
                    <div class="d-flex flex-column gap-16">
                        <div>
                            <label for="email" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">
                                Email Address
                                <span class="text-danger-600">*</span>
                            </label>
                            <input type="email" id="email" name="email" class="email-field form-control" placeholder="Enter your email" required>
                        </div>

                        <div>
                            <label for="password" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">
                                Password
                                <span class="text-danger-600">*</span>
                            </label>
                            <div class="position-relative">
                                <input type="password" id="password" name="password" class="password-field form-control" placeholder="Enter your password" required>
                                <button type="button" class="toggle-password btn p-0 border-0 bg-transparent position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light cursor-pointer ri-eye-line" data-toggle="#password" aria-label="Toggle password visibility">
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between gap-2">
                        <div class="form-check style-check d-flex align-items-center">
                            <input class="form-check-input border border-neutral-400" type="checkbox" value="" id="remember">
                            <label class="form-check-label" for="remember">Remember me </label>
                        </div>
                    </div>
                    <div class="">
                        <button type="submit" class="loginBtn btn btn-primary-600 text-sm btn-sm px-12 py-16 w-100 radius-8"> Log In
                        </button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

    @include('layouts.admin.scripts')
    
    <script>
        function quickLogin(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
            document.querySelector('form').submit();
        }
    </script>
</body>
</html>