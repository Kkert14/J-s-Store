function showToast(type, message) {
  if (type === "success") {
    toastr.success(message, "Success");
  } else {
    toastr.error(message, "Error");
  }
}

$(document).ready(function () {
  
  $("#addAppointmentForm").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: baseUrl + "appointment/save",
      method: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          $("#AddNewModal").modal("hide");
          $("#addAppointmentForm")[0].reset();
          showToast("success", "Appointment added successfully!");
          setTimeout(() => location.reload(), 1000);
        } else {
          showToast("error", response.message || "Failed to add appointment.");
        }
      },
      error: function () {
        showToast("error", "An error occurred.");
      },
    });
  });


  $(document).on("click", ".edit-btn", function () {
    const appointmentId = $(this).data("id");

    $.ajax({
      url: baseUrl + "appointment/edit/" + appointmentId,
      method: "GET",
      dataType: "json",
      success: function (response) {
        if (response.data) {
          $("#editAppointmentModal #appointment_id").val(
            response.data.appointment_id,
          );
          $("#editAppointmentModal #patient_id").val(response.data.patient_id);
          $("#editAppointmentModal #user_id").val(response.data.user_id);

          // Format DATETIME for input[type="datetime-local"]
          const date = new Date(response.data.appointment_date);
          const formatted = date.toISOString().slice(0, 16);
          $("#editAppointmentModal #appointment_date").val(formatted);

          $("#editAppointmentModal #status").val(response.data.status);
          $("#editAppointmentModal #notes").val(response.data.notes);

          $("#editAppointmentModal").modal("show");
        } else {
          showToast("error", "Error fetching appointment data");
        }
      },
      error: function () {
        showToast("error", "Error fetching appointment data");
      },
    });
  });

 
  $("#editAppointmentForm").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: baseUrl + "appointment/update",
      method: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          $("#editAppointmentModal").modal("hide");
          showToast("success", "Appointment updated successfully!");
          setTimeout(() => location.reload(), 1000);
        } else {
          showToast("error", response.message || "Update failed");
        }
      },
      error: function () {
        showToast("error", "Error updating appointment");
      },
    });
  });

 
  $(document).on("click", ".deleteAppointmentBtn", function () {
    const appointmentId = $(this).data("id");

    const csrfName = $('meta[name="csrf-name"]').attr("content");
    const csrfToken = $('meta[name="csrf-token"]').attr("content");

    if (confirm("Are you sure you want to delete this appointment?")) {
      $.ajax({
        url: baseUrl + "appointment/delete/" + appointmentId,
        method: "POST",
        dataType: "json",
        data: {
          _method: "DELETE",
          [csrfName]: csrfToken,
        },
        success: function (response) {
          if (response.status === "success") {
            showToast("success", "Appointment deleted successfully.");
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


  const csrfName = $('meta[name="csrf-name"]').attr("content");
  const csrfToken = $('meta[name="csrf-token"]').attr("content");

  $("#example1").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: baseUrl + "appointment/fetchRecords",
      type: "POST",
      data: function (d) {
        d[csrfName] = csrfToken;
      },
    },
    columns: [
      { data: "row_number" },
      { data: "appointment_id", visible: false },

      //  Use JOINed values 
      { data: "patient_name" },
      { data: "user_name" },

      { data: "appointment_date" },

     
      {
        data: "status",
        render: function (data) {
          let color = "secondary";
          if (data === "pending") color = "warning";
          else if (data === "completed") color = "success";
          else if (data === "cancelled") color = "danger";

          return `<span class="badge bg-${color}">${data}</span>`;
        },
      },

      { data: "notes" },

      {
        data: null,
        orderable: false,
        searchable: false,
        render: function (data, type, row) {
          return `
                        <button class="btn btn-sm btn-warning edit-btn" data-id="${row.appointment_id}">
                            <i class="far fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger deleteAppointmentBtn" data-id="${row.appointment_id}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    `;
        },
      },
    ],
    responsive: true,
    autoWidth: false,
  });
});
