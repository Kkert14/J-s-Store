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
          const canVoid = (row.status || "").toLowerCase() === "completed";
          const voidBtn = canVoid
            ? `<button class="btn btn-sm btn-danger void-sale" data-id="${row.id}" data-receipt="${row.receipt_no}">
                <i class="fas fa-ban"></i>
              </button>`
            : "";
          return `
            <a class="btn btn-sm btn-secondary" target="_blank" href="${baseUrl}sales/receipt/${row.id}">
              <i class="fas fa-print"></i>
            </a>
            ${voidBtn}
          `;
        },
      },
    ],
    responsive: true,
    autoWidth: false,
  });

  $(document).on("click", ".void-sale", function () {
    const id = $(this).data("id");
    const receipt = $(this).data("receipt");
    $("#void_sale_id").val(id);
    $("#void_receipt_no").text(receipt);
    $("#void_reason").val("");
    $("#VoidSaleModal").modal("show");
  });

  $("#voidSaleForm").on("submit", function (e) {
    e.preventDefault();
    const id = $("#void_sale_id").val();
    $("#btnVoidConfirm").prop("disabled", true);
    $.ajax({
      url: baseUrl + "sales/void/" + id,
      method: "POST",
      data: $(this).serialize(),
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
});
