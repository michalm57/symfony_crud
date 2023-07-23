$(document).ready(function () {
    let contactsTable = $('#contacts-table').DataTable({
        "ordering": true,
        "bInfo": true,
        "bLengthChange": false,
        "searching": true,
        "pageLength": 10,
        "order": [[2, "desc"]],
        responsive: true,
        bPaginate: true,
        "columnDefs": [
            { "targets": 0, "orderable": true, "width": "10%" },
            { "targets": 1, "orderable": true, "width": "10%", "responsivePriority": 0 },
            { "targets": 2, "orderable": true, "width": "10%", "responsivePriority": 1 },
            { "targets": 3, "orderable": true, "width": "10%", "responsivePriority": 1 },
            { "targets": 4, "orderable": true, "width": "10%", "responsivePriority": 1 },
        ],
    });
});