function showToast(type, message) {
  if (type === "success") toastr.success(message, "Success");
  else toastr.error(message, "Error");
}

$(document).ready(function () {
  $("#categoryTable").DataTable({
    processing: true,
    serverSide: true,
    order: [[2, "asc"]],
    ajax: {
      url: baseUrl + "category/fetchRecords",
      type: "POST",
      data: function (d) {
        d[$('meta[name="csrf-name"]').attr("content")] =
          $('meta[name="csrf-token"]').attr("content");
        return d;
      },
    },
    columns: [
      { data: "row_number" },
      { data: "id", visible: false },
      { data: "name" },
      {
        data: null,
        orderable: false,
        searchable: false,
        render: function (data, type, row) {
          return `
            <button class="btn btn-sm btn-warning edit-category" data-id="${row.id}">
              <i class="far fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-danger delete-category" data-id="${row.id}">
              <i class="fas fa-trash-alt"></i>
            </button>
          `;
        },
      },
    ],
    responsive: true,
    autoWidth: false,
  });

  $("#addCategoryForm").on("submit", function (e) {
    e.preventDefault();
    $.ajax({
      url: baseUrl + "category/save",
      method: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          $("#AddCategoryModal").modal("hide");
          $("#addCategoryForm")[0].reset();
          showToast("success", "Category added successfully!");
          setTimeout(() => location.reload(), 800);
        } else {
          showToast("error", response.message || "Failed to add category.");
        }
      },
      error: function (xhr) {
        showToast("error", xhr.responseJSON?.message || "An error occurred.");
      },
    });
  });

  $(document).on("click", ".edit-category", function () {
    const id = $(this).data("id");
    $.ajax({
      url: baseUrl + "category/edit/" + id,
      method: "GET",
      dataType: "json",
      success: function (response) {
        if (!response.data) {
          showToast("error", "Category not found.");
          return;
        }
        $("#edit_category_id").val(response.data.id);
        $("#edit_category_name").val(response.data.name);
        $("#EditCategoryModal").modal("show");
      },
      error: function () {
        showToast("error", "Error fetching category.");
      },
    });
  });

  $("#editCategoryForm").on("submit", function (e) {
    e.preventDefault();
    $.ajax({
      url: baseUrl + "category/update",
      method: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function (response) {
        if (response.success) {
          $("#EditCategoryModal").modal("hide");
          showToast("success", "Category updated successfully!");
          setTimeout(() => location.reload(), 800);
        } else {
          showToast("error", response.message || "Failed to update category.");
        }
      },
      error: function (xhr) {
        showToast("error", xhr.responseJSON?.message || "Error updating category.");
      },
    });
  });

  $(document).on("click", ".delete-category", function () {
    const id = $(this).data("id");
    const csrfName = $('meta[name="csrf-name"]').attr("content");
    const csrfToken = $('meta[name="csrf-token"]').attr("content");

    if (!confirm("Delete this category?")) return;
    $.ajax({
      url: baseUrl + "category/delete/" + id,
      method: "POST",
      data: { _method: "DELETE", [csrfName]: csrfToken },
      dataType: "json",
      success: function (response) {
        if (response.success) {
          showToast("success", "Category deleted successfully!");
          setTimeout(() => location.reload(), 800);
        } else {
          showToast("error", response.message || "Failed to delete category.");
        }
      },
      error: function (xhr) {
        showToast("error", xhr.responseJSON?.message || "Error deleting category.");
      },
    });
  });
});

