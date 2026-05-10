/* ============================================================
   appointment.js
   ============================================================ */

function showToast(type, message) {
    if (type === 'success') toastr.success(message, 'Success');
    else if (type === 'warning') toastr.warning(message, 'Warning');
    else toastr.error(message, 'Error');
}

const STATUS_LABELS = {
    pending:   'Pending',
    confirmed: 'Confirmed',
    completed: 'Completed',
    cancelled: 'Cancelled',
};

function statusBadge(status) {
    return `<span class="badge badge-${status} px-2 py-1">${STATUS_LABELS[status] ?? status}</span>`;
}

/* ============================================================
   VIEW TOGGLE — Table / Calendar
   ============================================================ */
$('#btnTableView').on('click', function () {
    $('#tableView').show();
    $('#calendarView').hide();
    $('#btnTableView').addClass('active');
    $('#btnCalendarView').removeClass('active');
});

$('#btnCalendarView').on('click', function () {
    $('#tableView').hide();
    $('#calendarView').show();
    $('#btnCalendarView').addClass('active');
    $('#btnTableView').removeClass('active');
    renderCalendar(calYear, calMonth);
});

/* ============================================================
   CALENDAR
   ============================================================ */
let calYear  = new Date().getFullYear();
let calMonth = new Date().getMonth() + 1;

const MONTH_NAMES = ['January','February','March','April','May','June',
                     'July','August','September','October','November','December'];
const DAY_NAMES   = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
function renderCalendar(year, month) {
    $('#calTitle').text(`${MONTH_NAMES[month - 1]} ${year}`);

    $.ajax({
        url: baseUrl + 'appointment/calendarData',
        method: 'GET',
        data: { year, month },
        dataType: 'json',
        success: function (appointments) {
            // Group by date
            const byDate = {};
            appointments.forEach(a => {
                const d = a.appointment_date.substring(0, 10);
                if (!byDate[d]) byDate[d] = [];
                byDate[d].push(a);
            });

            const firstDay  = new Date(year, month - 1, 1).getDay();
            const daysInMon = new Date(year, month, 0).getDate();
            const prevDays  = new Date(year, month - 1, 0).getDate();
            const today     = new Date().toISOString().substring(0, 10);

            let html = `
                <table style="width:100%; border-collapse:separate; border-spacing:4px;">
                    <thead>
                        <tr>`;

            DAY_NAMES.forEach(d => {
                html += `<th style="text-align:center; padding:6px 0; font-size:.8rem;
                                    color:#6c757d; font-weight:600; width:14.28%;">${d}</th>`;
            });

            html += `</tr></thead><tbody><tr>`;

            // Leading blank cells
            for (let i = 0; i < firstDay; i++) {
                const d = prevDays - firstDay + 1 + i;
                html += `<td style="min-height:80px; height:80px; vertical-align:top;
                                    border:1px solid #dee2e6; border-radius:6px; padding:4px;
                                    background:#f8f9fa; opacity:.6;">
                            <div style="font-size:.75rem; font-weight:700; color:#adb5bd;">${d}</div>
                         </td>`;
            }

            let cellCount = firstDay;

            // Current month cells
            for (let d = 1; d <= daysInMon; d++) {
                if (cellCount % 7 === 0 && cellCount !== 0) {
                    html += `</tr><tr>`;
                }

                const dateStr = `${year}-${String(month).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
                const isToday = dateStr === today;
                const events  = byDate[dateStr] || [];

                const cellBg     = isToday ? '#fff8e1' : '#fff';
                const cellBorder = isToday ? '#ffc107' : '#dee2e6';

                html += `<td style="min-height:80px; height:80px; vertical-align:top;
                                    border:1px solid ${cellBorder}; border-radius:6px; padding:4px;
                                    background:${cellBg};">
                            <div style="font-size:.75rem; font-weight:700; color:#495057;
                                        margin-bottom:3px;">${d}</div>`;

                events.forEach(a => {
                    const time     = a.appointment_date.substring(11, 16);
                    const colors   = {
                        pending:   { bg:'#fff3cd', color:'#856404' },
                        confirmed: { bg:'#cfe2ff', color:'#084298' },
                        completed: { bg:'#d1e7dd', color:'#0a3622' },
                        cancelled: { bg:'#f8d7da', color:'#842029' },
                    };
                    const c = colors[a.status] ?? { bg:'#e2e3e5', color:'#41464b' };

                    html += `<div class="cal-event ${a.status}"
                                  data-id="${a.appointment_id}"
                                  title="${a.patient_name} — ${a.user_name}"
                                  style="font-size:.7rem; border-radius:3px; padding:1px 5px;
                                         margin-bottom:2px; white-space:nowrap; overflow:hidden;
                                         text-overflow:ellipsis; cursor:pointer; display:block;
                                         background:${c.bg}; color:${c.color};">
                                ${time} ${a.patient_name}
                             </div>`;
                });

                html += `</td>`;
                cellCount++;
            }

            // Trailing cells
            const remaining = 7 - (cellCount % 7);
            if (remaining < 7) {
                for (let d = 1; d <= remaining; d++) {
                    html += `<td style="min-height:80px; height:80px; vertical-align:top;
                                        border:1px solid #dee2e6; border-radius:6px; padding:4px;
                                        background:#f8f9fa; opacity:.6;">
                                <div style="font-size:.75rem; font-weight:700; color:#adb5bd;">${d}</div>
                             </td>`;
                }
            }

            html += `</tr></tbody></table>`;
            $('#calendarGrid').html(html);
        }
    });
}

$('#calPrev').on('click', function () {
    calMonth--;
    if (calMonth < 1) { calMonth = 12; calYear--; }
    renderCalendar(calYear, calMonth);
});

$('#calNext').on('click', function () {
    calMonth++;
    if (calMonth > 12) { calMonth = 1; calYear++; }
    renderCalendar(calYear, calMonth);
});

// Click calendar event → open edit modal
$(document).on('click', '.cal-event', function () {
    const id = $(this).data('id');
    loadEdit(id);
});

/* ============================================================
   ADD
   ============================================================ */
$('#addAppointmentForm').on('submit', function (e) {
    e.preventDefault();
    $('#addConflictAlert').addClass('d-none');

    $.ajax({
        url: baseUrl + 'appointment/save',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $('#AddNewModal').modal('hide');
                $('#addAppointmentForm')[0].reset();
                showToast('success', 'Appointment added successfully!');
                setTimeout(() => location.reload(), 1000);
            } else if (response.status === 'conflict') {
                const list = $('#addConflictList').empty();
                response.conflicts.forEach(c => list.append(`<li>${c}</li>`));
                $('#addConflictAlert').removeClass('d-none');
            } else {
                showToast('error', response.message || 'Failed to add appointment.');
            }
        },
        error: function () { showToast('error', 'An error occurred.'); }
    });
});

/* ============================================================
   EDIT — load
   ============================================================ */
function loadEdit(id) {
    $.ajax({
        url: baseUrl + 'appointment/edit/' + id,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            if (!response.data) { showToast('error', 'Error fetching appointment.'); return; }
            const d = response.data;
            $('#appointment_id').val(d.appointment_id);
            $('#patient_id').val(d.patient_id);
            $('#user_id').val(d.user_id);
            // datetime-local needs "YYYY-MM-DDTHH:MM"
            $('#appointment_date').val(d.appointment_date.replace(' ', 'T').substring(0, 16));
            $('#status').val(d.status);
            $('#notes').val(d.notes);
            $('#editConflictAlert').addClass('d-none');
            $('#editAppointmentModal').modal('show');
        },
        error: function () { showToast('error', 'Error fetching appointment.'); }
    });
}

$(document).on('click', '.edit-btn', function () {
    loadEdit($(this).data('id'));
});

/* ============================================================
   EDIT — submit
   ============================================================ */
$('#editAppointmentForm').on('submit', function (e) {
    e.preventDefault();
    $('#editConflictAlert').addClass('d-none');

    $.ajax({
        url: baseUrl + 'appointment/update',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $('#editAppointmentModal').modal('hide');
                showToast('success', 'Appointment updated!');
                setTimeout(() => location.reload(), 1000);
            } else if (response.status === 'conflict') {
                const list = $('#editConflictList').empty();
                response.conflicts.forEach(c => list.append(`<li>${c}</li>`));
                $('#editConflictAlert').removeClass('d-none');
            } else {
                showToast('error', response.message || 'Update failed.');
            }
        },
        error: function () { showToast('error', 'An error occurred.'); }
    });
});

/* ============================================================
   STATUS QUICK-CHANGE (inline dropdown)
   ============================================================ */
$(document).on('change', '.status-select', function () {
    const id     = $(this).data('id');
    const status = $(this).val();
    const csrfName  = $('meta[name="csrf-name"]').attr('content');
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: baseUrl + 'appointment/updateStatus',
        method: 'POST',
        data: { appointment_id: id, status: status, [csrfName]: csrfToken },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                showToast('success', 'Status updated.');
                // Reload table silently
                $('#example1').DataTable().ajax.reload(null, false);
            } else {
                showToast('error', response.message);
            }
        },
        error: function () { showToast('error', 'Failed to update status.'); }
    });
});

/* ============================================================
   DELETE
   ============================================================ */
$(document).on('click', '.deleteUserBtn', function () {
    const id        = $(this).data('id');
    const csrfName  = $('meta[name="csrf-name"]').attr('content');
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    if (confirm('Are you sure you want to delete this appointment?')) {
        $.ajax({
            url: baseUrl + 'appointment/delete/' + id,
            method: 'POST',
            data: { _method: 'DELETE', [csrfName]: csrfToken },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    showToast('success', 'Appointment deleted.');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast('error', response.message);
                }
            },
            error: function () { showToast('error', 'Something went wrong.'); }
        });
    }
});

/* ============================================================
   DATATABLE
   ============================================================ */
$(document).ready(function () {

    const csrfName  = 'csrf_test_name';
    const csrfToken = $('input[name="' + csrfName + '"]').val();

    $('#example1').DataTable({
        processing: true,
        serverSide: true,
        order: [[4, 'asc']], // upcoming first
        ajax: {
            url: baseUrl + 'appointment/fetchRecords',
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken }
        },
        columns: [
            { data: 'row_number' },
            { data: 'appointment_id', visible: false },
            { data: 'patient_name' },
            { data: 'user_name' },
            { data: 'appointment_date' },
            {
                // Status — inline quick-change dropdown
                data: 'status',
                render: function (data, type, row) {
                    if (type === 'display') {
                        return `
                            <select class="form-control form-control-sm status-select"
                                    data-id="${row.appointment_id}"
                                    style="min-width:110px;">
                                <option value="pending"   ${data==='pending'   ?'selected':''}>Pending</option>
                                <option value="confirmed" ${data==='confirmed' ?'selected':''}>Confirmed</option>
                                <option value="completed" ${data==='completed' ?'selected':''}>Completed</option>
                                <option value="cancelled" ${data==='cancelled' ?'selected':''}>Cancelled</option>
                            </select>`;
                    }
                    return data;
                }
            },
            { data: 'notes' },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-warning edit-btn" data-id="${row.appointment_id}">
                            <i class="far fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger deleteUserBtn" data-id="${row.appointment_id}">
                            <i class="fas fa-trash-alt"></i>
                        </button>`;
                }
            }
        ],
        createdRow: function (row, data) {
            if (data.is_today) $(row).addClass('today-row');
        },
        responsive: true,
        autoWidth: false
    });

});