@extends('layouts.dashboardlayout')
@section('title', 'Subject')

@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<h1 style="padding-left: 3rem; padding-top: 3rem;"><b>View Subjects 🎒</b></h1>
<p style="padding-left: 3rem;">Here's a list of subjects offered. Click on the edit button to make adjustments. <br> Click on the Add button to add subjects:</p>
<br><br>

<!-- Add this toast container right after the content section starts -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Subject deleted successfully! 🗑️
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<div class="spacing" style="padding-left: 3rem; padding-right: 3rem;">

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('subjects.store') }}" method="POST">
    @csrf
    <div class="input-group mb-3">
        <input type="text" name="subject_code" class="form-control" placeholder="Subject Code" required>
        <span class="input-group-text"></span>
        <input type="text" name="name" class="form-control" placeholder="Subject Title" required>
        <button type="submit" class="btn btn-primary">Add Subject</button>
    </div>
</form>

<table class="table" id="subjectsTable">
  <thead>
    <tr>
      <th scope="col">Subject Code</th>
      <th scope="col">Subject Title</th>
      <th scope="col">Number of Students Enrolled in Subject</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach($subjects as $subject)
    <tr>
      <th scope="row">{{ $subject->subject_code }}</th>
      <td>
        <span class="subject-name">{{ $subject->name }}</span>
        <form action="{{ route('subjects.update', $subject->subject_code) }}" method="POST" class="edit-form d-none">
            @csrf
            @method('PUT')
            <div class="input-group">
                <input type="text" name="name" class="form-control" value="{{ $subject->name }}" required>
                <button type="submit" class="btn btn-success btn-sm">Save</button>
                <button type="button" class="btn btn-secondary btn-sm cancel-edit">Cancel</button>
            </div>
        </form>
      </td>
      <td>{{ $subject->students_count }}</td>
      <td>
        <button type="button" class="btn btn-primary btn-edit">Edit</button>
        <button type="button" class="btn btn-danger delete-btn" data-bs-toggle="modal" data-bs-target="#deleteSubjectModal" 
                data-subject-code="{{ $subject->subject_code }}" 
                data-subject-name="{{ $subject->name }}">
            Delete
        </button>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

</div>

<!-- Delete Subject Modal -->
<div class="modal fade" id="deleteSubjectModal" tabindex="-1" aria-labelledby="deleteSubjectModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteSubjectModalLabel">Delete Subject</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this subject?</p>
        <p class="fw-bold"><span id="subjectToDelete"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <form id="deleteForm" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <input type="hidden" id="deleteSubjectCode" name="subject_code">
            <button type="submit" class="btn btn-danger">Delete Subject</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit Subject Modal -->
<div class="modal fade" id="editSubjectModal" tabindex="-1" aria-labelledby="editSubjectModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editSubjectModalLabel">Edit Subject Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="edit_subject_code" class="form-label">Subject Code</label>
                <input type="text" class="form-control" id="edit_subject_code" name="subject_code" readonly>
            </div>
            <div class="mb-3">
                <label for="edit_subject_name" class="form-label">Subject Title</label>
                <input type="text" class="form-control" id="edit_subject_name" name="name" required>
            </div>
            <div class="modal-footer px-0 pb-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    // Initialize DataTable
    $(document).ready(function() {
        $('#subjectsTable').DataTable();
    });

    // Delete functionality
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            const subjectCode = this.getAttribute('data-subject-code');
            const subjectName = this.getAttribute('data-subject-name');
            document.getElementById('deleteForm').action = `/subjects/${subjectCode}`;
            document.getElementById('subjectToDelete').textContent = `${subjectCode} - ${subjectName}`;
            document.getElementById('deleteSubjectCode').value = subjectCode;
        });
    });

    // Edit functionality
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const subjectCode = row.querySelector('th').textContent;
            const subjectName = row.querySelector('.subject-name').textContent.trim();
            
            // Populate the edit modal
            document.getElementById('edit_subject_code').value = subjectCode;
            document.getElementById('edit_subject_name').value = subjectName;
            
            // Set the form action using the Laravel route
            document.getElementById('editForm').action = `/subjects/${subjectCode}`;
            
            // Show the modal
            new bootstrap.Modal(document.getElementById('editSubjectModal')).show();
        });
    });

    // Toast initialization and check
    const successToast = new bootstrap.Toast(document.getElementById('successToast'));
    if (window.location.search.includes('deleted=true')) {
        successToast.show();
    }
</script>

@endsection
