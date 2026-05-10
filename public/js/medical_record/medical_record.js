/* ============================================================
   medical_record.js  –  with medicines given support
   ============================================================ */

function showToast(type, message) {
  if (type === "success") {
    toastr.success(message, "Success");
  } else if (type === "warning") {
    toastr.warning(message, "Warning");
  } else {
    toastr.error(message, "Error");
  }
}

/* ── Medicine row builder ───────────────────────────────────── */

/**
 * Build the HTML for one medicine row.
 * @param {string} containerId   - "addMedicineRows" or "editMedicineRows"
 * @param {object|null} prefill  - { medicine_id, quantity_given } for edit mode
 */
function buildMedicineRow(containerId, prefill = null) {
  const index = $("#" + containerId + " .medicine-row").length;

  let options = '<option value="">-- Select Medicine --</option>';
  medicinesList.forEach(function (m) {
    const selected = prefill && parseInt(prefill.medicine_id) === parseInt(m.medicine_id) ? "selected" : "";
    options += `<option value="${m.medicine_id}" data-stock="${m.quantity}" ${selected}>
                  ${m.medicine_name} (Stock: ${m.quantity})
                </option>`;
  });

  const qtyVal = prefill ? parseInt(prefill.quantity_given) : 1;

  const row = `
    <div class="medicine-row input-group mb-2">
      <select name="medicines[${index}][medicine_id]" class="form-control medicine-select" required>
        ${options}
      </select>
      <input type="number"
             name="medicines[${index}][quantity_given]"
             class="form-control medicine-qty"
             style="max-width:100px;"
             value="${qtyVal}"
             min="1"
             placeholder="Qty"
             required>
      <div class="input-group-append">
        <button type="button" class="btn btn-outline-danger remove-medicine-row">
          <i class="fas fa-times"></i>
        </button>
      </div>
    </div>`;

  $("#" + containerId).append(row);
}

/* ── Re-index medicine rows so names stay sequential ───────── */
function reindexMedicineRows(containerId) {
  $("#" + containerId + " .medicine-row").each(function (i) {
    $(this).find(".medicine-select").attr("name", `medicines[${i}][medicine_id]`);
    $(this).find(".medicine-qty").attr("name",    `medicines[${i}][quantity_given]`);
  });
}

/* ── Enforce max qty = stock on change ──────────────────────── */
$(document).on("change", ".medicine-select", function () {
  const stock = parseInt($(this).find(":selected").data("stock")) || 0;
  const qtyInput = $(this).closest(".medicine-row").find(".medicine-qty");
  qtyInput.attr("max", stock);
  if (parseInt(qtyInput.val()) > stock) {
    qtyInput.val(stock);
  }
});

/* ── Add row buttons ────────────────────────────────────────── */
$(document).on("click", "#addMedicineRowBtn", function () {
  buildMedicineRow("addMedicineRows");
});

$(document).on("click", "#editAddMedicineRowBtn", function () {
  buildMedicineRow("editMedicineRows");
});

/* ── Remove row button ──────────────────────────────────────── */
$(document).on("click", ".remove-medicine-row", function () {
  const container = $(this).closest(".medicine-row").parent().attr("id");
  $(this).closest(".medicine-row").remove();
  reindexMedicineRows(container);
});

/* ── Reset add modal on close ───────────────────────────────── */
$("#AddNewModal").on("hidden.bs.modal", function () {
  $("#addMedicineRows").empty();
});

/* ============================================================
   ADD RECORD
   ============================================================ */

$(document).ready(function () {

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
          $("#addMedicineRows").empty();
          showToast("success", "Medical Record added successfully!");
          setTimeout(() => location.reload(), 1000);
        } else if (response.status === "warning") {
          showToast("warning", response.message);
          setTimeout(() => location.reload(), 2000);
        } else {
          showToast("error", response.message || "Failed to add Medical Record.");
        }
      },
      error: function () {
        showToast("error", "An error occurred.");
      },
    });
  });

  /* ============================================================
     EDIT – open modal
     ============================================================ */

  $(document).on("click", ".edit-btn", function () {
    const recordId = $(this).data("id");

    $.ajax({
      url: baseUrl + "medical_record/edit/" + recordId,
      method: "GET",
      dataType: "json",
      success: function (response) {
        if (!response.data) {
          showToast("error", "Error fetching medical record data.");
          return;
        }

        const d = response.data;

        $("#editMedicalModal #record_id").val(d.record_id);
        $("#editMedicalModal #patient_id").val(d.patient_id);
        $("#editMedicalModal #user_id").val(d.user_id);
        $("#editMedicalModal #chief_complaint").val(d.chief_complaint);
        $("#editMedicalModal #diagnosis").val(d.diagnosis);
        $("#editMedicalModal #treatment").val(d.treatment);
        $("#editMedicalModal #date_consulted").val(d.date_consulted);

        // Populate existing medicines
        $("#editMedicineRows").empty();
        if (d.medicines_given && d.medicines_given.length > 0) {
          d.medicines_given.forEach(function (med) {
            buildMedicineRow("editMedicineRows", med);
          });
        }

        $("#editMedicalModal").modal("show");
      },
      error: function () {
        showToast("error", "Error fetching medical record data.");
      },
    });
  });

  /* ============================================================
     EDIT – submit
     ============================================================ */

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
        } else if (response.status === "warning") {
          showToast("warning", response.message);
          setTimeout(() => location.reload(), 2000);
        } else {
          showToast("error", response.message || "Unknown error");
        }
      },
      error: function () {
        showToast("error", "Error updating record.");
      },
    });
  });

  /* ============================================================
     DELETE
     ============================================================ */

  const csrfName  = $('meta[name="csrf-name"]').attr("content");
  const csrfToken = $('meta[name="csrf-token"]').attr("content");

  $(document).on("click", ".deleteUserBtn", function () {
    const recordId = $(this).data("id");

    if (confirm("Are you sure you want to delete this Medical Record?\nMedicine stock will be restored automatically.")) {
      $.ajax({
        url: baseUrl + "medical_record/delete/" + recordId,
        method: "POST",
        data: { _method: "DELETE", [csrfName]: csrfToken },
        success: function (response) {
          if (response.status === "success") {
            showToast("success", "Record deleted and medicine stock restored.");
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

  /* ============================================================
     VIEW
     ============================================================ */

  $(document).on("click", ".view-btn", function () {
    const recordId = $(this).data("id");

    $.ajax({
      url: baseUrl + "medical_record/view/" + recordId,
      method: "GET",
      dataType: "json",
      success: function (response) {
        if (!response.data) {
          showToast("error", "No data found.");
          return;
        }

        const d = response.data;

        $("#viewModal #view_name").text(d.patient_name);
        $("#viewModal #view_doctor_name").text(d.doctor_name);
        $("#viewModal #view_chief_complaint").text(d.chief_complaint);
        $("#viewModal #view_diagnosis").text(d.diagnosis);
        $("#viewModal #view_treatment").text(d.treatment);
        $("#viewModal #view_date_consulted").text(d.date_consulted);

        // Medicines table
        const tbody = $("#view_medicines_body");
        tbody.empty();

        if (d.medicines_given && d.medicines_given.length > 0) {
          d.medicines_given.forEach(function (med) {
            tbody.append(`
              <tr>
                <td>${med.medicine_name}</td>
                <td>${med.quantity_given}</td>
              </tr>`);
          });
        } else {
          tbody.append('<tr><td colspan="2" class="text-muted text-center">No medicines recorded.</td></tr>');
        }

        $("#viewModal").modal("show");
      },
      error: function () {
        showToast("error", "Error fetching details.");
      },
    });
  });

  /* ── Print ─────────────────────────────────────────────────── */
  $(document).on("click", ".print-btn", function () {
    const recordId = $(this).data("id");
    window.open(baseUrl + "medical_record/print/" + recordId, "_blank");
  });

  /* ============================================================
     DATATABLE
     ============================================================ */

  $("#example1").DataTable({
    processing: true,
    serverSide: true,
    order: [[7, "desc"]],
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
      { data: "date_consulted" },
      {
        data: null,
        orderable: false,
        searchable: false,
        render: function (data, type, row) {
          return `
            <button class="btn btn-sm btn-warning edit-btn"   data-id="${row.record_id}"><i class="far fa-edit"></i></button>
            <button class="btn btn-sm btn-danger deleteUserBtn" data-id="${row.record_id}"><i class="fas fa-trash-alt"></i></button>
            <button class="btn btn-sm btn-info view-btn"      data-id="${row.record_id}"><i class="fas fa-eye"></i></button>
            <button class="btn btn-sm btn-secondary print-btn" data-id="${row.record_id}"><i class="fas fa-print"></i></button>
          `;
        },
      },
    ],
    responsive: true,
    autoWidth: false,
  });

});