<?php
    session_start();
    if($_GET) {
    } else {
        header( "Location: http://sascha.rojtas.com/classProjects/hw7/categories.php"); // Redirects to categories if GET IDs were cleared out.
    }
?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Forum -- View Thread</title>
        <link rel="stylesheet" type="text/css" href="css/styles.css">
    </head>

    <body>
        <header>
            <h1>Thread<?php if($_SESSION) echo " -- Logged in as ".$_SESSION["username"]; // Shows user that is logged in if any?></h1>
        </header>
        <div class="mainContent">
            <table class="mainTable">
                <th>Post</th>
                <th>Date</th>
                <th>User</th>
                <?php
                    if($_GET) {
                        include "dbconn.php";
                        $threadID = $_GET["id"];
                        $threadID = mysqli_real_escape_string($dbconnect,$threadID); // Sanitize
                        $postQuery = "SELECT hw7Replies.comment, hw7Replies.date, hw7Users.username FROM hw7Replies INNER JOIN hw7Users ON hw7Replies.userID_FK=hw7Users.userID WHERE threadID_FK = {$threadID}";
                        $result = mysqli_query($dbconnect,$postQuery); // SQL Statement to get thread details from database and loops it into a HTML table.
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                                echo "<td>".$row["comment"]."</td>";
                                echo "<td>".$row["date"]."</td>";
                                echo "<td>".$row["username"]."</td>";
                            echo "</tr>";
                        }
                    }
                ?>
            </table>
            <p><a href="postReply.php?threadID=<?php echo " {$_GET[ "id"]} ";?>">Reply to this Thread:</a></p>
            <p><a href="categories.php">Back to Categories</a></p>
            <p><?php if($_SESSION) echo "<p><a href='logout.php'>Log out</a></p>"; else echo "<p><a href='login.php'>Log in</a></p>";?>  <!-- Checks for login. If so, offers option to log out. If not, offers option to log in. --></p>

        </div>
    </body>

    </html>