@extends('layouts.dashboardlayout')
@section('title', 'Grade')

@section('content')

<!-- Styles -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Page Title -->
<h1 style="padding-left: 3rem; padding-top: 3rem;">
    <b>Grades for {{ $student->first_name }} {{ $student->last_name }}</b>
</h1>
<p style="padding-left: 3rem;">Click "Give Grade" to assign or update grades:</p>
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
                <th>Action</th>
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
                    <td>
                        <button type="button" class="btn btn-primary btn-sm give-grade-btn" data-bs-toggle="modal"
                            data-bs-target="#gradeModal"
                            data-student-id="{{ $student->student_id }}"
                            data-subject-code="{{ $subject->subject_code }}"
                            data-subject-name="{{ $subject->name }}"
                            data-grade="{{ $grade->grade ?? '' }}">
                            Give Grade
                        </button>
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

<!-- Modal -->
<div class="modal fade" id="gradeModal" tabindex="-1" aria-labelledby="gradeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="gradeForm" action="{{ route('grade.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="gradeModalLabel">Assign Grade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="student_id" id="student-id">
                    <input type="hidden" name="subject_code" id="subject-code">

                    <div class="mb-3">
                        <label for="subject-name" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="subject-name" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="grade" class="form-label">Grade</label>
                        <input type="number" step="0.25" min="1.0" max="5.0" class="form-control" id="grade" name="grade" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Grade</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        const gradeModal = new bootstrap.Modal(document.getElementById('gradeModal'));
        
        // Handle modal opening
        $('.give-grade-btn').on('click', function() {
            const studentId = $(this).data('student-id');
            const subjectCode = $(this).data('subject-code');
            const subjectName = $(this).data('subject-name');
            const grade = $(this).data('grade');
            
            $('#student-id').val(studentId);
            $('#subject-code').val(subjectCode);
            $('#subject-name').val(subjectName);
            $('#grade').val(grade || '');
            
            gradeModal.show();
        });

        // Handle modal hidden event to clean up backdrop
        $('#gradeModal').on('hidden.bs.modal', function () {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        });

        // Handle form submission
        $('#gradeForm').on('submit', function(e) {
            e.preventDefault();
            
            const gradeValue = parseFloat($('#grade').val());
            
            // Validate grade value
            if (!gradeValue) {
                alert('Please enter a grade');
                return;
            }

            // Check if grade is within valid ranges
            const validGrades = [
                [1.0, 1.25],
                [1.5, 1.75],
                [2.0, 2.0],
                [2.25, 2.5],
                [3.0, 5.0]
            ];

            let isValidGrade = false;
            for (const [min, max] of validGrades) {
                if (gradeValue >= min && gradeValue <= max) {
                    isValidGrade = true;
                    break;
                }
            }

            if (!isValidGrade) {
                alert('Please enter a valid grade according to the grade brackets');
                return;
            }
            
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $('#gradeModal').modal('hide');
                        setTimeout(function() {
                            alert('Grade saved successfully!');
                            location.reload();
                        }, 200);
                    } else {
                        alert('Error saving grade: ' + response.message);
                    }
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    alert('Error saving grade: ' + (response?.message || 'Please try again.'));
                }
            });
        });
    });
</script>

@endsection
