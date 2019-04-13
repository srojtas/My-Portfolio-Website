<?php
    session_start();
    session_unset();  // Destroys session data to log out user.
    session_destroy();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Forum -- Logged Out</title>
        <link rel="stylesheet" type="text/css" href="css/styles.css">
    </head>
    <body>
        <header><h1>You have been logged out successfully.</h1></header>
        <div class="mainContent"> <!-- Prompts user of successful log out -->
            <p><a href="categories.php">Click here to go to the forum.</a></p>
        </div>
    </body>
</html>