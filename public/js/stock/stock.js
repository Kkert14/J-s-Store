function showToast(type, message) {
  if (type === "success") toastr.success(message, "Success");
  else toastr.error(message, "Error");
}

function csrfData(d) {
  d[$('meta[name="csrf-name"]').attr("content")] = $('meta[name="csrf-token"]').attr("content");
  return d;
}

$(document).ready(function () {
  const lowTable = $("#lowStockTable").DataTable({
    processing: true,
    serverSide: true,
    order: [[2, "asc"]],
    ajax: {
      url: baseUrl + "stock/fetchLowStock",
      type: "POST",
      data: csrfData,
    },
    columns: [
      { data: "row_number" },
      { data: "id", visible: false },
      { data: "name" },
      {
        data: "sku",
        render: function (data) {
          return data && String(data).trim() ? data : "—";
        },
      },
      {
        data: "category_name",
        render: function (data) {
          return data && String(data).trim() ? data : "—";
        },
      },
      {
        data: "stock_qty",
        render: function (data) {
          const qty = parseInt(data || 0);
          return `<span class="badge badge-danger">${qty}</span>`;
        },
      },
      { data: "reorder_level" },
      {
        data: null,
        orderable: false,
        searchable: false,
        render: function (data, type, row) {
          return `
            <button class="btn btn-sm btn-info adjust-stock" data-id="${row.id}" data-name="${row.name}" data-stock="${row.stock_qty}">
              <i class="fas fa-warehouse"></i>
            </button>
            <a class="btn btn-sm btn-primary" href="${baseUrl}product" title="Open products">
              <i class="fas fa-external-link-alt"></i>
            </a>
          `;
        },
      },
    ],
    responsive: true,
    autoWidth: false,
  });

  const movementTable = $("#movementTable").DataTable({
    processing: true,
    serverSide: true,
    order: [[1, "desc"]],
    ajax: {
      url: baseUrl + "stock/fetchMovements",
      type: "POST",
      data: csrfData,
    },
    columns: [
      { data: "row_number" },
      {
        data: "created_at",
        render: function (data) {
          return data ? data : "—";
        },
      },
      {
        data: null,
        render: function (data, type, row) {
          const name = row.product_name || "Unknown";
          const sku = row.product_sku && String(row.product_sku).trim() ? ` <span class="text-muted">(${row.product_sku})</span>` : "";
          return `${name}${sku}`;
        },
      },
      {
        data: "movement_type",
        render: function (data) {
          const t = String(data || "").toLowerCase();
          const cls = t === "sale" ? "badge-primary" : t === "void" ? "badge-warning" : "badge-secondary";
          return `<span class="badge ${cls}">${data || "—"}</span>`;
        },
      },
      {
        data: "qty",
        render: function (data) {
          const n = parseInt(data || 0);
          const cls = n >= 0 ? "text-success" : "text-danger";
          const sign = n > 0 ? "+" : "";
          return `<span class="${cls} font-weight-bold">${sign}${n}</span>`;
        },
      },
      {
        data: "unit_cost",
        render: function (data) {
          if (data === null || data === "") return "—";
          const n = parseFloat(data || 0);
          return "₱" + n.toFixed(2);
        },
      },
      {
        data: "reason",
        render: function (data) {
          return data && String(data).trim() ? data : "—";
        },
      },
      {
        data: "user_name",
        render: function (data) {
          return data && String(data).trim() ? data : "—";
        },
      },
    ],
    responsive: true,
    autoWidth: false,
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
          lowTable.ajax.reload(null, false);
          movementTable.ajax.reload(null, false);
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

