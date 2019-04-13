<?php
    session_start();
    if($_SESSION){
    if($_SESSION["username"] == ""){
    header( "Location: http://sascha.rojtas.com/classProjects/hw7/login.php");
        exit();
    }
} else {
    header( "Location: http://sascha.rojtas.com/classProjects/hw7/login.php");
    exit();
}
    if($_POST) {
        if($_GET) {
            include "dbconn.php";
            $userPost = mysqli_real_escape_string($dbconnect,$_POST['userPost']); // Sanitize
            $todayDate = date('Y-m-d');
            $sqlInsert = "INSERT INTO `hw7Replies` (`comment`, `date`, `userID_FK`, `threadID_FK`) VALUES ('";
            $sqlInsert .= $userPost;
            $sqlInsert .= "', '";
            $sqlInsert .= $todayDate;
            $sqlInsert .= "', '{$_SESSION["userID"]}', '";
            $threadID = mysqli_real_escape_string($dbconnect,$_GET['threadID']); // Sanitize
            $sqlInsert .= $threadID;
            $sqlInsert .= "');";
            mysqli_query($dbconnect,$sqlInsert); // Adds reply to the SQL database then redirects to the thread.
            header( "Location: http://sascha.rojtas.com/classProjects/hw7/viewThread.php?id={$_GET['threadID']}");
            exit();
        } else {
            header( "Location: http://sascha.rojtas.com/classProjects/hw7/categories.php");
            exit();
        }
    } else if($_GET){
    } else {
        header( "Location: http://sascha.rojtas.com/classProjects/hw7/categories.php");
        exit();
    }
?>

<!DOCTYPE html>
<html>

<head>
    <title>Forum -- Post Reply</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

<body>
    <header>
        <h1>Forum -- Post Reply<?php if($_SESSION) echo " -- Logged in as ".$_SESSION["username"]; // Shows user that is logged in if any?></h1>
    </header>
    <div class="mainContent">
        <form method="post" action="postReply.php?threadID=<?php echo $_GET[ "threadID"];?>" class="replyForm">
            <p>
                <label for="userPost">Post Reply</label>
                <textarea name="userPost" cols="100" rows="6" required></textarea>
            </p>
            <p>
                <input type="submit" name="submit" value="Submit">
            </p>
        </form>
        <p><a href="categories.php">Back to Categories</a></p>
        <p><?php if($_SESSION) echo "<p><a href='logout.php'>Log out</a></p>"; else echo "<p><a href='login.php'>Log in</a></p>";?>  <!-- Checks for login. If so, offers option to log out. If not, offers option to log in. --></p>
    </div>
</body>

</html>