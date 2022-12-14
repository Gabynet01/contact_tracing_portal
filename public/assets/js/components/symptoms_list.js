var addSymptomApi = "/addSymptomApi";
var editSymptomApi = "/editSymptomApi";
var deleteSymptomApi = "/deleteSymptomApi";

$(document).ready(function () {
    getSymptomsListData();
});

/** ADD API **/

$("#addSymptomBtn").click(function (e) {
    e.preventDefault();
    show_modal_loader();

    var label = $.trim($('#addLabel').val());
    var description = $.trim($('#addDescription').val());

    if ((label == "" || label == undefined) && (description == "" || description == undefined)) {
        displayErrorMsgModal("All fields are required"); //display Error message
        return false;
    }
    else if (label == "" || label == undefined) {
        displayErrorMsgModal("Symptom label must be filled"); //display Error message
        return false;
    }
    else if (description == "" || description == undefined) {
        displayErrorMsgModal("Symptom description must be filled"); //display Error message
        return false;
    }
    else {

        $("#addSymptomBtn").prop("disabled", true);

        var formData = {
            "label": label,
            "description": description,
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: addSymptomApi,
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {
                $("#addSymptomBtn").removeAttr('disabled');

                console.log(data);
                setTimeout(function () {
                    window.location.href = "/symptomsList";
                }, 2000);

                $('#addSymptomModal').modal('hide');
                displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
            }

            else {
                $("#addSymptomBtn").removeAttr('disabled');
                console.log(data)
                displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            console.log(textStatus);
            //show the error message
            $("#addSymptomBtn").removeAttr('disabled');
            displayErrorMsgModal("Sorry, something went wrong");
        });

    }

});


// Query admin forms Data
function getSymptomsListData() {
    var data_table = null;

    $('appUsersDataTable').DataTable().destroy();

    data_table = $('#appUsersDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getSymptomsListDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'label', name: 'label' },
            { data: 'description', name: 'description' },
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

                    var edit_action = "<a href='#' rel='tooltip' data-symptom-edit='" + detailsJson + "'' class='' data-toggle='tooltip' data-placement='bottom' title='edit symptom'><i class='ti-pencil'></i></a>";
                    var delete_action = "<a href='#' rel='tooltip' data-symptom-delete='" + detailsJson + "'' class='' data-toggle='tooltip' data-placement='bottom' title='delete symptom'><i class='ti-trash'></i></a>";

                    return edit_action + " " + delete_action;

                }
            },
        ]
    });

}


//EDIT
$(document).on('click', '[data-symptom-edit]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-symptom-edit'));

    $('#displayEditLabel').html(toTitleCase(jsonDetails.label));
    $('#editLabel').val(jsonDetails.label);
    $('#editDescription').val(jsonDetails.description);

    $('#editSymptomModal').modal('show');

    // edit user fullName here

    $("#editSymptomBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var label = $.trim($('#editLabel').val());
        var description = $.trim($('#editDescription').val());

        if ((label == "" || label == undefined) && (description == "" || description == undefined)) {
            displayErrorMsgModal("All fields are required"); //display Error message
            return false;
        }
        else if (label == "" || label == undefined) {
            displayErrorMsgModal("Symptom label must be filled"); //display Error message
            return false;
        }
        else if (description == "" || description == undefined) {
            displayErrorMsgModal("Symptom description must be filled"); //display Error message
            return false;
        }

        else {

            $("#editSymptomBtn").prop("disabled", true);
            var formData = {
                "requestId": jsonDetails.id,
                "label": label,
                "description": description,
            };

            formData = JSON.stringify(formData);

            var request = $.ajax({
                url: editSymptomApi,
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    $("#editSymptomBtn").removeAttr('disabled');

                    console.log(data);

                    $('#editSymptomModal').modal('hide');
                    displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

                    setTimeout(function () {
                        window.location.href = "/symptomsList";
                    }, 2000);

                }

                else {
                    $("#editSymptomBtn").removeAttr('disabled');
                    console.log(data)
                    displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                $("#editSymptomBtn").removeAttr('disabled');
                displayErrorMsgModal("Sorry, something went wrong");
            });

        }

    });

});

//DELETE DATA
$(document).on('click', '[data-symptom-delete]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-symptom-delete'));

    var formData = {
        "requestId": jsonDetails.id
    };

    formData = JSON.stringify(formData);

    swal({
        title: "Delete " + jsonDetails.label,
        text: "",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        showLoaderOnConfirm: true,
        confirmButtonText: "Yes"
    },

        function () {
            show_loader();

            var request = $.ajax({
                url: deleteSymptomApi,
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {

                    displaySuccessToast(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
                    setTimeout(function () {
                        window.location.href = "/symptomsList";
                    }, 2000);
                }

                else {
                    hide_loader();
                    console.log(data)
                    displayErrorMsg(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                displayErrorMsg("Sorry, something went wrong");
            });

        });
});