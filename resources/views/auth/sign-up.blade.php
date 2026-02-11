
@extends ('layouts.app')

@section('title','Signup')

@section('content')
    <div class="flex items-center justify-center">

        <div class="form-card">
            <h2 class="h-2 text-center">Sign Up</h2>

            <form method="POST" action="/sign-up" class="space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="label">Name</label>
                    <input id="name" type="text" name="name"
                        class="input-field"
                        placeholder="Enter your name">
                    @error('name')
                        <p class="text-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="label">Email Address</label>
                    <input id="email" type="email" name="email"
                        class="input-field"
                        placeholder="Enter your email">
                    @error('email')
                        <p class="text-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="label">Password</label>
                    <input id="password" type="password" name="password"
                        class="input-field"
                        placeholder="Enter password">
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="label">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                        class="input-field"
                        placeholder="Confirm password">
                    @error('password')
                        <p class="text-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <button type="submit"
                        class="btn-primary w-full">
                    Sign Up
                </button>

                <!-- Sign In Link -->
                <p class="text-center text-gray-600 mt-2">
                    Already have an account?
                    <a href="/" class="text-blue-500 hover:underline">Sign In</a>
                </p>

            </form>
        </div>

    </div>
@endsection
