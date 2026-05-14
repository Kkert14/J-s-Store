function showToast(type, message) {
  if (type === "success") toastr.success(message, "Success");
  else toastr.error(message, "Error");
}

$(document).ready(function () {
  $("#productTable").DataTable({
    processing: true,
    serverSide: true,
    order: [[2, "asc"]],
    ajax: {
      url: baseUrl + "product/fetchRecords",
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
        data: "category_name",
        render: function (data) {
          return data && data.trim() ? data : "—";
        },
      },
      {
        data: "price",
        render: function (data) {
          const n = parseFloat(data || 0);
          return "₱" + n.toFixed(2);
        },
      },
      {
        data: null,
        render: function (data, type, row) {
          const qty = parseInt(row.stock_qty || 0);
          const low = row.low_stock;
          return low
            ? `<span class="badge badge-danger">${qty}</span>`
            : `<span class="badge badge-success">${qty}</span>`;
        },
      },
      {
        data: null,
        orderable: false,
        searchable: false,
        render: function (data, type, row) {
          return `
            <button class="btn btn-sm btn-info adjust-stock" data-id="${row.id}" data-name="${row.name}" data-stock="${row.stock_qty}">
              <i class="fas fa-warehouse"></i>
            </button>
            <button class="btn btn-sm btn-warning edit-product" data-id="${row.id}">
              <i class="far fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-danger delete-product" data-id="${row.id}">
              <i class="fas fa-trash-alt"></i>
            </button>
          `;
        },
      },
    ],
    responsive: true,
    autoWidth: false,
  });

  $("#addProductForm").on("submit", function (e) {
    e.preventDefault();
    $.ajax({
      url: baseUrl + "product/save",
      method: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          $("#AddProductModal").modal("hide");
          $("#addProductForm")[0].reset();
          $("#add_is_active").prop("checked", true);
          showToast("success", "Product added successfully!");
          setTimeout(() => location.reload(), 800);
        } else {
          showToast("error", response.message || "Failed to add product.");
        }
      },
      error: function (xhr) {
        showToast("error", xhr.responseJSON?.message || "An error occurred.");
      },
    });
  });

  $(document).on("click", ".edit-product", function () {
    const id = $(this).data("id");
    $.ajax({
      url: baseUrl + "product/edit/" + id,
      method: "GET",
      dataType: "json",
      success: function (response) {
        const d = response.data;
        if (!d) {
          showToast("error", "Product not found.");
          return;
        }
        $("#edit_product_id").val(d.id);
        $("#edit_product_name").val(d.name);
        $("#edit_product_sku").val(d.sku);
        $("#edit_product_category").val(d.category_id || "");
        $("#edit_product_unit").val(d.unit || "");
        $("#edit_product_cost").val(d.cost);
        $("#edit_product_price").val(d.price);
        $("#edit_product_stock").val(d.stock_qty);
        $("#edit_product_reorder").val(d.reorder_level);
        $("#edit_is_active").prop("checked", parseInt(d.is_active || 0) === 1);
        $("#EditProductModal").modal("show");
      },
      error: function () {
        showToast("error", "Error fetching product.");
      },
    });
  });

  $("#editProductForm").on("submit", function (e) {
    e.preventDefault();
    $.ajax({
      url: baseUrl + "product/update",
      method: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function (response) {
        if (response.success) {
          $("#EditProductModal").modal("hide");
          showToast("success", "Product updated successfully!");
          setTimeout(() => location.reload(), 800);
        } else {
          showToast("error", response.message || "Failed to update product.");
        }
      },
      error: function (xhr) {
        showToast("error", xhr.responseJSON?.message || "Error updating product.");
      },
    });
  });

  $(document).on("click", ".delete-product", function () {
    const id = $(this).data("id");
    const csrfName = $('meta[name="csrf-name"]').attr("content");
    const csrfToken = $('meta[name="csrf-token"]').attr("content");

    if (!confirm("Delete this product?")) return;
    $.ajax({
      url: baseUrl + "product/delete/" + id,
      method: "POST",
      data: { _method: "DELETE", [csrfName]: csrfToken },
      dataType: "json",
      success: function (response) {
        if (response.success) {
          showToast("success", "Product deleted successfully!");
          setTimeout(() => location.reload(), 800);
        } else {
          showToast("error", response.message || "Failed to delete product.");
        }
      },
      error: function (xhr) {
        showToast("error", xhr.responseJSON?.message || "Error deleting product.");
      },
    });
  });

  $(document).on("click", ".adjust-stock", function () {
    const id = $(this).data("id");
    const name = $(this).data("name");
    const stock = $(this).data("stock");

    $("#adjust_product_id").val(id);
    $("#adjust_product_name").text(name);
    $("#adjust_current_stock").text(stock);
    $("#adjust_action").val("in");
    $("#adjust_qty").val(1);
    $("#adjust_unit_cost").val("");
    $("#adjust_reason").val("");
    $("#AdjustStockModal").modal("show");
  });

  $("#adjustStockForm").on("submit", function (e) {
    e.preventDefault();
    $("#btnAdjustStockSave").prop("disabled", true);
    $.ajax({
      url: baseUrl + "product/adjustStock",
      method: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function (res) {
        if (res.success) {
          $("#AdjustStockModal").modal("hide");
          showToast("success", "Stock updated.");
          setTimeout(() => location.reload(), 800);
        } else {
          showToast("error", res.message || "Failed to update stock.");
        }
      },
      error: function (xhr) {
        showToast("error", xhr.responseJSON?.message || "Failed to update stock.");
      },
      complete: function () {
        $("#btnAdjustStockSave").prop("disabled", false);
      },
    });
  });
});
