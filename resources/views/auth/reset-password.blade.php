@extends ('layouts.app')

@section('title','Reset Password')

@section('content')

<div class="flex items-center justify-center">

    <div class="form-card">
        <h2 class="h-2 text-center">Reset Password</h2>

        <form method="POST" action="/submit-reset-password" class="space-y-4">
            @csrf
            <input name="token" type="hidden" value="{{ $token }}">

            <!-- Email -->
            <div>
                <label for="email" class="label">Email Address</label>
                <input id="email" type="email" name="email"
                       class="input-field">
                @error('email')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="label">Password</label>
                <input id="password" type="password" name="password"
                       class="input-field">
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="label">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       class="input-field">
                @error('password')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <button type="submit"
                    class="btn-primary w-full">
                Reset
            </button>

            <!-- Back -->
            <a href="/" class="btn-back w-full"> Back</a>

        </form>
    </div>

</div>
@endsection
