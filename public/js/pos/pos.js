function showToast(type, message) {
  if (type === "success") toastr.success(message, "Success");
  else toastr.error(message, "Error");
}

function formatMoney(n) {
  const v = parseFloat(n || 0);
  return "₱" + v.toFixed(2);
}

let cart = [];
let productCache = [];

function cartSubtotal() {
  return cart.reduce((sum, it) => sum + it.price * it.qty, 0);
}

function discountTotal() {
  const v = parseFloat($("#discountTotal").val() || 0);
  return v < 0 ? 0 : v;
}

function cartGrandTotal() {
  return Math.max(0, cartSubtotal() - discountTotal());
}

function fetchCategories() {
  $.ajax({
    url: baseUrl + "pos/getCategories",
    method: "GET",
    dataType: "json",
    success: function (res) {
      const $select = $("#posCategory");
      (res.data || []).forEach(function (cat) {
        $select.append(`<option value="${cat.id}">${cat.name}</option>`);
      });
    },
    error: function () {
      showToast("error", "Failed to load categories.");
    },
  });
}

function fetchProducts(q, category_id) {
  $.ajax({
    url: baseUrl + "pos/searchProducts",
    method: "GET",
    data: { q, category_id },
    dataType: "json",
    success: function (res) {
      productCache = res.data || [];
      renderSearchResults(productCache);
    },
    error: function () {
      showToast("error", "Failed to load products.");
    },
  });
}

function renderCart() {
  const $tbody = $("#cartTable tbody");
  $tbody.empty();

  if (cart.length === 0) {
    $tbody.append(`<tr><td colspan="5" class="text-center text-muted">No items yet</td></tr>`);
  } else {
    cart.forEach((it) => {
      $tbody.append(`
        <tr data-id="${it.product_id}">
          <td>${it.name}</td>
          <td class="text-right">${formatMoney(it.price)}</td>
          <td class="text-center" style="width: 120px;">
            <input type="number" class="form-control form-control-sm cart-qty" min="1" max="${it.stock_qty}" value="${it.qty}">
          </td>
          <td class="text-right">${formatMoney(it.price * it.qty)}</td>
          <td class="text-center" style="width: 110px;">
            <button class="btn btn-sm btn-warning btn-decrement" title="Reduce by 1"><i class="fas fa-minus"></i></button>
            <button class="btn btn-sm btn-danger btn-remove" title="Remove"><i class="fas fa-times"></i></button>
          </td>
        </tr>
      `);
    });
  }

  $("#subtotalDisplay").val(formatMoney(cartSubtotal()));
  $("#grandTotalDisplay").val(formatMoney(cartGrandTotal()));
  $("#btnCheckout").prop("disabled", cart.length === 0);

  const total = cartGrandTotal();
  const tendered = parseFloat($("#amountTendered").val() || 0);
  $("#changeDisplay").val(formatMoney(Math.max(0, tendered - total)));
}

function addToCart(product) {
  const pid = parseInt(product.id);
  const existing = cart.find((x) => x.product_id === pid);
  if (existing) {
    if (existing.qty + 1 > existing.stock_qty) {
      showToast("error", "Not enough stock.");
      return;
    }
    existing.qty += 1;
  } else {
    cart.push({
      product_id: pid,
      name: product.name,
      sku: product.sku,
      price: parseFloat(product.price || 0),
      stock_qty: parseInt(product.stock_qty || 0),
      qty: 1,
    });
  }
  renderCart();
}

function renderSearchResults(rows) {
  const $tbody = $("#posSearchTable tbody");
  $tbody.empty();

  if (!rows || rows.length === 0) {
    $tbody.append(`<tr><td colspan="4" class="text-center text-muted">No results</td></tr>`);
    return;
  }

  rows.forEach((r) => {
    const stock = parseInt(r.stock_qty || 0);
    const disabled = stock <= 0 ? "disabled" : "";
    $tbody.append(`
      <tr>
        <td>${r.name}</td>
        <td class="text-right">${formatMoney(r.price)}</td>
        <td class="text-right">${stock}</td>
        <td class="text-center">
          <button class="btn btn-sm btn-primary btn-add" data-id="${r.id}" ${disabled}>
            <i class="fas fa-plus"></i>
          </button>
        </td>
      </tr>
    `);
  });
}

$(document).ready(function () {
  let searchTimer = null;

  fetchCategories();
  fetchProducts("", "");

  $("#posCategory").on("change", function () {
    const category_id = $(this).val();
    const q = $("#posSearch").val().trim();
    fetchProducts(q, category_id);
  });

  $("#posSearch").on("input", function () {
    const q = $(this).val().trim();
    const category_id = $("#posCategory").val();
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => {
      fetchProducts(q, category_id);
    }, 250);
  });

  $(document).on("click", ".btn-add", function () {
    const id = parseInt($(this).data("id"));
    const product = productCache.find((x) => parseInt(x.id) === id);
    if (!product) {
      showToast("error", "Product not found.");
      return;
    }
    addToCart(product);
  });

  $(document).on("click", ".btn-decrement", function () {
    const id = parseInt($(this).closest("tr").data("id"));
    const it = cart.find((x) => x.product_id === id);
    if (!it) return;
    if (it.qty > 1) {
      it.qty -= 1;
    } else {
      cart = cart.filter((x) => x.product_id !== id);
    }
    renderCart();
  });

  $(document).on("click", ".btn-remove", function () {
    const id = parseInt($(this).closest("tr").data("id"));
    cart = cart.filter((x) => x.product_id !== id);
    renderCart();
  });

  $(document).on("input", ".cart-qty", function () {
    const $tr = $(this).closest("tr");
    const id = parseInt($tr.data("id"));
    const it = cart.find((x) => x.product_id === id);
    if (!it) return;
    const max = it.stock_qty;
    let v = parseInt($(this).val() || 1);
    if (v < 1) v = 1;
    if (v > max) { v = max; $(this).val(v); }
    it.qty = v;
    $tr.find("td:nth-child(4)").text(formatMoney(it.price * v));
    $("#subtotalDisplay").val(formatMoney(cartSubtotal()));
    $("#grandTotalDisplay").val(formatMoney(cartGrandTotal()));
    const tendered = parseFloat($("#amountTendered").val() || 0);
    $("#changeDisplay").val(formatMoney(Math.max(0, tendered - cartGrandTotal())));
  });

  $("#btnClearCart").on("click", function () {
    cart = [];
    $("#discountTotal").val(0);
    $("#amountTendered").val(0);
    renderCart();
  });

  $("#discountTotal").on("input", function () {
    renderCart();
  });

  $("#CheckoutModal").on("show.bs.modal", function () {
    const total = cartGrandTotal();
    $("#amountTendered").val(total.toFixed(2));
    $("#paymentMethod").val("Cash");
    $("#paymentReference").val("");
    $("#paymentReferenceGroup").hide();
    renderCart();
  });

  $("#paymentMethod").on("change", function () {
    const isCash = $(this).val() === "Cash";
    $("#paymentReferenceGroup").toggle(!isCash);
    renderCart();
  });

  $("#amountTendered").on("input", function () {
    renderCart();
  });

  $("#checkoutForm").on("submit", function (e) {
    e.preventDefault();

    const payload = {
      items: cart.map((it) => ({ product_id: it.product_id, qty: it.qty })),
      discount_total: discountTotal(),
      payment_method: $("#paymentMethod").val(),
      payment_reference: $("#paymentReference").val().trim() || null,
      amount_tendered: parseFloat($("#amountTendered").val() || 0),
    };

    $("#btnConfirmCheckout").prop("disabled", true);

    $.ajax({
      url: baseUrl + "pos/checkout",
      method: "POST",
      contentType: "application/json",
      dataType: "json",
      data: JSON.stringify(payload),
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      success: function (res) {
        if (!res.success) {
          showToast("error", res.message || "Checkout failed.");
          $("#btnConfirmCheckout").prop("disabled", false);
          return;
        }

        $("#CheckoutModal").modal("hide");
        cart = [];
        $("#discountTotal").val(0);
        renderCart();
        showToast("success", "Sale completed.");

        // Refresh respecting current filters
        fetchProducts($("#posSearch").val().trim(), $("#posCategory").val());

        window.open(baseUrl + "sales/receipt/" + res.sale_id, "_blank");
      },
      error: function (xhr) {
        showToast("error", xhr.responseJSON?.message || "Checkout failed.");
      },
      complete: function () {
        $("#btnConfirmCheckout").prop("disabled", false);
      },
    });
  });

  renderCart();
});