@extends ('layouts.app')

@section('title','Forget Password')

@section('content')
    <div class="flex items-center justify-center">

        <div class="form-card">

            <h2 class="h-2 text-center">
                Reset Password
            </h2>

            @if (session('error'))
                <div class="mb-4 p-3 rounded bg-red-100 text-center text-red-600 border border-red-300">
                    {{ session('error') }}
                </div>

            @elseif (session('success'))
                <div class="mb-4 p-3 rounded bg-blue-100 text-center text-blue-600 border border-blue-300">
                    {{ session('success') }}
                </div>

            @else
                <form method="POST" action="/send-rest-link" class="space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="label">
                            Email
                        </label>
                        <input
                            type="text"
                            name="email"
                            id="email"
                            class="input-field"
                            placeholder="Enter your email">

                        @error('email')
                            <p class="text-error">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="btn-primary w-full">
                        Send Reset Link
                    </button>
                </form>
            @endif

            <div>
                <a href="/" class="btn-back w-full mt-4">
                    Back
                </a>
            </div>

        </div>

    </div>
@endsection
