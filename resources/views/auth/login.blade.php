@extends ('layouts.app')

@section('title','Login')

@section('content')
    <div class="flex items-center justify-center">
        @if(session('success'))
            <div class="success-alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="form-card">
            <div class="text-center">
                <h2 class="h-2">Employee Management System</h2>
                <h3 class="h-3">Admin Portal</h3>
                <p class="txt mb-2">Sign in for Employee Management System</p>
            </div>

            <form method="POST" action="/login" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="label">Email :</label>
                    <input name="email" id="email" placeholder="email"
                        class="input-field">
                    @error('email')
                        <div class="text-error">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="password" class="label">Password :</label>
                    <input type="password" name="password" placeholder="Password"
                        class="input-field">
                    @error('password')
                        <div class="text-error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit"
                        class="btn-primary w-full">
                    Sign In
                </button>
                @error('submit')
                    <div class="text-error">{{ $message }}</div>
                @enderror
            </form>

            <div class="mt-4 text-center">
                <p class="txt">
                    <a href="/forgot-password" class="link-primary">Forgot Password?</a>
                </p>
                <p class="txt mt-2">
                    Don't have an account? <a href="/signup-page" class="link-primary">Sign up</a>
                </p>
            </div>
        </div>
    </div>
@endsection
