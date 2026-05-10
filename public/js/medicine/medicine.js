/* ============================================================
   medicine.js  –  with low stock row highlighting
   ============================================================ */

const LOW_STOCK_THRESHOLD = 5;

function showToast(type, message) {
    if (type === 'success') {
        toastr.success(message, 'Success');
    } else {
        toastr.error(message, 'Error');
    }
}

$('#addUserForm').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'medicine/save',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $('#AddNewModal').modal('hide');
                $('#addUserForm')[0].reset();
                showToast('success', 'Medicine added successfully!');
                setTimeout(() => location.reload(), 1000);
            } else {
                showToast('error', response.message || 'Failed to add medicine.');
            }
        },
        error: function () {
            showToast('error', 'An error occurred.');
        }
    });
});

$(document).on('click', '.edit-btn', function () {
    const userId = $(this).data('id');
    $.ajax({
        url: baseUrl + 'medicine/edit/' + userId,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.data) {
                $('#editUserModal #medicine_name').val(response.data.medicine_name);
                $('#editUserModal #userId').val(response.data.medicine_id);
                $('#editUserModal #quantity').val(response.data.quantity);
                $('#editUserModal #expiry_date').val(response.data.expiry_date);
                $('#editUserModal #date_received').val(response.data.date_received);
                $('#editUserModal').modal('show');
            } else {
                alert('Error fetching medicine data');
            }
        },
        error: function () {
            alert('Error fetching medicine data');
        }
    });
});

$(document).ready(function () {

    $('#editUserForm').on('submit', function (e) {
        e.preventDefault();
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

    $(document).on('click', '.deleteUserBtn', function () {
        const userId = $(this).data('id');
        const csrfName  = $('meta[name="csrf-name"]').attr('content');
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        if (confirm('Are you sure you want to delete this medicine?')) {
            $.ajax({
                url: baseUrl + 'medicine/delete/' + userId,
                method: 'POST',
                data: {
                    _method: 'DELETE',
                    [csrfName]: csrfToken
                },
                success: function (response) {
                    if (response.success) {
                        showToast('success', 'Medicine deleted successfully.');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        alert(response.message || 'Failed to delete.');
                    }
                },
                error: function () {
                    alert('Something went wrong while deleting.');
                }
            });
        }
    });

    const csrfName  = 'csrf_test_name';
    const csrfToken = $('input[name="' + csrfName + '"]').val();

    $('#example1').DataTable({
        processing: true,
        serverSide: true,
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
                // Quantity column — show badge if low stock
                data: 'quantity',
                render: function (data, type, row) {
                    if (type === 'display') {
                        if (parseInt(data) < LOW_STOCK_THRESHOLD) {
                            return `<span class="badge badge-danger px-2 py-1">
                                        <i class="fas fa-exclamation-circle mr-1"></i>${data} Low
                                    </span>`;
                        }
                        return `<span class="badge badge-success px-2 py-1">${data}</span>`;
                    }
                    return data;
                }
            },
            { data: 'expiry_date',
              render: function (data, type, row) {
                if (type === 'display') {
                    if (row.is_expired) {
                        return `<span class="badge badge-danger px-2 py-1">
                                    <i class="fas fa-times-circle mr-1"></i>${data} Expired
                                </span>`;
                    }
                    if (row.is_expiring_soon) {
                        return `<span class="badge badge-warning px-2 py-1">
                                    <i class="fas fa-clock mr-1"></i>${data} Expiring Soon
                                </span>`;
                    }
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
        // Highlight rows by status
        createdRow: function (row, data) {
            if (data.is_expired) {
                $(row).addClass('table-danger');
            } else if (data.is_expiring_soon) {
                $(row).addClass('table-warning');
            } else if (data.low_stock) {
                $(row).addClass('table-danger');
            }
        },
        responsive: true,
        autoWidth: false
    });

});