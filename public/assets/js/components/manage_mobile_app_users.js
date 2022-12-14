$(document).ready(function () {
    getMobileAppUsersData();
});


// Query admin forms Data
function getMobileAppUsersData() {
    var data_table = null;

    $('appUsersDataTable').DataTable().destroy();

    data_table = $('#appUsersDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getMobileAppUsersDataApi'       
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'upsa_id', name: 'upsa_id' },
            { data: 'phone_number', name: 'phone_number' },
            { data: 'personality', name: 'personality' },
            { data: 'device_id', name: 'device_id' },
            { data: 'saved_at', name: 'saved_at', orderable: false, searchable: false },            
        ]
    });

}