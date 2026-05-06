function showToast(type, message) {
  if (type === "success") {
    toastr.success(message, "Success");
  } else {
    toastr.error(message, "Error");
  }
}

$(document).ready(function () {

 
  const csrfName  = $('meta[name="csrf-name"]').attr("content");
  const csrfToken = $('meta[name="csrf-token"]').attr("content");


  $("#addMedicalForm").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: baseUrl + "medical_record/save",
      method: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          $("#AddNewModal").modal("hide");
          $("#addMedicalForm")[0].reset();
          showToast("success", "Medical Record added successfully!");
          setTimeout(() => location.reload(), 1000);
        } else {
          showToast("error", response.message || "Failed to add Medical Record.");
        }
      },
      error: function () {
        showToast("error", "An error occurred.");
      },
    });
  });

 
  $(document).on("click", ".edit-btn", function () {
    const recordId = $(this).data("id");

    $.ajax({
      url: baseUrl + "medical_record/edit/" + recordId,
      method: "GET",
      dataType: "json",
      success: function (response) {
        if (response.data) {
          $("#editMedicalModal #record_id").val(response.data.record_id);
          $("#editMedicalModal #patient_id").val(response.data.patient_id);
          $("#editMedicalModal #user_id").val(response.data.user_id);
          $("#editMedicalModal #chief_complaint").val(response.data.chief_complaint);
          $("#editMedicalModal #diagnosis").val(response.data.diagnosis);
          $("#editMedicalModal #treatment").val(response.data.treatment);
          $("#editMedicalModal #remarks").val(response.data.remarks);
          $("#editMedicalModal #date_consulted").val(response.data.date_consulted);

          $("#editMedicalModal").modal("show");
        } else {
          showToast("error", "Error fetching medical record data.");
        }
      },
      error: function () {
        showToast("error", "Error fetching medical record data.");
      },
    });
  });



  $("#editMedicalForm").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: baseUrl + "medical_record/update",
      method: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {  
          $("#editMedicalModal").modal("hide");
          showToast("success", "Medical Record updated successfully!");
          setTimeout(() => location.reload(), 1000);
        } else {
          showToast("error", response.message || "Unknown error");
        }
      },
      error: function () {
        showToast("error", "Error updating record.");
      },
    });
  });


  $(document).on("click", ".deleteUserBtn", function () {
    const recordId = $(this).data("id");

    if (confirm("Are you sure you want to delete this Medical Record?")) {
      $.ajax({
        url: baseUrl + "medical_record/delete/" + recordId,
        method: "POST",
        data: {
          _method: "DELETE",
          [csrfName]: csrfToken,
        },
        success: function (response) {
          if (response.status === "success") {  
            showToast("success", "Record deleted successfully.");
            setTimeout(() => location.reload(), 1000);
          } else {
            showToast("error", response.message || "Failed to delete.");
          }
        },
        error: function () {
          showToast("error", "Something went wrong while deleting.");
        },
      });
    }
  });


    // VIEW

  $(document).on("click", ".view-btn", function () {
    const recordId = $(this).data("id");

    $.ajax({
      url: baseUrl + "medical_record/view/" + recordId,
      method: "GET",
      dataType: "json",
      success: function (response) {
        if (response.data) {
          $("#viewModal #name").text(response.data.patient_name);
          $("#viewModal #doctor_name").text(response.data.doctor_name);
          $("#viewModal #chief_complaint").text(response.data.chief_complaint);
          $("#viewModal #diagnosis").text(response.data.diagnosis);
          $("#viewModal #treatment").text(response.data.treatment);
          $("#viewModal #remarks").text(response.data.remarks);
          $("#viewModal #date_consulted").text(response.data.date_consulted);

          $("#viewModal").modal("show");
        } else {
          showToast("error", "No data found.");
        }
      },
      error: function () {
        showToast("error", "Error fetching details.");
      },
    });
  });

//print
  $(document).on("click", ".print-btn", function () {
    const recordId = $(this).data("id");
    window.open(baseUrl + "medical_record/print/" + recordId, "_blank");
  });


   

  $("#example1").DataTable({
    processing: true,
    serverSide: true,

    order: [[8, "desc"]],

    ajax: {
      url: baseUrl + "medical_record/fetchRecords",
      type: "POST",
      data: function (d) {
        d[csrfName] = csrfToken; 
      },
    },

    columns: [
      { data: "row_number" },
      { data: "record_id",       visible: false },
      { data: "doctor_name" },
      { data: "patient_name" },
      { data: "chief_complaint" },
      { data: "diagnosis" },
      { data: "treatment" },
      { data: "remarks" },
      { data: "date_consulted" },
      {
        data: null,
        orderable: false,
        searchable: false,
        render: function (data, type, row) {
          return `
            <button class="btn btn-sm btn-warning edit-btn" data-id="${row.record_id}">
              <i class="far fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-danger deleteUserBtn" data-id="${row.record_id}">
              <i class="fas fa-trash-alt"></i>
            </button>
            <button class="btn btn-sm btn-info view-btn" data-id="${row.record_id}">
              <i class="fas fa-eye"></i>
            </button>
            <button class="btn btn-sm btn-secondary print-btn" data-id="${row.record_id}">
              <i class="fas fa-print"></i>
            </button>
          `;
        },
      },
    ],

    responsive: true,
    autoWidth: false,
  });

}); 