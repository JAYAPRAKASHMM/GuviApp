$(document).ready(function () {
    $("#submitBtn").click(function () {
        submitFormData();
    });
    function getUrlParameter(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }
    var username = getUrlParameter('username');
    $('#username').text(username);
    $.ajax({
        type: "GET",
        url: "php/profile.php",
        data: {
            username: username
        },
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                $('#email').text(response.user.email);
            } else {
                alert("User not found");
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + status + "\n" + error);
            alert("Error in AJAX request");
        }
    });
    function submitFormData() {
        // Serialize form data into JSON format
        var formData = {
            username: getUrlParameter('username'),
            dob: $("#dob").val(),
            gender: $("#gender").val(),
            institution: $("#institution").val(),
            yearOfPassing: $("#yearOfPassing").val(),
            phoneNumber: $("#phoneNumber").val()
        };
            $.ajax({
            type: "POST",
            url: "assets/dataStore.php",
            data: JSON.stringify(formData),
            contentType: "application/json",
            success: function (response) {
                console.log(response);
                $("#responseMessage").text(response);
                $("#responseModal").modal('show');
            },
            error: function (er) {
                $("#responseMessage").text("Error in saving user data");
                $("#responseModal").modal('show');
            }
        });
    }
        $('#responseModal').on('hidden.bs.modal', function () {
        $("#responseMessage").text("");
    });
});
