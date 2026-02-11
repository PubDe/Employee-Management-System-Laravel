@extends ('layouts.app')

@section('title','Add Employee')

@section('content')
<div class="flex items-center justify-center">
        <div class="form-card">

                <h2 class="h-2 text-center">
                    Register New Employee
                </h2>

                <form method="POST" action="/add-employee" class="space-y-2">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label class="label" for="name">Name</label>
                        <input
                            class="input-field"
                            name="name"
                            placeholder="Name"
                            id="name"
                        >
                        @error('name')
                            <p class="text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="label" for="email">Email</label>
                        <input
                            class="input-field"
                            name="email"
                            type="email"
                            placeholder="Email"
                            id="email"
                        >
                        @error('email')
                            <p class="text-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-between gap-4 mt-6">
                        <!-- Age -->
                        <div class="w-1/2">
                            <label class="label" for="age">Age</label>
                            <input
                                class="input-field"
                                name="age"
                                type="number"
                                placeholder="Age"
                            >
                            @error('age')
                                <p class="text-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="w-1/2">
                            <label class="label" for="phone">Phone</label>
                            <input
                                class="input-field"
                                name="phone"
                                type="number"
                                placeholder="Phone Number"
                            >
                            @error('phone')
                                <p class="text-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <!-- DOB -->
                    <div>
                        <label class="label" for="dob">Date of Birth</label>
                        <input
                            class="input-field"
                            type="date"
                            name="dob"
                        >
                        @error('dob')
                            <p class="text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <label class="label" for="role">Role</label>
                        <select id="role" name="role" class="input-field">
                            <option value="Manager">Manager</option>
                            <option value="Exective">Executive</option>
                            <option value="General Staff">General Staff</option>
                            <option value="Junior">Junior</option>
                        </select>
                        @error('role')
                            <p class="text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-center gap-4 mt-6">
                        <!-- Back -->

                        <a class="btn-back w-1/2" href="/dashboard">
                            Back to Home
                        </a>
                        <!-- Submit -->
                        <button type="submit" class="btn-primary w-1/2"> Register </button>
                    </div>
                </form>
        </div>
    </div>
@endsection
