$(document).ready(function() {
    function getUrlParameter(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }

    var username = getUrlParameter('username');
    $("#username").text("@"+username);
    var user = {
        username: username,
        email: "",
        dob: "",
        gender: "",
        institution: "",
        yearOfPassing: "",
        phoneNumber: ""
    };
 
    function handleSaveButtonClick(button) {
        var field = button.closest('.form-group').find('.form-control').attr('id');
        var value = $("#" + field).val();
    if (value !== "") {
        user[field] = value;
        updateMdb(username,field,value);
    }
    }

    $('.btn-primary').on('click', function() {
        handleSaveButtonClick($(this));
    });

    $('#submit').on('click', function() {
        $('.btn-primary').each(function(index, element) {
            handleSaveButtonClick($(element));
        });
    });

    $("#logoutButton").click(function() {
        saveUserStatusMySQL(username,"Logged out")
        window.location.href = "index.html";
    });

    $("#downloadBtn").click(function() {
        const userDataJson = JSON.stringify(user);
        const blob = new Blob([userDataJson], { type: 'text/plain' });
        const a = document.createElement('a');
        a.href = URL.createObjectURL(blob);
        a.download = 'userData.txt';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    });

    $("#finishButton").click(function() {
        $("#responseModal").modal('show');
    });
    function updateMdb(username, field, value) {

        var apiUrl = 'php/profile.php';
            var data = {
            username: username,
            field: field,
            value: value
        };
    
        $.ajax({
            type: 'POST',
            url: apiUrl,
            data: JSON.stringify(data),
            contentType: 'application/json',
            success: function(response) {
                console.log('Update successful:', response);
            },
            error: function(error) {
                console.error('Error updating MongoDB:', error);
            }
        });
    }
    function saveUserStatusMySQL(username, status) {
        $.ajax({
            type: "POST",
            url: "assets/mysql_connection.php",
            data: {
                username: username,
                status: status,
                time: getCurrentTime(),
                date: getCurrentDate()
            },
            success: function (response) {
                console.log(response);
            },
            error: function () {
                console.log("Error in saving user status");
            }
        });
    }
    function getCurrentTime() {
        var now = new Date();
        var hours = now.getHours();
        var minutes = now.getMinutes();
        var seconds = now.getSeconds();
        return hours + ":" + minutes + ":" + seconds;
    }
    function getCurrentDate() {
        var now = new Date();
        var year = now.getFullYear();
        var month = now.getMonth() + 1;
        var day = now.getDate();
        return year + "-" + month + "-" + day;
    }
  
});
