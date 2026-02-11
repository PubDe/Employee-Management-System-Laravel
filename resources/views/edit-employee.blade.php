@extends ('layouts.app')

@section('title','Edit Employee')

@section('content')
    <div class="flex justify-center">
        <div class="form-card">
        <h2 class="h-2 text-center">Edit Employee</h2>
            <div>
                <form action="/edit-employee/{{ $employee->id }}" method="POST" class="space-y-1">
                    @csrf
                    @method('PUT')
                    <label for="name" class="label">Name : </label>
                    <input class="input-field" type="text" name="name" value="{{ $employee->name }}"><br>
                    @error('name')
                        <div style="color:red;">
                            {{ $message }}
                        </div>
                    @enderror
                    <label for="email" class="label">Email : </label>
                    <input class="input-field" type="text" name="email" value="{{ $employee->email }}"><br>
                    @error('email')
                        <div style="color:red;">
                            {{ $message }}
                        </div>
                    @enderror

                    <label for="age" class="label">Age : </label>
                    <input class="input-field" type="text" name="age" value="{{ $employee->age }}"><br>
                    @error('age')
                        <div style="color:red;">
                            {{ $message }}
                        </div>
                    @enderror


                    <label for="phone" class="label">Phone : </label>
                    <input class="input-field" type="text" name="phone" value="{{ $employee->phone }}"><br>
                    @error('phone')
                        <div style="color:red;">
                            {{ $message }}
                        </div>
                    @enderror

                    <label for="dob" class="label">Date of Birth : </label>
                    <input class="input-field" type="date" name="dob" value="{{ $employee->dob }}"><br>
                    @error('phone')
                        <div style="color:red;">
                            {{ $message }}
                        </div>
                    @enderror

                    <label for="role" class="label">Role : </label>
                        <select class="input-field" id="role" name="role" value="{{ $employee->role }}">
                            <option value="Manager">Manager</option>
                            <option value="Exective">Exective </option>
                            <option value="General Staff">General Staff </option>
                            <option value="Junior">Junior</option>
                        </select><br>
                    @error('phone')
                        <div style="color:red;">
                            {{ $message }}
                        </div>
                    @enderror
                        <div class="flex justify-center gap-4 mt-6">
                            <a  class="btn-back w-1/2" href="/view-employees"> Back </a>
                            <button class="btn-primary w-1/2">Save</button>
                        </div>
                </form>
            </div>
        </div>

    </div>
@endsection
