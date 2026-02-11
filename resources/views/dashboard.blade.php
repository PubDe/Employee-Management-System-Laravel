@extends ('layouts.app')

@section('title','Dashboard')

@section('content')
    <div class="container px-4 py-8 ">
        <h2 class=" h-2">Employee Management</h2>
        <div class="container py-8 space-y-4 sm:w-1/3 w-full">
            <a href="/add" class="block btn-primary">
                Register Employee
            </a>
            <a href="/view-employees" class="block btn-primary">
                View Employees
            </a>
        </div>

    @if(session('success'))
        <div class="success-alert">
            {{ session('success') }}
        </div>
    @endif

    </div>
@endsection
