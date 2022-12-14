$(document).ready(function () {
    autoTracingUsersDataApi();
});


// Query admin forms Data
function autoTracingUsersDataApi() {
    var data_table = null;

    $('appUsersDataTable').DataTable().destroy();

    data_table = $('#appUsersDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/autoTracingUsersDataApi'       
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'upsa_user', name: 'upsa_user' },
            { data: 'latitude', name: 'latitude' },
            { data: 'longitude', name: 'longitude' },
            { data: 'last_seen_location', name: 'last_seen_location' },
            { data: 'device_id', name: 'device_id' },
            { data: 'saved_at', name: 'saved_at', orderable: false, searchable: false },            
        ]
    });

}