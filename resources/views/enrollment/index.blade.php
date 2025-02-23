@extends('layouts.dashboardlayout')
@section('title', 'Enrollment')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<h1 style="padding-left: 3rem; padding-top: 3rem;"><b>Enroll a Student 📝</b></h1>
<p1 style="padding-left: 3rem; padding-top: 3rem;">Please fill out the form below to enroll a student:</p1>
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
                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" required>
                        <label for="first_name">First Name</label>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">#</span>
                    <div class="form-floating">
                        <input type="number" class="form-control" id="student_id" name="student_id" placeholder="Student ID" required>
                        <label for="student_id">Student ID</label>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Middle Name" required>
                    <label for="middle_name">Middle Name</label>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" id="year_level" name="year_level" required>
                        <option value="1">1st Year</option>
                        <option value="2">2nd Year</option>
                        <option value="3">3rd Year</option>
                        <option value="4">4th Year</option>
                        <option value="5">5th Year</option>
                    </select>
                    <label for="year_level">Year Level</label>
                </div>
            </div>
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" required>
                    <label for="last_name">Last Name</label>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" id="semester" name="semester" required>
                        <option value="1st">First Semester</option>
                        <option value="2nd">Second Semester</option>
                        <option value="Summer">Summer</option>
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
        <div class="col">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="CAP2" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Capstone 2
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="SIA2" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    SIA 2
                </label>
            </div>
        </div>
        <div class="col">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="IAS2" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    IAS 2
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="WEBS" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Web Systems
                </label>
            </div>
        </div>
        <div class="col">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="APPD" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Application Development
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="MULT" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Multimedia
                </label>
            </div>
        </div>
    </div>
    </div> <br>

    <div class="d-flex justify-content-center">
        <input class="btn btn-primary align-items-center text-center" type="submit" value="Submit">
    </div><br>

</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- Bootstrap validation script -->
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

@endsection

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
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
