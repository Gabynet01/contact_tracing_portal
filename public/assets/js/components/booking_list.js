$(document).ready(function () {
    bookingListDataApi();
    bookingDateRangePicker();
    testResultDateRangePicker();
});


// Query admin forms Data
function bookingListDataApi() {
    var data_table = null;

    $('appUsersDataTable').DataTable().destroy();

    data_table = $('#appUsersDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/bookingListDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'upsa_user', name: 'upsa_user' },
            { data: 'booking_code', name: 'booking_code' },
            { data: 'appointment_date', name: 'appointment_date' },
            { data: 'visited_status', name: 'visited_status' },
            { data: 'saved_at', name: 'saved_at', orderable: false, searchable: false },
            { data: 'result_status', name: 'result_status' },
            { data: 'result_date', name: 'result_date' },  
            { data: 'result_confirmed_user', name: 'result_confirmed_user' },  
            {
                data: null,
                name: 'actions',
                orderable: false,
                searchable: false,
                className: "td-actions",
                render: function (data, type, full, meta) {
                    var detailsJson = JSON.stringify(data);

                    if (data.visited_status.toUpperCase() == "NO" && (data.test_result_status == null || data.test_result_status == undefined)) {

                        var edit_action = "<a href='#' rel='tooltip' data-booking-edit='" + detailsJson + "'' class='' data-toggle='tooltip' data-placement='bottom' title='edit user'><i class='ti-pencil'></i></a>";
                        var test_result_action = "";
                        return edit_action + " "+ test_result_action;
                    }

                    else if (data.visited_status.toUpperCase() == "YES" && (data.test_result_status == null || data.test_result_status == undefined)) {
                        var edit_action = "";
                        var test_result_action = "<a href='#' rel='tooltip' data-result-edit='" + detailsJson + "'' class='' data-toggle='tooltip' data-placement='bottom' title='update test result'><i class='ti-pencil-alt'></i></a>";

                        return edit_action + " "+ test_result_action;;
                    }
                    else {

                        return "";
                    }

                }
            },
        ]
    });

}

//EDIT ADMIN USER ROLE
$(document).on('click', '[data-booking-edit]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-booking-edit'));

    $('#displayUpsaUser').html(toTitleCase(jsonDetails.upsa_user));
    $('#upsaId').val(jsonDetails.upsa_user);
    $('#bookingCode').val(jsonDetails.booking_code);
    $('#visitedStatus').val(jsonDetails.visited_status);

    $('#bookingModal').modal('show');

    $("#updateBookingBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var visitedStatus = $.trim($('#visitedStatus').val());
        var visitedDate = $.trim($('#bookingDateRange').val());

        if (visitedStatus == "" || visitedStatus == "NO" || visitedStatus == undefined) {
            displayErrorMsgModal("Please select visit status"); //display Error message
            return false;
        }
        else if (visitedDate == "" || visitedDate == undefined) {
            displayErrorMsgModal("Please select visited date"); //display Error message
            return false;
        }
        else {

            $("#updateBookingBtn").prop("disabled", true);
            var formData = {
                "requestId": jsonDetails.id,
                "visitedStatus": visitedStatus,
                "visitedDate": visitedDate,
            };

            formData = JSON.stringify(formData);

            var request = $.ajax({
                url: "/updateBookingInfoApi",
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    $("#updateBookingBtn").removeAttr('disabled');

                    console.log(data);

                    $('#bookingModal').modal('hide');
                    displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

                    setTimeout(function () {
                        window.location.href = "/bookingList";
                    }, 2000);

                }

                else {
                    $("#updateBookingBtn").removeAttr('disabled');
                    console.log(data)
                    displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                $("#updateBookingBtn").removeAttr('disabled');
                displayErrorMsgModal("Sorry, something went wrong");
            });

        }

    });

});

//EDIT ADMIN USER ROLE
$(document).on('click', '[data-result-edit]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-result-edit'));

    $('#displayUpsaUser2').html(toTitleCase(jsonDetails.upsa_user));
    $('#upsaId2').val(jsonDetails.upsa_user);
    $('#bookingCode2').val(jsonDetails.booking_code);
    $('#visitedStatus2').val(jsonDetails.visited_status);
    $('#visitedDate').val(jsonDetails.visited_date);

    $('#testResultModal').modal('show');

    $("#updateTestResultBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var testResultStatus = $.trim($('#testResultStatus').val());
        var testResultDate = $.trim($('#testResultDateRange').val());

        if (testResultStatus == "" || testResultStatus == undefined) {
            displayErrorMsgModal("Please select test result status"); //display Error message
            return false;
        }
        else if (testResultDate == "" || testResultDate == undefined) {
            displayErrorMsgModal("Please select test result date"); //display Error message
            return false;
        }
        else {

            $("#updateTestResultBtn").prop("disabled", true);
            var formData = {
                "requestId": jsonDetails.id,
                "status": testResultStatus,
                "date": testResultDate,
            };

            formData = JSON.stringify(formData);

            var request = $.ajax({
                url: "/updateTestResultInfoApi",
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    $("#updateTestResultBtn").removeAttr('disabled');

                    console.log(data);

                    $('#testResultModal').modal('hide');
                    displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

                    setTimeout(function () {
                        window.location.href = "/bookingList";
                    }, 2000);

                }

                else {
                    $("#updateTestResultBtn").removeAttr('disabled');
                    console.log(data)
                    displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                $("#updateTestResultBtn").removeAttr('disabled');
                displayErrorMsgModal("Sorry, something went wrong");
            });

        }

    });

});

//date range picker
function bookingDateRangePicker() {

    var start = moment().startOf('day');
    var end = moment().endOf('day');

    function cb(start, end) {
        $('#bookingDateRange').val("");
    }

    $('#bookingDateRange').daterangepicker({
        parentEl: $('#bookingModal'),
        timePicker: true,
        timePicker24Hour: false,
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment().startOf('day'), moment()],
            'Tomorrow': [moment().startOf('day').add(1, 'days'), moment().add(1, 'days')],
            'Next Week': [moment().startOf('day').add(6, 'days'), moment()],
            'Next Month': [moment().startOf('day').add(29, 'days'), moment()],
            'This Month': [moment().startOf('day').startOf('month'), moment().endOf('month')]
        },
        locale: {
            format: 'YYYY-MM-DD HH:mm'
        },
        singleDatePicker: true
    }, cb);

    cb(start, end);

    // on select 
    $('#bookingDateRange').on('apply.daterangepicker', function (ev, picker) {

        allStartDate = picker.startDate.format('YYYY-MM-DD HH:mm:ss');
        allEndDate = picker.endDate.format('YYYY-MM-DD HH:mm:ss');

        //  do something, like logging an input
        //console.log("all Start date");
        //console.log(allStartDate);

        //console.log('allEndDate');
        //console.log(allEndDate);

    });
}

function testResultDateRangePicker() {

    var start = moment().startOf('day');
    var end = moment().endOf('day');

    function cb(start, end) {
        $('#testResultDateRange').val("");
    }

    $('#testResultDateRange').daterangepicker({
        parentEl: $('#testResultModal'),
        timePicker: true,
        timePicker24Hour: false,
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment().startOf('day'), moment()],
            'Tomorrow': [moment().startOf('day').add(1, 'days'), moment().add(1, 'days')],
            'Next Week': [moment().startOf('day').add(6, 'days'), moment()],
            'Next Month': [moment().startOf('day').add(29, 'days'), moment()],
            'This Month': [moment().startOf('day').startOf('month'), moment().endOf('month')]
        },
        locale: {
            format: 'YYYY-MM-DD HH:mm'
        },
        singleDatePicker: true
    }, cb);

    cb(start, end);

    // on select 
    $('#testResultDateRange').on('apply.daterangepicker', function (ev, picker) {

        allStartDate = picker.startDate.format('YYYY-MM-DD HH:mm:ss');
        allEndDate = picker.endDate.format('YYYY-MM-DD HH:mm:ss');

        //  do something, like logging an input
        //console.log("all Start date");
        //console.log(allStartDate);

        //console.log('allEndDate');
        //console.log(allEndDate);

    });
}
