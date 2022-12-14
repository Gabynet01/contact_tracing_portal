var addAdminUserApi = "/addAdminUserApi";
var editAdminUserApi = "/editAdminUserApi";
var deleteAdminUserApi = "/deleteAdminUserApi";

$(document).ready(function () {
    getAdminUsersData();
});

/** ADD USER API **/

$("#addUserBtn").click(function (e) {
    e.preventDefault();
    show_modal_loader();

    var user_id;
    var username = $('#addUserName').val();
    var password = $('#addPassword').val();
    var full_name = $('#addFullname').val();
    var email = $('#addEmailAddress').val();
    var job_position = $('#addJobPosition').val();
    var app_user_role = $('#addAppUserRole').val();

    if ((full_name == "" || full_name == undefined) && (username == "" || username == undefined) && (email == "" || email == undefined)) {
        displayErrorMsgModal("All fields are required"); //display Error message
        return false;
    }
    else if (full_name == "" || full_name == undefined) {
        displayErrorMsgModal("Fullname must be filled"); //display Error message
        return false;
    }
    else if (username == "" || username == undefined) {
        displayErrorMsgModal("Username must be filled"); //display Error message
        return false;
    }

    else if (email == "" || email == undefined) {
        displayErrorMsgModal("Email must be filled"); //display Error message
        return false;
    }

    else if (password == "" || password == undefined) {
        displayErrorMsgModal("Password must be filled"); //display Error message
        return false;
    }

    else if (job_position == "" || job_position == undefined) {
        displayErrorMsgModal("Job position must be filled"); //display Error message
        return false;
    }

    else if (app_user_role == "" || app_user_role == undefined) {
        displayErrorMsgModal("Please select an app user role"); //display Error message
        return false;
    }

    else {

        // call userRandomString() to get a random id for the user
        user_id = userRandomString();

        $("#addUserBtn").prop("disabled", true);

        var formData = {
            "username": username,
            "password": password,
            "full_name": full_name,
            "email": email,
            "job_position": job_position,
            "app_user_role": app_user_role,
            "app_user_id": user_id,
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: addAdminUserApi,
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {
                document.getElementById("addUserForm").reset();
                $("#addUserBtn").removeAttr('disabled');

                console.log(data);
                setTimeout(function () {
                    window.location.href = "/applicationUsers";
                }, 2000);

                $('#addUserModal').modal('hide');
                displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
            }

            else {
                $("#addUserBtn").removeAttr('disabled');
                console.log(data)
                displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            console.log(textStatus);
            //show the error message
            $("#addUserBtn").removeAttr('disabled');
            displayErrorMsgModal("Sorry, something went wrong");
        });

    }

});


// Query admin forms Data
function getAdminUsersData() {
    var data_table = null;

    $('appUsersDataTable').DataTable().destroy();

    data_table = $('#appUsersDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getAdminUsersDataApi'
            // "data": function (d) {
            //     d.department = "HelpDesk";
            // }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'full_name', name: 'full_name' },
            { data: 'username', name: 'username' },
            { data: 'email', name: 'email' },
            { data: 'job_position', name: 'job_position' },
            { data: 'app_user_role', name: 'app_user_role' },
            { data: 'created_by', name: 'created_by' },
            { data: 'saved_at', name: 'saved_at', orderable: false, searchable: false },
            {
                data: null,
                name: 'actions',
                orderable: false,
                searchable: false,
                className: "td-actions",
                render: function (data, type, full, meta) {
                    var detailsJson = JSON.stringify(data);

                    var edit_action = "<a href='#' rel='tooltip' data-user-edit='" + detailsJson + "'' class='' data-toggle='tooltip' data-placement='bottom' title='edit user'><i class='ti-pencil'></i></a>";
                    var delete_action = "<a href='#' rel='tooltip' data-user-delete='" + detailsJson + "'' class='' data-toggle='tooltip' data-placement='bottom' title='delete user'><i class='ti-trash'></i></a>";

                    return edit_action + " " + delete_action;

                }
            },
        ]
    });

}


//EDIT ADMIN USER ROLE
$(document).on('click', '[data-user-edit]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-user-edit'));

    $('#displayEditUserName').html(toTitleCase(jsonDetails.full_name));
    $('#editFullName').val(jsonDetails.full_name);

    $('#editUserModal').modal('show');

    // edit user fullName here

    $("#editUserBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var fullName = $('#editFullName').val();

        if (fullName == "" || fullName == undefined) {
            displayErrorMsgModal("Please enter full name"); //display Error message
            return false;
        }


        else {

            $("#editUserBtn").prop("disabled", true);
            var formData = {
                "app_user_id": jsonDetails.app_user_id,
                "fullName": fullName
            };

            formData = JSON.stringify(formData);

            var request = $.ajax({
                url: editAdminUserApi,
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    document.getElementById("editUserForm").reset();
                    $("#editUserBtn").removeAttr('disabled');

                    console.log(data);

                    $('#editUserModal').modal('hide');
                    displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

                    setTimeout(function () {
                        window.location.href = "/applicationUsers";
                    }, 2000);

                }

                else {
                    $("#editUserBtn").removeAttr('disabled');
                    console.log(data)
                    displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                $("#editUserBtn").removeAttr('disabled');
                displayErrorMsgModal("Sorry, something went wrong");
            });

        }

    });

});

//DELETE ADMIN USER DATA
$(document).on('click','[data-user-delete]',function(e){

    var jsonDetails = JSON.parse($(this).attr('data-user-delete'));

    var formData = {
        "app_user_id": jsonDetails.app_user_id
    };

    formData = JSON.stringify(formData);

    swal({
        title: "Delete "+jsonDetails.full_name,
        text: "",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        showLoaderOnConfirm: true,
        confirmButtonText: "Yes"
    },

    function(){
        show_loader();

        var request = $.ajax({
          url: deleteAdminUserApi,
          type: "POST",
          data: formData,
          contentType: "application/json"
        });

        request.done(function(data) {
            if (data.RESPONSE_CODE == "200") {
        
                displaySuccessToast(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
                setTimeout(function () {
                    window.location.href = "/applicationUsers";
                }, 2000);
            }

            else{
                hide_loader();
                console.log(data)
                displayErrorMsg(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function(jqXHR, textStatus) {
            console.log(textStatus);
            //show the error message
            displayErrorMsg("Sorry, something went wrong");
        });

    });

});