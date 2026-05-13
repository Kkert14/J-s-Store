function showToast(type, message) {
  if (type === "success") {
    toastr.success(message, "Success");
  } else {
    toastr.error(message, "Error");
  }
}

// ── Toggle new-parent fields (Add modal) ─────────────────────────────────────
$("#add_parent_id").on("change", function () {
  $("#addNewParentFields").toggle($(this).val() === "__new__");
});

// ── Toggle new-parent fields (Edit modal) ────────────────────────────────────
$("#parent_id").on("change", function () {
  $("#newParentFields").toggle($(this).val() === "__new__");
});

// ── Reset Add modal on close ─────────────────────────────────────────────────
$("#AddNewModal").on("hidden.bs.modal", function () {
  $("#addNewParentFields").hide();
  $("#add_parent_id").val("");
});

// ── Reset Edit modal on close ────────────────────────────────────────────────
$("#editUserModal").on("hidden.bs.modal", function () {
  $("#newParentFields").hide();
});

// ── Add New Patient ──────────────────────────────────────────────────────────
$("#addUserForm").on("submit", function (e) {
  e.preventDefault();
  $.ajax({
    url:      baseUrl + "patient/save",
    method:   "POST",
    data:     $(this).serialize(),
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

// ── Edit — load data into modal ──────────────────────────────────────────────
$(document).on("click", ".edit-btn", function () {
  const userId = $(this).data("id");

  $.ajax({
    url:      baseUrl + "patient/edit/" + userId,
    method:   "GET",
    dataType: "json",
    success: function (response) {
      if (!response.data) {
        showToast("error", "Error fetching patient data.");
        return;
      }

      const d = response.data;

      $("#editUserModal #userId").val(d.patient_id);
      $("#editUserModal #name").val(d.name);
      $("#editUserModal #last_name").val(d.last_name);
      $("#editUserModal #middle_name").val(d.middle_name);
      $("#editUserModal #sex").val(d.sex);
      $("#editUserModal #age").val(d.age);
      $("#editUserModal #birthdate").val(d.birthdate);
      $("#editUserModal #contact").val(d.contact);
      $("#editUserModal #department").val(d.department);

      // Parent / Guardian
      if (d.parent_id) {
        $("#editUserModal #parent_id").val(d.parent_id);
        $("#editUserModal select[name='relationship']").val(d.relationship);
        $("#newParentFields").hide();
      } else {
        $("#editUserModal #parent_id").val("");
        $("#editUserModal select[name='relationship']").val("");
        $("#newParentFields").hide();
      }

      $("#editUserModal").modal("show");
    },
    error: function () {
      showToast("error", "Error fetching patient data.");
    },
  });
});

// ── Edit — submit ────────────────────────────────────────────────────────────
$(document).ready(function () {
  $("#editUserForm").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url:      baseUrl + "patient/update",
      method:   "POST",
      data:     $(this).serialize(),
      dataType: "json",
      success: function (response) {
        // Controller returns { success: true } — kept as-is
        if (response.success) {
          $("#editUserModal").modal("hide");
          showToast("success", "Patient updated successfully!");
          setTimeout(() => location.reload(), 1000);
        } else {
          showToast("error", response.message || "Failed to update patient.");
        }
      },
      error: function (xhr) {
        showToast("error", xhr.responseJSON?.message || "Error updating patient.");
        console.error(xhr.responseText);
      },
    });
  });
});

// ── Delete ───────────────────────────────────────────────────────────────────
$(document).on("click", ".deleteUserBtn", function () {
  const userId    = $(this).data("id");
  const csrfName  = $('meta[name="csrf-name"]').attr("content");
  const csrfToken = $('meta[name="csrf-token"]').attr("content");

  if (confirm("Are you sure you want to delete this patient?")) {
    $.ajax({
      url:    baseUrl + "patient/delete/" + userId,
      method: "POST",
      data:   { _method: "DELETE", [csrfName]: csrfToken },
      success: function (response) {
        if (response.success) {
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

// ── View ─────────────────────────────────────────────────────────────────────
$(document).on("click", ".view-btn", function () {
  const userId = $(this).data("id");

  $.ajax({
    url:      baseUrl + "patient/view/" + userId,
    method:   "GET",
    dataType: "json",
    success: function (response) {
      if (!response.data) {
        showToast("error", "No data found.");
        return;
      }

      const d = response.data;

      $("#view_last_name").text(d.last_name);
      $("#view_name").text(d.name);
      $("#view_middle_name").text(d.middle_name || "—");
      $("#view_sex").text(d.sex);
      $("#view_age").text(d.age);
      $("#view_birthdate").text(d.birthdate);
      $("#view_contact").text(d.contact);
      $("#view_department").text(d.department);

      // Parent section — controller returns an array of parents
      if (d.parents && d.parents.length > 0) {
        const p = d.parents[0]; // show first parent; extend to loop if needed
        $("#view_parent_name").text(p.last_name + ", " + p.name);
        $("#view_parent_contact").text(p.contact    || "—");
        $("#view_parent_address").text(p.address    || "—");
        $("#view_relationship").text(p.relationship || "—");
        $("#view_parent_section").show();
        $("#view_no_parent").hide();
      } else {
        $("#view_parent_section").hide();
        $("#view_no_parent").show();
      }

      $("#viewModal").modal("show");
    },
    error: function () {
      showToast("error", "Error fetching details.");
    },
  });
});

// ── Print ────────────────────────────────────────────────────────────────────
$(document).on("click", ".print-btn", function () {
  window.open(baseUrl + "patient/print/" + $(this).data("id"), "_blank");
});

// ── DataTable ────────────────────────────────────────────────────────────────
$(document).ready(function () {
  $("#example1").DataTable({
    processing: true,
    serverSide: true,
    order: [[2, "asc"]],
    ajax: {
      url:  baseUrl + "patient/fetchRecords",
      type: "POST",
      // FIX: send CSRF token in the POST body, not as a header.
      // CI4 validates CSRF from the request body by default.
      data: function (d) {
        d[$('meta[name="csrf-name"]').attr("content")] =
          $('meta[name="csrf-token"]').attr("content");
        return d;
      },
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
        // "parents" is a GROUP_CONCAT string from the server, e.g.:
        // "Smith, John (Father) | Doe, Jane (Mother)"
        data: "parents",
        render: function (data) {
          return data && data.trim() ? data : "—";
        },
      },
      { data: "department" },
      {
        data:       null,
        orderable:  false,
        searchable: false,
        render: function (data, type, row) {
          return `
            <button class="btn btn-sm btn-warning edit-btn"    data-id="${row.patient_id}"><i class="far fa-edit"></i></button>
            <button class="btn btn-sm btn-danger deleteUserBtn" data-id="${row.patient_id}"><i class="fas fa-trash-alt"></i></button>
            <button class="btn btn-sm btn-info view-btn"       data-id="${row.patient_id}"><i class="fas fa-eye"></i></button>
            <button class="btn btn-sm btn-secondary print-btn" data-id="${row.patient_id}"><i class="fas fa-print"></i></button>
          `;
        },
      },
    ],
    responsive: true,
    autoWidth:  false,
  });
});
