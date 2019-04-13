<?php
    session_start();
?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Forum -- Categories</title>
        <link rel="stylesheet" type="text/css" href="css/styles.css">
    </head>

    <body>
        <header>
            <h1>Categories<?php if($_SESSION) echo " -- Logged in as ".$_SESSION["username"]; // Shows user that is logged in if any?></h1>
        </header>
        <div class="mainContent">
            <table class="mainTable">
                <tr>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Date</th>
                </tr>
                <?php
                include "dbconn.php";
                $categoryQuery = "SELECT * FROM hw7Categories"; // SQL Query to get all categories then loops into HTML table.
                $result = mysqli_query($dbconnect,$categoryQuery);
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                        echo "<td><a href='threads.php?id=".$row["catID"]."'>".$row["title"]."</a></td>";
                        echo "<td>".$row["desc"]."</td>";
                        echo "<td>".$row["date"]."</td>";
                    echo "</tr>";
                }
            ?>
            </table>
            <p><?php if($_SESSION) echo "<p><a href='logout.php'>Log out</a></p>"; else echo "<p><a href='login.php'>Log in</a></p>";?>  <!-- Checks for login. If so, offers option to log out. If not, offers option to log in. --></p>
        </div>
    </body>

    </html>