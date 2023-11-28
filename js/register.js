$(document).ready(function () {
  $("#registerBtn").click(function () {
      var username = $("#username").val();
      var password = $("#password").val();
      var email = $("#email").val();
      $.ajax({
          type: "POST",
          url: "php/register.php",
          data: {
              username: username,
              password: password,
              email: email
              
          },
          dataType: "json",
          success: function (response) {
            if (response.status === "success") {
                saveUserStatusMySQL(username, "registered");
                console.log("Data to be sent:", {
                    username: username,
                    password: password,
                    email: email
                });
                alert("Registration successful!");
                window.location.href = "login.html";
            } else {
                alert("Registration failed: " + response.message);
            }
        },        
          error: function (xhr, status, error) {
            console.error("AJAX Error: " + status + "\n" + error);
            console.log(xhr.responseText);
            alert("Error in AJAX request");
        }
      });
  });
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
