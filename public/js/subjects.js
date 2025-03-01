$(document).ready(function () {
    // Initialize DataTable
    $("#subjectsTable").DataTable();

    // Handle edit button clicks
    $(".btn-edit").click(function () {
        const row = $(this).closest("tr");
        row.find(".subject-name").hide();
        row.find(".edit-form").removeClass("d-none");
    });

    // Handle cancel edit button clicks
    $(".cancel-edit").click(function () {
        const row = $(this).closest("tr");
        row.find(".subject-name").show();
        row.find(".edit-form").addClass("d-none");
    });

    // Initialize delete modal
    const deleteModal = new bootstrap.Modal(
        document.getElementById("deleteSubjectModal")
    );

    // Handle delete button clicks
    $(".delete-btn").on("click", function () {
        const subjectCode = $(this).data("subject-code");
        const subjectName = $(this).data("subject-name");

        $("#subjectToDelete").text(`${subjectCode} - ${subjectName}`);
        $("#deleteForm").attr("action", `/subject/${subjectCode}`);

        deleteModal.show();
    });

    // Handle delete form submission
    $("#deleteForm").on("submit", function (e) {
        e.preventDefault();
        const form = $(this);
        const url = form.attr("action");

        $.ajax({
            url: url,
            type: "DELETE",
            data: form.serialize(),
            success: function (response) {
                if (response.success) {
                    deleteModal.hide();
                    // Reload the page or remove the row
                    location.reload();
                } else {
                    alert("Error deleting subject");
                }
            },
            error: function () {
                alert("Error deleting subject");
            },
        });
    });

    // Handle modal hidden event
    $("#deleteSubjectModal").on("hidden.bs.modal", function () {
        $("body").removeClass("modal-open");
        $(".modal-backdrop").remove();
    });
});
