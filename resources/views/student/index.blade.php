@extends('layouts.dashboardlayout')
@section('title', 'Student')

@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<h1 style="padding-left: 3rem; padding-top: 3rem;"><b>List of Students 👨‍👩‍👧‍👦</b></h1>
<p style="padding-left: 3rem;">Here's a list of enrolled students. Click on the edit button to make adjustments:</p>
<br><br>

<div class="table-responsive" style="padding-left: 3rem; padding-right: 3rem;">
    <table id="studentTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th scope="col">Student ID</th>
                <th scope="col">Student Name</th>
                <th scope="col">Year Level</th>
                <th scope="col">Semester</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                <tr>
                    <td>{{ $student->student_id }}</td>
                    <td>{{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}</td>
                    <td>{{ $student->year_level }}</td>
                    <td>{{ $student->semester }}</td>
                    <td>
                        <a href="{{ route('editStudent.index', ['student_id' => $student->student_id]) }}" class="btn btn-primary btn-sm">
                            Edit
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-LkDfPzzPb6hP6q0LmZYUmqgV8v3dMqQf6gH+uOipkuYlTsf21Ybbv2B+IfQefhWc" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#studentTable').DataTable({
            "paging": true,
            "searching": true,
            "info": true,
            "lengthChange": true,
            "ordering": true
        });
    });
</script>

@endsection
