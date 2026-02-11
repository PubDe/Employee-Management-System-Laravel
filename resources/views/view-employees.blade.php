@extends ('layouts.app')

@section('title','Employees')

@section('content')

    <div class="max-w-6xl mx-auto px-4 py-8">

        <h2 class="h-2">Employees</h2>

        {{-- Success Alert --}}
        @if(session('success'))
            <div class="success-alert">
                {{ session('success') }}
            </div>
        @endif

        {{-- Employee Table --}}
        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="table-base">
                <thead class="table-head">
                    <tr>
                        <th class="th">ID</th>
                        <th class="th">Name</th>
                        <th class="th">Email</th>
                        <th class="th">Age</th>
                        <th class="th">Phone</th>
                        <th class="th">DOB</th>
                        <th class="th">Role</th>
                        <th class="th"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($employees as $employee)
                    <tr class="hover:bg-gray-50">
                        <td class="td">{{ $employee->id }}</td>
                        <td class="td">{{ $employee->name }}</td>
                        <td class="td">{{ $employee->email }}</td>
                        <td class="td">{{ $employee->age }}</td>
                        <td class="td">{{ $employee->phone }}</td>
                        <td class="td">{{ $employee->dob }}</td>
                        <td class="td">{{ $employee->role }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center flex justify-center gap-2">
                            <a href="/edit-employee/{{ $employee->id }}"
                               class="btn-edit">
                                Edit
                            </a>
                            <form action="/delete-employee/{{ $employee->id }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this employee?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn-delete">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $employees->links('pagination::tailwind') }}
        </div>

    </div>

@endsection
