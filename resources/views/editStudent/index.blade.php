@extends('layouts.dashboardlayout')
@section('title', 'Edit Student')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<h1 style="padding-left: 3rem; padding-top: 3rem;">
    <b>Edit {{ $student->first_name }}'s Information 📝</b>
</h1>
<p1 style="padding-left: 3rem; padding-top: 3rem;">Edit {{ $student->first_name }}'s information below:</p1>
<br><br><br>

<h5 style="padding-left: 3rem; padding-bottom: 1rem;">Basic Information:</h5>

<form action="{{ route('enrollment.store') }}" method="POST" class="needs-validation" novalidate>
    @csrf
    <div class="container" style="padding-left: 3rem; padding-right: 3rem;">
        <div class="row">
            <div class="col">
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="fa-solid fa-id-badge"></i>
                    </span>
                    <div class="form-floating">
                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="{{ $student->first_name }}" required>
                        <label for="first_name">First Name</label>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">#</span>
                    <div class="form-floating">
                        <input type="number" class="form-control" id="student_id" name="student_id" placeholder="Student ID" value="{{ $student->student_id }}" required>
                        <label for="student_id">Student ID</label>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Middle Name" value="{{ $student->middle_name }}">
                    <label for="middle_name">Middle Name</label>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" id="year_level" name="year_level" required>
                        <option value="1" {{ $student->year_level == '1' ? 'selected' : '' }}>1st Year</option>
                        <option value="2" {{ $student->year_level == '2' ? 'selected' : '' }}>2nd Year</option>
                        <option value="3" {{ $student->year_level == '3' ? 'selected' : '' }}>3rd Year</option>
                        <option value="4" {{ $student->year_level == '4' ? 'selected' : '' }}>4th Year</option>
                        <option value="5" {{ $student->year_level == '5' ? 'selected' : '' }}>5th Year</option>
                    </select>
                    <label for="year_level">Year Level</label>
                </div>
            </div>
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="{{ $student->last_name }}" required>
                    <label for="last_name">Last Name</label>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" id="semester" name="semester" required>
                        <option value="1st" {{ $student->semester == '1st' ? 'selected' : '' }}>First Semester</option>
                        <option value="2nd" {{ $student->semester == '2nd' ? 'selected' : '' }}>Second Semester</option>
                        <option value="Summer" {{ $student->semester == 'Summer' ? 'selected' : '' }}>Summer</option>
                    </select>
                    <label for="semester">Semester</label>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>

    <h5 style="padding-left: 3rem; padding-bottom: 1rem;">Enroll student in these subjects:</h5>

    <div class="container" style="padding-left: 3rem; padding-right: 3rem;">
        <div class="row">
            @foreach ($subjects as $subject)
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="subjects[]" value="{{ $subject->subject_code }}" id="subject_{{ $subject->subject_code }}"
                            {{ $student->subjects->contains('subject_code', $subject->subject_code) ? 'checked' : '' }}>
                        <label class="form-check-label" for="subject_{{ $subject->subject_code }}">
                            {{ $subject->name }} ({{ $subject->subject_code }})
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <br>

    <div class="d-flex justify-content-center">
        <input class="btn btn-primary align-items-center text-center" type="submit" value="Submit">
        <button type="button" class="btn btn-danger">Delete Student</button>
    </div><br>

</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.from(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toastEl = document.querySelector('.toast');
        if (toastEl) {
            const toast = new bootstrap.Toast(toastEl, {
                autohide: true,
                delay: 10000
            });
            toast.show();
        }
    });
</script>

@endsection

@if (session('success'))
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Enrollment Services</strong>
                <small>JUST NOW</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ session('success') }}
            </div>
        </div>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
