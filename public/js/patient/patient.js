function showToast(type, message) {
  if (type === "success") {
    toastr.success(message, "Success");
  } else {
    toastr.error(message, "Error");
  }
}

// Toggle new parent fields — Add New modal
$("#add_parent_id").on("change", function () {
  $("#addNewParentFields").toggle($(this).val() === "");
});

// Toggle new parent fields — Edit modal
$("#parent_id").on("change", function () {
  $("#newParentFields").toggle($(this).val() === "");
});

// Reset add modal on close
$("#AddNewModal").on("hidden.bs.modal", function () {
  $("#addNewParentFields").hide();
  $("#add_parent_id").val("");
});

// Reset edit modal on close
$("#editUserModal").on("hidden.bs.modal", function () {
  $("#newParentFields").hide();
});

// Add New
$("#addUserForm").on("submit", function (e) {
  e.preventDefault();
  $.ajax({
    url: baseUrl + "patient/save",
    method: "POST",
    data: $(this).serialize(),
    dataType: "json",
    success: function (response) {
      if (response.status === "success") {
        $("#AddNewModal").modal("hide");
        $("#addUserForm")[0].reset();
        $("#addNewParentFields").hide();
        showToast("success", "Patient added successfully!");
        setTimeout(() => location.reload(), 1000);
      } else {
        showToast("error", response.message || "Failed to add patient.");
      }
    },
    error: function () {
      showToast("error", "An error occurred.");
    },
  });
});

// Edit — load data
$(document).on("click", ".edit-btn", function () {
  const userId = $(this).data("id");
  $.ajax({
    url: baseUrl + "patient/edit/" + userId,
    method: "GET",
    dataType: "json",
    success: function (response) {
      if (response.data) {
        $("#editUserModal #name").val(response.data.name);
        $("#editUserModal #userId").val(response.data.patient_id);
        $("#editUserModal #last_name").val(response.data.last_name);
        $("#editUserModal #middle_name").val(response.data.middle_name);
        $("#editUserModal #sex").val(response.data.sex);
        $("#editUserModal #age").val(response.data.age);
        $("#editUserModal #birthdate").val(response.data.birthdate);
        $("#editUserModal #contact").val(response.data.contact);
        $("#editUserModal #department").val(response.data.department);

        // Load parent if assigned
        if (response.data.parent_id) {
          $("#editUserModal #parent_id").val(response.data.parent_id);
          $("#editUserModal select[name='relationship']").val(
            response.data.relationship,
          );
          $("#newParentFields").hide();
        } else {
          $("#editUserModal #parent_id").val("");
          $("#editUserModal select[name='relationship']").val("");
          $("#newParentFields").hide();
        }

        $("#editUserModal").modal("show");
      } else {
        alert("Error fetching patient data");
      }
    },
    error: function () {
      alert("Error fetching patient data");
    },
  });
});

// Edit — submit
$(document).ready(function () {
  $("#editUserForm").on("submit", function (e) {
    e.preventDefault();
    $.ajax({
      url: baseUrl + "patient/update",
      method: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function (response) {
        if (response.success) {
          $("#editUserModal").modal("hide");
          showToast("success", "Patient updated successfully!");
          setTimeout(() => location.reload(), 1000);
        } else {
          alert("Error updating: " + (response.message || "Unknown error"));
        }
      },
      error: function (xhr) {
        alert("Error updating");
        console.error(xhr.responseText);
      },
    });
  });
});

// Delete
$(document).on("click", ".deleteUserBtn", function () {
  const userId = $(this).data("id");
  const csrfName = $('meta[name="csrf-name"]').attr("content");
  const csrfToken = $('meta[name="csrf-token"]').attr("content");

  if (confirm("Are you sure you want to delete this patient?")) {
    $.ajax({
      url: baseUrl + "patient/delete/" + userId,
      method: "POST",
      data: { _method: "DELETE", [csrfName]: csrfToken },
      success: function (response) {
        if (response.success) {
          showToast("success", "Record deleted successfully.");
          setTimeout(() => location.reload(), 1000);
        } else {
          alert(response.message || "Failed to delete.");
        }
      },
      error: function () {
        alert("Something went wrong while deleting.");
      },
    });
  }
});

// View
$(document).on("click", ".view-btn", function () {
  const userId = $(this).data("id");
  $.ajax({
    url: baseUrl + "patient/view/" + userId,
    method: "GET",
    dataType: "json",
    success: function (response) {
      if (response.data) {
        const d = response.data;
        $("#view_last_name").text(d.last_name);
        $("#view_name").text(d.name);
        $("#view_middle_name").text(d.middle_name || "—");
        $("#view_sex").text(d.sex);
        $("#view_age").text(d.age);
        $("#view_birthdate").text(d.birthdate);
        $("#view_contact").text(d.contact);
        $("#view_department").text(d.department);

        // Parent section
        if (d.parents && d.parents.length > 0) {
          const p = d.parents[0]; // or loop if you want multiple

          $("#view_parent_name").text(p.last_name + ", " + p.name);
          $("#view_parent_contact").text(p.contact || "—");
          $("#view_parent_address").text(p.address || "—");
          $("#view_relationship").text(p.relationship || "—");

          $("#view_parent_section").show();
          $("#view_no_parent").hide();
        } else {
          $("#view_parent_section").hide();
          $("#view_no_parent").show();
        }

        $("#viewModal").modal("show");
      } else {
        alert("No data found");
      }
    },
    error: function () {
      alert("Error fetching details");
    },
  });
});

// Print
$(document).on("click", ".print-btn", function () {
  const userId = $(this).data("id");
  window.open(baseUrl + "patient/print/" + userId, "_blank");
});

// DataTable
$(document).ready(function () {
  const $table = $("#example1");
  const csrfName = "csrf_test_name";
  const csrfToken = $('input[name="' + csrfName + '"]').val();

  $table.DataTable({
    processing: true,
    serverSide: true,
    order: [[2, "asc"]],
    ajax: {
      url: baseUrl + "patient/fetchRecords",
      type: "POST",
      headers: { "X-CSRF-TOKEN": csrfToken },
    },
    columns: [
      { data: "row_number" },
      { data: "patient_id", visible: false },
      { data: "last_name" },
      { data: "name" },
      { data: "middle_name" },
      { data: "sex" },
      { data: "age" },
      { data: "birthdate" },
      { data: "contact" },
      {
        data: "parents",
        render: function (data) {
          return data && data.trim() ? data : "—";
        },
      },
      { data: "department" },
      {
        data: null,
        orderable: false,
        searchable: false,
        render: function (data, type, row) {
          return `
            <button class="btn btn-sm btn-warning edit-btn" data-id="${row.patient_id}">
              <i class="far fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-danger deleteUserBtn" data-id="${row.patient_id}">
              <i class="fas fa-trash-alt"></i>
            </button>
            <button class="btn btn-sm btn-info view-btn" data-id="${row.patient_id}">
              <i class="fas fa-eye"></i>
            </button>
            <button class="btn btn-sm btn-secondary print-btn" data-id="${row.patient_id}">
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
