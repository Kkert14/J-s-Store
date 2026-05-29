function showToast(type, message) {
  if (type === "success") toastr.success(message, "Success");
  else toastr.error(message, "Error");
}

$(document).ready(function () {
  const table = $("#salesTable").DataTable({
    processing: true,
    serverSide: true,
    order: [[2, "desc"]],
    ajax: {
      url: baseUrl + "sales/fetchRecords",
      type: "POST",
      data: function (d) {
        d[$('meta[name="csrf-name"]').attr("content")] =
          $('meta[name="csrf-token"]').attr("content");
        return d;
      },
    },
    columns: [
      { data: "row_number" },
      { data: "receipt_no" },
      { data: "sale_datetime" },
      {
        data: "cashier_name",
        render: function (data) {
          return data && data.trim() ? data : "—";
        },
      },
      {
        data: "grand_total",
        render: function (data) {
          const n = parseFloat(data || 0);
          return "₱" + n.toFixed(2);
        },
      },
      { data: "payment_method" },
      { data: "status" },
      {
        data: null,
        orderable: false,
        searchable: false,
        render: function (data, type, row) {
          const status = (row.status || "").toLowerCase();
          const canVoid = status === "completed";
          const isAdmin = String(window.userRole || "").toLowerCase() === "admin";
          const canDelete = isAdmin && status === "voided";

          const voidBtn = canVoid
            ? `<button class="btn btn-sm btn-warning void-sale" title="Void" data-id="${row.id}" data-receipt="${row.receipt_no}">
                <i class="fas fa-ban"></i>
              </button>`
            : "";

          const deleteBtn = canDelete
            ? `<button class="btn btn-sm btn-danger delete-sale" title="Delete" data-id="${row.id}" data-receipt="${row.receipt_no}">
                <i class="fas fa-trash"></i>
              </button>`
            : "";

          return `
            <a class="btn btn-sm btn-secondary" target="_blank" href="${baseUrl}sales/receipt/${row.id}" title="Print">
              <i class="fas fa-print"></i>
            </a>
            ${voidBtn}
            ${deleteBtn}
          `;
        },
      },
    ],
    responsive: true,
    autoWidth: false,
  });

  // ── Void ──
  $(document).on("click", ".void-sale", function () {
    const id = $(this).data("id");
    const receipt = $(this).data("receipt");
    $("#void_sale_id").val(id);
    $("#void_receipt_no").text(receipt);
    $("#void_reason").val("");
    $("#VoidSaleModal").modal("show");
  });

  $("#btnVoidConfirm").on("click", function () {
    const id = $("#void_sale_id").val();
    const reason = String($("#void_reason").val() || "").trim();

    if (!reason) {
      showToast("error", "Void reason is required.");
      return;
    }

    $("#btnVoidConfirm").prop("disabled", true);

    $.ajax({
      url: baseUrl + "sales/void/" + id,
      method: "POST",
      data: {
        [($('meta[name="csrf-name"]').attr("content"))]: $('meta[name="csrf-token"]').attr("content"),
        void_reason: reason,
      },
      dataType: "json",
      success: function (res) {
        if (res.success) {
          $("#VoidSaleModal").modal("hide");
          showToast("success", "Sale voided.");
          table.ajax.reload(null, false);
        } else {
          showToast("error", res.message || "Failed to void sale.");
        }
      },
      error: function (xhr) {
        showToast("error", xhr.responseJSON?.message || "Failed to void sale.");
      },
      complete: function () {
        $("#btnVoidConfirm").prop("disabled", false);
      },
    });
  });

  // ── Delete ──
  $(document).on("click", ".delete-sale", function () {
    const id = $(this).data("id");
    const receipt = $(this).data("receipt");
    $("#delete_sale_id").val(id);
    $("#delete_receipt_no").text(receipt);
    $("#DeleteSaleModal").modal("show");
  });

  $("#btnDeleteConfirm").on("click", function () {
    const id = $("#delete_sale_id").val();
    $("#btnDeleteConfirm").prop("disabled", true);

    $.ajax({
      url: baseUrl + "sales/delete/" + id,
      method: "POST",
      data: {
        [($('meta[name="csrf-name"]').attr("content"))]: $('meta[name="csrf-token"]').attr("content"),
      },
      dataType: "json",
      success: function (res) {
        if (res.success) {
          $("#DeleteSaleModal").modal("hide");
          showToast("success", "Sale deleted.");
          table.ajax.reload(null, false);
        } else {
          showToast("error", res.message || "Failed to delete sale.");
        }
      },
      error: function (xhr) {
        showToast("error", xhr.responseJSON?.message || "Failed to delete sale.");
      },
      complete: function () {
        $("#btnDeleteConfirm").prop("disabled", false);
      },
    });
  });
});
