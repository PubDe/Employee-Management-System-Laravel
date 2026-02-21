@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="h-2">Department Status</h2>

    <div class="w-1/2">
        <label class="label" for="departmentSelect">Select Department</label>
        <select class="input-field" id="departmentSelect" class="form-control">
            @foreach($departments as $department)
                <option value="{{ $department->id }}">
                    {{ $department->name }}
                </option>
            @endforeach
        </select>
    </div>

    <table class="table" id="statusTable" style="display:none;">
        <thead class="table-head">
            <tr>
                <th class="th">Designation</th>
                <th class="th">Max Capacity</th>
                <th class="th">Current Filled</th>
                <th class="th">Remaining</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200"></tbody>
    </table>

</div>

<script>
function loadDepartmentStatus(departmentId) {

    if (!departmentId) {
        document.getElementById('statusTable').style.display = 'none';
        return;
    }

    fetch('/department-status/' + departmentId)
        .then(response => response.json())
        .then(data => {

            let tbody = document.querySelector('#statusTable tbody');
            tbody.innerHTML = '';

            data.forEach(item => {
                tbody.innerHTML += `
                    <tr>
                        <td class="td">${item.designation}</td>
                        <td class="td">${item.max_capacity}</td>
                        <td class="td">${item.current_count}</td>
                        <td class="td">${item.remaining}</td>
                    </tr>
                `;
            });

            document.getElementById('statusTable').style.display = 'table';
        });
}

// When page first loads
document.addEventListener('DOMContentLoaded', function () {
    let firstDepartmentId = document.getElementById('departmentSelect').value;
    loadDepartmentStatus(firstDepartmentId);
});

// When dropdown changes
document.getElementById('departmentSelect').addEventListener('change', function () {
    loadDepartmentStatus(this.value);
});

</script>

@endsection
