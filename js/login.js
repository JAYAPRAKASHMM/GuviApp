$(document).ready(function () {
    $("#loginBtn").click(function () {
        var username = $("#username").val();
        var password = $("#password").val();
        $.ajax({
            type: "POST",
            url: "php/login.php",
            data: {
                username: username,
                password: password
            },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    saveUserStatusInMySQL(username, "Logged in");
                    alert("Login successful!");
                    window.location.href = "profile.html?username=" + username;
                } else {
                    alert("Login failed: " + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: " + status + "\n" + error);
                console.log(xhr.responseText);
                alert("Error in AJAX request");
            }
        });
    });

    function saveUserStatusInMySQL(username, status) {
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
