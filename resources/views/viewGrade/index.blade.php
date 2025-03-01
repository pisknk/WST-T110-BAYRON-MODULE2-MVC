@extends('layouts.studentdashlayout')
@section('title', 'Your Grades')

@section('content')

<!-- Styles -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Page Title -->
<h1 style="padding-left: 3rem; padding-top: 3rem;">
    <b>Grades for {{ $student->first_name }} {{ $student->last_name }}</b>
</h1>
<br>

<!-- Grades Table -->
<div class="table-responsive" style="padding-left: 3rem; padding-right: 3rem;">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Subject Code</th>
                <th>Subject Title</th>
                <th>Grade</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalGrades = 0;
                $subjectsWithGrades = 0;
            @endphp

            @forelse($subjects as $subject)
                @php
                    $grade = $subject->grades->first();
                    if ($grade) {
                        $totalGrades += $grade->grade;
                        $subjectsWithGrades++;
                    }
                @endphp
                <tr>
                    <td>{{ $subject->subject_code }}</td>
                    <td>{{ $subject->name }}</td>
                    <td>{{ $grade->grade ?? 'No Grade' }}</td>
                    <td>
                        @if (!$grade)
                            Incomplete
                        @else
                            @php
                                $gradeValue = $grade->grade;
                            @endphp
                            
                            @if ($gradeValue >= 1.0 && $gradeValue <= 1.25)
                                <span class="badge bg-success">Excellent!</span>
                            @elseif ($gradeValue >= 1.50 && $gradeValue <= 1.75)
                                <span class="badge bg-primary">Great Job!</span>
                            @elseif ($gradeValue == 2.0)
                                <span class="badge bg-info">Passed</span>
                            @elseif ($gradeValue >= 2.25 && $gradeValue <= 2.50)
                                <span class="badge bg-warning">Satisfactory</span>
                            @elseif ($gradeValue >= 3.0 && $gradeValue <= 5.0)
                                <span class="badge bg-danger">Failed</span>
                            @else
                                <span class="badge bg-secondary">Invalid Grade</span>
                            @endif
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No subjects found</td>
                </tr>
            @endforelse

            <!-- GWA Row -->
            <tr class="table-info">
                <td colspan="2" class="text-end"><strong>General Weighted Average (GWA):</strong></td>
                <td>
                    @if($subjectsWithGrades > 0)
                        {{ number_format($totalGrades / $subjectsWithGrades, 2) }}
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    @if($subjectsWithGrades > 0)
                        @php
                            $gwa = $totalGrades / $subjectsWithGrades;
                        @endphp
                        
                        @if ($gwa >= 1.0 && $gwa <= 1.25)
                            <span class="badge bg-success">Excellent!</span>
                        @elseif ($gwa > 1.25 && $gwa <= 1.75)
                            <span class="badge bg-primary">Great Job!</span>
                        @elseif ($gwa > 1.75 && $gwa <= 2.0)
                            <span class="badge bg-info">Passed</span>
                        @elseif ($gwa > 2.0 && $gwa <= 2.50)
                            <span class="badge bg-warning">Satisfactory</span>
                        @elseif ($gwa > 2.50 && $gwa <= 5.0)
                            <span class="badge bg-danger">Failed</span>
                        @else
                            <span class="badge bg-secondary">Invalid GWA</span>
                        @endif
                    @else
                        <span class="badge bg-secondary">No Grades Yet</span>
                    @endif
                </td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

@endsection
