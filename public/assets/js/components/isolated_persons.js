$(document).ready(function () {
    isolatedPersonsDataApi();
});


// Query admin forms Data
function isolatedPersonsDataApi() {
    var data_table = null;

    $('appUsersDataTable').DataTable().destroy();

    data_table = $('#appUsersDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/isolatedPersonsDataApi'       
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'upsa_user', name: 'upsa_user' },
            { data: 'symptoms_checked', name: 'symptoms_checked' },
            { data: 'severity_condition', name: 'severity_condition' },
            { data: 'contacts_affected', name: 'contacts_affected' },
            { data: 'contacts_number_affected', name: 'contacts_number_affected' },
            { data: 'isolation_days_counter', name: 'isolation_days_counter' },
            { data: 'saved_at', name: 'saved_at', orderable: false, searchable: false },            
        ]
    });

}