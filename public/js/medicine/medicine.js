const LOW_STOCK_THRESHOLD = 5;

function showToast(type, message) {
    if (type === 'success') toastr.success(message, 'Success');
    else toastr.error(message, 'Error');
}

/* ── "Other" medicine name logic ── */
$('#add_medicine_name_select').on('change', function () {
    const isOther = $(this).val() === 'Other';
    $('#add_other_name_field').toggle(isOther);
});

$('#edit_medicine_name_select').on('change', function () {
    const isOther = $(this).val() === 'Other';
    $('#edit_other_name_field').toggle(isOther);
});

// Before Add form submits, resolve the final medicine name
$('#addUserForm').on('submit', function (e) {
    e.preventDefault();
    const selected = $('#add_medicine_name_select').val();
    const finalName = selected === 'Other'
        ? $('#add_medicine_name_other').val().trim()
        : selected;

    if (!finalName) {
        showToast('error', 'Please specify the medicine name.');
        return;
    }

    $('#add_medicine_name_final').val(finalName);

    $.ajax({
        url: baseUrl + 'medicine/save',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $('#AddNewModal').modal('hide');
                $('#addUserForm')[0].reset();
                $('#add_other_name_field').hide();
                showToast('success', 'Medicine added successfully!');
                setTimeout(() => location.reload(), 1000);
            } else {
                showToast('error', response.message || 'Failed to add medicine.');
            }
        },
        error: function () { showToast('error', 'An error occurred.'); }
    });
});

/* ── Edit — load data ── */
$(document).on('click', '.edit-btn', function () {
    const userId = $(this).data('id');
    $.ajax({
        url: baseUrl + 'medicine/edit/' + userId,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.data) {
                const d = response.data;
                $('#editUserModal #userId').val(d.medicine_id);
                $('#editUserModal #quantity').val(d.quantity);
                $('#editUserModal #expiry_date').val(d.expiry_date);
                $('#editUserModal #date_received').val(d.date_received);

                // Check if the saved name is in the dropdown
                const $select = $('#edit_medicine_name_select');
                const exists  = $select.find(`option[value="${d.medicine_name}"]`).length > 0;

                if (exists) {
                    $select.val(d.medicine_name);
                    $('#edit_other_name_field').hide();
                    $('#edit_medicine_name_other').val('');
                } else {
                    $select.val('Other');
                    $('#edit_other_name_field').show();
                    $('#edit_medicine_name_other').val(d.medicine_name);
                }

                $('#editUserModal').modal('show');
            } else {
                alert('Error fetching medicine data');
            }
        },
        error: function () { alert('Error fetching medicine data'); }
    });
});

/* ── Edit — submit ── */
$(document).ready(function () {
    $('#editUserForm').on('submit', function (e) {
        e.preventDefault();

        const selected = $('#edit_medicine_name_select').val();
        const finalName = selected === 'Other'
            ? $('#edit_medicine_name_other').val().trim()
            : selected;

        if (!finalName) {
            showToast('error', 'Please specify the medicine name.');
            return;
        }

        $('#edit_medicine_name_final').val(finalName);

        $.ajax({
            url: baseUrl + 'medicine/update',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#editUserModal').modal('hide');
                    showToast('success', 'Medicine updated successfully!');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    alert('Error updating: ' + (response.message || 'Unknown error'));
                }
            },
            error: function (xhr) {
                alert('Error updating');
                console.error(xhr.responseText);
            }
        });
    });

    /* ── Delete ── */
    $(document).on('click', '.deleteUserBtn', function () {
        const userId    = $(this).data('id');
        const csrfName  = $('meta[name="csrf-name"]').attr('content');
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        if (confirm('Are you sure you want to delete this medicine?')) {
            $.ajax({
                url: baseUrl + 'medicine/delete/' + userId,
                method: 'POST',
                data: { _method: 'DELETE', [csrfName]: csrfToken },
                success: function (response) {
                    if (response.success) {
                        showToast('success', 'Medicine deleted successfully.');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        alert(response.message || 'Failed to delete.');
                    }
                },
                error: function () { alert('Something went wrong while deleting.'); }
            });
        }
    });

    /* ── Adjust Stock modal — open ── */
    $(document).on('click', '.adjust-btn', function () {
        const id   = $(this).data('id');
        const name = $(this).data('name');
        const qty  = $(this).data('qty');

        $('#adjustStockModal').data('medicine-id', id);
        $('#adjust_medicine_name').text(name);
        $('#adjust_current_qty').text(qty);
        $('#adjust_amount').val(1);
        $('#adjustStockModal').modal('show');
    });

    /* ── Adjust Stock — add button ── */
    $('#btnAdd').on('click', function () {
        submitAdjust('add');
    });

    /* ── Adjust Stock — subtract button ── */
    $('#btnSubtract').on('click', function () {
        submitAdjust('subtract');
    });

    function submitAdjust(action) {
        const id     = $('#adjustStockModal').data('medicine-id');
        const amount = parseInt($('#adjust_amount').val());
        const csrfName  = $('meta[name="csrf-name"]').attr('content');
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        if (!amount || amount < 1) {
            showToast('error', 'Amount must be at least 1.');
            return;
        }

        $.ajax({
            url: baseUrl + 'medicine/adjustStock',
            method: 'POST',
            data: { medicine_id: id, action: action, amount: amount, [csrfName]: csrfToken },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#adjustStockModal').modal('hide');
                    showToast('success', response.message);
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast('error', response.message);
                }
            },
            error: function () { showToast('error', 'An error occurred.'); }
        });
    }

    /* ── DataTable ── */
    const csrfName  = 'csrf_test_name';
    const csrfToken = $('input[name="' + csrfName + '"]').val();

    $('#example1').DataTable({
        processing: true,
        serverSide: true,
        order: [[2, 'asc']], // ← added
        ajax: {
            url: baseUrl + 'medicine/fetchRecords',
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken }
        },
        columns: [
            { data: 'row_number' },
            { data: 'medicine_id', visible: false },
            { data: 'medicine_name' },
            {
                data: 'quantity',
                render: function (data, type, row) {
                    if (type === 'display') {
                        if (parseInt(data) < LOW_STOCK_THRESHOLD) {
                            return `<span class="badge badge-danger px-2 py-1"><i class="fas fa-exclamation-circle mr-1"></i>${data} Low</span>`;
                        }
                        return `<span class="badge badge-success px-2 py-1">${data}</span>`;
                    }
                    return data;
                }
            },
            {
                data: 'expiry_date',
                render: function (data, type, row) {
                    if (type === 'display') {
                        if (row.is_expired)       return `<span class="badge badge-danger px-2 py-1"><i class="fas fa-times-circle mr-1"></i>${data} Expired</span>`;
                        if (row.is_expiring_soon) return `<span class="badge badge-warning px-2 py-1"><i class="fas fa-clock mr-1"></i>${data} Expiring Soon</span>`;
                        return data;
                    }
                    return data;
                }
            },
            { data: 'date_received' },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-info adjust-btn"
                                data-id="${row.medicine_id}"
                                data-name="${row.medicine_name}"
                                data-qty="${row.quantity}">
                            <i class="fas fa-boxes"></i>
                        </button>
                        <button class="btn btn-sm btn-warning edit-btn" data-id="${row.medicine_id}">
                            <i class="far fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger deleteUserBtn" data-id="${row.medicine_id}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    `;
                }
            }
        ],
        createdRow: function (row, data) {
            if (data.is_expired)        $(row).addClass('table-danger');
            else if (data.is_expiring_soon) $(row).addClass('table-warning');
            else if (data.low_stock)    $(row).addClass('table-danger');
        },
        responsive: true,
        autoWidth: false
    });
});