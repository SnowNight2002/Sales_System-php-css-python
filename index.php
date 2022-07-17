<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/index.css" type="text/css"/>
    <title>Login form</title>
    <script type="text/javascript">
        function openPassword() {//display password or hidden password
            var password = document.getElementById("password");
            var show = document.getElementById("show");
            if(show.getAttribute('value') === "yes"){
                show.value = "no";
            }
            if (password.getAttribute('type')=='password' && show.getAttribute('value') === "no") {
                password.type = 'text';
            } else {
                password.type = 'password';
                if(show.getAttribute('value') === "no"){
                    show.value = "yes";
                }
            }
        }
    </script>
</head>
<body>
<div class="Border">
    <form action="welcome.php" method="post">
        <div class="login">Login Form</div>
        <div class="inputBox">
            <input type="text" placeholder="Enter your staff ID" name="ID" id="ID" required>
            <br>
        </div>
        <div class="inputBox">
            <input type="password" placeholder="Enter your password" name="password" id="password" required>
        </div>
        <div class="display"><input type="checkbox" onclick="openPassword()" value="no" id="show">Show Password</div>
        <input type="submit" value="Login" name="loginButton">
    </form>
</div>
</body>
</html>

