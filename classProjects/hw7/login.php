<?php
    session_start();
    if($_SESSION){
        if($_SESSION["username"] != ""){
            header( "Location: http://sascha.rojtas.com/classProjects/hw7/categories.php");  // Checks for session. If there is, it directs to the session.
            exit();
        }
    }
    if($_POST) {
        $username = $_POST['username'];
        $pswd = $_POST['password'];
        if(empty($username) || empty($pswd)) echo "Your username or password is incorrect.";
        else {
            include "dbconn.php";
            $username = mysqli_real_escape_string($dbconnect,$username); // Sanitize
            $pswd = mysqli_real_escape_string($dbconnect,$pswd); // Sanitize
            $sqlLoginStatement = "SELECT userID, username, password from hw7Users where username='";
            $sqlLoginStatement .= $username;
            $sqlLoginStatement .= "' and password='";
            $sqlLoginStatement .= $pswd;  // SQL to see if the username and password is correct. If so, goes to categories. If not, prompts again.
            $sqlLoginStatement .= "';";
            $result = mysqli_query($dbconnect,$sqlLoginStatement);
            $match = mysqli_fetch_assoc($result);
            if($username == $match["username"] && $pswd == $match["password"]) {
                $_SESSION["username"] = $username;
                $_SESSION["userID"] = $match["userID"];
                header( "Location: http://sascha.rojtas.com/classProjects/hw7/categories.php");
            } else {
                echo "Your username or password is incorrect.";
            }
        }
    }
?>

    <!DOCTYPE HTML>
    <html>

    <head>
        <title>Forum -- Login</title>
        <link rel="stylesheet" type="text/css" href="css/styles.css">
    </head>

    <body>
        <header>
            <h1>
        Forum -- Login
        </h1>
        </header>
        <div class="mainContent">
            <form method="post" action="login.php" class="loginForm">
                <p>
                    <label for="username">Username</label>
                    <input name="username" type="text">  <!-- HTML Form for login window -->
                </p>
                <p>
                    <label for="password">Password</label>
                    <input name="password" type="password">
                </p>
                <p>
                    <input type="submit" name="submit" value="Log In">
                </p>
            </form>


        </div>
    </body>

    </html>